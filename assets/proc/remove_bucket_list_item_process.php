<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$id = $_GET['id'];

$sqlRemoval = "DELETE FROM bucket_list_item WHERE id = ?";
$valuesRemoval = [['i', $id]];
$rsRemoval = db_prep_stmt($conn, $sqlRemoval, $valuesRemoval);

?>