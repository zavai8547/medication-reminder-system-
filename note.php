<?php
include 'config.php'; // Include the database configuration file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = ""; // Variable to hold success or error messages

// Handle form submission for adding a note
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_content'])) {
    $note_content = isset($_POST['note_content']) ? trim($_POST['note_content']) : "";

    if (!empty($note_content)) {
        // Insert the note into the database
        $stmt = $conn->prepare("INSERT INTO notes (user_id, note_content, created_at) VALUES (?, ?, NOW())");
        
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Set a default `user_id` value (you can adjust based on logged-in user)
        $user_id = 1; // Replace this with the logged-in user's ID in a session-based system

        $stmt->bind_param("is", $user_id, $note_content);

        if ($stmt->execute()) {
            $message = "Note saved successfully!";
        } else {
            $message = "Error saving note: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Please enter some content for the note.";
    }
}

// Handle form submission for deleting a note
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_note_id'])) {
    $note_id = intval($_POST['delete_note_id']);

    if ($note_id > 0) {
        // Delete the note from the database
        $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
        
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $note_id);

        if ($stmt->execute()) {
            $message = "Note deleted successfully!";
        } else {
            $message = "Error deleting note: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid note ID.";
    }
}

// Fetch and display existing notes
$sql = "SELECT id, note_content, created_at FROM notes ORDER BY created_at ASC";
$result = $conn->query($sql);

// Display message once at the top
if (!empty($message)) {
    echo "<div style='color: green; font-weight: bold;'>$message</div>";
}

if ($result && $result->num_rows > 0) {
    echo "<h2>Existing Notes</h2>";
    echo "<table style='width: 100%; border-collapse: collapse; border: 2px solid green;'>
            <tr style='background-color: green; color: white;'>
                <th>ID</th>
                <th>Note Content</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr style='background-color: #f9f9f9;'>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['id']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['note_content']) . "</td>
                <td style='border: 1px solid green;'>" . htmlspecialchars($row['created_at']) . "</td>
                <td style='border: 1px solid green;'>
                    <form action='note.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='delete_note_id' value='" . $row['id'] . "'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No Previous notes found.";
}

$conn->close();
?>
