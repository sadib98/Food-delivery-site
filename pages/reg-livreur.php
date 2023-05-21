<?php

	if(isset($_POST['reg_livreur'])){
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$telephone = $_POST['telephone'];
		$adresse = $_POST['adresse'];
		$pass = $_POST['pass'];

		if(empty($nom) OR empty($prenom) OR empty($telephone) OR empty($adresse) OR empty($pass)){
			echo "<span style='color:red;'>Tous les champs sont obligatoires.</span>";
		}else{

			$check = $cnx->query("SELECT * FROM client WHERE telephone='$telephone';");

			if($check->rowCount() != 0){
				echo "<span style='color:red;'>Un compte existe déjà avec vos informations fournis.</span>";
			}else{
				$reg_liv = $cnx->query("INSERT INTO livreur
							(nom,  prenom, telephone, adresse, mot_de_passe, etat) VALUES
							('$nom', '$prenom', '$telephone', '$adresse', '$pass', 'inactif') RETURNING matricule;");

				$matricule_liv = $reg_liv->fetch(); 
				echo "<p>INSCRIPTION REUSSI ! <br/>
				<b>Votre n° matricule : ".$matricule_liv['matricule']."</b><br/>
				Vous pouvez maintenant vous connecter avec votre n° matricule et mot de passe.</p>";
			}
		}
	}
?>

<div class="form-block">
	<div class="form-title">
		INSCRIPTION<br/>
		<div class="form-subtitle">Devenez notre livreur</div>
	</div>

	<div class="form">
		<form method="post" action="#">

		 	<input type="text" name="nom" placeholder="Nom" class="field"/><br/>

		 	<input type="text" name="prenom" placeholder="Prénom" class="field"/><br/>

		 	<input type="text" name="telephone" placeholder="Téléphone" class="field"/><br/>

			<input type="text" name="adresse" placeholder="Adresse" class="field"/><br/>

		 	<input type="password" name="pass" placeholder="Mot de passe" class="field"/><br/>

		 	<input type="reset" name="" value="Réinitialiser" class="button">
		 	<input type="submit" name="reg_livreur" value="Inscrire" class="button">

		</form>
	</div>
</div>