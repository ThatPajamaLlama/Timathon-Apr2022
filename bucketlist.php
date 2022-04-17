<?php
session_start();

include "assets/inc/user_access_control.php";
?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="bucket-list" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div class="flex-container">
                <section id="editor">
                    <form class="flex-container" onsubmit="return AddItem(event, this);">
                        <input type="text" id="item" name="item" placeholder="Enter a new bucket list item..." onkeyup="ItemChange(event, this)" maxLength="50"/>
                        <button type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    </form>
                    <table id="list">
                        <!-- Filled in using JS -->
                    </table>
                </section>
                <section id="info">
                    <h1>What is a Bucket List?</h1>
                    <p>A bucket list is a list of experiences or achievements that you hope to accomplish during your lifetime.</p>
                    <p>Creating one is a great way to keep track of your aspirations, allowing you to focus on what you can do to achieve them.</p>
                    <h1>Your Progress</h1>
                    <p>You have completed <span id="completed">4</span> out of your <span id="total">5</span> bucket list items. <span id="message">What a great start!</span></p>
                    <div id="chart">
                        <canvas id="bucket-list-progress-canvas"></canvas>
                    </div>
                </section>
            </div>
        </main>

    </body>
</html>

<script src="assets/js/tata.js"></script>

<!-- Chart.js library used to show piechart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.js"></script>

<script src="assets/js/bucket_list_management.js"></script>