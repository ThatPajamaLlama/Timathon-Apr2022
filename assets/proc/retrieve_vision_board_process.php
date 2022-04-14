<?php

function get_text($conn, $id) {
    $sqlText = "SELECT * FROM vision_board_text WHERE vision_board_id = ?";
    $valuesText = [['i', $id]];
    $rsText = db_prep_stmt($conn, $sqlText, $valuesText);
    
    $text = [];
    for ($i = 1; $i <= mysqli_num_rows($rsText); $i++) {
        $textItem = mysqli_fetch_assoc($rsText);
        array_push($text, [
            "text" => $textItem['text'],
            "font" => $textItem['font'],
            "size" => $textItem['size'],
            "colour" => $textItem['colour'],
            "x" => $textItem['x'],
            "y" => $textItem['y']
        ]);
    }

    return $text;
}

function get_images($conn, $id) {
    $sqlImages = "SELECT * FROM vision_board_image WHERE vision_board_id = ?";
    $valuesImages = [['i', $id]];
    $rsImages = db_prep_stmt($conn, $sqlImages, $valuesImages);
    
    $images = [];
    for ($i = 1; $i <= mysqli_num_rows($rsImages); $i++) {
        $image = mysqli_fetch_assoc($rsImages);
        array_push($images, [
            "path" => $image['path'],
            "width" => $image['width'],
            "height" => $image['height'],
            "x" => $image['x'],
            "y" => $image['y']
        ]);
    }

    return $images;
}

session_start();

include "../inc/db_helper.php";
$conn = db_connect();

$id = $_GET['id'];


$objects = [
    "text" => get_text($conn, $id),
    "images" => get_images($conn, $id)
];



// $pretty = json_encode($objects, JSON_PRETTY_PRINT);
// echo "<pre>" . $pretty . "</pre>";

print_r(json_encode($objects));

?>