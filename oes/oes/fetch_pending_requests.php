<?php
include "connection.php";

$sql = "SELECT * FROM instructor_requests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<li class="list-group-item">';
        echo 'Name: ' . htmlspecialchars($row['full_name']) . '<br>';
        echo 'Email: ' . htmlspecialchars($row['email']) . '<br>';
        echo 'Instructor ID: ' . htmlspecialchars($row['instructor_id']) . '<br>';
        echo '<button class="btn btn-success approve-request" data-id="' . $row['id'] . '">Approve</button>';
        echo '</li>';
    }
} else {
    echo '<li class="list-group-item">No pending requests</li>';
}

$conn->close();
?>
