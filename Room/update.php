<?php

	require_once '../common/connection.php';

	$requete = 'SELECT s.idSalle, s.nomSalle, s.nbQuestions, s.tempsLimite, c.labelCategorie, COUNT( idJoueur ) AS Count
						FROM SALLE s LEFT JOIN CATEGORIE c ON s.idCategorie = c.idCategorie
							LEFT JOIN SALLEJOUEUR sJ ON  sJ.idSalle = s.idSalle
						WHERE s.isStarted = 0
						GROUP BY s.idSalle';

	$salles = $connexion->query($requete, MYSQLI_USE_RESULT);

	while ($row = $salles->fetch_row()) {
		echo "<tr>
				  <td><button onclick=\"window.open('join.php?id=".$row[0]."','_self')\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-play\"></span> Rejoindre</button></td>
				  <td>".$row[1]."</td>
				  <td>".$row[2]."</td>
				  <td><span class=\"badge\">".$row[5]."</span></td>
				  <td>".$row[3]." s</td>
				  <td>".$row[4]."</td>
				  </tr>";
	}

	mysqli_free_result($salles);
	$connexion->close();

?>

