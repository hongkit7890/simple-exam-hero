<?php
// Include the database connection file
include "../database.php";

for ($j=1;$j<=40;$j++){
$query = "SELECT MAX(question_number) as maxNumber FROM questions";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($mysqli));
}

$row = mysqli_fetch_assoc($result);
$id = $row['maxNumber']+1;

$string = '2021MC'.str_pad($j, 2, '0', STR_PAD_LEFT);

// Now insert a new record into the questions table
$query = "INSERT INTO questions (question_number, parent, ref, question, chapter, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, qtype, 
timecreated, timemodified, createdby, modifiedby) 
VALUES (?, 0, '$string', 'question', '', 1, '', 1, 1, 'multichoice', NOW(), NOW(), 1, 1)";

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
}}
    
?>