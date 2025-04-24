<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connection.php');

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: register.php?error=Passwords do not match.");
        exit();
    }

    // Check if email already exists (optional but recommended)
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        header("Location: register.php?error=Email already registered.");
        exit();
    }

    // Hash the password and insert
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: application_form.php");
        exit();
    } else {
        header("Location: register.php?error=Something went wrong. Please try again.");
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #005691;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            width: 100%;
            background-color: #0070c0;
            border-color: #0070c0;
        }

        .btn-primary:hover {
            background-color: #005691;
            border-color: #005691;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>User Registration</h2>

    <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>

    <form method="POST" action="register.php">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <div class="mt-3 text-center">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

</body>
</html>
