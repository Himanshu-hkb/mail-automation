<?php
session_start(); // Session start karein
require 'db.php'; // Database connection include karein

// Check karein ki user logged in hai ya nahi
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Agar nahi hai, toh login page par redirect karein
    exit();
}

$user_id = $_SESSION['user_id']; // Session se user ID fetch karein

// Task add karein
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_date = $_POST['task_date'];

    // Database mein task insert karein
    $sql = "INSERT INTO tasks (user_id, task_name, task_description, task_date) VALUES (:user_id, :task_name, :task_description, :task_date)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'task_name' => $task_name, 'task_description' => $task_description, 'task_date' => $task_date]);

    echo "Task added successfully!";
}

// Task delete karein
if (isset($_GET['delete_id'])) {
    $task_id = $_GET['delete_id'];
    $sql = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['task_id' => $task_id, 'user_id' => $user_id]);
    echo "Task deleted successfully!";
}
?>

<!-- Task Add Form -->
<form method="POST" action="">
    <input type="text" name="task_name" placeholder="Task Name" required>
    <textarea name="task_description" placeholder="Task Description"></textarea>
    <input type="date" name="task_date" required>
    <button type="submit" name="add_task">Add Task</button>
</form>

<!-- Task List -->
<?php
// User ke tasks fetch karein
$sql = "SELECT * FROM tasks WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll();

foreach ($tasks as $task) {
    echo "<div>
            <h3>{$task['task_name']}</h3>
            <p>{$task['task_description']}</p>
            <p>Date: {$task['task_date']}</p>
            <a href='task.php?delete_id={$task['id']}'>Delete</a>
          </div>";
}
?>