<?php

include "../inc/db_helper.php";

$conn = db_connect();

session_start();
$username = $_SESSION['username'];
$text = $_POST['post'];
$timestamp = date_format(new DateTime(), "Y-m-d H:i:s");
echo $timestamp;

$sqlNewPost = "INSERT INTO post (user_id, text, timestamp) VALUES (?, ?, ?)";
$valuesNewPost = [
    ['s', $username],
    ['s', $text],
    ['s', $timestamp]
];
$rsNewPost = db_prep_stmt($conn, $sqlNewPost, $valuesNewPost);

?>