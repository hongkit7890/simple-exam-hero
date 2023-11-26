<?php
// Include the database connection file
include "../database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the id is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the question and choices from the database
    $questionQuery = "SELECT * FROM questions WHERE question_number = $id";
    $questionResult = mysqli_query($mysqli, $questionQuery);

    // Check if the question exists
    if (mysqli_num_rows($questionResult) === 1) {
        $row = mysqli_fetch_assoc($questionResult);
        $questionContent = $row['question'];
        $hashtag = $row['hashtag'];
        $generalFeedback = $row['generalfeedback'];

        // Retrieve the choices for the question
        $choicesQuery = "SELECT * FROM choices WHERE question_number = $id";
        $choicesResult = mysqli_query($mysqli, $choicesQuery);

        $choices = array();
        while ($choiceRow = mysqli_fetch_assoc($choicesResult)) {
            $choices[] = $choiceRow;
        }

        // Close the choices result set
        mysqli_free_result($choicesResult);
    } else {
        echo "Question not found.";
        exit;
    }

    // Close the question result set
    mysqli_free_result($questionResult);
} else {
    echo "Invalid request.";
    exit;
}

// Close the database connection
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <style>
        .question-content,
        .general-feedback,
        .choice-content {
            width: 100%;
        }

        .choice-container {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Edit Question</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="questionID" value="<?php echo $id; ?>">

        <label>Question Content:</label><br>
        <textarea class="question-content" name="questionContent" rows="4" cols="50"><?php echo isset($questionContent) ? $questionContent : ''; ?></textarea><br><br>

        <label>Hashtag:</label><br>
        <input type="text" name="hashtag" value="<?php echo isset($hashtag) ? $hashtag : ''; ?>"><br><br>

        <label>General Feedback:</label><br>
        <textarea class="general-feedback" name="generalFeedback" rows="4" cols="50"><?php echo isset($generalFeedback) ? $generalFeedback : ''; ?></textarea><br><br>

        <label>Choices:</label><br>
        <?php if (!empty($choices)) : ?>
            <?php foreach ($choices as $choice) : ?>
                <div class="choice-container">
                    <input type="radio" name="correctAnswer" value="<?php echo $choice['id']; ?>" <?php echo $choice['is_correct'] == 1 ? 'checked' : ''; ?>> Correct Answer<br>
                    <textarea class="choice-content" name="choice_<?php echo $choice['id']; ?>" rows="4" cols="50"><?php echo $choice['choice']; ?></textarea>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No choices found for this question.</p>
        <?php endif; ?>

        <br>

        <input type="submit" value="Update">
    </form>

    <a href="questions.php">Go back to Questions</a>

    <script>
        ClassicEditor
            .create(document.querySelector('.question-content'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('.general-feedback'))
            .catch(error => {
                console.error(error);
            });

        const choiceContents = document.querySelectorAll('.choice-content');
        choiceContents.forEach(choiceContent => {
            ClassicEditor
                .create(choiceContent)
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>