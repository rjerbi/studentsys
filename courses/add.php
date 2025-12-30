<?php  
require_once '../config/db.php'; // Include the database connection

// Start the session to use flash messages
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the course name was submitted and not empty
    if (isset($_POST['course_name']) && !empty($_POST['course_name'])) {
        $course_name = $_POST['course_name'];

        // Prepare and execute the SQL insert query
        $stmt = $pdo->prepare("INSERT INTO courses (course_name) VALUES (:course_name)");
        $stmt->execute(['course_name' => $course_name]);

        // Set a flash message indicating that the course was added successfully
        $_SESSION['flash'] = "Course added successfully!";

        // Redirect to the courses list after successful insertion
        header("Location: index.php"); // Redirect to course listing page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <!-- Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Add New Course</h2>

    <!-- Display flash message if it's set -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['flash']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?> <!-- Clear the flash message after displaying -->
    <?php endif; ?>

    <!-- Course form: sends POST request to the same page -->
    <form method="POST" action="add.php">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>
        </div>
        <button type="submit" class="btn btn-success">Add Course</button>
    </form>

    <!-- Link to go back to the courses list page -->
    <a href="index.php" class="btn btn-secondary mt-3">Back to Courses List</a>
</body>
</html>
