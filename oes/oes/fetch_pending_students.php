<?php
include "connection1.php";

// Fetch pending student registrations
$sql = "SELECT * FROM registered_students WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display pending students in a list
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['full_name']} ({$row['email']}) <button class='approveBtn' data-id='{$row['id']}'>Approve</button></li>";
    }
    echo "</ul>";
} else {
    echo "No pending registrations found.";
}

// Close connection
$conn->close();
?>
