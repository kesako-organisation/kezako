<div class="col-sm-3" style="max-width: 100%;">
	<h3>Classement</h3>

	<div class="sidebar-module">
		<div class="table-responsive">
			<table class="table" style="table-layout: fixed;">
				<thead>
					<tr>
						<th>Joueur</th>
						<th>Score</th>
						<th>Ratio</th>
					</tr>
				</thead>
			
				<tbody id="table">
					<?php
						require_once '../common/connection.php';

						/* Requete permettant la récupération du classement des utilisateurs */
						$requete = "SELECT login, nbTotalPoints, nbQuestionsCorrectes, nbQuestionsRepondus FROM joueur ORDER BY nbTotalPoints DESC LIMIT 10";
						$result = $connexion->query($requete, MYSQLI_USE_RESULT);

						/* Affichage du classement */ 
						while ($row = $result->fetch_row()) {
							
							 if ($row[3] == 0)
								$ratio = 0;
							else
								$ratio = round(100*$row[2]/$row[3],1);
						
							echo "<tr>
								<td>".$row[0]."</td>
								<td>".$row[1]."</td>
								<td><div class='progress progress-striped active'>
									<div class='progress-bar progress-bar-danger' role='progressbar' style='width: ".$ratio."%'><strong style='color:black;'>".$ratio."%</strong></div>
								</div></td>
							</tr>";
						}
						mysqli_free_result($result);
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>