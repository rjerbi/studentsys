<?php
require_once '../config/db.php'; // Include the database connection file
session_start(); // Start the session to handle flash messages

// Fetch enrollments with student and course names using SQL JOIN
$enrollments = $pdo->query("
    SELECT students.first_name AS student, courses.course_name AS course, enrollments.student_id, enrollments.course_id
    FROM enrollments
    JOIN students ON students.id = enrollments.student_id
    JOIN courses ON courses.id = enrollments.course_id
")->fetchAll(); // Execute the query and fetch all results
?>
<!DOCTYPE html>
<html>
<head>
    <title>Enrollments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Enrollments</h2>

<?php
// Display flash message if set
if (isset($_SESSION['flash_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['flash_message'] . '</div>';
    unset($_SESSION['flash_message']); // Clear the flash message after displaying
}
?>

<a href="add.php" class="btn btn-success mb-3">Add Enrollment</a>

<!-- Display the list of enrollments in a table -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Student</th>
            <th>Course</th>
            <th>Actions</th> <!-- Actions column for delete -->
        </tr>
    </thead>
    <tbody>
    <?php foreach ($enrollments as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['student_id']) ?></td> <!-- Display the student ID -->
            <td><?= htmlspecialchars($row['student']) ?></td> <!-- Display the student name -->
            <td><?= htmlspecialchars($row['course']) ?></td> <!-- Display the course name -->
            <td>
                <!-- Link to delete this enrollment, with a confirmation prompt -->
                <a href="delete.php?student_id=<?= $row['student_id'] ?>&course_id=<?= $row['course_id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this enrollment?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="../dashboard/index.php" class="btn btn-secondary">Back to Dashboard</a>
</body>
</html>
