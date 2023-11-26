<?php 
session_start(); 
if (isset($_SESSION['score'])) {
    $_SESSION['score']++;
    echo $_SESSION['score']; // Return the new score so it can be displayed on the page
} else {
    echo "0";
}
?>