<?php
/*
 * Work out and return how long ago a post/comment was made
 * @param then - the datetime of when the post/comment was made
 * @param now - the current datetime
 * @return timeAgo - how long ago it was made
 */
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
    } elseif ($difference['s'] < 5) {
        $timeAgo = "Just now";
    } else {
        $timeAgo = $difference['s'] . "s";
    }

    return $timeAgo;
}

/*
 * Separate inputted text into paragraphs
 * @param text - text inputted by user
 * @return paragraphs - array of paragraphs
 */
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

/*
 * Get all comments for post
 * @param conn - database connection
 * @param id - ID number of post
 * @param currentDateTime - the current date/time
 * @return comments - array of comments
 */
function retrieve_comments($conn, $id, $currentDateTime) {
    $rsComments = db_query($conn, "SELECT * FROM comment WHERE post_id = $id ORDER BY datetime ASC");

    $comments = [];
    for ($i = 1; $i <= mysqli_num_rows($rsComments); $i++) {
        $comment = mysqli_fetch_assoc($rsComments);
        $timestamp = new DateTime($comment['datetime']);
        $timeAgo = calculate_time_ago($timestamp, $currentDateTime);
        $timestamp = date_format($timestamp, 'l, j F Y \a\t H:i');

        $comments["'" . $comment['id'] . "'"] = [
            "username" => $comment['user_id'],
            "text" => $comment['text'],
            "timestamp" => $timestamp,
            "timeago" => $timeAgo
        ];
    }
    return $comments;
}

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$username = $_SESSION['username'];

// Retrieve all posts from database
$sqlAllPosts = "SELECT post.id AS thisone, post.*, media.ext, COUNT(post_like.post_id) AS likes, (SELECT 1
                                                                                        FROM post_like
                                                                                        WHERE post_like.user_id = '$username'
                                                                                        AND post_like.post_id = thisone) AS user_liked
                FROM post
                LEFT JOIN post_like ON post.id = post_like.post_id
                LEFT JOIN media ON post.id = media.post_id
                GROUP BY post.id
                ORDER BY post.id DESC";
$rsAllPosts = db_query($conn, $sqlAllPosts);

$posts = [];
$currentDateTime = new DateTime();

// For each post, obtain all necessary details and add to the posts array
for ($i = 1; $i <= mysqli_num_rows($rsAllPosts); $i++) {
    $post = mysqli_fetch_assoc($rsAllPosts);
    $id = $post['id'];
    $username = $post['user_id'];
    $likes = $post['likes'];
    $userLiked = $post['user_liked'] == 1 ? "1" : "0";
    $image = $post['ext'];

    $timestamp = new DateTime($post['timestamp']);

    $timeAgo = calculate_time_ago($timestamp, $currentDateTime);
    $timestamp = date_format($timestamp, 'l, j F Y \a\t H:i');
    

    $text = split_text($post['text']);
    $posts["'" . $id . "'"] = [
        "username" => $username,
        "timestamp" => $timestamp,
        "timeago" => $timeAgo,
        "text" => $text,
        "imageext" => $image,
        "likes" => $likes,
        "userliked" => $userLiked,
        "comments" => retrieve_comments($conn, $id, $currentDateTime)
    ];
}

print_r(json_encode($posts));

?>