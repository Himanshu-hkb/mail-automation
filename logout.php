<?php
session_start(); // Session start karein

// Session destroy karein
session_unset(); // Sabhi session variables clear karein
session_destroy(); // Session destroy karein

// User ko login page par redirect karein
header("Location: login.php");
exit();
?>