<?php

// If user is not logged in, redirect the user to login and show a toast
if (!isset($_SESSION['username'])){
    $_SESSION['toast'] = [
        "type" => "error",
        "header" => "User-Only Feature",
        "message" => "Login to access it"
    ];
    header('location: default.php#startnow');
}

?>