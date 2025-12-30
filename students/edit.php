<?php 
require_once '../config/db.php'; // Include the database connection file

// Start session to use flash messages
session_start();

// Check if the student ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current data of the student from the database
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $student = $stmt->fetch();

    // If the student doesn't exist, redirect to the students list
    if (!$student) {
        header("Location: index.php");
        exit();
    }
} else {
    // If the ID is not present in the URL, redirect to the students list
    header("Location: index.php");
    exit();
}

// Handle the form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // Update the student's information in the database
    $updateStmt = $pdo->prepare("UPDATE students SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id");
    $updateStmt->execute([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'id' => $id
    ]);

    // Set a flash message for successful update
    $_SESSION['flash'] = "Student details updated successfully!";

    // Redirect to the students list after the update
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Edit Student</h2>

    <!-- Display Flash Message if it exists -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['flash']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?> <!-- Clear the flash message after displaying -->
    <?php endif; ?>

    <!-- Edit student form -->
    <form method="POST">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
    <a href="index.php" class="btn btn-secondary mt-3">Back to Students List</a>
</body>
</html>
