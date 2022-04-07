<?php

session_start();
echo "<h1>You are logged in</h1>";
echo "<p>" . $_SESSION['username'] . "</p>";

?>


<script src="assets/js/tata.js"></script>
<script>
    tata.error("Login failed", "Incorrect password", {
        position: 'br'
    });
</script>