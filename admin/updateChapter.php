<?php
// Include the database connection file
include "../database.php";

if (isset($_POST['selectedQuestions']) && isset($_POST['newChapter'])) {
    $selectedQuestions = $_POST['selectedQuestions'];
    $newChapter = $mysqli->real_escape_string($_POST['newChapter']);

    foreach ($selectedQuestions as $questionNumber) {
        $query = "UPDATE questions SET chapter = '$newChapter' WHERE question_number = $questionNumber";
        $mysqli->query($query);
    }
}

$mysqli->close();
?>