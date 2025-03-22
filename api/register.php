<?php
error_reporting(E_ALL);
session_start();

include_once(dirname(__FILE__) . "/utils/database.php");

if (isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "Already logged in"));
    exit();
}

$db = new Database;


$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($username == "aline"){echo json_encode(array("success" => false, "error" => "VITAL. JE SAIS QUE C'EST TOI."));exit();}


$users = $db -> select("SELECT * FROM users WHERE username = ?", [$username]);
if (count($users) > 0) {
    echo json_encode(array("success" => false, "error" => "Username already exists"));
    exit();
}
if (strlen($username) < 3) {
    echo json_encode(array("success" => false, "error" => "Username must be at least 3 characters"));
    exit();
}
if (strlen($username) > 20) {
    echo json_encode(array("success" => false, "error" => "Username must be at most 20 characters"));
    exit();
}

$namePattern = "/^[a-zA-Z0-9]+$/";
if (!preg_match($namePattern, $username)) {
    echo json_encode(array("success" => false, "error" => "Username must contain only letters and numbers"));
    exit();
}

$db -> query("INSERT INTO users (username, passwrd) VALUES (?, ?)", [$username, $hashed_password]);
$users = $db -> select("SELECT * FROM users WHERE username = ?", [$username]);
$user = $users[0];

$_SESSION['user_id'] = $user['id'];

echo json_encode(array("success" => true));
exit();