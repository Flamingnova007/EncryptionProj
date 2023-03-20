<?php
// Connect to the database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'noencrypt';
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare the SQL query
$stmt = $mysqli->prepare("SELECT * FROM cust_details WHERE name = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the username exists and the password matches
if ($user) {
    // Login successful
    session_start();
    $_SESSION['user_id'] = $user['id'];
    header("Location: welcome.html");
    exit;
} else {
    // Login failed
    header("Location: denied.html");
    exit;
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>


