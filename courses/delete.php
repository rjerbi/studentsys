<?php
require_once '../config/db.php'; // Include the database connection file

// Start the session to use flash messages
session_start();

// Check if a course ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the course ID from the URL

    // Prepare and execute the SQL statement to delete the course
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Set a flash message indicating that the course was deleted successfully
    $_SESSION['flash'] = "Course deleted successfully!";

    // Redirect to the course list page after deletion
    header("Location: index.php");
    exit();
} else {
    // If no ID was passed, redirect to the course list page
    header("Location: index.php");
    exit();
}
?>
