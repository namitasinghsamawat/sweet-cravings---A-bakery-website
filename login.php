<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start session to manage login state

include 'connect_db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the login form
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate the required fields
    if (empty($email) || empty($password)) {
        echo "Email and password are required!";
        exit;
    }

    // Prepare and execute SQL to fetch the user by email
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists in the database
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email, $hashed_password);
        $stmt->fetch();

        // Verify if the entered password matches the hashed password in the database
        if (password_verify($password, $hashed_password)) {
            // Successful login, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            // Optionally handle remember me (cookies)
            if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
                setcookie('user_id', $id, time() + (86400 * 30), "/"); // 30 days
                setcookie('user_email', $email, time() + (86400 * 30), "/");
            }

            // Redirect to the homepage (or dashboard)
           header("Location: index.php");

            exit;

        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>