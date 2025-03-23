<?php
session_start(); 
require 'db.php'; // Database connection include karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

    echo "<script> alert('Task added successfully!'); </script>";
}

// Task delete karein
if (isset($_GET['delete_id'])) {
    $task_id = $_GET['delete_id'];
    $sql = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['task_id' => $task_id, 'user_id' => $user_id]);
    echo "<script> alert('Task deleted successfully!'); </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function loadContent(page) {
            let content = "";

            if (page === 'tasks') {
                content = `
                    <form method="POST" action="">
                        <div class="row form-row">
                            <div class="col-md-4">
                            <input type="text" class="form-control" name="task_name" placeholder="Task Name">
                            </div>
                            <div class="col-md-4">
                            <input type="date" class="form-control" name="task_date" required>
                            </div>
                            <div class="col-md-4">
                            <textarea name="task_description" class="form-control" placeholder="Task Description"></textarea>
                            </div>
                            <div class="col-auto">
                            <button type="submit" name="add_task" class="btn btn-primary mb-2">Submit</button>
                            </div>
                        </div>
                    </form>
                    <h2>Manage Tasks</h2>
                    <p>Here you can view and update your tasks.</p>
                    <!-- Task List -->
                    <?php
                    // User ke tasks fetch karein
                    $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(['user_id' => $user_id]);
                    $tasks = $stmt->fetchAll();
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tasks Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Date</th>
                            <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                foreach ($tasks as $task) {
                                echo "<tr>
                                        <th scope='row'>1</th>
                                        <td>{$task['task_name']}</td>
                                        <td>{$task['task_description']}</td>
                                        <td>Date: {$task['task_date']}</td>
                                        <td><a href='dashboard.php?delete_id={$task['id']}'>Delete</a></td>
                                    </tr>";
                                    }
                                    ?>
                            
                        </tbody>
                    </table>
                `;
            } 
            else if (page === 'schedule') {
                content = `
                    <h2>Schedule</h2>
                    <p>Your upcoming meetings and deadlines:</p>
                    <ul>
                        <li>Monday: Team Meeting at 10 AM</li>
                        <li>Wednesday: Project Deadline</li>
                        <li>Friday: Client Presentation</li>
                    </ul>
                `;
            }
            else if (page === 'dashboard') {
                content = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Profile Image">
                                <h5 class="card-title"><?php echo $_SESSION['user_name']; ?></h5>
                                <p class="card-text"><?php echo $_SESSION['user_email']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-info mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Boss Email</h5>
                                <p class="card-text">boss@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Tasks</h5>
                                <p class="card-text">You have 5 pending tasks.</p>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }

            document.getElementById('main-content').innerHTML = content;
        }

        // Page load hone par by default "dashboard" content show karein
        window.onload = function() {
            loadContent('dashboard');
        };
    </script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4 class="text-center">Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="loadContent('dashboard')">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="loadContent('tasks')">Manage Tasks</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white" onclick="loadContent('schedule')">Schedule</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-white">Logout</a>
                </li>
            </ul>
        </div>
        
        <!-- Page Content -->
        <div class="container-fluid p-4">
            <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
            <p>Your Dashboard</p>
            <div id="main-content" class="main-div">
                <!-- Default content yahan JavaScript se load hoga -->
            </div>
        </div>
    </div>
</body>
</html>
