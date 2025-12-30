<?php 
require_once '../config/db.php'; // Include the database connection

// Start the session to handle flash messages
session_start();

// Fetch students and courses for the dropdown options
$students = $pdo->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM students")->fetchAll();
$courses = $pdo->query("SELECT id, course_name FROM courses")->fetchAll();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id']; // Get the selected student ID from the form
    $course_id = $_POST['course_id'];   // Get the selected course ID from the form

    // Insert the enrollment into the database
    $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
    $stmt->execute([$student_id, $course_id]);

    // Set a success message in the session to inform the user that the enrollment was added
    $_SESSION['flash_message'] = 'Enrollment successfully added!';
    
    // Redirect to the enrollment list page after insertion
    header("Location: index.php");
    exit(); // Ensure that the script ends after the redirect
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Add Enrollment</h2>

<?php
// Display flash message if set
if (isset($_SESSION['flash_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['flash_message'] . '</div>';
    unset($_SESSION['flash_message']); // Clear the flash message after displaying
}
?>

<!-- Enrollment Form -->
<form method="POST" action="add.php">
    <!-- Student selection -->
    <div class="mb-3">
        <label for="student_id" class="form-label">Select Student</label>
        <select class="form-select" id="student_id" name="student_id" required>
            <option value="">Select Student</option>
            <?php foreach ($students as $student): ?>
                <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Course selection -->
    <div class="mb-3">
        <label for="course_id" class="form-label">Select Course</label>
        <select class="form-select" id="course_id" name="course_id" required>
            <option value="">Select Course</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['course_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Add Enrollment</button>
</form>

<a href="index.php" class="btn btn-secondary mt-3">Back to Enrollments List</a>
</body>
</html>
