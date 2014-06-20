<?php

require_once '../common/connection.php';

$loc = "index.php";

if(!isset($_REQUEST['name'])){
	// Si non présente par défaut la redirection se fera sur l'index
	header('Location: '.$loc);
}

/* Récupération des variables données */
$nom = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['name']));
$nb = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['NbQuestions']));
$tps = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['TempsLimite']));
$cat = mysqli_real_escape_string($connexion,htmlspecialchars($_REQUEST['Cat']));

/* Requete permettant la création d'un nouveau planning */
$requete = "INSERT INTO SALLE (nomSalle, idCategorie, nbQuestions, tempsLimite, isStarted)
        VALUES(\"".$nom."\", \"".$cat."\", '".$nb."', \"".$tps."\",  \"0\" )";

/*On lance la requête */
if (!$connexion->query($requete)) {
	throw new Exception($connexion->error);
}

/*on récupère l'id de la salle insérée */
$id = $connexion->insert_id;

$requete = "INSERT INTO SALLEJOUEUR (idJoueur, idSalle, isHost)
        	SELECT idJoueur, '".$id."', '1' from joueur where login = '".$_SESSION['login']."'";

if (!$connexion->query($requete)) {
	$requete = "DELETE FROM salle WHERE idSalle = '".$id."'";
	$connexion->query($requete);
	throw new Exception($connexion->error);
}


/*On lance la requête */
$connexion->close();

/* Redirection en fonction de la variable $loc */
header('Location: ../Game/index.php?id='.$id);

?>