<?php
$servername = "localhost"; // if phpMyAdmin locally
$username = "root";        // default XAMPP/WAMP
$password = "";            // default no password
$database = "resume_analyzer"; // DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
