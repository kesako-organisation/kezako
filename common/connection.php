<?php
    /**
     * Identifiants de connection
     */
    $host  = "localhost";
    $user = "root";
    $passwd = "";
    $base = "kezako";
    
	/*
	$user = "kesakoho_toto";
	$passwd = "zhT0~{Fsd!{;";
	$base = "kesakoho_kezako";
	*/
    session_start();
    $connexion = mysqli_connect($host, $user, $passwd, $base);
    
    /* Vérification de la connexion */
    if ($connexion->connect_errno) {
    	throw Exception("Échec de la connexion : %s\n", $connexion->connect_error);
    	exit();
    }
    
    /* Modification du jeu de résultats en utf8 */
    if (!$connexion->set_charset("utf8")) {
    	throw Exception("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $connexion->error);
    }
    
    date_default_timezone_set('Europe/Paris');
?>