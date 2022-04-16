<?php
session_start();
include "assets/inc/user_access_control.php";
?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="style-generator" class="user-area flex-container generator">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
        <div id="container" class="center-contents">
                <div>
                    <section>
                        <button onclick="return GenerateStyle();">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                            <p>Choose my style!</p>
                        </button>
                    </section>
                    <section id="style" class="random-item">
                        <h1 id="name">&nbsp;</h1>
                        <p id="desc" >&nbsp;</p>
                        <div id="imgs" class="flex-container">
                            <div id="fem-img" class="img"></div>
                            <div id="masc-img" class="img"></div>
                        </div>
                    </section>
                </div>
            </div>
        </main>

    </body>
</html>

<script>
    const style = document.querySelector('#style');
    const name = style.querySelector('#name');
    const description = style.querySelector('#desc');
    const feminineImage = style.querySelector('#imgs #fem-img');
    const masculineImage = style.querySelector('#imgs #masc-img');

    var lastId = null;
    function GenerateStyle() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                
                name.innerHTML = response["name"];
                description.innerHTML = response["description"];
                feminineImage.style.backgroundImage = "url('" + response["feminine_img"] + "')";
                masculineImage.style.backgroundImage = "url('" + response["masculine_img"] + "')";
                if (lastId == null) {
                    style.style.visibility = "visible";
                }
                lastId = response["id"];
            }
        };
        var url = "assets/proc/generate_style_process.php";
        if (lastId != null) {
            url += "?last=" + lastId;
        }
        request.open("POST", url, true);
        request.send();
    }
</script>
