<?php
error_reporting(E_ALL);
include_once(dirname(__FILE__) . "/utils/database.php");

session_start();


if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}


$db = new Database;

if (isset($_POST["username"])){
    $users = $db -> select("SELECT id, username, banned FROM users WHERE username = ?", [$_POST["username"]]);
}elseif (isset($_POST["id"])){
    $users = $db -> select("SELECT id, username, banned FROM users WHERE id = ?", [$_POST["id"]]);
}

if (count($users) == 0){
    echo json_encode(array("success" => false, "error" => "User not found"));
    exit();
}

echo json_encode(array("success" => true, "user" => $users[0]));