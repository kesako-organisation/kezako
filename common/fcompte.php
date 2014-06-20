<?php

	require_once 'connection.php';
	$website_url = 'http://www.kesako.host-ed.me/Kesako/trunk/';
/* Commentaires sur la librairie

Cryptage des données :
	Le cryptage utilisé est un mélange d'un md5 suivi d'un SHA512 doublé
	Les mots de passes sont stockés dans la base une fois cryptés
	Les clés utilisées dans les liens sont aussi encryptées

Sécurisation des requêtes SQL :
	$variableAProteger = mysql_real_escape_string($variable);
	$requete = sprintf("SELECT * FROM utilisateur WHERE mail = '$variableAProteger' ;";
	$resultat = mysql_query($requete);

*/

/********************************
* Vérification de l'utilisateur *
********************************/
// Vérifie que l'utilisateur est authentifié
function CheckUserConnected($username, $password, &$error)
{
	global $connexion;
	
	$sql = sprintf("SELECT password, status FROM joueur WHERE login = '".mysqli_real_escape_string($connexion, $username)."' ;");
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error="Erreur de lecture de la base de données\nContactez un administrateur\n";
		return 0;
	}
	while( list($passwordDB, $actifDB) = mysqli_fetch_row($result) )
		if($actifDB==1 && $passwordDB==$password)
			return 1;
	$error="Problème de session. Veuillez vous reconnecter\n";
	return -1;
}

// Renvoie l'email de l'utilisateur pour la page "moncompte"
function getInfoUtilisateur($login, &$error)
{
 	global $connexion;

	$sql = sprintf("SELECT email FROM joueur WHERE login = '".mysqli_real_escape_string($connexion,$login)."' ;");
	$result = $connexion->query($sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error="Erreur de lecture de la base de données\nContactez un administrateur\n";
		return 0;
	}
	return mysqli_fetch_row($result)[0];
}

/*****************************
* Connexion de l'utilisateur *
*****************************/
function ConnexionUtilisateur($username, $password, &$passcrypt, &$error)
{
	global $connexion;
	
	$sql = sprintf("SELECT password, status FROM joueur WHERE login = '".mysqli_real_escape_string($connexion, $username)."' ;");
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error = "Erreur de lecture de la base de donn&eacute;es\nContactez un administrateur : ".$connexion->error;
		return 0;
	}
	// Si le mot de passe correspond et que le compte est actif
	// La boucle est une sécurité
	while( list($passwordDB, $actifDB) = mysqli_fetch_row($result) )
	{
		//if($actifDB==1)
		//{
			if(cryptageCompte($password)==$passwordDB)
			{
				$passcrypt=$passwordDB;
				return 1;
			}
			else
				$error = "Mauvais utilisateur ou mauvais mot de passe";
		//}
		//else {
			//$error = "Compte non activ&eacute;. Merci de l\'activer avant de vous connecter";
			//return 1;
		//}
	}
	$error = "Mauvais utilisateur ou mauvais mot de passe";
	return 0;
}

function Deconnexion()
{
	session_destroy();
}

/****************************
* Création d'un utilisateur *
****************************/
// Vérifier la disponibilité de l'email
function freeEmail ($email, &$error)
{
	global $connexion;
	
	// Vérification de doublons de comptes
	$sql = sprintf("SELECT email FROM joueur ;");
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error = "Impossible de charger la liste des utilisateurs : ".$connexion->error;
		return 0;
	}
	while( list($emailDB) = mysqli_fetch_row($result) )
	{
		if($emailDB == $email)
		{
			$error = "Attention : L'e-mail est déjà utilisée pour un autre compte !";
			return 0;
		}
	}
	return 1;
}

// Création utilisateur
function creerUtilisateur($login, $email, $motdepasse, &$error)
{
	global $connexion;
	
	$sql = sprintf("INSERT INTO joueur (`login`, `password`, `email`, `status`) VALUES ('".mysqli_real_escape_string($connexion, $login)."', '".mysqli_real_escape_string($connexion, $motdepasse)."', '".mysqli_real_escape_string($connexion, $email)."', 1);");
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
		$error = "Impossible de créer le nouvel utilisateur : ".$connexion->error;
}


/**************************************
* Gestion des mots de passe de compte *
**************************************/
function genererMotDePasse ($longueur) {
    // initialiser la variable $mdp
    $mdp = "";

    // Définir tout les caractères possibles dans le mot de passe
    $possible = "2346789abcdefghijkmnopqrtuvwxyzABCDEFGHIJKLMNOPQRTUVWXYZ";
 
    // obtenir le nombre de caractères dans la chaîne précédente
    $longueurMax = strlen($possible);
 
    if ($longueur > $longueurMax) {
        $longueur = $longueurMax;
    }
 
    // initialiser le compteur
    $i = 0;
 
    // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
    while ($i < $longueur) {
        // prendre un caractère aléatoire
        $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
 
        // vérifier si le caractère est déjà utilisé dans $mdp
        if (!strstr($mdp, $caractere)) {
            // Si non, ajouter le caractère à $mdp et augmenter le compteur
            $mdp .= $caractere;
            $i++;
        }
    }
    return $mdp;
}

// Fonction de cryptage en md5 suivi d'un SHA512 doublé utilisé pour encoder les données des liens et du mot de passe.
function cryptageCompte ($variable) {
	$cryptedData=hash("sha512", hash("sha512", md5($variable)));
	return $cryptedData;
}

