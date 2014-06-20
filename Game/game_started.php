<?php
    require_once '../common/connection.php';
    
    $idRoom = $_POST['idRoom'];
    
    /*Game started*/    
    $requete = 'UPDATE salle
				SET isStarted = 1
				WHERE idSalle = '.$idRoom;
	$connexion->query($requete);
	$connexion->close();
?>
