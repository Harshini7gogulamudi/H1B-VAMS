<?php
session_start();

// Check if user is already logged in, redirect to the application page
if (isset($_SESSION['user_id'])) {
    header("Location: application_form.php");
    exit();
}

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if user exists with the given email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: application_form.php");
            exit();
        } else {
            $error_message = "Invalid password. Please try again.";
        }
    } else {
        $error_message = "No user found with this email. Please register.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff;
            font-family: sans-serif;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #fff;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #0070c0;
            border-color: #0070c0;
        }

        .btn-primary:hover {
            background-color: #005691;
            border-color: #005691;
        }

        .register-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: #0070c0;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #dc3545;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: bold;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Login</h2>

        <?php if (isset($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <a href="register.php" class="register-link">Don't have an account? Register here</a>
    </div>
</div>

</body>
</html>
