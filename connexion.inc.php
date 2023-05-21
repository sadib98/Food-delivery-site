<?php

/*
 * création d'objet PDO de la connexion qui sera représenté par la variable $cnx
 */
try {
	$user		= 'postgres';
	$pass		= 'sadib';

    $cnx = new PDO('pgsql:host=127.0.0.1;port=5432; dbname=postgres', $user, $pass);

}
catch (PDOException $e) {
    echo "ERREUR : La connexion a échouée";

}
