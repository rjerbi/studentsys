<?php
session_start(); // Start the session to store user data after login

require_once '../config/db.php'; // Include database connection file

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email']; // Get email input from form
    $password = $_POST['password']; // Get password input from form

    // Prepare SQL to find user with matching email and password
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]); // Execute query with form values
    $user = $stmt->fetch(); // Fetch the user data

    // If credentials are valid
    if ($user) {
        $_SESSION['user'] = $user; // Store user info in session
        header("Location: ../dashboard/index.php"); // Redirect to dashboard
        exit(); // Stop script
    } else {
        $error = "Invalid credentials"; // Error message for wrong login
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Load Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Login</h2>

<!-- Show error alert if login failed -->
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<!-- Login form -->
<form method="POST">
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

</body>
</html>
