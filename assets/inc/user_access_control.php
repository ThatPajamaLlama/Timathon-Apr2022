<?php

if (!isset($_SESSION['username'])){
    $_SESSION['toast'] = [
        "type" => "error",
        "header" => "User-Only Feature",
        "message" => "Login to access it"
    ];
    header('location: default.php#startnow');
}

?>