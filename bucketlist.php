<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="peer-support" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            
        </main>

    </body>
</html>

<script>

var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            console.log(response);
        }
    };
    link = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?fields=formatted_address%2Cname%2Crating%2Copening_hours%2Cgeometry&input=mongolian&inputtype=textquery&locationbias=circle%3A2000%4047.6918452%2C-122.2226413&key="
    request.open("POST", link, true);
    request.send();
</script>