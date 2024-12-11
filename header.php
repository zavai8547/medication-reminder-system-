<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeMaster - <?php echo ucfirst(str_replace('.php', '', basename($_SERVER['PHP_SELF']))); ?></title>
    <link rel="stylesheet" href="dashboard-style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard">
        <?php include 'includes/sidebar.php'; ?>
        <main class="content">
