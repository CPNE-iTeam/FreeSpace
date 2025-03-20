<?php
session_start();
include_once(dirname(__FILE__) . "/utils/database.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("logged" => false));
    exit();
}

$db = new Database;
$users = $db->select("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']]);
$user = $users[0];
$username = $user["username"];
$banned = $user["banned"];
$id = $user["id"];
echo json_encode(array("logged" => true, "username" => $username, "banned" => $banned, "id" => $id));
exit();
?>