<?php

require_once '../common/connection.php';

$loc = "index.php";

//On récupère l'id de la salle
if(!isset($_GET['id'])){
	header('Location: '.$loc);
}
$id=$_GET['id'];

/*Vérifier que la salle existe */
$requete = "SELECT COUNT(*) from salle where idSalle = ".$id;
$result = $connexion->query($requete,MYSQLI_USE_RESULT);
$row = $result->fetch_row();

if($row[0] == 0){
	header('Location: index.php?msg=Cette salle n\'existe plus.');
}
else if($row[0] == 8){
	header('Location: index.php?msg=Cette salle est pleine');
}
mysqli_free_result($result);

//On vérifie que la partie n'a pas déjà débuté
$requete = "SELECT isStarted from salle where idSalle = ".$id;
$result = $connexion->query($requete,MYSQLI_USE_RESULT);
$row = $result->fetch_row();
if($row[0] = 1){
	header('Location: index.php?msg=La partie a déjà commencé.');
}
mysqli_free_result($result);

/*sinon on insère le joueur dans la table sallejoueur et on le redirige vers la page*/	
$requete = "INSERT INTO SALLEJOUEUR (idJoueur, idSalle, isHost)
			SELECT idJoueur, '".$id."', '0' from joueur where login = '".$_SESSION['login']."'";

$connexion->query($requete);

/*On lance la requête */
$connexion->close();

/* Redirection en fonction de la variable $loc */
header('Location: ../Game/index.php?id='.$_GET['id']);

?>