<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and store the form inputs
    $passport_number = htmlspecialchars(trim($_POST['passport_number']));
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $organization_name = htmlspecialchars(trim($_POST['organization_name']));
    $job_title = htmlspecialchars(trim($_POST['job_title']));
    $job_category = htmlspecialchars(trim($_POST['job_category']));
    $application_status = htmlspecialchars(trim($_POST['application_status']));
    $comments = htmlspecialchars(trim($_POST['comments']));

    // You can now process/store/send this data
    // For demonstration, we'll just display a simple success message
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Application Submitted</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
                padding: 40px;
                font-family: Arial, sans-serif;
            }

            .confirmation-box {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: auto;
                text-align: center;
            }

            h2 {
                color: #28a745;
            }

            p {
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <div class="confirmation-box">
            <h2>Application Submitted Successfully!</h2>
            <p><strong>Passport Number:</strong> <?php echo $passport_number; ?></p>
            <p><strong>Full Name:</strong> <?php echo $full_name; ?></p>
            <p><strong>Organization:</strong> <?php echo $organization_name; ?></p>
            <p><strong>Job Title:</strong> <?php echo $job_title; ?></p>
            <p><strong>Job Category:</strong> <?php echo $job_category; ?></_
