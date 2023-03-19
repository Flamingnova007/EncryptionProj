<?php
require_once('vendor/autoload.php');
require_once('algo.php');
use algo\process;
use phpseclib\Crypt\Hash;

$host_name = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'noencrypt';
$sqlcmd = new mysqli($host_name, $db_user, $db_pass, $db_name);

$user_name = $_POST['username'];
$user_passwd = $_POST['password'];

$cipher = new process();
$cipher->setKey("12358953");
$cipher->setIV(4);

$encrypted_password = $cipher->process($user_passwd);

$hash_obj = new phpseclib\Crypt\Hash();
$hashed_password = $hash_obj->hash($encrypted_password);

$stmt = $sqlcmd->prepare("SELECT hashed_password FROM cust_details WHERE name=?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($stored_hashed_password);
    $stmt->fetch();

    if ($stored_hashed_password === $hashed_password) {
        header("Location: welcome.html");
        exit;
    } else {
        header("Location: denied.html");
        exit;
    }
} else {
    header("Location: denied.html");
    exit;
}

$stmt->close();
$sqlcmd->close();
?>
