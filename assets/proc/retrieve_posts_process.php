<?php

function calculate_time_ago($then, $now) {
    $difference = (array) date_diff($now, $then);

    if ($difference['y'] > 0) {
        $timeAgo = "A long time ago";
    } elseif ($difference['m'] > 0) {
        $timeAgo = date_format($then, 'j M \a\t H:i');
    } elseif ($difference['d'] > 0) {
        $timeAgo = $difference['d'] . "d";
    } elseif ($difference['h'] > 0) {
        $timeAgo = $difference['h'] . "h";
    } elseif ($difference['i'] > 0) {
        $timeAgo = $difference['i'] . "m";
    } elseif ($difference['s'] < 10) {
        $timeAgo = "Just now";
    } else {
        $timeAgo = $difference['s'] . "s";
    }

    return $timeAgo;
}

function split_text($text) {
    $parts = explode("\\r\\n", $text);
    $paragraphs = [];
    foreach ($parts as $part) {
        if ($part != "") {
            array_push($paragraphs, $part);
        }
    }
    return $paragraphs;
}

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$rsAllPosts = db_query($conn, "SELECT * FROM post ORDER BY id DESC");

$posts = [];
$currentDateTime = new DateTime();

for ($i = 1; $i <= mysqli_num_rows($rsAllPosts); $i++) {
    $post = mysqli_fetch_assoc($rsAllPosts);
    $id = $post['id'];
    $username = $post['user_id'];

    $timestamp = new DateTime($post['timestamp']);

    $timeAgo = calculate_time_ago($timestamp, $currentDateTime);
    $timestamp = date_format($timestamp, 'l, j F Y \a\t H:i');
    

    $text = split_text($post['text']);
    $posts["'" .  $id . "'"] = [
        "username" => $username,
        "timestamp" => $timestamp,
        "timeago" => $timeAgo,
        "text" => $text
        ];
}

print_r(json_encode($posts));

?>