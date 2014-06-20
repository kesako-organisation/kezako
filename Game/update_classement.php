<?php
    require_once '../common/connection.php';
	
	$idRoom = $_POST['idRoom'];
	$nbQuestions = $_POST['nbQuestions'];
	
	/** Récupération des joueurs de cette salle */
	$requete = 'SELECT idJoueur, score
				FROM sallejoueur
				WHERE idSalle = '.$idRoom;
	
	$result = $connexion->query($requete);
	
	while ($row = $result->fetch_row()) {
		$idJoueur = $row[0];
		$scoreTotal = $row[1];
		/** Récupération du nombre de victoire réussies */
		$requete2 = 'SELECT COUNT(*)
					FROM sallequestion
					WHERE winner = '.$idJoueur;

		$result2 = $connexion->query($requete2);
		
		$row2 = $result2->fetch_row();
		$nbWinner = $row2[0];
		
		$nbQReussies =  $scoreTotal - $nbWinner;
		/** Mise à jour du classement générale */
		$requete3 = 'UPDATE joueur
					SET nbQuestionsCorrectes = nbQuestionsCorrectes + '.$nbQReussies.',
					nbQuestionsRepondus = nbQuestionsRepondus + '.$nbQuestions.',
					nbTotalPoints = nbTotalPoints + '.$scoreTotal.'
					WHERE idJoueur = '.$idJoueur;
	
		$result3 = $connexion->query($requete3);
		
		mysqli_free_result($result3);
	}
	
	mysqli_free_result($result);
?>
