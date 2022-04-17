<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

// Ensure user doesn't get same two styles in a row
$last = isset($_GET['last']) ? $_GET['last'] : "";
$sqlStyle = "SELECT * FROM style " . ($last == "" ? "" : "WHERE id <> $last") . " ORDER BY RAND() LIMIT 1";

$rsStyle = db_query($conn, $sqlStyle);

$style = mysqli_fetch_assoc($rsStyle);

print_r(json_encode($style));

?>