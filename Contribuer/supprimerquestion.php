<?php


require_once '../common/connection.php';

$id = $_GET['id'];

$requete = 'DELETE FROM question
WHERE idquestion = '.$id;


$connexion->query($requete);

/* Requete permettant de r�cuperer les informations des room*/
$requete = 'SELECT idQuestion, labelQuestion, c.labelCategorie
			FROM question q, categorie c
			WHERE q.idCategorie = c.idCategorie
			AND isValidated = 0';

$questions = $connexion->query($requete);

while ($row = $questions->fetch_row()) {
	echo
   "<tr>
	<td>".$row[2]."</td>
	<td>".$row[1]."</td>";
	
	$requete2 = 'SELECT r.idReponse, r.labelReponse
				FROM reponse r, questionreponse qr
				WHERE r.idreponse = qr.idreponse
				AND qr.idQuestion = '.$row[0];

	$reponses = $connexion->query($requete2);
	
	while ($row2 = $reponses->fetch_row()) {echo "<td>".$row2[1]."</td>";}

	echo
   "<td><button onclick=\"valider(".$row[0].");\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-play\"></span>Valider</button></td>
	<td><button onclick=\"supprimer(".$row[0].");\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-play\"></span>Supprimer</button></td></tr>";
	mysqli_free_result($reponses);
}
mysqli_free_result($questions);
$connexion->close();

?>