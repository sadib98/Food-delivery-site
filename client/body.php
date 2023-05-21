<div class="body-block">
	<?php
		if(isset($_GET['page'])){
			$page=$_GET['page'];

			if($page == 'restaurant'){
				include('restaurant.php');
			}elseif($page == 'panier'){
				include('panier.php');
			}elseif($page == 'confirmation'){
				include('confirmation.php');
			}elseif($page == 'compte'){
				include('compte.php');
			}elseif($page == 'feedback'){
				include('feedback.php');
			}else{
				include('home.php');
			}
		}else{
			include('home.php');
		}
	?>
</div>