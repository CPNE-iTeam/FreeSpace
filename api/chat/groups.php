<?php
include_once(dirname(__FILE__) . "/../utils/database.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "error" => "You are not logged in"));
    exit();
}

$db = new Database;


$groups_id = $db -> select("SELECT * FROM chat_users_groups WHERE user = ?", [$_SESSION['user_id']]);
$groups = array();
foreach ($groups_id as $group) {
    $group_id = $group['chat_group'];
    $group_name = $db -> select("SELECT * FROM chat_groups WHERE id = ?", [$group_id])[0]['name'];
    $groups[] = array("id" => $group_id, "name" => $group_name);
}

echo json_encode(array("success" => true, "groups" => $groups));
exit();