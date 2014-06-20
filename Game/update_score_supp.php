<?php
    require_once '../common/connection.php';
	
	$idRoom = $_POST['idRoom'];
	$idQuestion = $_POST['idQuestion'];
	$tempMax = $_POST['tempsMax'];
	
	/** Récupération du joueur le plus rapide correctement à la question sur cette salle */
	$requete = 'SELECT idJoueur, tempsLastQuestion
				FROM sallejoueur
				WHERE idSalle = '.$idRoom.'
				ORDER BY tempsLastQuestion
				LIMIT 1';
	
	$result = $connexion->query($requete);
	$row = $result->fetch_row();
	
	$idJoueur = $row[0];

	if ($row[1] < $tempMax) {
		/** Ajout du point supplémentaire car plus rapide */
		$requete = 'UPDATE sallejoueur
					SET score = score + 1
					WHERE idJoueur = '.$idJoueur.'
					AND idSalle = '.$idRoom;
					
		$connexion->query($requete);
		
		mysqli_free_result($result);
		
		/** Identification du gagnant de cette question sur cette salle */
		$requete = 'UPDATE sallequestion
					SET winner = '.$idJoueur.'
					WHERE idQuestion = '.$idQuestion.'
					AND idSalle = '.$idRoom;
					
		$connexion->query($requete);
		
	}
	
	mysqli_free_result($result);
?>
