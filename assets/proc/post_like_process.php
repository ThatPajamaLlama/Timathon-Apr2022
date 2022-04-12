<?php

include "../inc/db_helper.php";
$conn = db_connect();

session_start();
$username = $_SESSION['username'];

$postId = $_POST['postId'];
$process = $_POST['process'];

if ($process == "like") {
    echo "like";
    $sqlLike = "INSERT INTO post_like (user_id, post_id) VALUES (?, ?)";
    $valuesLike = [
        ['s', $username],
        ['i', $postId]
    ];
    $rsLike = db_prep_stmt($conn, $sqlLike, $valuesLike);
    
} else {
    echo "unlike";
    $sqlUnlike = "DELETE FROM post_like WHERE user_id = ? AND post_id = ?";
    $valuesUnlike = [
        ['s', $username],
        ['i', $postId]
    ];
    $rsUnlike = db_prep_stmt($conn, $sqlUnlike, $valuesUnlike);
}

?>