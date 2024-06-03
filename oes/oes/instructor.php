<?php
include "connection1.php";
include "logoutField1.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - Online Examination System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        
        .back-button {
            position: absolute;
            top: 15px;
            left: 15px;
            text-decoration: none;
            color: rgb(138, 138, 230);
            font-size: 20px;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        .back-button:hover {
            color: #a93226;
        }
    </style>
</head>
<body>
    <a href="homepage.php" class="back-button">&#8592; Back</a>
    <div class="container">
        <h1 class="text-center">Instructor Dashboard - Online Examination System</h1>
        <ul class="nav nav-tabs" id="instructorTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="add-student-tab" data-toggle="tab" href="#add-student" role="tab" aria-controls="add-student" aria-selected="true">Add Student</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="approve-student-tab" data-toggle="tab" href="#approve-student" role="tab" aria-controls="approve-student" aria-selected="false">Approve Student</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="delete-student-tab" data-toggle="tab" href="#delete-student" role="tab" aria-controls="delete-student" aria-selected="false">Delete Student</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="evaluate-exam-tab" data-toggle="tab" href="#evaluate-exam" role="tab" aria-controls="evaluate-exam" aria-selected="false">Evaluate Exam</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="modify-questions-tab" data-toggle="tab" href="#modify-questions" role="tab" aria-controls="modify-questions" aria-selected="false">Modify Questions</a>
            </li>
        </ul>
        <div class="tab-content" id="instructorTabContent">
            <div class="tab-pane fade show active" id="add-student" role="tabpanel" aria-labelledby="add-student-tab">
                <h3>Add Student</h3>
                <form id="addStudentForm">
                    <div class="form-group">
                        <label for="studentName">Student Name</label>
                        <input type="text" class="form-control" id="studentName" placeholder="Enter student name" required>
                    </div>
                    <div class="form-group">
                        <label for="studentEmail">Student Email</label>
                        <input type="email" class="form-control" id="studentEmail" placeholder="Enter student email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
            </div>
            <div class="tab-pane fade" id="approve-student" role="tabpanel" aria-labelledby="approve-student-tab">
                <h3>Approve Student</h3>
                <!-- Approval form goes here -->
                <form id="approveStudentForm">
                    <!-- Display pending student registrations here -->
                    <div id="pendingStudents"></div>
                </form>
            </div>
            <div class="tab-pane fade" id="delete-student" role="tabpanel" aria-labelledby="delete-student-tab">
                <h3>Delete Student</h3>
                <form id="deleteStudentForm">
                    <div class="form-group">
                        <label for="studentID">Student ID</label>
                        <input type="text" class="form-control" id="studentID" placeholder="Enter student ID" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Student</button>
                </form>
            </div>
            <div class="tab-pane fade" id="evaluate-exam" role="tabpanel" aria-labelledby="evaluate-exam-tab">
                <h3>Evaluate Exam</h3>
                <!-- Evaluation form goes here -->
            </div>
            <div class="tab-pane fade" id="modify-questions" role="tabpanel" aria-labelledby="modify-questions-tab">
                <h3>Modify Questions</h3>
                <!-- Question modification interface goes here -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Fetch pending student registrations when the document is ready
        $(document).ready(function() {
            $.get('fetch_pending_students.php', function(response) {
                $('#pendingStudents').html(response);
            });

            // Approve student when the approve button is clicked
            $(document).on('click', '.approveBtn', function() {
                const studentID = $(this).data('id');
                $.post('approve_student.php', { studentID: studentID }, function(response) {
                    alert(response);
                    $.get('fetch_pending_students.php', function(response) {
                        $('#pendingStudents').html(response);
                    });
                }).fail(function(xhr, status, error) {
                    alert("Error: " + xhr.responseText);
                });
            });
        });
    </script>
</body>
</html>
