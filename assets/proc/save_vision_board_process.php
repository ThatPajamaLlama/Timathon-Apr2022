<?php

include "../inc/db_helper.php";
$conn = db_connect();

$id = $_GET['id'];

// Remove all text and images currently stored in database for this vision board
$valuesClear = [['i', $id]];
$sqlClear = "DELETE FROM vision_board_text WHERE vision_board_id = ?";
$rsClear = db_prep_stmt($conn, $sqlClear, $valuesClear);
$sqlClear = "DELETE FROM vision_board_image WHERE vision_board_id = ?";
$rsClear = db_prep_stmt($conn, $sqlClear, $valuesClear);

// Add each vision board element to the database
$data = json_decode($_POST['data'], true);
foreach ($data as $element) {
    if ($element["type"] == "text") {
        $details = $element["db"];
        $sqlInsertText = "INSERT INTO vision_board_text (vision_board_id, text, font, size, colour, x, y)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $valuesInsertText = [
            ['i', $id],
            ['s', $details["text"]],
            ['s', $details["font"]],
            ['i', $details["size"]],
            ['s', $details["colour"]],
            ['i', $details["x"]],
            ['i', $details["y"]]
        ];
        $rsInsertText = db_prep_stmt($conn, $sqlInsertText, $valuesInsertText);
    } else {
        $details = $element["db"];
        $sqlInsertImage = "INSERT INTO vision_board_image (vision_board_id, path, width, height, x, y)
                            VALUES (?, ?, ?, ?, ?, ?)";
        $valuesInsertImage = [
            ['i', $id],
            ['s', $details["path"]],
            ['i', $details["width"]],
            ['i', $details["height"]],
            ['i', $details["x"]],
            ['i', $details["y"]]
        ];
        $rsInsertImage = db_prep_stmt($conn, $sqlInsertImage, $valuesInsertImage);
    }
}

?>