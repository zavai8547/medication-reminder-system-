<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone to Africa/Nairobi (East Africa Time)
date_default_timezone_set('Africa/Nairobi');

// Debug log function
function debug_log($message) {
    error_log(date('Y-m-d H:i:s') . ": " . print_r($message, true));
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
debug_log("Checking reminders for user_id: " . $user_id);

try {
    // Get current date and time
    $current_date = date('Y-m-d');
    $current_time = new DateTime();
    $current_time_12hr = $current_time->format('h:i A');
    
    debug_log("Timezone: " . date_default_timezone_get());
    debug_log("Current date: " . $current_date);
    debug_log("Current time (12hr): " . $current_time_12hr);
    debug_log("Current time (24hr): " . $current_time->format('H:i'));

    // Query to get due reminders that haven't been shown yet
    $query = "SELECT id, description, reminder_time_12hr, reminder_date 
              FROM reminders 
              WHERE user_id = ? 
              AND reminder_date = ? 
              AND STR_TO_DATE(reminder_time_12hr, '%h:%i %p') <= STR_TO_DATE(?, '%h:%i %p')
              AND is_shown = 0";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $current_date, $current_time_12hr);
    $stmt->execute();
    $result = $stmt->get_result();

    debug_log("SQL Query: " . $query);
    debug_log("Parameters: user_id=" . $user_id . ", date=" . $current_date . ", time=" . $current_time_12hr);

    $dueReminders = [];
    while ($row = $result->fetch_assoc()) {
        $dueReminders[] = $row;
        debug_log("Found due reminder: " . print_r($row, true));

        // Mark reminder as shown
        $update_query = "UPDATE reminders SET is_shown = 1 WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $row['id']);
        $update_stmt->execute();
        $update_stmt->close();
    }

    debug_log("Total due reminders found: " . count($dueReminders));
    echo json_encode(['dueReminders' => $dueReminders]);

} catch (Exception $e) {
    debug_log("Error: " . $e->getMessage());
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>
