<?php
$servername = "localhost";  // Change if you're using a different host
$username = "root";         // MySQL username
$password = "";             // MySQL password
$dbname = "h1b_applications";  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
