<?php
// Include the database connection file
include "../database.php";


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
        $chapter = $row['chapter'];
        $ref = $row['ref'];
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
    $query = "SELECT MAX(question_number) as maxNumber FROM questions";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($mysqli));
    }

    $row = mysqli_fetch_assoc($result);
    $id = $row['maxNumber']+1;


    // Now insert a new record into the questions table
    $query = "INSERT INTO questions (question_number, parent, ref, question, chapter, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, qtype, 
    timecreated, timemodified, createdby, modifiedby) VALUES (?, 0, 'ref', 'question', 'chapter', 1, 'generalfeedback', 1, 1, 'multichoice', NOW(), NOW(), 1, 1)";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die('Insert question failed: ' . $mysqli->error);
    }

    // Insert 4 new records into the choices table
    $choices = ['A', 'B', 'C', 'D'];

    for ($i = 0; $i < 4; $i++) {
        $query = "INSERT INTO choices (question_number, choice) VALUES ($id, '{$choices[$i]}')";
        echo $query; // For debugging purposes only, remove in production code
        if (mysqli_query($mysqli, $query) === FALSE) {
            die('Failed to insert choice: ' . mysqli_error($mysqli));
        }
    }
    header('Location: edit.php?id='.$id);
    exit;
}

// Close the database connection
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../tinymce2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>


const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'upload.php');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location !== 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });


        tinymce.init({
            selector: 'textarea',
            //selector: '.question-content',
            plugins: 'image code', // Added 'code' plugin
            toolbar: 'redo undo | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image code', // Added 'code' to the toolbar

            // without images_upload_url set, Upload tab won't show up
            images_upload_url: 'upload.php',

            // override default upload handler to simulate successful upload
            images_upload_handler: image_upload_handler_callback
        });

        $(document).ready(function() {
            $('form').on('submit', function(event) {
                // Check if a correct answer is selected
                if (!$('input[name="correctAnswer"]:checked').length) {
                    event.preventDefault(); // Prevent form submission
                    alert('Please select a correct answer before submitting.'); // Show an alert message
                }
            });
        });
    
    </script>

</head>
<body>
    <h1>Edit Question <?php echo $ref;?></h1>
    <form action="update.php" method="POST">
        
    <input type="submit" value="Update"><br>
    <input type="hidden" name="questionID" value="<?php echo $id; ?>">

        <label>Question Content:</label><br>
        <textarea class="question-content" name="questionContent" rows="4" cols="50"><?php echo isset($questionContent) ? $questionContent : ''; ?></textarea><br><br>

        <label>Reference:</label><br>
        <input type="text" name="ref" value="<?php echo isset($ref) ? $ref : ''; ?>"><br><br>

        <label>chapter:</label><br>
        <input type="text" name="chapter" value="<?php echo isset($chapter) ? $chapter : ''; ?>"><br><br>

        <label>General Feedback:</label><br>
        <textarea class="general-feedback" name="generalFeedback" rows="4" cols="50"><?php echo isset($generalFeedback) ? $generalFeedback : ''; ?></textarea><br><br>

        <label>Choices:</label><br>
        <?php if (!empty($choices)) : ?>
            <?php 
            $labels = array('A', 'B', 'C', 'D'); // Array of labels A, B, C, D
            $choiceIndex = 0; // Counter variable to track the choice index
            foreach ($choices as $choice) : 
                $label = $labels[$choiceIndex]; // Get the corresponding label for the choice
                $choiceIndex++;
            ?>
                <div class="choice-container">
                    <input type="radio" name="correctAnswer" value="<?php echo $choice['id']; ?>" 
                        <?php echo $choice['is_correct'] == 1 ? 'checked' : ''; ?>> 
                    Correct Answer (<?php echo $label; ?>)<br>
                    <textarea class="choice-content" name="choice_<?php echo $choice['id']; ?>" rows="4" cols="50">
                        <?php echo $choice['choice']; ?>
                    </textarea>
                </div>
                <br>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No choices found for this question.</p>
        <?php endif; ?>

        <br>

        
    </form>

    <a href="questions.php">Go back to Questions</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
    $(document).keydown(function(event) {
        if (event.ctrlKey && event.keyCode == 13) {
        $('form').submit();
        }
    });
    });
    </script>
</body>
</html>


