<?php
$conn = new mysqli("localhost", "root", "", "sweet_cravingss");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
