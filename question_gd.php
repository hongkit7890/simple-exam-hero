<?php 
include "database.php"; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<?php session_start(); 
if (!isset($_SESSION['score'])) {
	$_SESSION['score'] = 0;
	$_SESSION['wrong'] = 0;
}

$filter = "";

if (isset($_GET['n'])) {
	$filter = " AND question_number = $_GET[n]";
	echo "題目編號 #$_GET[n]";
}

if (isset($_GET['year'])) {
	$filter = " AND left(ref, 4) = $_GET[year]";
	echo "歷屆試題 $_GET[year]";
}

if (isset($_GET['hashtag'])) {
	$filter = " AND hashtag like '%$_GET[hashtag]%'";
	echo "標籤 $_GET[hashtag]";
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
    <title>PHP Quizzer!</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/jquery-3.7.1.min.js"></script>
  </head>
  <body>
    <div id="container">
      <header>
        <div class="container">
          <h1>PHP Quizzer</h1>
	    </div>
      </header>

      <main>
      <div class="container">
        <div class="current"><?php echo $ref; ?> 題目編號 #<?php echo $number; ?></div>

		
	<p class="question"><?php echo $question['question'] ?></p>
	<form>
	    <ul class="choices">
	    <?php while($row=$choices->fetch_assoc()): ?>
		    <li><input name="choice" type="radio" value="<?php echo $row['id']; ?>" 
			<?php if ($row['is_correct'] == 1) {echo "class='correct'";} ?> /> 
			    <?php echo $row['choice']; ?>
			</li>
		<?php endwhile; ?>
	    </ul>
	    <input type="button" id='checka' value="Check Answer"/>
		<input type="button" id='next' value="Next Question" hidden/>
	    <input type="hidden" name="number" value="<?php echo $number; ?>" />
	</form>
	<p id="result-message"></p>
	<p id="score">Score: <?php echo $_SESSION['score']; ?></p>

	<p align="center"><input type="button" id='end' value="End Quiz"/></p>


    </div>
    </div>
    </main>


    <footer>
      <div class="container">
      	   Copyright &copy; 2015, PHP Quizzer
      </div>
    </footer>

	<script>
		$(document).ready(function() {
		var correct = $('.correct');
		var resultMessage = $('#result-message');
		var checkAnswer = $('#checka');
		var score = $('#score');
		var next = $('#next');
		var end = $('#end');
		var attempted = false;



		checkAnswer.on('click', function() {
			if (correct.eq(0).is(':checked')) {
				resultMessage.html("Correct!");
				checkAnswer.prop('hidden', true);
				next.prop('hidden', false);

				// Use jQuery's ajax method to send a request to increment_score.php
				if(!attempted){
					$.ajax({
						url: 'increment_score.php',
						type: 'POST',
						success: function(data) {
							// Update the score on the page with the new score from the server
							score.html("Score: " + data);

						}
					});
					attempted = true;
				}

			} else {
				resultMessage.html("Wrong!");
				$.ajax({
					url: 'increment_wrong.php',
					type: 'POST',
					success: function(data) {
						// Update the score on the page with the new score from the server
						score.html("Wrong: " + data);
					}
				});
			}	
		});

		// Use jQuery's ajax method to send a request to increment_score.php


		next.on('click', function() {
			window.location.href = "question.php";
		});

		end.on('click', function() {
			window.location.href = "end.php";
		});


		});
	</script>

  </body>
</html>