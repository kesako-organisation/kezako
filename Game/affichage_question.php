<?php
    
    require_once '../common/connection.php';

	$j= $_POST['j'];
	$idRoom = $_POST['idRoom'];
	
	/*Get la question courante*/
	$requete = 'SELECT Q.idQuestion, Q.labelQuestion, Q.idCategorie
				FROM sallequestion S, question Q
				WHERE Q.idQuestion = S.idQuestion
				AND S.idSalle = '.$idRoom;
	$result = $connexion->query($requete, MYSQLI_USE_RESULT);
	$i = 0;
	$idQuestion = 0;
	$question = "";
	$reponses = [];
	$idReponses = [];
	while($row = $result->fetch_row() and $i <= $j){
		$idQuestion = $row[0];
		$question = $row[1];
		$idCategorie = $row[2];
		$i = $i + 1;
	}
	mysqli_free_result($result);
	
	/*Get les reponses courante*/
	$requete = 'SELECT R.idReponse, R.labelReponse, QR.isCorrect
				FROM reponse R, questionreponse QR
				WHERE R.idReponse = QR.idReponse
				AND QR.idQuestion = '.$idQuestion;
	$result = $connexion->query($requete, MYSQLI_USE_RESULT);
	$i = 0;
	$idBonneReponse = 42;
	while($row = $result->fetch_row())
	{
		$idReponses[$i] = $row[0];
		$reponses[$i] = $row[1];
		if($row[2]){
			$idBonneReponse = $row[0];
			$strBonneReponse = $row[1];
		}
		$i = $i + 1;
	}
    mysqli_free_result($result);
    
    echo '<h4><span class="label label-primary">Question #'.($j+1).'</span></h4>
		  <div class="photo-question">
				<div class="thumbnail">
				  <img src="../img/categories/'.$idCategorie.'.png" alt="..." width="450" >
				</div>
			</div>
			
			<div class="panel panel-default" id="labelQuestion">
			  <div class="panel-body">
				<h3 class="question_lbl">'.$question.'</h3>
			  </div>
			</div>
			
			
			<table class="table">
			  <tbody>
				  <tr>
					  <td><button class="btn btn-primary btn-block buttons_responses" onClick="clickReponse('.$idReponses[0].');">'.$reponses[0].'</button></td>
					  <td><button class="btn btn-primary btn-block buttons_responses" onClick="clickReponse('.$idReponses[1].');">'.$reponses[1].'</button></td>
				  </tr>
				  <tr>
					  <td><button class="btn btn-primary btn-block buttons_responses" onClick="clickReponse('.$idReponses[2].');">'.$reponses[2].'</button></td>
					  <td><button class="btn btn-primary btn-block buttons_responses" onClick="clickReponse('.$idReponses[3].');">'.$reponses[3].'</button></td>
				  </tr>
			  </tbody>
			</table>';
	$connexion->close();
?>

<script type="text/javascript">
    var idBonneReponse = <?php echo $idBonneReponse;?>;
    var strBonneReponse = '<?php echo $strBonneReponse;?>';
</script>
