<?php
session_start();

include "assets/inc/db_helper.php";
$conn = db_connect();

function get_name($conn) {
    $sqlName = "SELECT name FROM vision_board WHERE id = ?";
    $valuesName = [['i', $_GET['id']]];
    $rsName = db_prep_stmt($conn, $sqlName, $valuesName);
    $name = mysqli_fetch_assoc($rsName)['name'];
    return $name;
}

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="vision-board" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>

            <div id="editor" class="flex-container">
                <div id="options">
                    <a id="back-button" href="visionboards.php"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>Back</a>
                    <h1>Edit '<?php echo get_name($conn);?>'</h1>
                    <form onsubmit="DrawBoard(this, ctx); return false;">
                        <h2>Text</h2>
                        <div id="text-inputs">
                            <!-- Filled in using JS -->
                        </div>
                        <a class="add-button" onclick="AddInput('text');"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                        <h2>Imagery</h2>
                        <div id="image-inputs">
                            <!-- Filled in using JS -->
                        </div>
                        <a class="add-button" onclick="AddInput('image');"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                        <input type="submit" value="Draw"/>
                    </form>
                    
                </div>
                <div id="board" class="center-contents">
                    <canvas>
                        
                    </canvas>
                </div>
            </div>
        </main>

    </body>
</html>

<script src="assets/js/tata.js"></script>
<script src="assets/js/canvas_setup.js"></script>

<script src="assets/js/vision_board_creation.js"></script>