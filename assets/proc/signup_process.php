<?php

include "../inc/db_helper.php";
session_start();

$conn = db_connect();

$username = db_input($conn, "username", "post");
$password = db_input($conn, "password", "post");
$passwordConfirmation = db_input($conn, "password-confirmation", "post");

$lowercaseUsername = strtolower($username);

$sqlExistingUser = "SELECT username FROM user WHERE LOWER(username) = ?";
$valuesExistingUser = [
    ['s', $lowercaseUsername]
];
$rsExistingUser = db_prep_stmt($conn, $sqlExistingUser, $valuesExistingUser);

if (mysqli_num_rows($rsExistingUser) != 0) {
    $_SESSION['toast'] = [
        "type" => "error",
        "header" => "Signup Failed",
        "message" => "Username already in use"
    ];
    header('location: ../../default.php#startnow');
} else {
    if ($password == $passwordConfirmation) {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $sqlAddUser = "INSERT INTO user (username, password) VALUES (?, ?)";
        $valuesAddUser = [
            ['s', $username],
            ['s', $password]
        ];
        $rsAddUser = db_prep_stmt($conn, $sqlAddUser, $valuesAddUser);
        
        $_SESSION['username'] = $username;

        $_SESSION['toast'] = [
            "type" => "success",
            "header" => "Signed Up",
            "message" => "Your account has been created"
        ];

        header('location: ../../dash.php');
    } else {
        $_SESSION['toast'] = [
            "type" => "error",
            "header" => "Signup Failed",
            "message" => "Confirmation password must match"
        ];
        header('location: ../../default.php#startnow');
    }
   
}

?>