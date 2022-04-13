<?php

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$username = $_SESSION['username'];

$sqlList = "SELECT * FROM bucket_list_item WHERE user_id = ? ORDER BY completed ASC, item ASC";
$valuesList = [['s', $username]];
$rsList = db_prep_stmt($conn, $sqlList, $valuesList);

$list = [];
for ($i = 1; $i <= mysqli_num_rows($rsList); $i++) {
    $item = mysqli_fetch_assoc($rsList);
    $list["'" . $item['id'] . "'"] = [
        "item" => $item['item'],
        "completed" => $item['completed']
    ];
}


// $pretty = json_encode($list, JSON_PRETTY_PRINT);
// echo "<pre>" . $pretty . "</pre>";

print_r(json_encode($list));

?>