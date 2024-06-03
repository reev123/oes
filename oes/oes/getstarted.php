<?php
include"connection.php";
include"logoutField.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Exam Type</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
            overflow: hidden;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        header {
            background: linear-gradient(90deg, #2c3e50, #34495e);
            color: #fff;
            padding: 1em;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 2;
        }

        header h1 {
            margin: 0;
        }

        nav {
            display: flex;
            justify-content: center;
            background: linear-gradient(90deg, #34495e, #2c3e50);
            padding: 0.5em;
            position: fixed;
            top: 60px;
            width: 100%;
            z-index: 2;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5em 1em;
            margin: 0 1em;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #555;
        }

        section {
            padding: 2em;
            text-align: center;
            margin-top: 120px;
            color: #fff;
            padding-bottom: calc(50px + 1em);
        }

        .animated-text-container {
            animation: scaleIn 0.5s forwards;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .exam-options {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .exam-option {
            background: linear-gradient(135deg, #ff8a00, #e52e71);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 200px;
            text-align: center;
            border: 2px solid #fff;
        }

        .exam-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border-color: #ff8a00;
        }

        .exam-option h3 {
            font-size: 18px;
            margin: 0;
            color: #fff;
        }


        footer {
            background: linear-gradient(90deg, #2c3e50, #34495e);
            color: #fff;
            text-align: center;
            padding: 1em;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Online Examination System</h1>
    </header>

    <nav>
        <a href="homepage.php">Home</a>   
    </nav>

    <section>
        <div class="animated-text-container">
            <h2 class="animated-text">Select Exam Type</h2>
        </div>
        <div class="exam-options">
            <div class="exam-option">
                <a href="multiplechoice.php" style="text-decoration: none;">
                    <h3>Multiple Choice</h3>
                </a>
            </div>
            <div class="exam-option">
                <a href="essay.php" style="text-decoration: none;">
                    <h3>Essay</h3>
                </a>
            </div>
            <div class="exam-option">
                <a href="trueorfalse.html" style="text-decoration: none;">
                    <h3>True/False</h3>
                </a>
            </div>
            <div class="exam-option">
                <a href="fill_in_the_blank.html" style="text-decoration: none;">
                    <h3>Fill in the Blank</h3>
                </a>
            </div>
        </div>
    </section>

    <footer>
        &copy; 2024 @OES. All rights reserved.
    </footer>
</body>
</html>
