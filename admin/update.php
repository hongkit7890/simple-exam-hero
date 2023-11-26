<?php
// Include the database connection file
include "../database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the question ID from the form
    $questionID = $_POST['questionID'];

    // Get the updated question content, chapter, and general feedback from the form
    $questionContent = $_POST['questionContent'];
    $chapter = $_POST['chapter'];
    $generalFeedback = $_POST['generalFeedback'];
    $ref = $_POST['ref'];

    // Update the question in the database
    $updateQuestionQuery = "UPDATE questions SET question = ?, chapter = ?, generalfeedback = ?, ref = ? WHERE question_number = ?";
    $stmt = $mysqli->prepare($updateQuestionQuery);
    $stmt->bind_param("ssssi", $questionContent, $chapter, $generalFeedback, $ref, $questionID);
    $stmt->execute();

    // Update the choices in the database
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'choice_') !== false) {
            $choiceID = substr($key, strlen('choice_'));
            $isCorrect = ($_POST['correctAnswer'] == $choiceID) ? 1 : 0;

            $updateChoiceQuery = "UPDATE choices SET choice = ?, is_correct = ? WHERE id = ?";
            $stmt = $mysqli->prepare($updateChoiceQuery);
            $stmt->bind_param("sii", $value, $isCorrect, $choiceID);
            $stmt->execute();
        }
    }

    // Redirect back to the edit page with the question ID
    header("Location: edit.php?id=$questionID");
    exit;
} else {
    echo "Invalid request.";
    exit;
}

// Close the database connection
mysqli_close($mysqli);
?>