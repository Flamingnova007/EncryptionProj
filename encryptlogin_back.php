<?php
require_once('vendor/autoload.php');
require_once('algo.php');
use algo\process;
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

// Prepare the SQL query to fetch the user data
$stmt = $mysqli->prepare("SELECT hashed_password FROM cust_details WHERE name=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    // User exists
    $stmt->bind_result($stored_hashed_password);
    $stmt->fetch();

    if ($stored_hashed_password === $hashed_password) {
        // Login successful
        header("Location: welcome.html");
        exit;
    } else {
        // Login failed
        header("Location: denied.html");
        exit;
    }
} else {
    // User not found
    header("Location: denied.html");
    exit;
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>
