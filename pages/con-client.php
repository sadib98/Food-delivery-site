<?php
	$msg_con_client = NULL;
	if(isset($_POST['conclient'])){
		$email=$_POST['email'];
		$pass=$_POST['pass'];

		$resultat = $cnx->query("SELECT idcli FROM client WHERE mail='".$email."' AND mot_de_passe='".$pass."';");

		if($resultat == False){
			$msg_con_client = "<b>Erreur d'authentification !</b>";
		}else{
			$get_id = $resultat->fetch();
			$id = $get_id['idcli'];
			if($id == NULL){
				$msg_con_client = "<span style='color:red; font-size:14px;font-weight:bold;'>Votre E-mail ou Mot de passe est incorrect.</span>";
			}else{
				$_SESSION['idclient']=$id;
				header("Location: client/index.php");
			}
		}
	}
?>

<div class="form-block">
	<div class="form-title">
		CONNEXION<br/>
		<div class="form-subtitle">Connecter en tant que client.</div>
	</div>

	<div class="form">
		<?php
			if($msg_con_client != NULL){
				echo $msg_con_client;
			}
		?>
		<form method="POST" action="#">

		 	<input type="text" name="email" placeholder="E-mail" class="field"/><br/>

		 	<input type="password" name="pass" placeholder="Mot de passe" class="field"/><br/>

		 	<input type="reset" name="" value="Réinitialiser" class="button">
		 	<input type="submit" name="conclient" value="Connecter" class="button">

		</form>
	</div>
</div>