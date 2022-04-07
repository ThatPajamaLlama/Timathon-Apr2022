<?php

include "../inc/db_helper.php";
session_start();

$conn = db_connect();

$username = db_input($conn, "username", "post");

$sqlUser = "SELECT * FROM user WHERE username = ?";
$valuesUser = [
    ['s', $username]
];
$rsUser = db_prep_stmt($conn, $sqlUser, $valuesUser);

if (mysqli_num_rows($rsUser) == 1) {
    $details = mysqli_fetch_assoc($rsUser);
    $password = $_POST['password'];
    if (password_verify($password, $details['password'])) {
        $_SESSION['username'] = $details['username'];
        header('location: ../../dash.php');
    } else {
        $_SESSION['toast'] = [
            "type" => "error",
            "header" => "Login Failed",
            "message" => "Your password is incorrect"
        ];
        header('location: ../../default.php#startnow');
    }
} else {
    $_SESSION['toast'] = [
        "type" => "error",
        "header" => "Login Failed",
        "message" => "User not found"
    ];
    header('location: ../../default.php#startnow');
}

?>