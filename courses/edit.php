<?php
require_once '../config/db.php';

// Start the session to use flash messages
session_start();

// Check if a course ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve course information
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $course = $stmt->fetch();

    // Check if the course exists
    if (!$course) {
        echo "Course not found!";
        exit();
    }

    // Handle the edit form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $course_name = $_POST['course_name'];

        // Update the course in the database
        $stmt = $pdo->prepare("UPDATE courses SET course_name = :course_name WHERE id = :id");
        $stmt->execute(['course_name' => $course_name, 'id' => $id]);

        // Set a flash message indicating that the course was updated successfully
        $_SESSION['flash'] = "Course updated successfully!";

        // Redirect to the course list page after the update
        header("Location: index.php");
        exit();
    }
} else {
    // If no ID is passed, redirect to the course list page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Edit Course</h2>

<!-- Display flash message if it's set -->
<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['flash']; ?>
    </div>
    <?php unset($_SESSION['flash']); ?> <!-- Clear the flash message after displaying -->
<?php endif; ?>

<!-- Edit course form -->
<form method="POST">
    <div class="mb-3">
        <label for="course_name" class="form-label">Course Name</label>
        <input type="text" class="form-control" id="course_name" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Course</button>
</form>

<a href="index.php" class="btn btn-secondary mt-3">Back to Courses</a>
</body>
</html>
