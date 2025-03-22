<?php
include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}

$contact = $_POST['contact'];

$db = new Database;
$messages = $db -> select("SELECT * FROM messages WHERE (to_user = ? and from_user = ?) or (from_user = ? and to_user = ?)", [$_SESSION['user_id'], $contact, $_SESSION['user_id'], $contact]);

$result = array();
foreach ($messages as $message) {
    $fromUser = $db -> select("SELECT username FROM users WHERE id = ?", [$message["from_user"]])[0];
    $result[] = array(
        "from_user" => $fromUser,
        "message" => $message["message"],
        "date" => $message["date"],
        "id" => $message["id"]
    );
}

echo json_encode(array("success" => true, "messages" => $result));