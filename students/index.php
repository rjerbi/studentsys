<?php 
require_once '../config/db.php'; // Include the database connection

// Start session to use flash messages
session_start();

// Fetch all students from the students table
$students = $pdo->query("SELECT * FROM students")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <!-- Including Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Students</h2>

    <!-- Display Flash Message if it exists -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['flash']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?> <!-- Clear the flash message after displaying -->
    <?php endif; ?>

    <!-- Button to add a new student -->
    <a href="add.php" class="btn btn-success mb-3">Add Student</a>

    <!-- Table to display student data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['id']) ?></td>
                <!-- Displaying the student's full name -->
                <td><?= htmlspecialchars(trim($student['first_name'] . ' ' . $student['last_name'])) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td>
                    <!-- Edit and delete action buttons -->
                    <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Button to navigate back to the dashboard -->
    <a href="../dashboard/index.php" class="btn btn-secondary">Back to Dashboard</a>
</body>
</html>
