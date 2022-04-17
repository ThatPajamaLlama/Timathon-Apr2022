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
            <div class="flex-container">
                <section id="gen">
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
                    <p id="multiclick">Clicking the button multiple times somewhat voids the point...</p>
                </section>
                <section id="info">
                    <h1>What is this?</h1>
                    <p>This is the style generator, where you can press the 'Choose my Style' button to randomly select a style for you to wear today.</p>
                    <p>Using this can allow you to re-invent yourself each day and discover new tastes by trying styles you wouldn't otherwise.</p>
                </section>
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

    const multiclick = document.querySelector('p#multiclick');

    var lastId = null;
    var counter = 0;
    function GenerateStyle() {
        counter++;
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

        if (counter == 2) {
            multiclick.classList.add('active');
        } else if (counter > 2) {
            if (counter == 3) {
                multiclick.classList.remove('active');
            }
            multiclick.classList.remove('jiggle');
            void multiclick.offsetWidth;
            multiclick.classList.add('jiggle');
        }
    }
</script>
