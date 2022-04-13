<?php

include "../inc/db_helper.php";

$conn = db_connect();

session_start();

$username = $_SESSION['username'];
$item = $_POST['item'];

$sqlNewItem = "INSERT INTO bucket_list_item (user_id, item, completed) VALUES (?, ?, ?)";
$valuesNewItem = [
    ['s', $username],
    ['s', $item],
    ['i', 0]
];
$rsNewItem = db_prep_stmt($conn, $sqlNewItem, $valuesNewItem);

?>