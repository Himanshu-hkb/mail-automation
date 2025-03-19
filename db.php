<?php
// Database connection details
$host = 'localhost'; // Database host
$dbname = 'u271281502_task_scheduler'; // Database name
$username = 'u271281502_task_scheduler'; // Database username
$password = 'Task_scheduler@123'; // Database password

// Create connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Debugging ke liye
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>