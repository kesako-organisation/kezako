<?php
    require_once '../common/connection.php';

    /*Requete pour delete dans la table sallequestion*/
    $idRoom = $_POST['idRoom'];
    $limiteQuestions = $_POST['limiteQuestions'];
    
	$requete = 'DELETE FROM sallequestion
				WHERE idSalle = '.$idRoom;
	$result = $connexion->query($requete);
	mysqli_free_result($result);
	
	//require_once "load_game.php";
	//header('Location: index.php');
	
	/*Recuperer la liste des questions*/
	$requete = 'SELECT idQuestion, labelQuestion, idCategorie
				FROM question
				ORDER BY RAND( )
				LIMIT '.$limiteQuestions;
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
?>
