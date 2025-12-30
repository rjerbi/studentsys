<?php 
require_once '../config/db.php'; // Include the database connection file

// Start the session to use flash messages
session_start();

// Check if the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form input values
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];

    // Prepare the SQL query to insert the student data into the database
    $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, date_of_birth, email) VALUES (?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $date_of_birth, $email]);

    // Set a flash message indicating that the student was added successfully
    $_SESSION['flash'] = "Student added successfully!";

    // Redirect to the students list page after successful insertion
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Add Student</h2>

<!-- Display flash message if it's set -->
<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['flash']; ?>
    </div>
    <?php unset($_SESSION['flash']); ?> <!-- Clear the flash message after displaying -->
<?php endif; ?>

<!-- Student addition form -->
<form method="POST" action="add.php">
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    <div class="mb-3">
        <label for="date_of_birth" class="form-label">Date of Birth</label>
        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <button type="submit" class="btn btn-success">Add Student</button>
</form>

<!-- Link to go back to the students list -->
<a href="index.php" class="btn btn-secondary mt-3">Back to Students List</a>

</body>
</html>
