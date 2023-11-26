<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Questions</title>

    <style>
        /* CSS styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ccc;
        }

        .question-cell {
            white-space: normal;
            word-wrap: break-word;
        }
        
        .question-cell img {
            max-width: 100%;
            height: auto;
        }

        /* CSS styles for the form input and button */
        #newChapter {
            margin-top: 10px;
            padding: 5px;
        }

        #updateButton {
            margin-top: 10px;
            padding: 5px 10px;
        }
    </style>

</head>

<?php
// Include the database connection file
include "../database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filter = "";
$title="";
if (isset($_GET['n'])) {
	$filter = " AND question_number = $_GET[n]";
	$title = "題目編號 #$_GET[n]";
}

if (isset($_GET['year'])) {
	$filter = " AND left(ref, 4) = $_GET[year]";
	$title = "歷屆試題 $_GET[year]";
}

if (isset($_GET['keyword'])) {
	$keywords = explode(",", $_GET['keyword']);
	$keywords = array_map('trim', $keywords); // Remove any leading/trailing spaces
	$keywords = array_map([$mysqli, 'real_escape_string'], $keywords); // Prevent SQL injection

	$likeClauses = array();
    foreach ($keywords as $keyword) {
        if ($keyword != "") $likeClauses[] = "question LIKE '%$keyword%'";
    }

    $filter = " AND (" . implode(' OR ', $likeClauses) . ")";
    $title = "標籤 " . $_GET['keyword'];

	if ($title[strlen($title) - 1] === ',') {
		$title = rtrim($title, ',');
	  }
	
}


?>
<a href="edit.php">New</a>

<form id="questionsForm">
<table border=1 width=100%>
    <thead>
        <tr>
            <th>Select</th>
            <th>Question Number</th>
            <th>Reference</th>
            <th>Question</th>
            <th>Chapter</th>
            <th>Edit</th>
            <th>Del</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to select all fields from the "questions" table
        $query = "SELECT question_number, ref, question, chapter, qtype FROM questions where TRUE $filter
        order by ref";
        $result = $mysqli->query($query);

        // Check if the query was successful
        if ($result) {
            // Loop through the rows of the result set
            while ($row = $result->fetch_assoc()) {
                // Display each row as a table row
                echo "<tr>";
                echo "<td><input type='checkbox' name='selectedQuestions[]' value='" . $row['question_number'] . "'></td>";
                echo "<td>" . $row['question_number'] . "</td>";
                echo "<td>" . $row['ref'] . "</td>";
                echo "<td class='question-cell'>" . $row['question'] . "</td>";
                echo "<td>" . $row['chapter'] . "</td>";
                echo "<td><a href='edit.php?id=" . $row['question_number'] . "' target=_BLANK>Edit</a></td>"; // Edit button?>
                <td>
                <a href="javascript:void(0);" onclick="deleteQuestion(<?php echo $row['question_number']; ?>)">Del</a>
                </td>
                <?php
                echo "</tr>";
            }
        } else {
            // Query was not successful
            echo "<tr><td colspan='5'>Error: " . $mysqli->error . "</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Add a text input for the new chapter and a button to submit the changes -->
<input type="text" id="newChapter" name="newChapter" placeholder="New chapter">
<button type="button" onclick="updateChapters()">Update Chapters</button>
</form>

<?php
// Close the database connection
$mysqli->close();
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
function deleteQuestion(id) {
    if (window.confirm("Are you sure you want to delete this question?")) {
        $.ajax({
            url: 'delete.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                location.reload(); // Reload the page to get the updated list
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
}

function updateChapters() {
    let form = $('#questionsForm');
    let formData = form.serialize();

    $.ajax({
        url: 'updateChapter.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            location.reload(); // Reload the page to get the updated list
        },
        error: function(error) {
            console.log(error);
        }
    });
}


</script>
</body>
</html>