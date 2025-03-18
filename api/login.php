<?php
include_once(dirname(__FILE__) . "/utils/database.php");

if (isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "Already logged in"));
    exit();
}

$db = new Database;


$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

$users = $db.select("SELECT * FROM users WHERE username = ?", [$username]);
if (count($users) == 0) {
    echo json_encode(array("success" => false, "error" => "Username does not exist"));
    exit();
}
$user = $users[0];
if (!password_verify($password, $user['password'])) {
    echo json_encode(array("success" => false, "error" => "Incorrect password"));
    exit();
}

session_start();
$_SESSION['user_id'] = $user['id'];
echo json_encode(array("success" => true));
exit();