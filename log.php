<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Get any error or success messages
$message = '';
$messageClass = '';

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'username_taken':
            $message = 'Username is already taken. Please choose another.';
            $messageClass = 'error';
            break;
        case 'invalid_password':
            $message = 'Invalid password. Please try again.';
            $messageClass = 'error';
            break;
        case 'user_not_found':
            $message = 'No account found with that username.';
            $messageClass = 'error';
            break;
        case 'missing_fields':
            $message = 'Please fill out all fields.';
            $messageClass = 'error';
            break;
    }
}

if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
    $message = 'Sign-up successful! Please log in.';
    $messageClass = 'success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign-Up</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Medication Reminder System</h1>
    </header>

    <div class="container">
        
        <div class="form-container">
            <?php if ($message): ?>
                <div class="message <?php echo $messageClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <input type="radio" name="tab" id="login" checked>
            <input type="radio" name="tab" id="signup">
            <div class="tabs">
                <label for="login" class="tab">Login</label>
                <label for="signup" class="tab">Sign-Up</label>
            </div>
            
            <!-- Login Form -->
            <form class="form login-form" action="login.php" method="POST">
                <h2>Login</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            
            <!-- Sign-Up Form -->
            <form class="form signup-form" action="signup.php" method="post">
                <h2>Sign-Up</h2>
                <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="second_name" placeholder="Second Name" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password" placeholder="ConfirmPassword" required>
        <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
