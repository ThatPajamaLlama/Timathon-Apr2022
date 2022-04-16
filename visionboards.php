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
                        <input type="text" id="board-name" name="board-name" placeholder="Enter a name for your vision board..." onkeyup="if (event.key == 'enter') {this.parentNode.submit();}"/>
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

<script>
    function AddBoard(e, form) {
        e.preventDefault();
        var name = form.querySelector('#board-name');
        if (name.value != ""){
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    tata.success('Vision Board Created', 'New: \'' + name.value + '\'', {
                        position: 'br'
                    });
                    name.value = "";
                    DisplayBoards();
                }
            };
            request.open("POST", "assets/proc/add_vision_board_process.php", true);
            request.send(new FormData(form));
        }       
    }

    window.onload = function() {
        DisplayBoards();
    }

    function DisplayBoards() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                html = "";
                for (const [id, name] of Object.entries(response)) {
                    html += "<tr class='board' id='board-" + id.replaceAll("'", "") + "'>";
                    html +=     "<td class='name'>" + name + "</td>";
                    html +=     "<td><a class='edit-button' onclick='return EditBoard(this);'><i class='fa fa-pencil-square' aria-hidden='true'></i></a></td>";
                    html +=     "<td><a class='remove-button' onclick='return RemoveBoard(this);'><i class='fa fa-minus-circle' aria-hidden='true'></i></a></td>";
                    html += "</tr>";
                }
                document.querySelector('table#list').innerHTML = html;
                thesePosts = response;
            }
        };
        request.open("POST", "assets/proc/retrieve_vision_boards_process.php", true);
        request.send();
    }

    function RemoveBoard(button) {
        var board = button.closest('tr.board');
        var boardId = board.id.split("-")[1];
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var name = board.querySelector('td.name').innerHTML;
                DisplayBoards();
                tata.success('Vision Board Removed', 'Removed \'' + name + '\'', {
                    position: 'br'
                });
            }
        };
        request.open("POST", "assets/proc/remove_vision_board_process.php?id=" + boardId, true);
        request.send();
    }

    function EditBoard(button) {
        var boardId = button.closest('tr.board').id.split("-")[1];
        window.location.href = "visionboard.php?id=" + boardId;
    }

</script>