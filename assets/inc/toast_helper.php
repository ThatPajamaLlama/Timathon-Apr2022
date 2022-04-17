<?php
/*
 * Display toast from session variable
 */
function handle_toast() {
    if (isset($_SESSION['toast'])) {
        $type = $_SESSION['toast']['type'];
        $header = $_SESSION['toast']['header'];
        $message = $_SESSION['toast']['message'];
        echo "<script type='text/javascript'>
            tata.$type('$header', '$message', {
                position: 'br'
            });
            </script>";
        unset($_SESSION['toast']);
    }
}

?>