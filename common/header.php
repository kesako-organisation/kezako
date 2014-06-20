<?php
	require_once  '../common/fcompte.php';
	
	$connecter = 0;
	$status = 0;
	if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
		if (CheckUserConnected($_SESSION['login'], $_SESSION['password'], $error) != -1) {
			$connecter = 1;
			$status = $_SESSION['status'];
		}
	}
	
	if (isset($_GET['logout'])) {
		Deconnexion();	
		header("Location: ../");
		exit();
	}
	
	setlocale (LC_ALL, 'fr-FR.utf8','fra');
	
?>

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="../Login/index.php"><i class="glyphicon glyphicon-home"></i></a>
				</div>
	
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<?php
							if($connecter == 1) {
						?>
						<li><a href="../Room/index.php">Salle de jeux</a></li>
						<li><a href="../Contribuer/index.php">Contribuer</a></li>
						<?php }
							if($status == 1){
						?>
						<li><a href="../Contribuer/valider.php">Valider questions</a></li>
						<li><a href="../Contribuer/supprimer.php">Supprimer questions</a></li>
						<?php } ?>
					</ul>
					
					<?php
					if($connecter == 1) {
					?>
						<div class="pull-right">
							<ul class="nav navbar-nav">
							<li>
							<a href="../Compte/index.php" style="color:white;" class="navbar-brand"><?php echo $_SESSION['login']; ?>
							<img style="max-height:35px;max-width:35px;" src="../img/joueurs/<?php echo $_SESSION['login']; ?>.jpg"/></a>
							</li>
							<li><a href="?logout=1" style="color:white;">
								<button class="btn btn-warning btn-sm" type="submit">
									<i class="glyphicon glyphicon-off"></i>
									Déconnexion
								</button>
							</a></li>

						</ul>
						</div>
						
					<?php
						}
					?>
				</div>
				

			  	
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>
