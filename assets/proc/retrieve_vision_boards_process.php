<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$username = $_SESSION['username'];

// Get all vision boards by this user
$sqlBoards = "SELECT * FROM vision_board WHERE user_id = ? ORDER BY name ASC";
$valuesBoards = [['s', $username]];
$rsBoards = db_prep_stmt($conn, $sqlBoards, $valuesBoards);

// Create array of vision boards including ID and name
$boards = [];
for ($i = 1; $i <= mysqli_num_rows($rsBoards); $i++) {
    $board = mysqli_fetch_assoc($rsBoards);
    $boards["'" . $board['id'] . "'"] = $board['name'];
}

print_r(json_encode($boards));

?>