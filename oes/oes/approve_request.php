<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $approveId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    if ($approveId) {
        // Fetch request data
        $sql = "SELECT * FROM instructor_requests WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $approveId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $request = $result->fetch_assoc();

            // Insert into registered_instructors
            $sql = "INSERT INTO registered_instructors (full_name, email, instructor_id, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $request['full_name'], $request['email'], $request['instructor_id'], $request['password']);

            if ($stmt->execute()) {
                // Delete the request from instructor_requests
                $sql = "DELETE FROM instructor_requests WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $approveId);
                if ($stmt->execute()) {
                    echo "Instructor approved successfully";
                } else {
                    echo "Error deleting request: " . $conn->error;
                }
            } else {
                echo "Error inserting instructor: " . $conn->error;
            }
        } else {
            echo "Request not found";
        }
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>