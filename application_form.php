<?php
// application_form.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $passport_number = $_POST['passport_number'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $organization_name = $_POST['organization_name'];
    $job_title = $_POST['job_title'];
    $job_category = $_POST['job_category'];
    $application_status = "Pending";
    $comments = $_POST['comments'];

    $sql = "INSERT INTO applications (passport_number, full_name, email, organization_name, job_title, job_category, application_status, comments)
            VALUES ('$passport_number', '$full_name', '$email', '$organization_name', '$job_title', '$job_category', '$application_status', '$comments')";

    if ($conn->query($sql) === TRUE) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML Form for Application Submission -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
</head>
<body>
    <h2>Submit Application</h2>

    <form method="POST" action="application_form.php">
        <label>Passport Number:</label>
        <input type="text" name="passport_number" required><br><br>

        <label>Full Name:</label>
        <input type="text" name="full_name" required value="<?php echo $_SESSION['user_name']; ?>" readonly><br><br>
        
        <label>Email:</label>
        <input type="email" name="email" required value="<?php echo $_SESSION['user_email']; ?>" readonly><br><br>
        
        <label>Organization Name:</label>
        <input type="text" name="organization_name" required><br><br>
        
        <label>Job Title:</label>
        <input type="text" name="job_title" required><br><br>
        
        <label>Job Category:</label>
        <input type="text" name="job_category" required><br><br>
        
        <label>Comments:</label>
        <textarea name="comments" required></textarea><br><br>

        <input type="submit" value="Submit Application">
    </form>

    <br>
    <a href="logout.php">Logout</a>  <!-- Logout link -->
</body>
</html>
