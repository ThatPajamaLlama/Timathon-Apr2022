<?php

use function PHPSTORM_META\sql_injection_subst;

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$sqlStats = "SELECT completed AS status, COUNT(completed) AS total FROM bucket_list_item WHERE user_id = ? GROUP BY completed ORDER BY status DESC";
$valuesStats = [['s', $_SESSION['username']]];
$rsStats = db_prep_stmt($conn, $sqlStats, $valuesStats);

$labels = [];
$numbers = [];
for ($i = 1; $i <= mysqli_num_rows($rsStats); $i++){
    $row = mysqli_fetch_assoc($rsStats);
    $labels[] = $row['status'] == "1" ? "Complete" : "Incomplete";
    $numbers[] = $row['total'];
}

$stats = [
    "labels" => $labels,
    "data" => $numbers
];

print_r(json_encode($stats));

?>