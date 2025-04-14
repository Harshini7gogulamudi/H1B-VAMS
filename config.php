<?php
// Database connection configuration
$host = 'localhost';  // Server (usually localhost)
$username = 'root';   // MySQL username (change if needed)
$password = 'Vamshis@123';       // MySQL password (use the password set for the MySQL user)
$dbname = 'h1b_application'; // Database name (replace with your database name)

try {
    // Create a new PDO instance to connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Uncomment the line below to check the connection
    // echo "Connected successfully"; 
} catch(PDOException $e) {
    // If connection fails, show an error message
    echo "Connection failed: " . $e->getMessage();
}
?>
