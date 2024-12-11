<?php
// Start session
session_start();

// Include database configuration file
require 'config.php'; 

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the username exists and verify password
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Set session variables for logged-in user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: log.php?error=invalid_password");
            exit();
        }
    } else {
        header("Location: log.php?error=user_not_found");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If someone tries to access this file directly, redirect to login page
    header("Location: log.php");
    exit();
}
?>
