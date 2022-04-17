<?php
session_start();
include "assets/inc/user_access_control.php";

include "assets/inc/toast_helper.php";

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="vision-boards" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div class="flex-container">
                <section id="editor">
                    <form class="flex-container" onsubmit="return AddBoard(event, this);">
                        <input type="text" id="board-name" name="board-name" placeholder="Enter a name for your vision board..." maxLength="50" onkeyup="NameChange(event, this);"/>
                        <button type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    </form>
                    <table id="list">
                        <!-- Filled in using JS -->
                    </table>
                </section>
                <section id="info">
                    <h1>What is a Vision Board?</h1>
                    <p>A vision board is a collage made up of words and images relating to your personal goals.</p>
                    <p>Creating them and looking at them can be a great way to stay inspired and motivated.</p>
                    <p>You may create and keep numerous vision boards. Some choose to put all of their current goals on one vision board and create a new one whenever their goals change, allowing them to keep a record of their previous aspirations. Others create vision boards for each goal individually.</p>
                </section>
           </div>
        </main>

    </body>
</html>

<script src="assets/js/tata.js"></script>
<?php handle_toast();?>

<script src="assets/js/vision_board_management.js"></script>