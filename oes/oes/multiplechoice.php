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
    <title>Multiple Choice Exam</title>
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
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

        .answered label {
            color: #000; /* Change text color for answered questions */
        }

        #timer {
            position: relative;
            margin-top: 20px; /* Add space between timer and footer */
            text-align: center; /* Center the timer horizontally */
        }
    </style>
</head>
<body>
    <header>
        <h1>Multiple Choice Exam</h1>
    </header>

    <input type="hidden" id="id" value="<?php echo htmlspecialchars($id); ?>">
    <input type="hidden" id="username" value="<?php echo htmlspecialchars($username); ?>">

    <main>
        <section id="question-display">
            <!-- Questions and options will be dynamically generated here -->
        </section>

        <nav id="navigation">
            <button id="prev-btn">Previous</button>
            <button id="submit-btn">Submit</button>
            <button id="next-btn">Next</button>
            <button id="finish-btn" style="display: none;">Finish Exam</button>
        </nav>

        <div id="timer">10:00</div>
    </main>

    <footer>
        &copy; 2024 @OES. All rights reserved.
    </footer>

    <script>
        const questions = [
            {
                question: "What is the capital of France?",
                options: ["Paris", "London", "Berlin", "Rome"],
                correctAnswer: "Paris",
                answered: false
            },
            {
                question: "Who painted the Mona Lisa?",
                options: ["Leonardo da Vinci", "Pablo Picasso", "Vincent van Gogh", "Michelangelo"],
                correctAnswer: "Leonardo da Vinci",
                answered: false
            },
            // Add more questions here...
        ];

        let currentQuestionIndex;
        let timerInterval;

        function initializeExam() {
            currentQuestionIndex = parseInt(sessionStorage.getItem('currentQuestionIndex')) || 0;
            displayQuestion();
            setupEventListeners();
            startOrResumeTimer();
            const remainingSeconds = parseInt(sessionStorage.getItem('examTimer'), 10);
            if (remainingSeconds <= 0) {
                handleTimerExpiration();
            }
            enableRadioButtons();
            const currentQuestion = questions[currentQuestionIndex];
            if (isQuestionAnswered(currentQuestion)) {
                disableRadioButtons();
            }
        }

        function displayQuestion() {
            const questionDisplay = document.getElementById('question-display');
            const currentQuestion = questions[currentQuestionIndex];
            const selectedOption = sessionStorage.getItem(`selectedOption-${currentQuestionIndex}`);
            const finishButton = document.getElementById('finish-btn');

            if (currentQuestionIndex === questions.length - 1) {
                finishButton.style.display = 'inline-block';
            } else {
                finishButton.style.display = 'none';
            }

            enableRadioButtons();

            questionDisplay.innerHTML = `
                <h2>${currentQuestion.question}</h2>
                <ul>
                    ${currentQuestion.options.map((option, index) => `
                        <li>
                            <input type="radio" id="option-${index}" name="answer" value="${option}" ${isQuestionAnswered(currentQuestion) ? 'disabled' : ''} ${selectedOption === option ? 'checked' : ''}>
                            <label for="option-${index}" class="${isQuestionAnswered(currentQuestion) ? 'answered' : ''} ${selectedOption === option ? 'selected' : ''}">${option}</label>
                        </li>
                    `).join('')}
                </ul>
            `;
        }

        function enableRadioButtons() {
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radioButton => {
                const currentQuestion = questions[currentQuestionIndex];
                if (!isQuestionAnswered(currentQuestion)) {
                    radioButton.disabled = false;
                }
            });
        }

        function isQuestionAnswered(question) {
            return question.answered || sessionStorage.getItem(`answered-${currentQuestionIndex}`) === 'true';
        }

        function startOrResumeTimer() {
            if (!sessionStorage.getItem('visitedBefore')) {
                startTimer(600);
                sessionStorage.setItem('visitedBefore', 'true');
            } else {
                const remainingSeconds = parseInt(sessionStorage.getItem('examTimer'), 10);
                startTimer(remainingSeconds);
            }
        }

        function startTimer(startSeconds) {
            let seconds = startSeconds;
            timerInterval = setInterval(() => {
                seconds--;
                if (seconds < 0) {
                    clearInterval(timerInterval);
                    disableUserInteraction();
                    enableFinishButton();
                    showFinishButton();
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

        function setupEventListeners() {
            document.getElementById('prev-btn').addEventListener('click', goToPreviousQuestion);
            document.getElementById('next-btn').addEventListener('click', goToNextQuestion);
            document.getElementById('submit-btn').addEventListener('click', submitExam);
            document.getElementById('finish-btn').addEventListener('click', finishExam);
        }

        function goToPreviousQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                sessionStorage.setItem('currentQuestionIndex', currentQuestionIndex.toString());
                displayQuestion();
                enableRadioButtons();
            }
        }

        function goToNextQuestion() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                sessionStorage.setItem('currentQuestionIndex', currentQuestionIndex.toString());
                displayQuestion();
                enableRadioButtons();
            }
        }

        function submitExam() {
            const currentQuestion = questions[currentQuestionIndex];
            const selectedOption = document.querySelector('input[name="answer"]:checked');
            if (!selectedOption) {
                const confirmed = confirm("No option selected. Please select an option!!!");
                if (!confirmed) {
                    return;
                }
            } else {
                currentQuestion.answered = true;
                const selectedValue = selectedOption.value;
                sessionStorage.setItem(`selectedOption-${currentQuestionIndex}`, selectedValue);
                sessionStorage.setItem(`answered-${currentQuestionIndex}`, 'true');

                // Send selected answer, correct answer, user ID, and username to PHP script for storing in the database
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "store_multiplechoice.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                    }
                };
                const params = `question=${encodeURIComponent(currentQuestion.question)}&selected_answer=${encodeURIComponent(selectedValue)}&correct_answer=${encodeURIComponent(currentQuestion.correctAnswer)}&user_id=${encodeURIComponent(document.getElementById('user_id').value)}&username=${encodeURIComponent(document.getElementById('username').value)}`;
                xhr.send(params);
            }
            disableRadioButtons();
            displayQuestion();
        }

        function finishExam() {
            clearInterval(timerInterval);
            sessionStorage.removeItem('examTimer');
            sessionStorage.removeItem('currentQuestionIndex');
            sessionStorage.clear();
            window.location.href = "getstarted.php";
        }

        function disableRadioButtons() {
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radioButton => {
                radioButton.disabled = true;
            });
        }

        function enableFinishButton() {
            const finishButton = document.getElementById('finish-btn');
            finishButton.disabled = false;
        }

        function disableUserInteraction() {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
            });
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.disabled = true;
            });
        }

        function showFinishButton() {
            const finishButton = document.getElementById('finish-btn');
            const nextButton = document.getElementById('next-btn');
            finishButton.style.display = 'inline-block';
            nextButton.style.display = 'none';
        }

        function handleTimerExpiration() {
            disableUserInteraction();
            showFinishButton();
        }

        initializeExam();
    </script>
</body>
</html>
