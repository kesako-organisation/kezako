<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Kezako - Gérer votre compte</title>
		<meta name="keywords" lang="fr" content="kezako,mise en situation, a propos" />
		<title>À propos</title>
		<?php
			require_once '../common/include.inc';
			require_once '../common/connection.php'; 
			require_once '../common/fcompte.php';
		?>
		
	</head>

	<body>
	<!-- Insertion de la barre de navigation -->
	<?php
		include('../common/header.php');
		
		//Output 
		$bad_pwd = '';
		$updateProfile_bad_message = '';
		$updateProfile_good_message = '';
		$mail_error = '';
		$userMail = getInfoUtilisateur($_SESSION['login'], $error);
		
		if (!isset($_SESSION['login']) && !isset($_SESSION['password'])) {
			header("Location: ../index.php");
			exit();
		}
		
		if(isset($_REQUEST['email']))
		{
			$mail = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['email']));
			$oldPwd = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['passwordold']));
			$newPwd = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['password1']));

			$fichier = $_FILES["picture"];
			if ($fichier["error"] == UPLOAD_ERR_OK) {
				require_once('imageresizer.class.php');
				//Path To Upload Directory
				$dirpath = "../img/joueurs/";
				
				//MAX WIDTH AND HEIGHT OF IMAGE
				$max_height = 50; $max_width = 50;
				
				//Create Image Control Object - Parameters(file name, file tmp name, file type, directory path)
				$resizer = new ImageResizer($_SESSION['login'],$fichier['tmp_name'],$dirpath);
				
				//RESIZE IMAGE - Parameteres(max height, max width)
				$resizer->resizeImage($max_height,$max_width);
			}
			
			// Changement de mots de passe
			$error = null;
			if (isset($_POST['passwordold']) && isset($_POST['password1']) && isset($_POST['password2'])) {
				// Control du mot de passe courant
				if (($_POST['passwordold'] != '') && !verifierMotDePasse($_SESSION['login'],$_POST['passwordold'],$error)){
					$bad_pwd = "<div class='alert alert-danger alert-dismissable form-group'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								<strong>Erreur!</strong> ".$error."</div>";
				}
				else if (($_POST['password1'] != '') && ($_POST['password2'] != '')){
					if (($_POST['password1'] == $_POST['password2'])) {
						if ($_POST['passwordold'] == $_POST['password1']) {
							$updateProfile_bad_message = "<div class='alert alert-danger alert-dismissable form-group'>
														<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														<strong>Erreur!</strong> Le nouveau mots de passe est identique</div>";
						}
						else if(!changerMotDePasse($_SESSION['login'], $_POST['password2'], $error)){
							$updateProfile_bad_message = "<div class='alert alert-danger alert-dismissable form-group'>
														<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														<strong>Erreur!</strong> ".$error."</div>";
						}
					}
					else {
						$updateProfile_bad_message = "<div class='alert alert-danger alert-dismissable form-group'>
														<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														<strong>Erreur!</strong> Mots de passe différent.
													</div>";
					}
				}
			}
			
			// Changement de l'e-mail
			$error = null;
			if (isset($_POST['email'])) {
				if ($_POST['email'] != ''){
					// Control du mot de passe courant
					if (!changerEmail($_SESSION['login'],$_POST['email'],$error)){
						$mail_error = "<div class='alert alert-danger alert-dismissable form-group'>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
									<strong>Erreur!</strong> ".$error."</div>";
					}else{
						$userMail = getInfoUtilisateur($_SESSION['login'], $error);
					}
				}
			}
			
		}
	?>
	<div class="wrap">
		<div class="container main">
			<div class="container-fluid">
				<div class="page-header">
					<h1>Gérer votre compte</h1>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
				
						<div class="row text-center">
						
						<div class="col-md-6 col-md-offset-4">
							<form class="form-horizontal" role="form" action="index.php" method="post" enctype="multipart/form-data" >
								<div class="col-sm-10">
									<div class="input-group form-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input disabled="true" type="text" class="form-control" value="<?php echo $_SESSION['login'];?>" id="login" name="login">
									</div>
								</div>
								<div class="col-sm-10">
									<div class="input-group form-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input type="email" class="form-control" placeholder=<?php echo $userMail ?> name="email">
									</div>
									<?php echo $mail_error; ?>
									<hr/>
								</div>
								
								<div class="col-sm-10">
									
									<div class="alert alert-info form-group">
										<strong>Vous devez saisir votre mot de passe actif pour le modifier.</strong>
									</div>
									<div class="input-group form-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
										<input type="password" class="form-control" placeholder="Ancien mot de passe" name="passwordold" id="passwordold">
									</div>
									<?php echo $bad_pwd; ?>
								</div>
								<div class="col-sm-10">
									<div class="input-group form-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
										<input type="password" class="form-control" placeholder="Nouveau mot de passe" name="password1" id="password1">
									</div>
								</div>
								<div class="col-sm-10">
									<div class="input-group form-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-check"></i></span>
										<input type="password" class="form-control" placeholder="Confirmer mot de passe" name="password2" id="password2"/>
									</div>
									<?php echo $updateProfile_bad_message; ?>
									<hr/>
								</div>
								
								<div class="col-sm-10">
									<div class="form-group">
										<input name="picture" type="file" class="filestyle" data-buttonBefore="true">
									</div>
								</div>
								
								<div class="col-sm-10">
									<div class="form-group">
										<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-save"></i> Sauvegarder</button>
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
	
	<?php
		$connexion->close();
		include('../common/footer.php');
	?>
	</body>
</html>