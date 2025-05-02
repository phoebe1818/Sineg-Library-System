<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Replace with hashed password in production
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='admin'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $_SESSION['username'] = $username;
    header("Location: admin_dashboard.php");
} else {
    echo "Invalid admin credentials. <a href='login.php'>Try again</a>";
}
?>
