<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $selected_answer = $_POST['selected_answer'];
    $correct_answer = $_POST['correct_answer'];
    $id = $_POST['id'];
    $username = $_POST['username'];
    $timestamp = date('Y-m-d H:i:s');

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO multiple_choice_answers (user_id, username, question, selected_answer, correct_answer, timestamp) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id, $username, $question, $selected_answer, $correct_answer, $timestamp);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record saved successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
