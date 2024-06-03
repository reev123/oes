<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $essay_content = $_POST['essayContent'];
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO essay_exam (id, username, essay_content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $username, $essay_content);

    if ($stmt->execute()) {
        echo "Essay submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
