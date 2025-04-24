<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging Out...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3;url=login.php"> <!-- Redirect after 3 seconds -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: sans-serif;
        }

        .message-box {
            text-align: center;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #005691;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            color: #333;
        }

        .spinner-border {
            color: #0070c0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h2>You have been logged out</h2>
        <p>Redirecting to the login page...</p>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</body>
</html>
