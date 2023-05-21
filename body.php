<div class="body-block">
	<?php
		if(isset($_GET['page'])){
			$page=$_GET['page'];

			if($page == 'regclient'){
				include('pages/reg-client.php');
			}elseif($page == 'reglivreur'){
				include('pages/reg-livreur.php');
			}elseif($page == 'conclient'){
				include('pages/con-client.php');
			}elseif($page == 'conlivreur'){
				include('pages/con-livreur.php');
			}else{
				include('pages/home.php');
			}
		}else{
			include('pages/home.php');
		}
	?>
</div>