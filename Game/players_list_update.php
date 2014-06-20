<?php
	require_once("../common/connection.php");
	$idRoom = $_POST['idRoom'];
	
	/*Recuperer la liste des joueurs et leur score*/
	$requete = 'SELECT j.login, sj.score
				FROM joueur j,sallejoueur sj
				WHERE j.idJoueur = sj.idJoueur
				AND sj.idsalle = '.$idRoom.'
				ORDER BY sj.score DESC';
	$result = $connexion->query($requete, MYSQLI_USE_RESULT);
	echo "<tr style='visibility:hidden;'>
			<th></th>
			<th></th>
			<th></th>
		  </tr>";
		  
	while($row = $result->fetch_row())
	{
		echo "<tr>
				<td style='vertical-align: middle;'><img src=\"../img/joueurs/".$row[0].".jpg\" alt=\"...\" width=\"34\" class='img-rounded'></td>
				<td style='vertical-align: middle;'>".$row[0]."</td>
				<td style='vertical-align: middle;'><span class='badge'>".$row[1]."</span></td>
			</tr>";
	}
	mysqli_free_result($result);
?>