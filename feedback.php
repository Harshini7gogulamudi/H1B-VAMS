<?php
// feedback.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = $_POST['application_id'];
    $feedback_text = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO feedback (application_id, feedback_text, rating)
            VALUES ('$application_id', '$feedback_text', '$rating')";

    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML Form for Feedback Submission -->
<form method="POST" action="feedback.php">
    <label>Application ID:</label>
    <input type="number" name="application_id" required><br><br>
    
    <label>Feedback:</label>
    <textarea name="feedback_text" required></textarea><br><br>
    
    <label>Rating (1 to 5):</label>
    <input type="number" name="rating" min="1" max="5" required><br><br>

    <input type="submit" value="Submit Feedback">
</form>
