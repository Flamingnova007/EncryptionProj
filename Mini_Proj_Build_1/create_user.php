<?php
// Connect to the database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'noencrypt';
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Get the form data
$name = $_POST['username'];
$password = $_POST['password'];

// Insert the data into the database
$stmt = $mysqli->prepare("INSERT INTO cust_details (name, password) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $password);
$stmt->execute();
$stmt->close();

// Close the database connection
$mysqli->close();

// Redirect the user to a success page
header("Location: success.html");
exit;
?>
