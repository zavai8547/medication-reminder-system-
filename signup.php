<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if username, email, and password fields are set
    if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'medical');
        
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        } else {
            // Check if username already exists
            $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows > 0) {
                header("Location: log.php?error=username_taken");
                exit();
            }
            
            // Prepare the SQL statement for insertion
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            // Execute the statement and check for success
            if ($stmt->execute()) {
                // Redirect to login page with success message
                header("Location: log.php?signup=success");
                exit();
            } else {
                header("Location: log.php?error=signup_failed");
                exit();
            }

            // Close the statements and connection
            $stmt->close();
            $check_stmt->close();
            $conn->close();
        }
    } else {
        header("Location: log.php?error=missing_fields");
        exit();
    }
} else {
    // If someone tries to access this file directly, redirect to login page
    header("Location: log.php");
    exit();
}
?>
