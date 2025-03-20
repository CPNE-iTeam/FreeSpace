<?php
include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}

$from = $_POST['from'];

$db = new Database;
$messages = $db -> select("SELECT * FROM messages WHERE to_user = ?", [$_SESSION['user_id']]);