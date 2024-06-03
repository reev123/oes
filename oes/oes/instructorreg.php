<?php
include "connection.php";

// Retrieve form data
$fullName = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$instructorId = filter_input(INPUT_POST, 'instructor-id', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$confirmPassword = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_STRING);

if ($fullName && $email && $instructorId && $password && $confirmPassword) {
    if ($password === $confirmPassword) {
        // Check if email or instructor ID already exists in requests or registered instructors
        $sql = "SELECT * FROM instructor_requests WHERE email = ? OR instructor_id = ? UNION SELECT * FROM registered_instructors WHERE email = ? OR instructor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $email, $instructorId, $email, $instructorId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('User already exists'); window.location.href='instructorreg.html';</script>";
        } else {
            // Insert new instructor request
            $sql = "INSERT INTO instructor_requests (full_name, email, instructor_id, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $fullName, $email, $instructorId, $password);

            if ($stmt->execute()) {
                echo "<script>alert('Request sent to the admin for approval'); window.location.href='instructorreg.html';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "<script>alert('Passwords do not match'); window.location.href='instructorreg.html';</script>";
    }
} else {
    echo "<script>alert('Please fill in all fields'); window.location.href='instructorreg.html';</script>";
}

$conn->close();
?>
