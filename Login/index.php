<?php
	require_once '../common/connection.php'; 
	require_once '../common/fcompte.php'; 
?>
<html lang="fr">
	<head>
		<title>Connexion/Inscription</title>
		<?php require_once '../common/include.inc';?>
	</head>
	<body >
		<div class="wrap">
		
			<?php require_once '../common/header.php';?>
			
			<div class="container main">
				<div class="container-fluid">
					<div class="page-header">
						<h1>Bienvenue <small>Kezakoien</small></h1>
					</div>
					<div class="panel panel-default">
						 <div class="panel-body">
							<div class="row text-center">
								<?php
									$error = null;
									
									// Cas déjà connecter
									if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
										if (CheckUserConnected($_SESSION['login'], $_SESSION['password'], $error) != -1) {
											header("Location: ../Room/");
											exit();
										}
									}
									
									// Cas d'inscription
									if (isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['email'])) {
										if (!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
											if ($_POST['password1'] == $_POST['password2'])
											{
												if (freeEmail($_POST['email'], $error))
												{
													creerUtilisateur($_POST['login'], $_POST['email'], cryptageCompte($_POST['password1']), $error);
													if (empty($error)) {
														envoyerMailInscription($_POST['email'], $_POST['password1']);
														echo "<div class='alert alert-info alert-dismissable'>
														  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														  <strong>Info!</strong> Un email a été envoyé avec vos identifiants. Attention, il se peut qu\'il soit dans vos spams.
														</div>";
													} else {
														echo "<div class='alert alert-danger alert-dismissable'>
																<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
																<strong>Erreur!</strong> ".$error.".
															</div>";
													}
												}
												else {
													echo "<div class='alert alert-danger alert-dismissable'>
														  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														  <strong>Erreur!</strong> ".$error.".
														</div>";
												}
											}
										}
									}
									
									// Cas de connexion
									if (isset($_POST['login'])&&isset($_POST['password'])){
										if(!empty($_POST['login'])&&!empty($_POST['password']))
										{
											if(ConnexionUtilisateur($_POST['login'], $_POST['password'], $passcrypt, $error))
											{
												$_SESSION['login']=$_POST['login'];
												$_SESSION['password']=$passcrypt;
												$_SESSION['status']=1;
												header("Location: ../Room/");
												exit();
											}
											else {
												echo "<div class='alert alert-danger alert-dismissable'>
														  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														  <strong>Erreur!</strong> ".$error.".
														</div>";
											}
										}
									}
									
									// Cas de réinitialisation
									if (isset($_POST['emailRestart'])) {
										if (!empty($_POST['emailRestart']))
										{
											$motdepasse = genererMotDePasse(10);
											$mdpEncrypte = cryptageCompte($motdepasse);
											if (changerMotDePasse($_POST['emailRestart'], $mdpEncrypte, 0, $error) != 1)
											{
												envoyerMailRestart($_POST['emailRestart'], $motdepasse);
												echo "<div class='alert alert-info alert-dismissable'>
														  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														  <strong>Info!</strong> Un email a été envoyé avec votre mot de passe généré. Attention, il se peut qu\'il soit dans vos spams.
														</div>";
											} else {
												echo "<div class='alert alert-danger alert-dismissable'>
														  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
														  <strong>Erreur!</strong> ".$error.".
														</div>";
											}
										}
									}
								?>
								<div class="col-md-6" style="border-right: solid 1px #ccc">
									
									<h1 class="text-left" style="border-bottom: solid 1px #ccc ">Inscription</h1>
									<!-- Formulaire d'inscription -->
									<form class="form-horizontal" role="form" action="index.php" method="POST" >
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
												<input type="text" class="form-control" placeholder="Utilisateur" required name="login">
											</div>
										</div>
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<span class="input-group-addon">@</span>
												<input type="email" class="form-control" placeholder="Email" required name="email">
											</div>
										</div>
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-flash"></span></span>
												<input type="password" class="form-control" placeholder="Mot de passe" required name="password1">
											</div>
										</div>
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-flash"></span></span>
												<input type="password" class="form-control" placeholder="Confirmer mot de passe" required name="password2">
											</div>
										</div>
										<div class=" col-sm-10">
											<div class="form-group">
												<button type="submit" class="btn btn-default">Inscription</button>
											</div>
										</div>
									</form>
									<!-- End - Formulaire d'inscription -->
								</div>
								
								<div class="col-md-6 ">
									<h1 class="text-left" style="border-bottom: solid 1px #ccc">Connexion</h1>
									<!-- Formulaire de connexion -->
									<form class="form-horizontal" role="form" action="index.php" method="POST">
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
												<input type="text" class="form-control" placeholder="Utilisateur" required name="login">
											 </div>
										</div>
											
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-flash"></span></span>
												<input type="password" class="form-control" placeholder="Mot de passe" required name="password">
											</div>
										</div>
										
										<div class=" col-sm-10">
											<div class="input-group form-group">
												<a href="#" data-target=".bs-example-modal-lg" data-toggle="modal">Mot de passe oublié ?</a>
											</div>
										</div>
											
										<div class=" col-sm-10">
											<div class="form-group">
												<button type="submit" class="btn btn-primary">Connexion</button>
											</div>
										</div>
									</form>
									<!-- End - Formulaire de connexion -->
								</div>
								
							</div>
						 </div>
					</div>
				</div>
			</div>
		</div>


	<!-- Modal PopUp creation -->
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        	<h4 class="modal-title">Mot de passe oublié ?</h4>
	      	</div>
	      	<div class="modal-body">
				<form role="form" action="index.php" method="GET">
					<div class="form-group">
						<p>Veuillez entrer l'email saisi lors de votre inscription :<p>
						<input type="email" class="form-control" placeholder="Email" required name="emailRestart">
					</div>
					<input id="sub" type="submit" style="display:none"/>
				</form>
	      	</div>
	      	<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        		<button type="button" class="btn btn-primary" onclick="$('#sub').click();">Valider</button>
      		</div>	      
	    </div>
	  </div>
	</div>		
	
	<?php require_once '../common/footer.php'; ?>
	
	</body>
</html>