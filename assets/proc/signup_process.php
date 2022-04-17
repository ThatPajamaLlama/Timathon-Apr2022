<?php

include "../inc/db_helper.php";
session_start();

$conn = db_connect();

$username = $_POST['username'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['password-confirmation'];

// SQL query to find user
$lowercaseUsername = strtolower($username);
$sqlExistingUser = "SELECT username FROM user WHERE LOWER(username) = ?";
$valuesExistingUser = [
    ['s', $lowercaseUsername]
];
$rsExistingUser = db_prep_stmt($conn, $sqlExistingUser, $valuesExistingUser);

// If user already exists, go back to signup area
if (mysqli_num_rows($rsExistingUser) != 0) {
    $_SESSION['toast'] = [
        "type" => "error",
        "header" => "Signup Failed",
        "message" => "Username already in use"
    ];
    header('location: ../../default.php#startnow');
} else {
    // If user does not already exist, check that passwords match
    if ($password == $passwordConfirmation) {
        // If passwords match, sign the user up and redirect to user dash
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
        // If passwords do not match, send user back to signup area
        $_SESSION['toast'] = [
            "type" => "error",
            "header" => "Signup Failed",
            "message" => "Confirmation password must match"
        ];
        header('location: ../../default.php#startnow');
    }
   
}

?>