<?php
	session_start();

	if(empty($_SESSION['idliv'])){
		//echo "Session id_client manque.";
		header("Location: ../index.php");
	}else{
		include("../connexion.inc.php");
		$resultat = $cnx->query("SELECT * FROM livreur WHERE matricule=".$_SESSION['idliv'].";");

		if($resultat == False){
			//echo "Erreur dans la requete.";
			header("Location: ../index.php");
		}else{
			$get_data = $resultat->fetch();

			$matricule = $get_data['matricule'];
			$nom = $get_data['nom'];
			$prenom = $get_data['prenom'];
			$telephone = $get_data['telephone'];
			$adresse = $get_data['adresse'];
			$statut = $get_data['etat'];

			if($matricule == NULL){
				//echo "Id client est fausse.";
				header("Location: ../index.php");
			}
		}
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Enjoy !</title>

		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="stylesheet" type="text/css" href="livreurstyle.css">
	</head>

	<body>
			<?php 
				//Head 
				include('head.php');

				//Body
				include('body.php');

				//footer
				include('../footer.php');
			?>
	</body>
</html>
