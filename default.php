<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body>
        <div id="editor" class="flex-container">
            <div id="options">
                <form onsubmit="DrawRect(this, ctx); return false;">
                    <input type="number" name="x" id="x" placeholder="X"/>
                    <input type="number" name="y" id="y" placeholder="Y"/>
                    <input type="number" name="w" id="w" placeholder="W"/>
                    <input type="number" name="h" id="h" placeholder="H"/>
                    <input type="submit" value="Draw"/>
                </form>
            </div>
            <div id="board" class="center-contents">
                <canvas>
                    
                </canvas>
            </div>
        </div>
    </body>
</html>

<script src="assets/js/canvas.js"></script>
<script src="assets/js/draw.js"></script>