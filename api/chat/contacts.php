<?php
include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();


if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}

$user = $_SESSION['user_id'];

$db = new Database;

$messages = $db -> select("SELECT * FROM messages WHERE from_user = ? OR to_user = ?", [$user, $user]);
$contacts = array();
foreach ($messages as $message) {
    if ($message['from_user'] == $user) {
        $contact = $message['to_user'];
    } else {
        $contact = $message['from_user'];
    }
    if (!in_array($contact, $contacts)) {
        $contacts[] = $contact;
    }
}

$result = array();
foreach ($contacts as $contact) {
    $username = $db -> select("SELECT username FROM users WHERE id = ?", [$contact])[0]['username'];
    $result[] = array(
        "id" => $contact,
        "username" => $username
    );
}

echo json_encode(array("success" => true, "contacts" => $result));