<?php
// Include database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; // Assuming user_id is 1 for this example
    $med_name = $_POST['med_name'];
    $days_left = $_POST['days_left'];

    $sql = "INSERT INTO drugrefills (user_id, med_name, days_left) VALUES ('$user_id', '$med_name', '$days_left')";

    if ($conn->query($sql) === TRUE) {
        echo "New drug refill set successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Fetch and display existing appointments
$sql = "SELECT id, med_name, days_left FROM drugrefills ORDER BY days_left ASC";
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
                <th>medication name</th>
                <th>Days Left</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['id']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['med_name']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['days_left']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No Drugs to be refilled.";
}

$conn->close();
?>
