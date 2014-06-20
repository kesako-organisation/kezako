<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html lang="fr">
	<head>
		<title>Kezako - Valider Question</title>
		<meta name="keywords" lang="fr" content="kezako,valider" />
		<title>Valider</title>
		<?php 
		require_once '../common/include.inc';
		require_once '../common/connection.php';
		require_once "../common/fcompte.php";
		?>
	</head>

	<body>
	<!-- Insertion de la barre de navigation -->
    <?php
        include('../common/header.php');
    ?>
	<div class="wrap">
		<div class="container main">
			<div class="container-fluid">
				<div class="page-header">
					<h1>Valider des questions</h1>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Liste des questions non validées</h4>
					</div>
					
					<div class="panel-body">
						<div class=" text-center">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Thème</th>
											<th>Question</th>
											<th>Bonne réponse</th>
											<th>Mauvaise réponse</th>
											<th>Mauvaise réponse</th>
											<th>Mauvaise réponse</th>
										</tr>
									</thead>
									<tbody id="table">
									<?php
										/* Requete permettant de récuperer les informations des room*/
										$requete = 'SELECT idQuestion, labelQuestion, c.labelCategorie
													FROM question q, categorie c
													WHERE q.idCategorie = c.idCategorie
													AND isValidated = 0';
	
										$questions = $connexion->query($requete);
									
										while ($row = $questions->fetch_row()) {
											echo
										   "<tr>
											<td>".$row[2]."</td>
											<td>".$row[1]."</td>";
											
											$requete2 = 'SELECT r.idReponse, r.labelReponse
														FROM reponse r, questionreponse qr
														WHERE r.idreponse = qr.idreponse
														AND qr.idQuestion = '.$row[0];

											$reponses = $connexion->query($requete2);
											
											while ($row2 = $reponses->fetch_row()) {echo "<td>".$row2[1]."</td>";}
			
											echo
										   "<td><button onclick=\"valider(".$row[0].");\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-play\"></span>Valider</button></td>
										    <td><button onclick=\"supprimer(".$row[0].");\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-play\"></span>Supprimer</button></td></tr>";
											mysqli_free_result($reponses);
										}
										mysqli_free_result($questions);
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('../common/footer.php'); ?>
	
	
	
	<script type="text/javascript">

			function valider(id)
			{
				$.ajax({
					url: "validerquestion.php?id="+id,
					type : 'GET',
					async: true,
					dataType: "text",
					success: function( data ) {
							$("#table").html(data);
					   }
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					  });
			}
			
			function supprimer(id)
			{
				$.ajax({
					  url: "supprimerquestion.php?id="+id,
					  type : 'GET',
					  async: true,
					  dataType: "text",
					  success: function( data ) {
							$("#table").html(data);
					   }
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					  });
			}
			
		</script>
	
	</body>
</html>