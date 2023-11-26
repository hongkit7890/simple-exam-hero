<?php 
include "database.php"; 
error_reporting(E_ALL);
ini_set('display_errors', 1);



?>

<?php session_start();


if (!isset($_SESSION['total'])) {
	$_SESSION['score'] = 0;
	$_SESSION['total'] = 0;
}

$filter = "";

if (isset($_GET['n'])) {
	$filter = " AND question_number = $_GET[n]";
	echo $title = "題目編號 #$_GET[n]";
}

if (isset($_GET['year'])) {
	$filter = " AND left(ref, 4) = $_GET[year]";
	echo $title = "歷屆試題 $_GET[year]";
}

if (isset($_GET['hashtag'])) {
	$filter = " AND hashtag like '%$_GET[hashtag]%'";
	echo $title = "標籤 $_GET[hashtag]";
}


	//hashtag='#試算表'

	//Set question number
	//$number = (int) $_GET['n'];

	//Get total number of questions
	$query = "select * from questions";
	$results = $mysqli->query($query) or die($mysqli->error.__LINE__);
	$total=$results->num_rows;

	// Get Question
	$query = "SELECT * FROM questions where TRUE $filter ORDER BY RAND() LIMIT 1";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	$question = $result->fetch_assoc();
	$number = (int) $question['question_number'];
	$ref = $question['ref'];


	// Get Choices
	$query = "select * from `choices` where question_number = $number";
	$choices = $mysqli->query($query) or die($mysqli->error.__LINE__);

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Exam Hero</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery-3.7.1.min.js"></script>
  </head>
  <body>
    <div id="container">
      <header>
        <div class="container">
          <h1>Exam Hero</h1>
	    </div>
      </header>

      <main>
      <div class="container">
        <div class="current"><?php echo $ref; ?> 題目編號 #<?php echo $number; ?></div>

		
	<p class="question"><?php echo $question['question'] ?></p>
	<form>
	<table class="choices">
    <?php while($row=$choices->fetch_assoc()): ?>
        <tr>
            <td>
                <input name="choice" type="radio" value="<?php echo $row['id']; ?>"
                <?php if ($row['is_correct'] == 1) {echo "class='correct'";} ?> /> 
            </td>
            <td>
                <?php echo $row['choice']; ?>
            </td>
        </tr>
    <?php endwhile; ?>
	</table>
	<p></p>


	    <input type="button" id='checka' value="Check Answer"/>
		
	    <input type="hidden" name="number" value="<?php echo $number; ?>" />
	</form>
	<p id="result-message"></p> 
	<p id="score"> 
		<?php 
		if ($_SESSION['total'] > 0) {
			echo "Score:" .  $_SESSION['score'] . " / ". $_SESSION['total'];
			$percentage = ($_SESSION['score'] / $total) * 100;
			echo " (" . round($percentage, 2) . "%)";
		 } ?>
		
	</p>
	<p align="center"><input type="button" id='next' value="Next Question" hidden/></p>
	<p align="right"><input type="button" id='end' value="End Quiz"/></p>


    </div>
    </div>
    </main>


    <footer>
      <div class="container">
      	   Copyright &copy; 2023, Exam Hero
      </div>
    </footer>

	<script>
		$(document).ready(function() {
		var correct = $('.correct');
		var resultMessage = $('#result-message');
		var checkAnswer = $('#checka');
		var scoreDisplay = $('#score');
		var next = $('#next');
		var end = $('#end');
		var attempted = false;

		$.ajax({
			url: 'get_session_values.php',
			method: 'POST',
			success: function(response) {
				var data = JSON.parse(response);
				var score = data.score;
				var total = data.total;
				
				console.log('Score:', score);
				console.log('Total:', total);
				
				// Handle the score and total values here
			},
			error: function(xhr, status, error) {
				console.error('Error:', error);
				// Handle the error if the request fails
			}
		});

		checkAnswer.on('click', function() {
		if (correct.eq(0).is(':checked')) {
		
			resultMessage.html("Correct!");
			checkAnswer.prop('hidden', true);
			next.prop('hidden', false);
			$('input[type=radio]').prop('disabled', true);

			// Use jQuery's ajax method to send a request to increment_score.php
				$.ajax({
					url: 'increment_score.php',
					type: 'POST',
					async: false,
					success: function(data) {
						score = parseInt(data);
					}
				});
			} else {
				resultMessage.html("Wrong!");
			}	

			$.ajax({
					url: 'increment_total.php',
					type: 'POST',
					async: false,
					success: function(data) {
						total = parseInt(data);
					}
				});
			updateScoreDisplay(score, total);
		});

		// Use jQuery's ajax method to send a request to increment_score.php


		next.on('click', function() {
			location.reload();
		});

		end.on('click', function() {
			window.location.href = "end.php?title=<?php echo $title; ?>";
		});


		function updateScoreDisplay(score, total) {
        $.ajax({
            url: 'get_session_values.php',
            method: 'POST',
            success: function(response) {
                var data = JSON.parse(response);
                score = data.score;
                total = data.total;

                var percentage = ((parseInt(score) / parseInt(total)) * 100).toFixed(2);
                scoreDisplay.text("Score: " + score + " / " + total + " (" + percentage + "%)");
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle the error if the request fails
            }
        });
    }
});
	</script>

  </body>
</html>