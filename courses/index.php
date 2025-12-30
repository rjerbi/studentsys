<?php
require_once '../config/db.php'; // Include the database connection

// Start the session to use flash messages
session_start();

// Fetch all courses from the database
$courses = $pdo->query("SELECT * FROM courses")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Courses</h2>

    <!-- Display flash message if it's set -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['flash']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?> <!-- Clear the flash message after displaying -->
    <?php endif; ?>

    <!-- Button to add a new course -->
    <a href="add.php" class="btn btn-success mb-3">Add Course</a>

    <!-- Display the course list in a table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Actions</th> <!-- Edit/Delete buttons -->
            </tr>
        </thead>
        <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <!-- Display course ID and name (with HTML special characters escaped) -->
                <td><?= htmlspecialchars($course['id']) ?></td>
                <td><?= htmlspecialchars(trim($course['course_name'])) ?></td>
                <td>
                    <!-- Edit button -->
                    <a href="edit.php?id=<?= $course['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <!-- Delete button with confirmation popup -->
                    <a href="delete.php?id=<?= $course['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Back to the dashboard -->
    <a href="../dashboard/index.php" class="btn btn-secondary">Back to Dashboard</a>
</body>
</html>
