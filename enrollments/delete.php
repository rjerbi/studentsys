<?php
require_once '../config/db.php'; // Include the database connection

// Start the session to handle flash messages
session_start();

// Check if 'student_id' and 'course_id' parameters are present in the URL
if (isset($_GET['student_id']) && isset($_GET['course_id'])) {
    $student_id = $_GET['student_id'];  // Get student ID from the URL
    $course_id = $_GET['course_id'];    // Get course ID from the URL

    // Delete the enrollment from the 'enrollments' table where both student_id and course_id match
    $stmt = $pdo->prepare("DELETE FROM enrollments WHERE student_id = :student_id AND course_id = :course_id");
    $stmt->execute([
        'student_id' => $student_id,
        'course_id' => $course_id
    ]);

    // Set a success message in the session
    $_SESSION['flash_message'] = 'Enrollment successfully deleted!';

    // Redirect back to the enrollments page after deletion
    header("Location: index.php");
    exit();
} else {
    // If the 'student_id' or 'course_id' is not provided, redirect to the enrollments page
    header("Location: index.php");
    exit();
}
?>
