<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$id = $_POST['id'];
$complete = $_POST['complete'];

// Find user who owns this bucket list item
$sqlUser = "SELECT user_id FROM bucket_list_item WHERE id = ?";
$valuesUser = [['i', $id]];
$rsUser = db_prep_stmt($conn, $sqlUser, $valuesUser);

// Ensure user is accessing their own bucket list item
if (mysqli_num_rows($rsUser) == 0){
    echo "You may only change your own bucket list items.";
} else if (mysqli_fetch_assoc($rsUser)["user_id"] == $_SESSION['username']) {
    $sqlChange = "UPDATE bucket_list_item SET completed = ? WHERE id = ?";
    $valuesChange = [
        ['i', $complete],
        ['i', $id]
    ];
    $rsChange = db_prep_stmt($conn, $sqlChange, $valuesChange);
} else {
    echo "You may only change your own bucket list items.";
}







?>