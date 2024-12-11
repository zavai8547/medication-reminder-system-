<?php
include 'config.php'; // Include database connection
session_start(); // Start the session at the beginning

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'] ?? 1;

    // Check if user_id is available
    if ($user_id === null) {
        // Redirect to login page if user is not logged in
        header("Location: log.php");
        exit();
    }

    // Initialize an empty array to store drug data.
    $drugs = [];

    // Loop through each form submission (assuming there are two forms as in your example).
    for ($i = 1; $i <= 2; $i++) {
        // Check if each input exists in the POST array before accessing it to prevent undefined array warnings.
        $drug_name = $_POST["drug_name_$i"] ?? null;
        $start_date = $_POST["start_date_$i"] ?? null;
        $end_date = $_POST["end_date_$i"] ?? null;

        // If all fields for this drug are set, add to drugs array.
        if (!empty($drug_name) && !empty($start_date) && !empty($end_date)) {
            $drugs[] = [
                'drug_name' => $drug_name,
                'start_date' => $start_date,
                'end_date' => $end_date
            ];
        }
    }

    // Prepare and execute insert statement for each drug entry.
    foreach ($drugs as $drug) {
        $stmt = $conn->prepare("INSERT INTO drugs (user_id, drug_name, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $drug['drug_name'], $drug['start_date'], $drug['end_date']);
        
        if ($stmt->execute()) {
            echo "Drug saved successfully!";
        } else {
            echo "Error saving drug: " . $stmt->error;
        }
        $stmt->close();
    }

    // Fetch existing drugs for display
    $sql = "SELECT * FROM drugs WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<h2>Existing Drugs</h2>";
            echo "<table style='width: 100%; border-collapse: collapse; border: 2px solid green;'>
                    <tr style='background-color: green; color: white;'>
                        <th>ID</th>
                        <th>Drug Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr style='background-color: #f9f9f9;'>
                        <td style='border: 1px solid green;'>" . htmlspecialchars($row['id']) . "</td>
                        <td style='border: 1px solid green;'>" . htmlspecialchars($row['drug_name']) . "</td>
                        <td style='border: 1px solid green;'>" . htmlspecialchars($row['start_date']) . "</td>
                        <td style='border: 1px solid green;'>" . htmlspecialchars($row['end_date']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No Drugs To be Taken.";
        }
    } else {
        echo "Error fetching drugs: " . $conn->error;
    }

    $conn->close();
}
?>
