<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Debug statement to check POST data

    if(isset($_POST['id'])) {
        $studentId = $conn->real_escape_string($_POST['id']);
        
        // Debug statement to check student ID
        echo "Student ID: " . $studentId;

        $sql = "SELECT full_name FROM registered_students WHERE student_id = '$studentId'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $student = $result->fetch_assoc();
                $fullName = $student['full_name'];

                $sql = "SELECT exam_type, score FROM results WHERE student_id = '$studentId'";
                $result = $conn->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        $response = ['name' => $fullName, 'exams' => []];
                        while ($row = $result->fetch_assoc()) {
                            $response['exams'][] = [
                                'type' => $row['exam_type'],
                                'score' => $row['score']
                            ];
                        }
                        echo json_encode($response);
                    } else {
                        echo json_encode(['message' => 'No results found for the given student ID']);
                    }
                } else {
                    echo json_encode(['message' => 'Error fetching results: ' . $conn->error]);
                }
            } else {
                echo json_encode(['message' => 'Student not found']);
            }
        } else {
            echo json_encode(['message' => 'Error fetching student data: ' . $conn->error]);
        }
    } else {
        echo json_encode(['message' => 'Student ID is missing in POST data']);
    }
}

$conn->close();
?>
