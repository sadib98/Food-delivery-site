<?php
	session_start();

	if(empty($_SESSION['idclient'])){
		//echo "Session id_client manque.";
		header("Location: ../index.php");
	}else{
		include("../connexion.inc.php");
		$resultat = $cnx->query("SELECT * FROM client WHERE idcli=".$_SESSION['idclient'].";");

		if($resultat == False){
			//echo "Erreur dans la requete.";
			header("Location: ../index.php");
		}else{
			$get_data = $resultat->fetch();

			$id = $get_data['idcli'];
			$nom = $get_data['nom'];
			$prenom = $get_data['prenom'];
			$email = $get_data['mail'];
			$telephone = $get_data['telephone'];
			$numcb = $get_data['numcb'];
			$adresse = $get_data['adresse'];
			$codepostal = $get_data['codepostal'];
			$pointsfidelite = $get_data['pointsfidelite'];

			if($id == NULL){
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
		<link rel="stylesheet" type="text/css" href="clientstyle.css">
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
