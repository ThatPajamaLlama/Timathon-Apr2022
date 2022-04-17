<?php

include "../inc/db_helper.php";
session_start();

$conn = db_connect();

$username = $_POST['username'];

// Look for user in database
$sqlUser = "SELECT * FROM user WHERE username = ?";
$valuesUser = [
    ['s', $username]
];
$rsUser = db_prep_stmt($conn, $sqlUser, $valuesUser);

// If user exists then check password
// If password is correct then login, else go back to login page
if (mysqli_num_rows($rsUser) == 1) {
    $details = mysqli_fetch_assoc($rsUser);
    $password = $_POST['password'];
    if (password_verify($password, $details['password'])) {
        $_SESSION['username'] = $details['username'];
        $_SESSION['toast'] = [
            "type" => "success",
            "header" => "Logged In",
            "message" => "Welcome back!"
        ];
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
    // If user does not exist go back to login
    $_SESSION['toast'] = [
        "type" => "error",
        "header" => "Login Failed",
        "message" => "User not found"
    ];
    header('location: ../../default.php#startnow');
}

?>