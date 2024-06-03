<?php
include "connection1.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $instructorid = $_POST['instructor-id'];
    $password = $_POST['password'];

    if (!empty($instructorid) && !empty($password)) {
        $sql = "SELECT * FROM registered_instructors WHERE instructor_id='$instructorid' AND password='$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $_SESSION['instructor_id'] = $instructorid;
            header("Location: instructor.php");
            exit();
        } else {
            echo "<script>alert('Invalid ID or password');</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields');</script>";
    }
}
?>
