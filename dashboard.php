<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: log.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar with Navigation Links -->
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <a href="#" onclick="showSection('reminders')">Reminders</a>
            <a href="Existing reminders.php">Existing Reminders</a>
            <a href="#" onclick="showSection('appointments')">Appointments</a>
            <a href="#" onclick="showSection('notes')">Notes</a>
            <a href="#" onclick="showSection('drugs')">Drugs</a>
            <a href="#" onclick="showSection('refill')">Drug Refill</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </aside>

        <!-- Main Content Area -->
        <main class="content">
            <?php if (isset($_GET['reminder'])): ?>
                <div class="message <?php echo $_GET['reminder'] === 'success' ? 'success' : 'error'; ?>">
                    <?php 
                    if ($_GET['reminder'] === 'success') {
                        echo "Reminder set successfully!";
                    } else {
                        echo htmlspecialchars($_GET['message'] ?? "Error setting reminder.");
                    }
                    ?>
                </div>
            <?php endif; ?>

            <section id="reminders" class="section reminders">
                <h2>Medication Reminder System</h2>
                <p>Manage your medication reminders here.</p>
                <h3>Set Alarms</h3>
                <form action="reminders_new.php" method="POST">
                    <div id="alarms">
                        <label for="reminder_time_input">Reminder Time:</label>
                        <input type="time" class="alarm-input" name="reminder_time" id="reminder_time_input" required>
                        
                        <label for="reminder_date_input">Reminder Date:</label>
                        <input type="date" id="reminder_date_input" name="reminder_date" required>

                        <label for="description_input">Description:</label>
                        <textarea id="description_input" name="description" rows="4" placeholder="Enter reminder description"></textarea>
                        
                        <button type="submit">Set Reminder</button>
                    </div>
                </form>
            </section>

            <section id="appointments" class="section appointments">
                <h2>Appointments</h2>
                <form action="appointments.php" method="POST">
                    <h3>Appointment 1</h3>
                    <label for="appointment_date_1">Date:</label>
                    <input type="date" id="appointment_date_1" name="appointment_date_1" required>
                    <label for="appointment_place_1">Place/ Hospital's Name:</label>
                    <input type="text" id="appointment_place_1" name="appointment_place_1" required>
                    <label for="doctor_name_1">Doctor's Name:</label>
                    <input type="text" id="doctor_name_1" name="doctor_name_1" required>
                    <h3>Appointment 2</h3>
                    <label for="appointment_date_2">Date:</label>
                    <input type="date" id="appointment_date_2" name="appointment_date_2">
                    <label for="appointment_place_2">Place/ Hospital's Name:</label>
                    <input type="text" id="appointment_place_2" name="appointment_place_2">
                    <label for="doctor_name_2">Doctor's Name:</label>
                    <input type="text" id="doctor_name_2" name="doctor_name_2">
                    <h3>Appointment 3</h3>
                    <label for="appointment_date_3">Date:</label>
                    <input type="date" id="appointment_date_3" name="appointment_date_3">
                    <label for="appointment_place_3">Place/ Hospital's Name:</label>
                    <input type="text" id="appointment_place_3" name="appointment_place_3">
                    <label for="doctor_name_3">Doctor's Name:</label>
                    <input type="text" id="doctor_name_3" name="doctor_name_3">
                    <button type="submit">Save Appointments</button>
                </form>
            </section>

            <section id="notes" class="section notes">
                <div class="notes-container">
                    <h2>Write Your Notes</h2>
                    <form action="note.php" method="POST">
                        <label for="note_content">Notes:</label>
                        <textarea id="note_content" class="note-input" name="note_content" placeholder="Write your notes here..."></textarea>
                        <button type="submit" class="save-btn">Save Note</button>
                    </form>
                </div>
            </section>

            <section id="drugs" class="section drugs">
                <h2>Drugs being taken</h2>
                <form action="drugs.php" method="POST">
                    <label for="drug_name_1">Drug Names:</label>
                    <input type="text" id="drug_name_1" name="drug_name_1" required>
                    <label for="start_date_1">Start Date:</label>
                    <input type="date" id="start_date_1" name="start_date_1" required>
                    <label for="end_date_1">End Date:</label>
                    <input type="date" id="end_date_1" name="end_date_1" required>
                    <button type="submit">Save Drug</button>
                </form>
                <form action="drugs.php" method="POST">
                    <label for="drug_name_2">Drug Names:</label>
                    <input type="text" id="drug_name_2" name="drug_name_1" required>
                    <label for="start_date_2">Start Date:</label>
                    <input type="date" id="start_date_2" name="start_date_1" required>
                    <label for="end_date_2">End Date:</label>
                    <input type="date" id="end_date_2" name="end_date_1" required>
                    <button type="submit">Save Drug</button>
                </form>
            </section>

            <section id="refill" class="section refill">
                <h2>Drug Refill</h2>
                <form action="Refill.php" method="POST">
                    <label for="med_name_1">Medication Name:</label>
                    <input type="text" name="med_name" id="med_name_1" required>
                    <label for="days_left_1">Days Left:</label>
                    <input type="number" name="days_left" id="days_left_1" placeholder="e.g., 5 days" required>
                    <button type="submit">Add Refill Date</button>
                </form>
                <form action="Refill.php" method="POST">
                    <label for="med_name_2">Medication Name:</label>
                    <input type="text" name="med_name" id="med_name_2" required>
                    <label for="days_left_2">Days Left:</label>
                    <input type="number" name="days_left" id="days_left_2" placeholder="e.g., 5 days" required>
                    <button type="submit">Add Refill Date</button>
                </form>
                <form action="Refill.php" method="POST">
                    <label for="med_name_3">Medication Name:</label>
                    <input type="text" name="med_name" id="med_name_3" required>
                    <label for="days_left_3">Days Left:</label>
                    <input type="number" name="days_left" id="days_left_3" placeholder="e.g., 5 days" required>
                    <button type="submit">Add Refill Date</button>
                </form>
            </section>
        </main>
    </div>

    <script>
        // Debug logging with timezone info
        function debugLog(message) {
            const now = new Date();
            console.log(`${now.toISOString()} [${Intl.DateTimeFormat().resolvedOptions().timeZone}]: ${message}`);
        }

        // Show the reminders section if there's a reminder parameter in the URL
        if (window.location.hash === '#reminders') {
            showSection('reminders');
        }

        function showSection(sectionId) {
            // Hide all sections
            const sections = document.getElementsByClassName('section');
            for (let section of sections) {
                section.style.display = 'none';
            }
            
            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        // Show reminders section by default
        if (!window.location.hash) {
            showSection('reminders');
        }

        // Initialize audio with error handling
        let audio = new Audio('alarm3.wav');
        audio.addEventListener('error', function(e) {
            debugLog('Audio error: ' + e.message);
        });
        
        audio.load();
        debugLog('Audio initialized');

        // Request notification permission
        if ("Notification" in window) {
            Notification.requestPermission().then(function(permission) {
                debugLog('Notification permission: ' + permission);
            });
        } else {
            debugLog('Notifications not supported');
        }

        // Function to show notification
        async function showNotification(reminder) {
            debugLog('Showing notification for reminder: ' + JSON.stringify(reminder));

            try {
                // Create and show notification first
                if ("Notification" in window && Notification.permission === "granted") {
                    const notification = new Notification("Medication Reminder", {
                        body: reminder.description || "Time to take your medication!",
                        icon: "images/pill-icon.svg",
                        requireInteraction: true,
                        silent: true // Disable default notification sound
                    });

                    // Play sound immediately after showing notification
                    await audio.play();
                    debugLog('Audio playing successfully with notification');

                    // Add click handler for the notification
                    notification.onclick = function() {
                        window.focus();
                        notification.close();
                    };
                } else {
                    // If notifications not allowed, just play sound
                    await audio.play();
                    debugLog('Audio playing without notification');
                    // Show alert as fallback
                    alert("Medication Reminder: " + (reminder.description || "Time to take your medication!"));
                }
            } catch (error) {
                debugLog('Error showing notification or playing sound: ' + error);
                // Fallback to system beep and alert
                window.navigator.vibrate(200);
                alert("Medication Reminder: " + (reminder.description || "Time to take your medication!"));
            }
        }

        // Function to check for due reminders
        function checkDueReminders() {
            const now = new Date();
            debugLog('Checking for due reminders... Current time: ' + 
                    now.toLocaleTimeString('en-US', { hour12: true, hour: 'numeric', minute: 'numeric' }));
            
            $.ajax({
                url: 'check_due_reminders.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    debugLog('Received response: ' + JSON.stringify(response));
                    
                    if (response.error) {
                        debugLog('Error from server: ' + response.error);
                        return;
                    }
                    
                    if (response.dueReminders && response.dueReminders.length > 0) {
                        debugLog('Found ' + response.dueReminders.length + ' due reminders');
                        response.dueReminders.forEach(function(reminder) {
                            showNotification(reminder);
                        });
                    } else {
                        debugLog('No due reminders found');
                    }
                },
                error: function(xhr, status, error) {
                    debugLog('Ajax error: ' + error);
                    debugLog('Status: ' + status);
                    debugLog('Response: ' + xhr.responseText);
                }
            });
        }

        // Check for reminders every 60 seconds
        const CHECK_INTERVAL = 60000; // 60 seconds
        setInterval(function() {
            debugLog('Running scheduled reminder check');
            checkDueReminders();
        }, CHECK_INTERVAL);

        // Initial check when page loads
        debugLog('Running initial reminder check');
        checkDueReminders();
    </script>
</body>
</html>