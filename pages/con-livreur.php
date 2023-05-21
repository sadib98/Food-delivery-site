<?php
	$msg_con_livreur = NULL;
	if(isset($_POST['conlivreur'])){
		$id=$_POST['matricule'];
		$pass=$_POST['pass'];

		$resultat = $cnx->query("SELECT matricule FROM livreur WHERE matricule='".$id."' AND mot_de_passe='".$pass."';");

		if($resultat == False){
			$msg_con_livreur = "<b>Erreur d'authentification !</b>";
		}else{
			$get_idliv = $resultat->fetch();
			$idliv = $get_idliv['matricule'];
			if($idliv == NULL){
				$msg_con_livreur = "<span style='color:red; font-size:14px;font-weight:bold;'>Votre Matricule ou Mot de passe est incorrect.</span>";
			}else{
				$_SESSION['idliv']=$idliv;
				header("Location: livreur/index.php");
			}
		}
	}
?>

<div class="form-block">
	<div class="form-title">
		CONNEXION<br/>
		<div class="form-subtitle">Connecter en tant que livreur.</div>
	</div>

	<div class="form">
		<?php
			if($msg_con_livreur != NULL){
				echo $msg_con_livreur;
			}
		?>
		<form method="post" action="">

		 	<input type="text" name="matricule" placeholder="Matricule" class="field"/><br/>

		 	<input type="password" name="pass" placeholder="Mot de passe" class="field"/><br/>

		 	<input type="reset" name="" value="Réinitialiser" class="button">
		 	<input type="submit" name="conlivreur" value="Connecter" class="button">

		</form>
	</div>
</div>