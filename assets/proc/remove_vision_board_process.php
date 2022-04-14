<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$id = $_GET['id'];

$sqlTextRemoval = "DELETE FROM vision_board_text WHERE vision_board_id = ?";
$valuesTextRemoval = [['i', $id]];
$rsTextRemoval = db_prep_stmt($conn, $sqlTextRemoval, $valuesTextRemoval);

$sqlImageRemoval = "DELETE FROM vision_board_image WHERE vision_board_id = ?";
$valuesImageRemoval = [['i', $id]];
$rsImageRemoval = db_prep_stmt($conn, $sqlImageRemoval, $valuesImageRemoval);

$sqlBoardRemoval = "DELETE FROM vision_board WHERE id = ?";
$valuesBoardRemoval = [['i', $id]];
$rsBoardRemoval = db_prep_stmt($conn, $sqlBoardRemoval, $valuesBoardRemoval);
?>