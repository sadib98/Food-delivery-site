<div class="body-block">
	<?php
		if(isset($_GET['page'])){
			$page=$_GET['page'];

			if($page == 'compte'){
				include('compte.php');
			}else{
				include('home.php');
			}
		}else{
			include('home.php');
		}
	?>
</div>