<?php

include "../inc/db_helper.php";

$conn = db_connect();

session_start();

$username = $_SESSION['username'];
$name = $_POST['board-name'];

$sqlNewBoard = "INSERT INTO vision_board (name, user_id) VALUES (?, ?)";
$valuesNewBoard = [
    ['s', $name],
    ['s', $username]
];
$rsNewBoard = db_prep_stmt($conn, $sqlNewBoard, $valuesNewBoard);

?>