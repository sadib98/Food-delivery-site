<?php
	if(isset($_POST['add_ville'])){
		$ville_postale=$_POST['ville'];

		$cnx->exec("INSERT INTO travailler VALUES (".$matricule.", '$ville_postale');");
		header("Location: index.php?page=compte");
	}
	if(isset($_POST['del_ville'])){
		$ville_postale=$_POST['ville'];

		$cnx->exec("DELETE FROM travailler WHERE codepostal=".$ville_postale.";");
		header("Location: index.php?page=compte");
	}
	if(isset($_GET['change_statut'])){
		if($_GET['change_statut'] == 'en_attente'){
			$cnx->exec("UPDATE livreur SET etat='en attente' WHERE matricule =".$matricule.";");
			header("Location: index.php?page=compte");
			
		}else if($_GET['change_statut'] == 'inactif'){
			$cnx->exec("UPDATE livreur SET etat='inactif' WHERE matricule =".$matricule.";");
			header("Location: index.php?page=compte");
		}
	}

?>

<div class="left-sidebar-block">
	<div class="livreur-infos-block">
		Matricule : <b><?php echo $matricule; ?></b><br/>
		Nom :  <?php echo $nom; ?><br/>
		Prénom :  <?php echo $prenom; ?><br/>
		Téléphone :  <?php echo $telephone; ?> <br/>
		Adresse :  <?php echo $adresse; ?> <br/>
		Statut :  <?php 

			if($statut == 'inactif'){
				echo "<span style='color:red; font-weight:bold;'>Inactif</span>|
				<a href='?page=compte&&change_statut=en_attente'>En attente</a>
				";
			}else if($statut == 'en attente'){
				echo "<span style='color:green; font-weight:bold;'>En attente</span>|
				<a href='?page=compte&&change_statut=inactif'>Inactif</a>
				";
			}else{
				echo $statut;
			}

		?> <br/>
	</div>
</div>
<div class="right-sidebar-block">
	<div class="livreur-travail-block">
		<div class="livreur-travail-title">
			Les villes où vous travaillez
		</div>

		<!--Villes items-->
		<div class="villes-list-block">

			<?php

				$res = $cnx->query("SELECT nom FROM travailler NATURAL JOIN ville WHERE matricule=".$matricule.";");
				
				foreach($res as $data){
					echo "
						<div class='ville-item'>
							".$data['nom']."
						</div>
					";
				}
			?>
		</div>

		<!--Ajouter une ville-->
		<div class="modify-ville-block">
			<form action="#" method="POST">
				<table>
					<tbody>
							<tr>
								<td>
									Choisir ville :
								</td>
								<td>
									<select name="ville">
										<?php
											$res = $cnx->query("SELECT nom,codepostal FROM ville WHERE nom NOT IN (SELECT nom FROM travailler NATURAL JOIN ville WHERE matricule=".$matricule.");");

											foreach($res AS $data){
												echo"
													<option value='".$data['codepostal']."'>
													".$data['nom']."
													</option>
												";
											}
										?>
									</select>
								</td>
								<td>
									<input type="submit" name="add_ville" value="Ajouter">
								</td>
							</tr>
					</tbody>
				</table>
			</form>
		</div>

		<!--Supprimer une ville-->
		<div class="modify-ville-block delete-ville">
			<form action="#" method="POST">
				<table>
					<tbody>
							<tr>
								<td>
									Choisir ville :
								</td>
								<td>
									<select name="ville">
										<?php
											$res = $cnx->query("SELECT nom,codepostal FROM travailler NATURAL JOIN ville WHERE matricule=".$matricule.";");

											foreach($res AS $data) {
												echo"
													<option value='".$data['codepostal']."'>
													".$data['nom']."
													</option>
												";
											}
										?>
									</select>
								</td>
								<td>
									<input type="submit" name="del_ville" value="Supprimer">
								</td>
							</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>