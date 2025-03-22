<?php
include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();


if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}


$db = new Database;
if (isset($_GET["search"])){
    $users = $db -> select("SELECT id, username, banned FROM users WHERE username LIKE ?", ["%" . $_GET["search"] . "%"]);
}else{
    $users = $db -> select("SELECT id, username, banned FROM users");
}

echo json_encode(array("success" => true, "users" => $users));