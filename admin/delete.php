<?php 
include "../database.php"; 

$response = ['success' => false, 'message' => 'No ID provided to delete.'];

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM questions WHERE question_number = $id";
    $result = $mysqli->query($query);

    if($result) {
        $response['success'] = true;
        $response['message'] = 'Question deleted successfully.';
    } else {
        $response['message'] = "Error deleting question: ".$mysqli->error;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>