<?php
include 'config.php';

// Add is_shown column if it doesn't exist
$alter_table_sql = "ALTER TABLE reminders ADD COLUMN IF NOT EXISTS is_shown TINYINT(1) DEFAULT 0";
if ($conn->query($alter_table_sql) === FALSE) {
    die("Error adding is_shown column: " . $conn->error);
}

// Create a test reminder for 2 minutes from now
$user_id = 1; // Use the default user ID
$current_time = new DateTime();
$reminder_time = new DateTime();
$reminder_time->modify('+2 minutes');

$reminder_date = $reminder_time->format('Y-m-d');
$reminder_time_12hr = $reminder_time->format('h:i A');
$description = "Test reminder - will trigger at " . $reminder_time_12hr;

// Insert the test reminder
$stmt = $conn->prepare("INSERT INTO reminders (user_id, reminder_time_12hr, reminder_date, description, is_shown) VALUES (?, ?, ?, ?, 0)");
$stmt->bind_param("isss", $user_id, $reminder_time_12hr, $reminder_date, $description);

if ($stmt->execute()) {
    echo "Test reminder created successfully!<br>";
    echo "Reminder will trigger at: " . $reminder_time_12hr . "<br>";
    echo "Current time is: " . $current_time->format('h:i A') . "<br>";
    echo "<script>setTimeout(function() { window.location.href = 'reminders.php'; }, 3000);</script>";
} else {
    echo "Error creating reminder: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
