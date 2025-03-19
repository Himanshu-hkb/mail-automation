<?php
require 'db.php'; // Database connection include karein
require 'vendor/autoload.php'; // PHP Mailer include karein

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Sabhi users ke tasks fetch karein
$sql = "SELECT users.boss_email, tasks.task_name, tasks.task_description, tasks.task_date 
        FROM tasks 
        JOIN users ON tasks.user_id = users.id 
        WHERE tasks.task_date = CURDATE()"; // Aaj ke tasks
$stmt = $conn->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll();

// Har task ko boss ke email par send karein
foreach ($tasks as $task) {
    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com'; // Your email
        $mail->Password = 'your_password'; // Your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email details
        $mail->setFrom('your_email@gmail.com', 'Task Scheduler');
        $mail->addAddress($task['boss_email']); // Boss ka email
        $mail->isHTML(true);
        $mail->Subject = 'Daily Task Report';
        $mail->Body = "Task: {$task['task_name']}<br>Description: {$task['task_description']}<br>Date: {$task['task_date']}";

        $mail->send();
        echo "Email sent to {$task['boss_email']} successfully!";
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>