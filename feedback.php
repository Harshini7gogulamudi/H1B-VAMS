<?php
// feedback.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff;
            font-family: sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 100px;
        }

        .alert {
            padding: 20px;
            font-size: 1.1rem;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0070c0;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $application_id = $_POST['application_id'];
        $feedback_text = $_POST['feedback_text'];
        $rating = $_POST['rating'];

        $sql = "INSERT INTO feedback (application_id, feedback_text, rating)
                VALUES ('$application_id', '$feedback_text', '$rating')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success text-center" role="alert">Feedback submitted successfully!</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">Error: ' . $conn->error . '</div>';
        }

        $conn->close();
    } else {
        echo '<div class="alert alert-warning text-center" role="alert">Invalid access method.</div>';
    }
    ?>
    <a href="feedback_form.php" class="back-link">Go Back to Feedback Form</a>
</div>

</body>
</html>
