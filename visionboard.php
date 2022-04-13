<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="vision-board" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
        <div id="editor" class="flex-container">
            <div id="options">
                <form onsubmit="DrawBoard(this, ctx); return false;">
                    <h2>Text</h2>
                    <div id="text-inputs">
                        <input type="text" id="text-1" placeholder="Text"/>
                    </div>
                    <a onclick="AddInput('text');"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                    <h2>Imagery</h2>
                    <div id="image-inputs">
                        <input type="text" id="image-1" placeholder="Image (Link)"/>
                    </div>
                    <a onclick="AddInput('image');"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

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

<script src="assets/js/canvas_setup.js"></script>

<script src="assets/js/vision_board_creation.js"></script>