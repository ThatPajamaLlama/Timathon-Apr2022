<?php

include "../inc/db_helper.php";

$conn = db_connect();

session_start();
$username = $_SESSION['username'];
$postId = $_POST['postId'];
$text = $_POST['comment'];
$text = str_replace("\\r\\n", "", $text);
$timestamp = date_format(new DateTime(), "Y-m-d H:i:s");

$sqlNewComment = "INSERT INTO comment (post_id, user_id, text, datetime) VALUES (?, ?, ?, ?)";
$valuesNewComment = [
    ['i', $postId],
    ['s', $username],
    ['s', $text],
    ['s', $timestamp]
];
$rsNewComment = db_prep_stmt($conn, $sqlNewComment, $valuesNewComment);

?>