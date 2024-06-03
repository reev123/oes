<?php
include "connection.php";

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay Exam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: #2c3e50;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #question-display {
            width: 80%;
            background-color: #fff;
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2em;
        }

        button {
            background-color: #2c3e50;
            color: #fff;
            padding: 15px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
            transition: background-color 0.3s;
            font-size: 15px;
        }

        button:hover {
            background-color: #1d2731;
        }

        footer {
            background: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        #timer {
            position: relative;
            margin-top: 20px;
            text-align: center;
        }

        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <header>
        <h1>Essay Exam</h1>
    </header>

    <main>
        <section id="question-display">
            <h2>Write an essay on the following topic:</h2>
            <p><strong>Topic:</strong> The Impact of Technology on Society</p>
            <textarea id="essay-text" placeholder="Write your essay here..."></textarea>
        </section>

        <!-- Hidden fields to store user ID and username -->
        <input type="hidden" id="user_id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="hidden" id="username" value="<?php echo htmlspecialchars($username); ?>">

        <nav id="navigation">
            <button id="submit-btn">Submit</button>
            <button id="finish-btn" style="display: none;">Finish Exam</button>
        </nav>

        <div id="timer">10:00</div>
    </main>

    <footer>
        &copy; 2024 @OES. All rights reserved.
    </footer>
     
    <script>
        let timerInterval;
        let essaySubmitted = false;

        function startOrResumeTimer() {
            const isEssaySubmitted = sessionStorage.getItem('essaySubmitted');
            if (!isEssaySubmitted) {
                const visitedBefore = sessionStorage.getItem('visitedBefore');
                if (!visitedBefore) {
                    startTimer(600);
                    sessionStorage.setItem('visitedBefore', 'true');
                } else {
                    const remainingSeconds = parseInt(sessionStorage.getItem('examTimer'), 10);
                    startTimer(remainingSeconds);
                }
            }
        }

        function startTimer(startSeconds) {
            let seconds = startSeconds;
            timerInterval = setInterval(() => {
                seconds--;
                if (seconds < 0) {
                    clearInterval(timerInterval);
                    disableUserInteraction();
                    checkTimerStatus();
                    document.getElementById('finish-btn').style.display = 'inline-block';
                    return;
                }
                sessionStorage.setItem('examTimer', seconds.toString());
                updateTimerDisplay(seconds);
            }, 1000);
        }

        function updateTimerDisplay(totalSeconds) {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            document.getElementById('timer').innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }

        function disableUserInteraction() {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
            });
            const textarea = document.getElementById('essay-text');
            textarea.disabled = true;
        }

        function submitEssay() {
            const essayContent = document.getElementById('essay-text').value.trim();
            const userId = document.getElementById('user_id').value;
            const username = document.getElementById('username').value;
            if (essayContent === "") {
                alert("Please write your essay before submitting.");
                return;
            }
            
            clearInterval(timerInterval);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "submit_essay.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send("essayContent=" + encodeURIComponent(essayContent) + "&user_id=" + encodeURIComponent(userId) + "&username=" + encodeURIComponent(username));

            document.getElementById('essay-text').disabled = true;
            essaySubmitted = true;
            document.getElementById('finish-btn').style.display = 'inline-block';
            document.getElementById('submit-btn').disabled = true;
            sessionStorage.setItem('essaySubmitted', 'true');
            window.onbeforeunload = null;
        }

        function finishExam() {
            clearInterval(timerInterval);
            sessionStorage.clear();
            window.location.href = "getstarted.php";
        }

        function initializeExam() {
            startOrResumeTimer();
            const savedEssayContent = sessionStorage.getItem('essayContent');
            if (savedEssayContent) {
                document.getElementById('essay-text').value = savedEssayContent;
            }
            const isEssaySubmitted = sessionStorage.getItem('essaySubmitted');
            if (isEssaySubmitted === 'true') {
                essaySubmitted = true;
                document.getElementById('finish-btn').style.display = 'inline-block';
                document.getElementById('submit-btn').disabled = true;
                document.getElementById('essay-text').disabled = true;
                window.onbeforeunload = null;
            }
            setupEventListeners();
        }

        function setupEventListeners() {
            document.getElementById('submit-btn').addEventListener('click', submitEssay);
            document.getElementById('finish-btn').addEventListener('click', finishExam);
            document.getElementById('essay-text').addEventListener('input', function() {
                sessionStorage.setItem('essayContent', this.value);
            });
        }

        function checkTimerStatus() {
            if (!essaySubmitted) {
                submitEssay();
            }
            document.getElementById('finish-btn').disabled = false;
        }

        initializeExam();
    </script>
</body>
</html>
