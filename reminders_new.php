<?php
session_start();
include 'config.php';

// Set timezone to Africa/Nairobi (East Africa Time)
date_default_timezone_set('Africa/Nairobi');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: log.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reminder_time'], $_POST['reminder_date'])) {
    $reminder_time_24hr = $_POST['reminder_time'];
    $reminder_date = $_POST['reminder_date'];
    $description = $_POST['description'] ?? '';

    if (!empty($reminder_time_24hr) && !empty($reminder_date)) {
        try {
            // Convert 24-hour time to 12-hour format
            $time = DateTime::createFromFormat('H:i', $reminder_time_24hr);
            if (!$time) {
                throw new Exception("Invalid time format");
            }
            $reminder_time_12hr = $time->format('h:i A');

            error_log("Timezone: " . date_default_timezone_get());
            error_log("Original time (24hr): " . $reminder_time_24hr);
            error_log("Converted time (12hr): " . $reminder_time_12hr);

            // Insert the reminder
            $stmt = $conn->prepare("INSERT INTO reminders (user_id, reminder_time_12hr, reminder_date, description, is_shown) VALUES (?, ?, ?, ?, 0)");
            $stmt->bind_param("isss", $user_id, $reminder_time_12hr, $reminder_date, $description);

            if ($stmt->execute()) {
                // Redirect back to dashboard with success message
                header("Location: dashboard.php?reminder=success#reminders");
                exit();
            } else {
                $message = "Error saving reminder: " . $stmt->error;
            }
            $stmt->close();
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
            error_log("Reminder error: " . $e->getMessage());
        }
    } else {
        $message = "Please fill in all required fields.";
    }
}

// If there was an error, redirect back to dashboard with error message
if ($message) {
    header("Location: dashboard.php?reminder=error&message=" . urlencode($message) . "#reminders");
    exit();
}

$conn->close();
?>
