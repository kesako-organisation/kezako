<!DOCTYPE html>
		
<html lang="fr">
	<head>
		<title>Kezako - Salles de jeu</title>
		<meta name="keywords" lang="fr" content="kezako,mise en situation, salles" />
		<?php require_once '../common/include.inc';?>
		<link href="../css/room.css" rel="stylesheet">
	</head>
	
	<body>
		<div class="wrap">
			<?php 
				require_once '../common/header.php';
				require_once '../common/connection.php';
				require_once "../common/fcompte.php";
				
				// Cas déjà connecter
				if (!isset($_SESSION['login']) && !isset($_SESSION['password'])) {
					header("Location: ../index.php");
					exit();
				}
				

				/* Requete permettant de récuperer les informations des room*/
				$requete = 'SELECT s.idSalle, s.nomSalle, s.nbQuestions, s.tempsLimite, c.labelCategorie, COUNT( idJoueur ) AS Count
							FROM SALLE s LEFT JOIN CATEGORIE c ON s.idCategorie = c.idCategorie
								LEFT JOIN SALLEJOUEUR sJ ON  sJ.idSalle = s.idSalle
							WHERE s.isStarted = 0
							GROUP BY s.idSalle';
				
				
				$salles = $connexion->query($requete, MYSQLI_USE_RESULT);
				
				if (isset($_GET['msg']) ) {
					
					echo "<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<strong>Info!</strong>".$_GET['msg']."</div>";
				}
				
			?>
		
			<div class="container main">
				<h1 class="page-header">
					Salles disponibles 
				</h1>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-sm-9 blog-main">
							<div class="row">
								<div class="col-md-3 pull-left">
									<p >
										<i class="glyphicon glyphicon-time"></i>
										<span id="time"><strong>
										<?php echo strftime("%d/%m/%Y %H:%M:%S",time()); ?>
										</strong></span>
									</p>
								</div>
								
								<div class="col-md-5 pull-right">
								<div class="row">
									<button class="btn btn-primary col-md-offset-1 pull-right" onclick="updateTable();">
										<i class="glyphicon glyphicon-refresh"></i>
										Rafraîchir
									</button>
									<button class="btn btn-primary pull-right" data-target=".bs-example-modal-lg" data-toggle="modal">
										<i class="glyphicon glyphicon-plus"></i>
										Nouvelle partie
									</button>
								</div>
								</div>
								
							</div>
							<hr/>

							<div class="table-responsive">
								<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>Nom</th>
												<th>Nombre de questions</th>
												<th>Nombre de joueurs</th>
												<th>Temps limite/ question</th>
												<th>Catégorie</th>
											</tr>
										</thead>
										<tbody id="table">
											<?php
												while ($row = $salles->fetch_row()) {
												echo "<tr>
														  <td><button onclick=\"window.open('join.php?id=".$row[0]."','_self')\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-play\"></span> Rejoindre</button></td>
														  <td>".$row[1]."</td>
														  <td>".$row[2]."</td>
														  <td><span class=\"badge\">".$row[5]."</span></td>
														  <td>".$row[3]." s</td>
														  <td>".$row[4]."</td>
														  </tr>";
											}
											mysqli_free_result($salles);
											?>
										</tbody>
									</table>
							</div>
						</div>
						
						<!-- Affichage du classement des dix premier joueurs -->
						<?php
							require_once "./classement.php";
						?>
					</div>
				</div>
			</div>
		</div>
		
		<?php require_once '../common/footer.php';?>
		

		<!-- Modal PopUp creation -->
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Création d'une partie</h4>
					</div>
					<div class="modal-body">
						<form role="form" action="add.php" method="POST">
							<div class="form-group">
								<label for="name">Nom de la salle&nbsp;:</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Entrez le nom de la salle" required/>
							</div>
							<div class="form-group">
								<label for="NbQuestions">Nombre de questions&nbsp;:</label>
								<input type="number" class="form-control" id="NbQuestions" name="NbQuestions"
								placeholder="Nombre de questions" max="50" min="5" step="1" required/>
							</div>
							<div class="form-group">
								<label for="TempsLimite">Temps limite (en secondes)&nbsp;:</label>
								<input type="number" class="form-control" id="TempsLimite" name="TempsLimite"
								placeholder="Temps limite par question"  max="35" min="6" step="1" required/>
							</div>
							<div class="form-group">
								<label for="Cat">Catégorie&nbsp;:</label>
								<select  data-width="100%" class="selectpicker show-tick" title='Choisissez une catégorie' name="Cat" id="Cat">
									<?php
										$requete = 'SELECT idCategorie, labelCategorie from categorie';
										 
										$categories = $connexion->query($requete, MYSQLI_USE_RESULT);
										 
										
										while ($row = $categories->fetch_row()) {
											echo "<option value=\"".$row[0]."\">".$row[1]."</option>";
										}

										mysqli_free_result($categories);
										$connexion->close();
									?>
								</select>
							</div>
							<input id="sub" type="submit" style="display: none"/>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
						<button type="button" class="btn btn-primary" onclick="$('#sub').click();">Sauvegarder</button>
					</div>
				</div>

			</div>
		</div>
		
		<script type="text/javascript">

			$('select').selectpicker();
			setInterval(function(){updateTable();},10000);
			function updateTable()
			{
				$.ajax({
					  url: "update.php",
					  async: true,
					  dataType: "text",
					  success: function( data ) {

							//alert(data);
							$("#table").html(data);
							var d = new Date();
							$("#time").html("<strong>"+d.toLocaleString()+"</strong>");

					   }
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					  })
			}
			
		</script>
	
		
	</body>
</html>
