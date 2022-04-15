<?php
session_start();

include "assets/inc/toast_helper.php";

function get_image() {
    $images = array_slice(scandir("assets/img/quotes"), 2);
    $choice = random_int(0, count($images)-1);
    echo $images[$choice];
}
?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="dash" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div class="center-contents" style="height: 100%;">
                <div id="dash-container">
                    <h1>Hey, <span><?php echo $_SESSION['username'];?></span>!</h1>
                    <h2>Ready to make today extraordinary?</h2>
                    <div id="quote-image" style="background-image: url('assets/img/quotes/<?php get_image(); ?>');" class="center-contents">
                        <div id="quote-container">
                            <p id="quote"></p>
                            <p id="author"></p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>

    </body>
</html>


<script src="assets/js/tata.js"></script>
<?php handle_toast(); ?>
<script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
<script>

window.onload = function() {
    LoadJSON();
}

async function LoadJSON() {

    const requestURL = 'https://gist.githubusercontent.com/nasrulhazim/54b659e43b1035215cd0ba1d4577ee80/raw/e3c6895ce42069f0ee7e991229064f167fe8ccdc/quotes.json';
    const request = new Request(requestURL);

    const response = await fetch(request);
    const quotes = await response.json();

    SelectQuote(quotes["quotes"]);
}

function SelectQuote(quotes) {
    var random = Math.floor(Math.random() * Object.keys(quotes).length);
    document.getElementById("quote").innerHTML = "\"" + quotes[random]["quote"] + "\"";
    document.getElementById("author").innerHTML = quotes[random]["author"];
}



</script>