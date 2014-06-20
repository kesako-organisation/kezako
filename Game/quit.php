<?php

require_once '../common/connection.php';

/*Recuperer l'id du joueur*/
$loginJoueur = $_SESSION['login'];
$idRoom = $_POST['idRoom'];
$isHost = $_POST['isHost'];

$requete = 'DELETE FROM sallejoueur	
			WHERE idJoueur = (SELECT idJoueur
							  FROM Joueur  					
							  WHERE login = \''.$loginJoueur.'\')';

$connexion->query($requete);

if($isHost){
	//Si c'est l'host de la room : l'enlever dans la base en tant qu'host
    //Un nouveau joueur devient host
	$requete = 'SELECT idJoueur FROM sallejoueur WHERE idSalle = ' . $idRoom . ' AND isHost = 0';
	$result = $connexion->query($requete) or die('Error in query: '.$requete. ' ' . mysql_error());

    if(isset($result) and !empty($result)){
		$row = $result->fetch_row();
		$newIdHost = $row[0];
		//UPDATE de la table sallejoueurs
		$requete = 'UPDATE sallejoueur SET isHost = 1 WHERE idJoueur = ' . $newIdHost;
		$connexion->query($requete);
	}
	
	$requete = 'SELECT login FROM joueur WHERE idJoueur = ' . $newIdHost;
	$result = $connexion->query($requete);
	$row = $result->fetch_row();
	$newPlayer = $row[0];
	
    
}
$connexion->close();

echo $newPlayer;

?>
