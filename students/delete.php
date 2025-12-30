<?php
require_once '../config/db.php'; // Include the database connection file

// Start session to use flash messages
session_start();

// Check if the student ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the query to delete the student from the database
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Set a flash message indicating the student has been deleted
    $_SESSION['flash'] = "Student deleted successfully!";

    // Redirect to the students list page after successful deletion
    header("Location: index.php");
    exit();
} else {
    // If the ID is not present in the URL, set an error flash message and redirect
    $_SESSION['flash'] = "Error: Student not found.";
    header("Location: index.php");
    exit();
}
?>
