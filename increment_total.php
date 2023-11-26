<?php 
session_start(); 
if (isset($_SESSION['total'])) {
    $_SESSION['total']++;
    echo $_SESSION['total']; // Return the new score so it can be displayed on the page
} else {
    echo "0";
}
?>
