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

echo json_encode(array("logged" => true, "user" => $user));
exit();
?>