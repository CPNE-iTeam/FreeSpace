<?php

include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}


$db = new Database;
$messages = $db -> select("SELECT * FROM global_messages JOIN users ON global_messages.sender = users.id");
$result = array();
foreach ($messages as $message) {
    $result[] = array(
        "message" => $message['message'],
        "sender" => $message['username']
    );
}
echo json_encode(array("success" => true, "messages" => $result));