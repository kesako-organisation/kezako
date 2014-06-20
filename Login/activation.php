<?php
	// Page d'activation du compte utilisateur
	include('../common/connection.php');
	include('../common/fcompte.php');
?>
<!doctype html>
<html>
<head>
    <title>Activation</title>
	<?php require_once '../common/include.inc'; ?>
</head>
<body>
    <?php
        include('../common/header.php');
    ?>
	<div class="wrap">
		<div class="container main">
			<div class="container-fluid">
			
				<div class="page-header">
					<h1>Activation de votre compte</h1>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row text-center">
							<?php
								echo "<p>";
								if(isset($_GET['key']))
								{
									if(!empty($_GET['key']))
									{
										if (!activerCompte($_GET['key'], $error))
											echo $error;
										else
											echo "Votre compte est activé !";
									}
								}
								else
									echo "Aucune clé d'activation n'a été détectée.";
								echo "</p>";
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		include('../common/footer.php');
	?>
</body>
</html>