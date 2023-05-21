<?php
	$msg_comment = NULL;

	if(isset($_POST['add_comment'])){
		$idres = $_POST['idres'];
		$idcmd = $_POST['numcmd'];
		$note = $_POST['note'];
		$comment = pg_escape_string($_POST['comment']);

		if(empty($note) OR empty($comment)){
			$msg_comment = "Veuillez cochez une note et écrivez une commentaire.";
		}else{
			$cnx->exec("INSERT INTO commenter (idcli,idres,note,commentaire) VALUES ('$id', '$idres', '$note', '$comment');");
			header("Location:?page=feedback&&numcmd=".$idcmd."");
		}
	}


	if(isset($_GET['numcmd'])){
		$num_cmd=$_GET['numcmd'];

		$resultat1 = $cnx->query("SELECT nom,adresse,prixlivraison,commande.idres AS idres FROM commande,restaurant WHERE
					commande.idres = restaurant.idres AND
					commande.numcom = ".$num_cmd.";");
		$get_data1 = $resultat1->fetch();


		$resultat2 = $cnx->query("SELECT nomplat,prix,quantite FROM commande,contenir,plat
					WHERE commande.numcom=contenir.numcommande AND contenir.idplat=plat.idplat
					AND commande.numcom=".$num_cmd.";");


		$res1_bis  = $cnx->query("SELECT avg(note) AS avgnote FROM commenter WHERE idres = ".$get_data1['idres'].";");
		$get_bis   = $res1_bis->fetch();
		
		$resultat3 = $cnx->query("SELECT * FROM commenter WHERE idcli=".$id." AND idres=".$get_data1['idres'].";");
		

		echo "
			<table class='feedback_block'>
				<tbody>
					<tr>
						<td colspan='2'>
							<h4>Restaurant : ".$get_data1['nom']."</h4><br/>
							Adresse : ".$get_data1['adresse']."<br/>
							Note global: ".floatval($get_bis['avgnote'])."/5
						</td>

					</tr>
					<tr>
						<td>";
							echo "<h5>Commande n° ".$num_cmd."</h5>";

		$total=0;
		foreach($resultat2 as $data){
			$total += $data['prix']*$data['quantite'];
			echo $data['nomplat']."---Quantite :".$data['quantite']." ----".$data['prix']*$data['quantite']."€ <br/>";
		}
		echo "Prix livraison : ".$get_data1['prixlivraison']."€";
		$total +=$get_data1['prixlivraison'];
		echo "
							<p><b>Total : $total €</b></p>
						</td>";


				if($resultat3->rowCount() == 0){

					echo"
						<td>
							<h5>Noter et commenter</h5>
							<span style='color:red;'>$msg_comment</span>
							<form method='POST' action='#'>
							Note :";

							for($i=1; $i < 5; $i++){
								echo "<input type='radio' name='note' value='$i' />$i ";
							}
								echo "<input type='radio' name='note' value='5' checked/>5
								<br/><textarea name='comment' placeholder='Ecrire un commentaire' cols='50'></textarea><br/>
								<input type='hidden' name='idres' value='".$get_data1['idres']."' />
								<input type='hidden' name='numcmd' value='".$_GET['numcmd']."' />

								<input type='submit' name='add_comment' value='Envoyer' />
							</form>
						</td>";
				}else{
					$get_data2 = $resultat3->fetch();

					echo"
					<td>
							<h5>Vous avez déjà donné votre avis à propos de cet restaurant.</h5>
							Votre commantaire : ".$get_data2['commentaire']."<br/>
							Votre note : ".$get_data2['note']."
						</td>";

				}
					echo"
					</tr>
				</tbody>
			</table>
		";
	}
?>