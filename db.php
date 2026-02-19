<?php
// db.php - reusable database connection

// Enable error reporting (optional, useful for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "localhost";   // Usually localhost
$username = "root";          // Your MySQL username
$password = "";              // Your MySQL password
$dbname = "bloodconnect";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful
// $conn can now be used in other pages
?>
