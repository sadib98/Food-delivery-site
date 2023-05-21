<?php
	if(isset($_GET['action'])){
		$action = $_GET['action'];

		if($action == 'accepter_cmd'){
			$cnx->exec("UPDATE commande SET etat='en cours', idliv=".$matricule." WHERE numcom=".$_GET['cmd'].";");
			$cnx->exec("UPDATE livreur SET etat='en course' WHERE matricule=".$matricule.";");
			header("Location:index.php?cmd=".$_GET['cmd']."");
		
		}else if($action == 'livrer_cmd'){

			$cnx->exec("UPDATE commande SET etat='Livré' WHERE numcom=".$_GET['cmd'].";");
			$cnx->exec("UPDATE livreur SET etat='en attente' WHERE matricule=".$matricule.";");

			// Récupération de idcli de la commande
			$res1=$cnx->query("SELECT idcli FROM commande WHERE numcom='".$_GET['cmd']."' ;");
			$idcli_cmd=$res1->fetch();


			// Ajout des points fidelites au parrain
			$res2=$cnx->query("SELECT idparrain FROM parrainer WHERE idcli='".$idcli_cmd['idcli']."' ;");
			if($res2->rowCount() > 0){
				$id_parrain=$res2->fetch();

				$res3=$cnx->query("SELECT pointsfidelite FROM client WHERE idcli='".$id_parrain['idparrain']."' ;");
				$get_points=$res3->fetch();

				$new_points=$get_points['pointsfidelite']+5;

				$cnx->exec("UPDATE client SET pointsfidelite=".$new_points." WHERE idcli=".$id_parrain['idparrain']." ;");
			}

			// Points de fidélité - Réduction
			$res4=$cnx->query("SELECT pointsfidelite FROM client WHERE idcli='".$idcli_cmd['idcli']."' ;");
			
			if($res4->rowCount() > 0){

				$get_points=$res4->fetch();
				if($get_points['pointsfidelite'] >= 5){
					$reduc_points = $get_points['pointsfidelite']-5;
					$cnx->exec("UPDATE client SET pointsfidelite=".$reduc_points." WHERE idcli=".$idcli_cmd['idcli']." ;");
				}	

			}

			header("Location:index.php");
		}
	}
?>
<div class="left-sidebar-block">
	<div class="livreur-statut">
		Statut : <?php echo $statut; ?>
	</div>

	<div class="commande-wait-block">
		<div class="commande-wait-title">
			Commande en attente
		</div>
		<div class="commande-item-list">
			<?php
				if($statut == 'en attente'){
					$res = $cnx->query("SELECT numcom FROM travailler,restaurant,commande
					WHERE travailler.codepostal = restaurant.codepostal AND restaurant.idres = commande.idres AND travailler.matricule = ".$matricule." AND commande.etat='en attente';");

				if($res->rowCount() == 0){
					echo "Il n'y a aucune commande qui est en attente pour le moment.";
				}else{
					foreach($res AS $data){
						echo"
							<div class='commande-item'>
								<a href='?cmd=".$data['numcom']."'>Cmd ".$data['numcom']."</a>
							</div>
						";
					}
				}
				}else if($statut == 'en course'){
					echo "Vous êtes déjà en cours de livraison.";
				}else if($statut == 'inactif'){
					echo "Vous devez changer votre statut en 'en attente' pour accèder aux commandes en attente de livraison.";
				}
			?>
		</div>
	</div>
</div>
<div class="right-sidebar-block">

	<?php

		if(isset($_GET['cmd']) OR $statut == 'en course'){
			
			if(isset($_GET['cmd'])){
				$num_cmd = $_GET['cmd'];
			}else if($statut == 'en course'){
				$res = $cnx->query("SELECT numcom FROM commande WHERE idliv=".$matricule." AND commande.etat='en cours';");
				$get_numcom=$res->fetch();
				
				$num_cmd = $get_numcom['numcom'];
			}

			$res = $cnx->query("SELECT commande.etat AS cmdetat,restaurant.adresse AS adr_res,client.adresse AS adr_cli FROM client,commande,restaurant 
				WHERE
				client.idcli = commande.idcli AND
				restaurant.idres = commande.idres AND
				numcom=".$num_cmd.";");
			
			$get_data = $res->fetch();

			echo "
				<div class='commande-details-block'>
				<div class='commande-details-title'>
					Détail de la commande
				</div>
				<div class='commande-details-content'>
					Num Commande : ".$num_cmd."<br/>
					Restaurant adresse : ".$get_data['adr_res']." <br/>
					Client adresse : ".$get_data['adr_cli']." <br/>
				</div>";

			if($get_data['cmdetat'] == 'en attente'){
				echo"
				<!--Button accepter la commande-->
				<a href='?cmd=".$num_cmd."&&action=accepter_cmd'>
					<div class='button-commande'>
						Accepter la commande
					</div>
				</a>";
			}else if($get_data['cmdetat'] == 'en cours'){
				echo "
				<!--Button Livré-->
				<a href='?cmd=".$num_cmd."&&action=livrer_cmd'>
					<div class='button-commande'>
						Livré
					</div>
				</a>";
			}
				
				echo"	
			</div>
			";
		}

		
	?>
</div>