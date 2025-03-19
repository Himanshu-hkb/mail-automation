<?php
session_start(); // Session start karein

// Check karein ki user logged in hai ya nahi
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Agar nahi hai, toh login page par redirect karein
    exit();
}

// Agar logged in hai, toh user ka dashboard show karein
//echo "Welcome, " . $_SESSION['user_email']; // User ka email show karein
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4 class="text-center">Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="task.php" class="nav-link text-white">Manage Tasks</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Schedule</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
            </ul>
        </div>
        
        <!-- Page Content -->
        <div class="container-fluid p-4">
            <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
            <p>Your Dashboard</p>
            <p>Here you can manage your tasks.</p>
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
                <div class="col-md-4">
                    <div class="card text-bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Schedule</h5>
                            <p class="card-text">Next meeting at 3 PM.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



