<?php

	if(isset($_POST['reg_client'])){
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$telephone = $_POST['telephone'];
		$carte_bank = $_POST['ncb'];
		$adresse = $_POST['adresse'];
		$codepostal = $_POST['codepostal'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];

		if(empty($nom) OR empty($prenom) OR empty($telephone) OR empty($carte_bank) OR empty($adresse) OR empty($email) OR empty($pass)){
			echo "<span style='color:red;'>Tous les champs sont obligatoires.</span>";
		}else{

			$check = $cnx->query("SELECT * FROM client WHERE mail='$email' OR telephone='$telephone' OR numcb='$carte_bank' ;");



			if($check->rowCount() != 0){
				echo "<span style='color:red;'>Un compte existe déjà avec vos informations fournis.</span>";
			}else{
				$cnx->exec("INSERT INTO client 
							(nom,  prenom,  mail,   telephone,  numcb,       adresse,  codepostal, pointsfidelite, mot_de_passe) VALUES
							('$nom', '$prenom', '$email', '$telephone', '$carte_bank', '$adresse', '$codepostal', 0,'$pass');");

				echo "<p>INSCRIPTION REUSSI ! <br/> Vous pouvez maintenant vous connecter.</p>";
			}
		}
	}
?>

<div class="form-block">
	<div class="form-title">
		INSCRIPTION<br/>
		<div class="form-subtitle">Devenez notre client</div>
	</div>

	<div class="form">
		<form method="post" action="#">

		 	<input type="text" name="nom" placeholder="Nom" class="field"/><br/>

		 	<input type="text" name="prenom" placeholder="Prénom" class="field"/><br/>

		 	<input type="text" name="telephone" placeholder="Téléphone" class="field"/><br/>

		 	<input type="text" name="ncb" placeholder="N° Carte Bancaire" class="field"/><br/>

		 	<input type="text" name="adresse" placeholder="Adresse" class="field"/><br/>

		 	Ville : <select name="codepostal">
		 	<?php
		 		$res = $cnx->query("SELECT nom,codepostal FROM ville;");
		 		foreach($res AS $data){
		 			echo "<option value='".$data['codepostal']."'>".$data['nom']."</option>";
		 		}
		 	?>
		 	</select><br/>
		 	<span style="font-size:13px;">Si votre ville n'est pas dans la liste cela veut dire qu'il n'y pas de restaurant dans votre ville.</span>
		 	<br/>

		 	<input type="email" name="email" placeholder="E-mail" class="field"/><br/>

		 	<input type="password" name="pass" placeholder="Mot de passe" class="field"/><br/>

		 	<input type="reset" name="" value="Réinitialiser" class="button">
		 	<input type="submit" name="reg_client" value="Inscrire" class="button">

		</form>
	</div>
</div>