<?php
	$msg_parrainer = NULL;
	if(isset($_GET['action'])){
		if($_GET['action'] == 'annuler_cmd'){
			$cmd = $_GET['cmd'];
			$cnx->exec("DELETE FROM commande WHERE numcom='".$cmd."';");
		}
	}

	if(isset($_POST['add_parrain'])){
		$email_parraine = $_POST['par_email'];

		if($email_parraine == $email){
			$msg_parrainer = "<span style='color:red; font-size:13px;'>Vous ne pouvez pas parrainer vous même.</span>";
		}else{
			$checking = $cnx->query("SELECT * FROM client WHERE (idcli IN
						(SELECT idcli FROM parrainer) OR
						idcli IN
						(SELECT idparrain FROM parrainer))
						AND mail='$email_parraine';");

			if($checking->rowCount() > 0){
				$msg_parrainer = "<span style='color:red; font-size:13px;'>Vous ne pouvez pas parrainer <i>".$email_parraine."</i>.</span>";
			}else{
				$res = $cnx->query("SELECT idcli FROM client WHERE mail='".$email_parraine."';");

				if($res->rowCount() == 0){
					$msg_parrainer = "<span style='color:red; font-size:13px;'>Aucun client existe avec cet email : <i>".$email_parraine."</i>.</span>";
				}else{
					$get_id = $res->fetch();
					$id_parraine = $get_id['idcli'];

					$cnx->exec("INSERT INTO parrainer VALUES ('".$id_parraine."', '".$id."');");
					header("Location: index.php?page=compte");
				}
			}
		}
	}

	
?>

<div class="left-sidebar-block">
	<div class="compte-details-block">
		Nom : <?php echo $nom; ?><br/>
		Prénom : <?php echo $prenom; ?><br/>
		E-mail : <?php echo $email; ?><br/>
		Téléphone : <?php echo $telephone; ?><br/>
		Adresse : <?php echo $adresse." ".$codepostal; ?><br/>
		Points fidélité : <?php echo $pointsfidelite; ?><br/>
		Votre parrain : 
		<?php
			$res = $cnx->query("SELECT nom,prenom FROM client,parrainer WHERE client.idcli=parrainer.idparrain AND parrainer.idcli=".$id."; ");
			if($res->rowCount() == 0){
				echo "Vous n'avez pas de parrain.";
			}else{
				$data = $res->fetch();
				echo $data['nom']." ".$data['prenom'];
			}
		?>
		<table>
			<tr>
				<td>
					--<br/>
					Vos parainné(s)
				</td>
			</tr>
			<tr>
				<td>
					<?php
						$res = $cnx->query("SELECT nom,prenom FROM client WHERE idcli IN 
									 (SELECT idcli FROM parrainer WHERE idparrain=".$id.");");

						foreach($res AS $data){
							echo $data['nom']." ".$data['prenom']." |";
						}
					?>

				</td>
			</tr>
		</table>
		<?php
			echo $msg_parrainer;
		?>
		<form method="POST" action="#">
			<input type="email" name="par_email" placeholder="E-mail de votre parrainé" />
			<input type="submit" name="add_parrain" value="ajouter" />
		</form>
	</div>
</div>
<div class="right-sidebar-block">
	<div class="commande-historique-title">
		Historiques de vos commandes
	</div>

	<div class="commande-historique-list">
		<?php

			$resultat = $cnx->query("SELECT * FROM commande WHERE idcli=".$id." ORDER BY numcom DESC;");
			
			if($resultat->rowCount() == 0){
				echo "<span style='font-size:12px; font-style:italic;' >Vous n'avez pas encore passer de commande.</span>";
			}else{

				foreach($resultat as $ligne){
					echo "
						<div class='commande-historique-item'>
							<div class='col1'>
								Cmd ".$ligne['numcom']."
							</div>
							<div class='col2'>";
								
					if($ligne['etat']=='Livré'){
						echo"<a href='?page=feedback&&numcmd=".$ligne['numcom']."'>feedback</a>";
					}

							echo"</div>
							<div class='col3'>";

					if($ligne['etat']=='en attente'){
						echo"<a href='?page=compte&&action=annuler_cmd&&cmd=".$ligne['numcom']."'>Annuler</a>";
					}
					
					echo"
							</div>
							<div class='col4'>
								".$ligne['etat']."
							</div>
						</div>
					";
				}
			}
		?>
	</div>
</div>