<?php
session_start();
include "assets/inc/user_access_control.php";
?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="activity-randomiser" class="user-area flex-container generator">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div class="flex-container">
                <section id="gen">
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
                    <p id="multiclick">Clicking the button multiple times somewhat voids the point...</p>
                </section>
                <section id="info">
                    <h1>What is this?</h1>
                    <p>This is the activity randomiser, where you can press the 'Pick an Activity' button to randomly select an activity to complete today.</p>
                    <p>Using this can allow you to make each day a little less ordinary, and perhaps try something new.</p>
                </section>
            </div>
        </main>

    </body>
</html>

<script src="assets/js/repeated_generator_clicks.js"></script>

<script>
    const activity = document.querySelector('#activity');
    const name = activity.querySelector('#name');
    const description = activity.querySelector('#desc');
    const image = activity.querySelector('#img');

    var lastId = null;
    var counter = 0;

    /*
    * Randomly select and display an activity
    */
    function GenerateActivity() {
        counter++;

        // Use AJAX to randomly select activity from db
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

        MultipleClicks(counter);
    }
</script>
