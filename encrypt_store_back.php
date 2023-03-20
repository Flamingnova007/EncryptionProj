<?php
require_once('vendor/autoload.php');
require_once('algo.php');
use algo\process;
//use phpseclib\Crypt\AES;
use phpseclib\Crypt\Hash;

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'noencrypt';
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Initialize the AES cipher
$cipher = new process();
$cipher->setKey("12358953");
$cipher->setIV(4);

// Encrypt the password using AES
$encrypted_password = $cipher->process($password);

// Hash the encrypted password using SHA256
$hash_obj = new phpseclib\Crypt\Hash();
$hashed_password = $hash_obj->hash($encrypted_password);

// Prepare the SQL query
$stmt = $mysqli->prepare("INSERT INTO cust_details (name, hashed_password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

// Check if the query was successful
if ($stmt->affected_rows == 1) {
    // Registration successful
    header("Location: success.html");
    exit;
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>
