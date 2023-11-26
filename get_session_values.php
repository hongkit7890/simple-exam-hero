<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = isset($_SESSION['score']) ? $_SESSION['score'] : 0;
    $total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;

    $response = array(
        'score' => $score,
        'total' => $total
    );

    echo json_encode($response);
} else {
    echo 'Invalid request method.';
}
?>