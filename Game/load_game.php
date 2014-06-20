<?php
require_once '../common/connection.php';
$idRoom = $_GET['id'];
$loginJoueur = $_SESSION['login'];

/* Requete permettant de récuperer les informations de la salle */
$requete = 'SELECT S.nomSalle, S.nbQuestions, S.idCategorie, S.tempsLimite, S.idSalle
			FROM salle S				
			WHERE s.idSalle = '.$idRoom;

$requete = $connexion->query($requete, MYSQLI_USE_RESULT);
$row = $requete->fetch_row();

$nomSalle = $row[0];
$limiteQuestions = $row[1];
$idTheme= $row[2];
$tempsLimite = $row[3];



/*Requete pour recuperer le label du theme de la partie*/
$requete = 'SELECT C.labelCategorie
			FROM categorie C				
			WHERE C.idCategorie = '.$idTheme;
$requete = $connexion->query($requete, MYSQLI_USE_RESULT);
$row = $requete->fetch_row();
$theme = $row[0];

/*DEBUG*/
//$limiteQuestions = 5;

/*Est-ce que le joueur courant est administrateur de la salle de jeu*/
$requete = 'SELECT isHost
			FROM sallejoueur S, joueur J	
			WHERE idSalle = '.$idRoom.'
			AND S.idJoueur = J.idJoueur
			AND J.login = \''.$connexion->escape_string($loginJoueur).'\'';
$requete = $connexion->query($requete, MYSQLI_USE_RESULT);
$row = $requete->fetch_row();
$isHost = $row[0];

if($isHost){

	/*Recuperer la liste des questions*/
	$requete = 'SELECT idQuestion, labelQuestion, idCategorie
				FROM question
				ORDER BY RAND( )
				LIMIT '.$connexion->escape_string($limiteQuestions);
	$result = $connexion->query($requete, MYSQLI_USE_RESULT);

	/*Requete pour recuperer les reponses aux questions*/
	$j = 0;
	while($row = $result->fetch_row())
	{
		$idQuestions[$j] = $row[0];
		$questions[$j] = $row[1];
		$idCategories[$j] = $row[2];
		$j = $j + 1;
	}
	mysqli_free_result($result);



	/*Pour chaque questions : recuperer les reponses a afficher*/
	for ($i = 0; $i < $limiteQuestions; $i++) {
		$requete2 = 'SELECT labelReponse
				FROM questionreponse Q, reponse R
				WHERE Q.idReponse = R.idReponse
				AND Q.idQuestion = '.$idQuestions[$i].'
				ORDER BY RAND()';
		$result = $connexion->query($requete2, MYSQLI_USE_RESULT);
		$k = 0;
		while($row = $result->fetch_row())
		{
			$reponses[$i][$k] = $row[0];
			$k = $k + 1;
		}
		
		mysqli_free_result($result);
	}

	/*Update de la table sallequestion*/
	for ($i = 0; $i < $limiteQuestions; $i++) {
		$requete = 'INSERT INTO sallequestion
					VALUES ('.$idRoom.','.$idQuestions[$i].',0)';
		$result = $connexion->query($requete);
	}
	$connexion->close();
}

















$j = 0;
?>
