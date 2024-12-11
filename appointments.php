<?php
include 'config.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to store messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointments = [];
    for ($i = 1; $i <= 3; $i++) {
        $date = isset($_POST["appointment_date_$i"]) ? $_POST["appointment_date_$i"] : null;
        $place = isset($_POST["appointment_place_$i"]) ? $_POST["appointment_place_$i"] : null;
        $doctor = isset($_POST["doctor_name_$i"]) ? $_POST["doctor_name_$i"] : null;

        // Skip empty appointments
        if (!empty($date) && !empty($place) && !empty($doctor)) {
            $appointments[] = [
                'date' => $date,
                'place' => $place,
                'doctor' => $doctor
            ];
        }
    }

    foreach ($appointments as $appointment) {
        $stmt = $conn->prepare("INSERT INTO appointments (date, place, doctor) VALUES (?, ?, ?)");
        
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $appointment['date'], $appointment['place'], $appointment['doctor']);

        if ($stmt->execute()) {
            $message = "Appointment saved successfully!"; // Set success message
        } else {
            $message = "Error saving appointment: " . $stmt->error; // Set error message
        }
        $stmt->close();
    }
}

// Fetch and display existing appointments
$sql = "SELECT id, date, place, doctor FROM appointments ORDER BY date ASC";
$result = $conn->query($sql);

// Display message once at the top
if (!empty($message)) {
    echo "<div style='color: green; font-weight: bold;'>$message</div>";
}

if ($result->num_rows > 0) {
    echo "<h2>Existing Appointments</h2>";
    echo "<table style='width: 100%; border-collapse: collapse; border: 2px solid green;'>
            <tr style='background-color: green; color: white;'>
                <th>ID</th>
                <th>Date</th>
                <th>Place</th>
                <th>Doctor</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['id']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['date']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['place']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['doctor']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No appointments found.";
}

$conn->close();
?>
