<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

// Ensure user doesn't get same two activities in a row
$last = isset($_GET['last']) ? $_GET['last'] : "";
$sqlActivity = "SELECT * FROM activity " . ($last == "" ? "" : "WHERE id <> $last") . " ORDER BY RAND() LIMIT 1";

$rsActivity = db_query($conn, $sqlActivity);

$activity = mysqli_fetch_assoc($rsActivity);

print_r(json_encode($activity));

?>