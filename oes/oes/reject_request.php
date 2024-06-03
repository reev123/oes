<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM pending_instructors WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Instructor rejected.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
