<html lang="fr">
	<head>
		<title>Kezako - Contribuer</title>
		<meta name="keywords" lang="fr" content="kezako,contribuer" />
		<title>Contribuer</title>
		<?php require_once '../common/include.inc';?>
	</head>

	<body>
	<!-- Insertion de la barre de navigation -->
    <?php require_once('../common/header.php');
    	require_once ('../common/connection.php');

		if (isset($_GET['msg']) ) {
	
			echo "<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			".$_GET['msg']."</div>";
		}

    ?>
	<div class="wrap">
		<div class="container main">
			<div class="container-fluid">
				<div class="page-header">
					<h1>Proposer de nouvelles questions</h1>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Nouvelle question</h4>
					</div>
					

					
					<div class="panel-body">
						<div class="row">
				
							<div class="col-md-6 col-md-offset-4">
								<form class="form-horizontal" role="form" action="insert_new_question.php" method="POST" >
									<div class=" col-sm-10">
										<div class="form-group">
											<label for="Cat">Catégorie&nbsp;:</label>
											<div class="row-fluid">
											<select required  data-width="100%" class="selectpicker show-tick"  title='Choisissez une catégorie' name="Cat" id="Cat">
											<?php
											$requete = 'SELECT idCategorie, labelCategorie from categorie where idCategorie <> 1';
											 
											$categories = $connexion->query($requete, MYSQLI_USE_RESULT);
											 
											
											while ($row = $categories->fetch_row()) {
												echo "<option value=\"".$row[0]."\">".$row[1]."</option>";
											}
	
											mysqli_free_result($categories);
											$connexion->close();
											?>
										</select>
										</div>
										</div>
									</div>
									<div class=" col-sm-10">
										<div class="form-group">
											<label for="Cat">Question&nbsp;:</label>
											<input type="text" class="form-control" name="question" placeholder="Question" required>
										</div>
									</div>
									<div class=" col-sm-10">
										<div class=" form-group">
											<label for="Cat">Bonne réponse&nbsp;:</label>
											<input type="text" class="form-control" name="bonnereponse" placeholder="Bonne réponse" required>
										</div>
									</div>
									<div class=" col-sm-10">
										<div class=" form-group">
											<label for="Cat">Mauvaise réponse&nbsp;:</label>
											<input type="text" class="form-control" name="mauvaisereponse1" placeholder="Mauvaise réponse" required>
										</div>
									</div>
									<div class=" col-sm-10">
										<div class=" form-group">
											<label for="Cat">Mauvaise réponse&nbsp;:</label>
											<input type="text" class="form-control" name="mauvaisereponse2" placeholder="Mauvaise réponse" required>
										</div>
									</div>
									<div class=" col-sm-10">
										<div class=" form-group">
											<label for="Cat">Mauvaise réponse&nbsp;:</label>
											<input type="text" class="form-control" name="mauvaisereponse3" placeholder="Mauvaise réponse" required	>
										</div>
									</div>
									<div class=" col-sm-10">
										<div class="form-group">
											<button type="submit" class="btn btn-success">Sauvegarder</button>
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
	</div>
	<?php include('../common/footer.php'); ?>
	<script>$('select').selectpicker();</script>
	</body>
</html>
