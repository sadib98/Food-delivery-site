<div class="list-restaurant-block">
	<div class="list-restaurant-title">
		<?php
			$resultat = $cnx->query("SELECT nom FROM ville WHERE codepostal=".$codepostal.";");
			$get_data = $resultat->fetch();

			$nom_vile = $get_data['nom'];

			echo $nom_vile;
		?> | Spécialité : <?php
			if(isset($_GET['specialite'])){
				echo $_GET['specialite'];
			}else{
				echo "Toutes";
			}
		?> 
	</div>
	<div class="recherche-restaurant-block">
		<form action="#" method="GET">
			<table>
				<tr>
					<td>
						<input type="text" name="search" placeholder="Rechercher un restaurant" class="recherche-restaurant-field"/>
					</td>
					<td>
						<input type="submit" name="submit" value="RECHERCHER" class="recherche-restaurant-button"/>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<!--Liste des restaurants-->
	<div class="list-restaurant">
		<?php
			if(isset($_GET['specialite'])){

				$resultat = $cnx->query(
					"SELECT *
					FROM restaurant NATURAL JOIN decriverspecialite
					WHERE codepostal = ".$codepostal." AND motclef = '".$_GET['specialite']."';");
			}elseif(isset($_GET['search'])){
				$search=$_GET['search'];
				$resultat = $cnx->query("SELECT * FROM restaurant WHERE codepostal=".$codepostal." AND nom LIKE '%$search%';");
			}else{
				$resultat = $cnx->query("SELECT * FROM restaurant WHERE codepostal=".$codepostal.";");
			}

			if($resultat->rowCount() == 0){
				echo "Aucun restaurant n'a été trouvé !";
			}else{
				foreach($resultat AS $data){
					echo "
					<a href='?page=restaurant&&idres=".$data['idres']."'>
					<div class='restaurant-item'>
						<div class='restaurant-image-block'>
							<img src='logo/".$data['image']."' width='100%' height='100%' />
						</div>
						<div class='restaurant-descrip-block'>
							<h4>".$data['nom']."</h4>
							<p>
								Adresse : ".$data['adresse']."<br/>
							</p>
						</div>
					</div></a>
					";
				}
			}
			
		?>
	</div>
</div>

<div class="list-specialite-block">
	<div class='list-specialite-title'>
		Choisissez votre spécialité préféré
	</div>
	<div class="list-specialite">
		<?php

			$resultat = $cnx->query("SELECT motclef FROM specialite;");

			foreach($resultat AS $data){
				
				echo "
					<a href='?specialite=".$data['motclef']."'><div class='specialte-item'>
						".$data['motclef']."
					</div></a>
				";
			}
		?>
	</div>
</div>