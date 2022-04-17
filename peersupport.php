<?php
session_start();
include "assets/inc/user_access_control.php";
?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="peer-support" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div class="flex-container">
                <div id="social">
                    <section id="new-post">
                        <form onsubmit="return CreatePost(event, this);" method="post">
                            <div class="flex-container">
                                <textarea id="post" name="post" placeholder="How did you make today a little less ordinary?" oninput="PostChange(event, this);" maxLength="255"></textarea>
                                <button type="submit"><i class="fa fa-share-square-o" aria-hidden="true"></i>Share</button>
                            </div>
                        </form>
                    </section>
                    <section id="posts">
                        <!-- Shows all posts from all users -->
                    </section>
                </div>
                <div id="info">
                    <h1>What is this?</h1>
                    <p>This is a sharing area where you'll find like-minded people sharing what they're doing to make everyday a little less ordinary.</p>
                    <p>We believe that <span class="site-name">to the fullest</span> is a community, which revolves around a shared mission. This sharing area is here so that the group can collectively inspire one another with ideas for how to enrich our daily lives.</p>
                </div>
            </div>
        </main>

    </body>
</html>

<script src="assets/js/tata.js"></script>

<script src="assets/js/peer_support_management.js"></script>