<?php
include "connection1.php";

if (isset($_POST['studentID'])) {
    $studentID = $_POST['studentID'];

    // Approve the student by updating their status
    $query = "UPDATE registered_students SET status = 'approved' WHERE id = '$studentID'";
    if (mysqli_query($conn, $query)) {
        echo "Student approved successfully!";
    } else {
        echo "Error approving student: " . mysqli_error($conn);
    }
} else {
    echo "No student ID provided";
}
?>
