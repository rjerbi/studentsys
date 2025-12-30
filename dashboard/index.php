<?php 
session_start(); // Start session to track user login

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="mb-4">Dashboard</h2>

        <!-- Navigation buttons to different sections -->
        <div class="mb-3">
            <a href="../students/index.php" class="btn btn-success me-2">Students</a>
            <a href="../courses/index.php" class="btn btn-primary me-2">Courses</a>
            <a href="../enrollments/index.php" class="btn btn-warning me-2">Enrollments</a>
            <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
