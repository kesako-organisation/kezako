<?php
    
    require_once '../common/connection.php';

	$login = $_POST['login'];
	$idRoom = $_POST['idRoom'];
	$temps = $_POST['temps'];
	$scoremore = $_POST['score'];
	
	/*Get la question courante*/
	$requete = 'UPDATE sallejoueur
				SET score = score + '.$scoremore.',
				tempsLastQuestion = '.$temps.'
				WHERE sallejoueur.idJoueur IN (
					SELECT idJoueur
					FROM joueur
					WHERE joueur.login = \'' . $connexion->escape_string($login).'\')
				AND sallejoueur.idSalle = '.$idRoom;
	$result = $connexion->query($requete);
	mysqli_free_result($result);
	$connexion->close();
?>
