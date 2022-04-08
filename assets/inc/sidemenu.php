<header>
    <h1 id="logo">To the fullest</h1>
    <nav class="sidemenu">
        <ul>
            <li><a href="dash.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        </ul>
        <h2>Change Today</h2>
        <ul>
            <li><a href="stylegenerator.php"><i class="fa fa-paint-brush" aria-hidden="true"></i>Style Generator</a></li>
            <li><a href="activityrandomiser.php"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Activity Randomiser</a></li>
        </ul>
        <h2>Change Everyday</h2>
        <ul>
            <li><a href="visionboard.php"><i class="fa fa-thumb-tack" aria-hidden="true"></i>Vision Board</a></li>
            <li><a href="bucketlist.php"><i class="fa fa-list" aria-hidden="true"></i>Bucket List</a></li>
        </ul>
        <h2>Peer Support</h2>
        <ul>
            <li><a href="peersupport.php"><i class="fa fa-comment" aria-hidden="true"></i>Share with Others!</a></li>
        </ul>
        <h2>Account</h2>
        <ul>
            <li><a href="assets/proc/logout_process.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
        </ul>
    </nav>
</header>

<script>
    var currentPage = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
    document.querySelector('nav a[href^="' + currentPage + '"]').classList.add('active');
</script>