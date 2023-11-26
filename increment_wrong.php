<?php 
session_start(); 
if (isset($_SESSION['wrong'])) {
    $_SESSION['wrong']++;
    echo $_SESSION['wrong']; // Return the new score so it can be displayed on the page
} else {
    echo "0";
}
?>