// Vérifie si le mot de passe crypté correspond à celui de l'utilisateur enregistré dans la base
function verifierMotDePasse ($username, $motdepasse, &$error)
{
	global $connexion;
	
	$sql = sprintf("SELECT password FROM joueur WHERE login = '".mysqli_real_escape_string($connexion, $username)."' ;");
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error="Erreur de lecture de la base de données.\nContactez un administrateur";
		return 0;
	}
	list($passwordDB) = mysqli_fetch_row($result);
	
	if (cryptageCompte($motdepasse)==$passwordDB) {
		return 1;
	} else {
		$error = "Vous n'avez pas entré le bon mot de passe.";
		return 0;
	}
}

// Exécute la requête de mise à jour du mot de passe crypté et retourne "vrai" si la fonction a réussi
function changerMotDePasse ($login, $nouveauMdp, &$error)
{
	global $connexion;
	
	$sql = "UPDATE joueur SET password = '".mysqli_real_escape_string($connexion, cryptageCompte($nouveauMdp))
		."' WHERE login = '".mysqli_real_escape_string($connexion, $login)."' ;";
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error = "Erreur de la modification du mot de passe.\nContactez un administrateur";
		return 0;
	}
	else
		return 1;
}

// Exécute la requête de mise à jour de l'email et retourne "vrai" si la fonction a réussi
function changerEmail ($login, $email, &$error)
{
	global $connexion;
	
	$sql = "UPDATE joueur SET email = '".mysqli_real_escape_string($connexion, $email)
		."' WHERE login = '".mysqli_real_escape_string($connexion, $login)."' ;";
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error = "Erreur de la modification de l'e-mail.\nContactez un administrateur";
		return 0;
	}
	else
		return 1;
}

/*************************************************
* Fonctions d'envoi des mails vers l'utilisateur *
*************************************************/
function envoyerMailInscription ($email, $motdepasse)
{
	$destinataire = $email;
	$sujet = "Activation de votre compte";
	$entete = "From: no-reply@kezako.fr";

	$message = 'Bienvenue sur Kezako,
	Nous vous rappelons vos identifiants, merci de les garder précieusement. 
	Votre mot de passe étant crypté dans notre base de données, il nous est impossible de vous le renvoyer. 
	Il vous faudra le réinitialiser.

	Login : '.$email.'
	Mot de passe : '.$motdepasse.'

	Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet.
	'.$website_url.'Login/activation.php?key='.urlencode(cryptageCompte($email)).'
	
	Cordialement,
	Kezako Team
	---------------
	Ceci est un mail automatique, Merci de ne pas y répondre.';

	mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail
}

// Mail envoyé lors d'uh changement ou d'une réinitialisation du mot de passe
function envoyerMailRestart ($email, $motdepasse)
{
	$destinataire = $email;
	$sujet = "Réinitialistion de votre mot de passe";
	$entete = "From: no-reply@kezako.fr";

	$message = 'Bonjour,
	Vous venez de demander la modification/réinitialisation de votre mot de passe. Il vous est possible de le modifier dans votre espace de compte.
	La modification/réinitialisation du mot de passe implique de réactiver votre compte, ce dernier étant désactivé par mesure de sécurité.
	Votre mot de passe étant crypté dans notre base de données, il nous sera impossible de vous le renvoyer. Il vous faudra le réinitialiser.

	Login : '.$email.'
	Mot de passe : '.$motdepasse.'

	Pour réactiver votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet.'
	.$website_url.'Login/activation.php?key='.urlencode(cryptageCompte($email)).'
	
	Cordialement,
	Kezako Team
	---------------
	Ceci est un mail automatique, Merci de ne pas y répondre.';

	mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail
}

function envoyerMail($envoyeur, $destinataire, $sujet, $mess){
	$dest = $destinataire;
	$sjt = $sujet;
	$entete = "From: no-reply@kezako.fr";

	$message = 'Bonjour,
	Vous venez de recevoir un email de contact de : '.$envoyeur.'

	Son message est le suivant: "'.$mess.'.".

	Cordialement,
	Kezako Team
	---------------
	Ceci est un mail automatique, Merci de ne pas y répondre.';

    mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail
}

function envoyerMail2($destinataire, $sujet, $mess, $entete){
	mail($destinataire, $sujet, $mess, $entete) ; // Envoi du mail
}

/**********************************************
* Fonction d'activation du compte utilisateur *
**********************************************/
// Active le compte grâce à la clé étant l'encodage de l'adresse mail de l'utilisateur
function activerCompte($key, &$error)
{
	global $connexion;
	
	$sql = sprintf("SELECT email FROM joueur ;");
	$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
	if(!$result) // Si échec de la requête, arrêter le script
	{
		$error = "Impossible de charger la liste des utilisateurs : ".$connexion->error;
		return 0;
	}
	
	while( list($emailDB) = mysqli_fetch_row($result) )
	{
		if(cryptageCompte($emailDB) == $key)
		{
			$sql = sprintf("UPDATE joueur SET status=1 WHERE email='".mysqli_real_escape_string($connexion, $emailDB)."' ;");
			$result = mysqli_query($connexion, $sql); // Exécution de la requête préparée
			if(!$result) // Si échec de la requête, arrêter le script
			{
				$error = "Impossible d'activer votre compte utilisateur : ".$connexion->error;
				return 0;
			}
			break;
		}
	}
	return 1;
}

?>