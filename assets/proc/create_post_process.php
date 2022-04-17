<?php

function create_post($conn, $username, $text, $timestamp) {
    $sqlNewPost = "INSERT INTO post (user_id, text, timestamp) VALUES (?, ?, ?)";
    $valuesNewPost = [
        ['s', $username],
        ['s', $text],
        ['s', $timestamp]
    ];
    $rsNewPost = db_prep_stmt($conn, $sqlNewPost, $valuesNewPost);
}


include "../inc/db_helper.php";

$conn = db_connect();

session_start();
$username = $_SESSION['username'];
$text = $_POST['post'];
$timestamp = date_format(new DateTime(), "Y-m-d H:i:s");

// If there is a file, check to ensure the file works
if (isset($_FILES['file'])){
    $filePath = "../img/social/";
    $img = $_FILES['file'];
    if ($img["error"] <= 0)
    {
        if (!file_exists($filePath . $img["name"]))
        {
            $allowed_exts = ["jpg", "png", "jpeg", "bmp"];
            $explosion = explode(".", $img["name"]);
            $extension = end($explosion);
            if (!in_array($extension, $allowed_exts)){
                $error = "Not a supported image type";
            } else {
                // If there are no issues, then add post and image
                create_post($conn, $username, $text, $timestamp);
                $postId = mysqli_insert_id($conn);
                $newImageName = $postId . "." . $extension;
                move_uploaded_file($img["tmp_name"], $filePath . $newImageName);
                $sqlNewMedia = "INSERT INTO media (post_id, ext) VALUES (?, ?)";
                $valuesNewMedia = [
                    ['i', $postId],
                    ['s', $extension]
                ];
                $rsNewMedia = db_prep_stmt($conn, $sqlNewMedia, $valuesNewMedia);
            }
        }
    } elseif ($img["error"] == 1){
        $error = "Image too large";
    } elseif ($img['error'] == 4){
        $error = "No image selected";
    } else {
        $error = "An unknown file issue has occurred";
    }
} else {
    create_post($conn, $username, $text, $timestamp);
}
 
echo (isset($error) ? $error : "");





?>