<?php
// db.php - Database connection using PDO (PHP Data Objects)

$host = 'localhost';          // Database host
$dbname = 'student_system';   // Name of the database
$username = 'root';           // MySQL username
$password = '';               // MySQL password (empty by default for localhost)

try {
    // Create a new PDO instance and connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions for errors (good for debugging)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display an error message if connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>
