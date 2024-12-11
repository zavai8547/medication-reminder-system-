<?php 
session_start();
include 'config.php';  // Include your database configuration file

// Initialize flag for success or error messages
$form_submitted = false;

// Fetch reminders for the logged-in user
$user_id = $_SESSION['user_id'] ?? 1; // Default to user ID 1 if session is not set
$query = "SELECT * FROM reminders WHERE user_id = ? ORDER BY reminder_date, reminder_time_12hr";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$reminders = $result->fetch_all(MYSQLI_ASSOC);

// Check if form is submitted for delete or update actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_reminder'])) {
        // Handle reminder deletion
        $reminder_id = $_POST['reminder_id'];
        $delete_query = "DELETE FROM reminders WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bind_param("i", $reminder_id);
        $delete_stmt->execute();
        $delete_stmt->close();
    } elseif (isset($_POST['edit_reminder'])) {
        // Handle reminder update
        $reminder_id = $_POST['reminder_id'];
        $new_time = $_POST['new_time'];
        $new_description = $_POST['new_description'];
        $update_query = "UPDATE reminders SET reminder_time_12hr = ?, description = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssi", $new_time, $new_description, $reminder_id);
        $update_stmt->execute();
        $update_stmt->close();
    }

    // Refresh the reminders list after modification
    header("Location: reminders.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reminders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        .reminder-list {
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .reminder-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .reminder-item:last-child {
            border-bottom: none;
        }

        .reminder-actions {
            display: flex;
            gap: 10px;
        }

        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .edit-form {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Your Reminders</h2>

<!-- List of reminders -->
<div class="reminder-list">
    <?php if ($reminders): ?>
        <?php foreach ($reminders as $reminder): ?>
            <div class="reminder-item">
                <div>
                    <strong>Time:</strong> <?= $reminder['reminder_time_12hr'] ?><br>
                    <strong>Date:</strong> <?= $reminder['reminder_date'] ?><br>
                    <strong>Description:</strong> <?= $reminder['description'] ?>
                </div>
                <div class="reminder-actions">
                    <button onclick="openEditForm(<?= $reminder['id'] ?>, '<?= $reminder['reminder_time_12hr'] ?>', '<?= $reminder['description'] ?>')">Edit</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="reminder_id" value="<?= $reminder['id'] ?>">
                        <button type="submit" name="delete_reminder">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reminders found.</p>
    <?php endif; ?>
</div>

<!-- Edit Reminder Form -->
<div id="editForm" class="edit-form" style="display: none;">
    <h3>Edit Reminder</h3>
    <form method="POST">
        <input type="hidden" id="reminder_id" name="reminder_id">
        <label for="new_time">New Time:</label>
        <input type="time" id="new_time" name="new_time" required><br><br>

        <label for="new_description">New Description:</label>
        <textarea id="new_description" name="new_description" rows="4" cols="50" required></textarea><br><br>

        <button type="submit" name="edit_reminder">Save Changes</button>
        <button type="button" onclick="closeEditForm()">Cancel</button>
    </form>
</div>

<script>
    // JavaScript for opening and closing the edit form
    function openEditForm(id, time, description) {
        document.getElementById('reminder_id').value = id;
        document.getElementById('new_time').value = time;
        document.getElementById('new_description').value = description;
        document.getElementById('editForm').style.display = 'block';
    }

    function closeEditForm() {
        document.getElementById('editForm').style.display = 'none';
    }

    // Check reminder time and play alarm sound when the time is reached
    function checkReminderTimes() {
        console.log('Checking reminder times...');
        const now = new Date();
        const reminders = <?php echo json_encode($reminders); ?>;

        reminders.forEach(reminder => {
            const reminderTime = new Date(reminder.reminder_date + ' ' + reminder.reminder_time_12hr);
            console.log('Reminder time:', reminderTime);
            console.log('Current time:', now);

            if (reminderTime <= now && reminderTime > new Date(now - 60000)) {  // 60 seconds tolerance
                alert(reminder.description);  // Show pop-up message
                playAlarm();
            }
        });
    }

    function playAlarm() {
        const audio = new Audio('alarm.wav');  // Ensure the file path is correct
        audio.play();
        setTimeout(() => audio.play(), 1000);  // Play the alarm sound 3 times
        setTimeout(() => audio.play(), 2000);
        setTimeout(() => audio.play(), 3000);
    }

    // Check reminder times every minute
    setInterval(checkReminderTimes, 60000); // Check every minute
</script>

</body>
</html>