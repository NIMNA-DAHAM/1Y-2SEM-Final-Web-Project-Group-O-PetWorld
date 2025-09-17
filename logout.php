<?php
session_start();

// Unset all session variables
$_SESSION = array();


session_destroy();

// Redirect to first page
header("Location: firstpage.php");
exit();
?>