<?php
    require_once '../common/connection.php';

    $theme = $_POST['Cat'];
    $question = $_POST['question'];
    $bonnereponse = $_POST['bonnereponse'];
    $mauvaisereponse1 = $_POST['mauvaisereponse1'];
    $mauvaisereponse2 = $_POST['mauvaisereponse2'];
    $mauvaisereponse3 = $_POST['mauvaisereponse3'];
    
	
    /*Trouver l'id de la catégorie*/
    $idCategorie = $theme;
    
    /*Insert des reponses*/
	$requete = "INSERT INTO reponse
				SET labelReponse = '".$connexion->escape_string($bonnereponse)."';";

	
	$requete .= "INSERT INTO reponse
				SET labelReponse = '".$connexion->escape_string($mauvaisereponse1)."';";


	$requete .= "INSERT INTO reponse
				SET labelReponse = '".$connexion->escape_string($mauvaisereponse2)."';";


	$requete .="INSERT INTO reponse
				SET labelReponse = '".$connexion->escape_string($mauvaisereponse3)."'";
	

	$connexion->multi_query($requete);
	print $requete;
	print $connexion->error;
	
	$idReponse1 = $connexion->insert_id;
	$connexion->next_result();
	$idReponse2 = $connexion->insert_id;
	$connexion->next_result();
	$idReponse3 = $connexion->insert_id;
	$connexion->next_result();
	$idReponse4 = $connexion->insert_id;
	
	
    //mysqli_free_result($result);
	
    /*Insert la nouvelle question*/
	$requete = "INSERT INTO question
				SET labelQuestion='".$connexion->escape_string($question)."',
				idCategorie = '".$idCategorie."',
				isValidated = 0;";
				
	$connexion->query($requete);
	
	$idQuestion = $connexion->insert_id;
	
	/*Insert dans la table questionreponse*/
	print $idReponse2. ' ' . $idQuestion;
	$requete = "INSERT INTO questionreponse
				SET 	idQuestion = ".$idQuestion.",
						idReponse = ".$idReponse1.",
						isCorrect = 1;";
						
	$requete .= "INSERT INTO questionreponse
				SET 	idQuestion = ".$idQuestion.",
						idReponse = ".$idReponse2.",
						isCorrect = 0;";
						
	$requete .= "INSERT INTO questionreponse
				SET 	idQuestion = ".$idQuestion.",
						idReponse = ".$idReponse3.",
						isCorrect = 0;";
						
	$requete .= "INSERT INTO questionreponse
				SET 	idQuestion = ".$idQuestion.",
						idReponse = ".$idReponse4.",
						isCorrect = 0";
						
	$result = $connexion->multi_query($requete);

	//mysqli_free_result($result);	
	
	$connexion->close();

    header('Location: index.php?msg=Merci pour votre contribution');
    
?>
