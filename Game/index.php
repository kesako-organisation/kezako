<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Game</title>
	<?php 
		require_once '../common/include.inc';
		require_once '../common/connection.php';
		require_once "../common/fcompte.php";
	?>
	
	<script src="../js/disableRefresh.js"></script>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">	
	<link href="../css/game.css" rel="stylesheet">
	</head>
  <body>
    <div class="wrap">
	

    
	<?php 
	    require_once "load_game.php";
	?>
	<?php
		// Cas déjà connecter
		if (!isset($_SESSION['login']) && !isset($_SESSION['password'])) {
			header("Location: ../");
			exit();
		}
		$nbJoueurs = 1;
		global $idBonneReponse;
		global $strBonneReponse;
		?>

        <div class="container main">
			<div class="panel panel-default">
				<div class="panel-heading" id="panel_salle_heading">
					<h1>Salle <?php echo $nomSalle;?>
						<div class="pull-right">
							<?php
								if($isHost){
									echo "<button class=\"btn btn-primary\" id=\"button_start\" onClick=\"startPlay();\">Start</button>";									
								}
							?>
							<button class="btn btn-primary" id="sortir" onClick="sortir();">
								<span class="glyphicon glyphicon-log-out"></span>
								Sortir
							</button>
						</div>
					</h1>
				</div>
				<div id="messages" style="visibility:hidden;background-color:rgba(0,0,0,0.1);border-radius:15px;margin:auto;">
					<img width="34" class='img-circle' id="profil-img">
					<span class="label label-default" id="author"></span>&nbsp;<span id="income-message"></span>
				</div>
			    <div class="panel-body">
					<!--Questions et Reponses-->
					<div class="col-sm-8 blog-main" id="nextQuestion"></div>
					
					<!--Temps restant + Liste des joueurs sur le coté-->
					<div class="col-sm-3 col-sm-offset-1 blog-sidebar"> 						
						<div class="panel panel-default" >
						    <div class="panel-body">
								<div class="progress progress-striped active" >
									<div class="progress-bar" role="progressbar" id="clock" style="width: 0%"></div>
								</div>
							</div>
						</div>
						<div class="sidebar-module sidebar-module-inset">
							<h3>Joueurs</h3>
						</div>
						<div class="sidebar-module">				
							<table id="players_list" class="table"></table>
						</div>
						<!-- Tchat -->
						<div class="sidebar-module">				
							<div class="input-group">
								<input type="text" class="form-control" id="message" placeholder="Message">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" id="btnMessage">Go!</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
	<?php 
		require_once '../common/footer.php';
	?>
	<script type="text/javascript">
		var t = 0;
		var j = 0;
		var enJeu = false;
		var time = <?php echo $tempsLimite; ?>;
		var jmax = <?php echo $limiteQuestions; ?>;
		var idRoom = <?php echo $idRoom; ?>;
		var login = '<?php echo $loginJoueur; ?>';
		var isHost = <?php echo $isHost; ?>;
		var timer;
		var timeToRespond;		
		var mauvaiseRep = false;
		var clicker = 0;
		
		function sortir(){
			/*Sortir de la salle de jeu */
			$.ajax({				
				type: "POST",
				data:{'idRoom': idRoom,'isHost':isHost},
				url: "quit.php",
				async: true,
				success: function( data ){
					newHostPlayer(data);
					location.href = "../Room/index.php";
				}
			}).fail(function() {
				alert( "Une erreur s'est produite" );
			});
		}
		
		$.ajax({
			/*MISE A JOUR DE LA LISTE DES JOUEURS */
			type: "POST",
			data:{'idRoom': idRoom},
			url: "players_list_update.php",
			async: true,
			success: function( data ){
				$("#players_list").html(data);
			}
		}).fail(function() {
			alert( "Une erreur s'est produite" );
		});
		
		function clickReponse(ind){
			clicker = 1;
			$(".buttons_responses").hide();
			
			if(ind == idBonneReponse){
				/*Bonne reponse*/
				$("#labelQuestion").html("<div class=\"panel-body\"><h3 class=\"question_lbl\">Bonne réponse</h3></div>")
				more = 1;
				timeToRespond = t;
			}
			else{
				/*Mauvaise reponse*/
				$("#labelQuestion").html('<div class="panel-body"><h3 class="question_lbl">Mauvaise réponse, la réponse était : '+strBonneReponse+' !</h3></div>')
				more = 0;
				timeToRespond = time; 
			}
			
			$.ajax({
				/*UPDATE dans la table sallejoueur*/
				type: "POST",
				data:{'idRoom': idRoom, 'login':login, 'temps': timeToRespond, 'score': more},
				url: "update_score.php",
				async: true,
				success: function(data){
					/*Faire des choses si necessaire*/
					clicker = 0;
				}
			}).fail(function() {
				alert( "Une erreur s'est produite" );
			});
				
			websocket.send(JSON.stringify(changed));
			
		    return;
		}
		
		function startPlay(){
			//alert("toto");
			t = 0;
			j = 0;	
		    timer = setInterval(myTimer, 100);
		    enJeu = true;
		    $("#button_start").hide();
		    //$(".buttons_responses").show();
		    $.ajax({
				/*DELETE dans la table sallequestion*/
				type: "POST",
				data:{'idRoom': idRoom},
				url: "game_started.php",
				async: true,
				success: function( data ){
					/*Faire des choses si necessaire*/
				}
				}).fail(function() {
					alert( "Une erreur s'est produite" );
				});				
			
			<?php if ($isHost==1) { ?>
				websocket.send(JSON.stringify(startParty));
			<?php } ?>
		}	
		
		function myTimer(){
			if(t==0) {
				websocket.send(JSON.stringify(changed));
				if (j>=jmax){				
					clearInterval(timer);
					enJeu = false;
					$("#nextQuestion").css("visibility", "hidden");
					<?php if($isHost) { ?>
					$.ajax({
						/*DELETE dans la table sallequestion*/
						type: "POST",
						data: {'idRoom': idRoom, 'nbQuestions' : jmax},
						url: "update_classement.php",
						async: true,
						success: function( data ){
						<?php }  ?>
							$.ajax({
								/*DELETE dans la table sallequestion*/
								type: "POST",
								data: {'idRoom': idRoom, 'limiteQuestions' : jmax},
								url: "unload_game.php",
								async: true,
								success: function( data ){}
							}).fail(function() {
								alert( "Une erreur s'est produite" );
							})
							<?php if($isHost) { ?>
						}
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					})
					<?php } ?>

					$.ajax({
						/*DELETE dans la table sallequestion*/
						type: "POST",
						data:{'idRoom': idRoom},
						url: "game_stopped.php",
						async: true,
						success: function( data ){
							/*Faire des choses si necessaire*/
						}
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					})
					$("#button_start").show();
					return;
				}
		
				$.ajax({
					type : "POST",
					data: {'idRoom': idRoom,'j':j},
					url: "affichage_question.php",
					async: true,
					dataType: "text",
					success: function( data ) {
						$("#nextQuestion").html(data);
						j++;
						//idBonneReponse = <?php echo $idBonneReponse; ?>;
					}
				}).fail(function() {
					alert( "Une erreur s'est produite" );
				});
			}
			t = t+0.1;
			
			//Temp limite atteint
			if (t>=time){
				if (clicker==0){
					$.ajax({
						/*UPDATE dans la table sallejoueur*/
						type: "POST",
						data:{'idRoom': idRoom, 'login':login, 'temps': time, 'score': 0},
						url: "update_score.php",
						async: true,
						success: function(data){
							
						}
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					});
				}
				
				<?php if ($isHost) { ?>
					//Calcul point supplémentaires // LE PLUS RAPIDE +100
					$.ajax({
						type : "POST",
						data: {'idRoom': idRoom, 'idQuestion': <?php echo $idQuestions[$j] ?>, 'tempsMax': time},
						url: "update_score_supp.php",
						async: clicker,
						dataType: "text",
						success: function( data ) {}
					}).fail(function() {
						alert( "Une erreur s'est produite" );
					});
					websocket.send(JSON.stringify(changed));
				<?php } ?>

				$("#clock").attr( "aria-valuemin", 0 );
				$("#clock").attr( "aria-valuemax", time );
				$("#clock").attr( "aria-valuenow", time );
				$("#clock").css("width", "100.0%");	
				t = 0;							
			} else {
				$("#clock").attr( "aria-valuemin", 0 );
				$("#clock").attr( "aria-valuemax", time );
				$("#clock").attr( "aria-valuenow", t );
				$("#clock").css("width", (t*1.0/time*1.0)*100.0+"%");	
			}
		}
	</script>
	<?php require_once ('communication.php'); ?>
  </body>
</html>
