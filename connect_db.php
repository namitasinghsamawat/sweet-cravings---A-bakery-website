<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sweet_cravingss"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
