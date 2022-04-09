<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="activity-randomiser" class="user-area flex-container generator">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div id="container" class="center-contents">
                <div>
                    <section>
                        <button onclick="return GenerateActivity();">
                            <i class="fa fa-fort-awesome" aria-hidden="true"></i>
                            <p>Pick an activity!</p>
                        </button>
                    </section>
                    <section id="activity" class="random-item">
                        <h1 id="name">&nbsp;</h1>
                        <div id="img" class="img"></div>
                    </section>
                </div>
            </div>
        </main>

    </body>
</html>

<script>
    const activity = document.querySelector('#activity');
    const name = activity.querySelector('#name');
    const description = activity.querySelector('#desc');
    const image = activity.querySelector('#img');

    var lastId = null;
    function GenerateActivity() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                
                name.innerHTML = response["name"];
                image.style.backgroundImage = "url('" + response["img"] + "')";
                if (lastId == null) {
                    activity.style.visibility = "visible";
                }
                lastId = response["id"];
            }
        };
        var url = "assets/proc/generate_activity_process.php";
        if (lastId != null) {
            url += "?last=" + lastId;
        }
        request.open("POST", url, true);
        request.send();
    }
</script>
