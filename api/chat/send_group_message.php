<?php
include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();

$group = $_POST['group'];
$message = htmlspecialchars($_POST['message']);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}

if (strlen($message) < 1) {
    echo json_encode(array("success" => false, "error" => "Message must be at least 1 character"));
    exit();
}

if (strlen(htmlspecialchars($message)) > 10000 or strlen($message) > 5000) {
    echo json_encode(array("success" => false, "error" => "Message must be at most 5'000 characters"));
    exit();
}

$from = $_SESSION['user_id'];

$db = new Database;

$peoples_in_group = $db -> select("SELECT * FROM chat_users_groups WHERE chat_group = ?", [$group]);

foreach ($peoples_in_group as $people) {
    $to = $people['chat_user'];
    $db -> query("INSERT INTO messages (from_user, to_user, message, chat_group) VALUES (?, ?, ?, ?)", [$from, $to, $message, $group]);
}


echo json_encode(array("success" => true));