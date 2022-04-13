<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$id = $_POST['id'];
$complete = $_POST['complete'];

$sqlChange = "UPDATE bucket_list_item SET completed = ? WHERE id = ?";
$valuesChange = [
    ['i', $complete],
    ['i', $id]
];

$rsChange = db_prep_stmt($conn, $sqlChange, $valuesChange);

?>