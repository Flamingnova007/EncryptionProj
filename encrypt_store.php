<?php
require_once('vendor/autoload.php');
require_once('algo.php');
use algo\process;
//use phpseclib\Crypt\AES;
use phpseclib\Crypt\Hash;

$host_name = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'user_cred';
$s_command = new mysqli($host_name, $db_user, $db_pass, $db_name);

$user_name = $_POST['username'];
$user_passwd = $_POST['password'];

$cipher = new process();
$cipher->setKey("12358953");
$cipher->setIV(4);

$encrypted_password = $cipher->process($user_passwd);

$hash_obj = new phpseclib\Crypt\Hash();
$hashed_password = $hash_obj->hash($encrypted_password);

$statement = $s_command->prepare("INSERT INTO cust_details (username, hashed_password) VALUES (?, ?)");
$statement->bind_param("ss", $user_name, $hashed_password);
$statement->execute();

if ($statement->affected_rows == 1) {
    header("Location: success.html");
    exit;
}

$statement->close();
$s_command->close();
?>
