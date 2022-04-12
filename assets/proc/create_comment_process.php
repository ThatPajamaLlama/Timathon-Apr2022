<?php

include "../inc/db_helper.php";

$conn = db_connect();

session_start();
$username = db_input($conn, "username", "session");
$postId = db_input($conn, "postId", "post");
$text = db_input($conn, "comment", "post");
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