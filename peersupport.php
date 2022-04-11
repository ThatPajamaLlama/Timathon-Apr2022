<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="peer-support" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <section id="new-post">
                <form onsubmit="return CreatePost(event, this);" method="post">
                    <div class="flex-container">
                        <textarea id="post" name="post" placeholder="How did you make today a little less ordinary?"></textarea>
                        <button type="submit"><i class="fa fa-share-square-o" aria-hidden="true"></i>Share</button>
                    </div>
                </form>
            </section>
            <section id="posts">
                <!-- Shows all posts from all users -->
                <article id="post-12" class="post">
                    <h1 class="user">MyNameIsShannon</h1>
                    <div class="timestamp">
                        <h2><span class="timeago">2d</span> · <i class="fa fa-clock-o" aria-hidden="true"></i></h2>
                        <span class="timestamp-tooltip">Saturday, 9 April 2022 at 17:45</span>
                    </div>
                    <div class="text">
                        <p>I had something new for breakfast today - Waffles! Making the day different nice and early this morning...</p>
                    </div>
                    <div class="comments">
                        <textarea name="comment" rows="1" placeholder="Write a comment..."></textarea>
                        <div class="comment">
                            <div class="comment-header">
                                <h1 class="user">adam</h1>
                                <h2 class="timestamp"><span class="timeago">2d</span> · <i class="fa fa-clock-o" aria-hidden="true"></i><span class="timestamp-tooltip">Saturday, 9 April 2022 at 17:45</span></h2>
                            </div>
                            <p>Oooh you can't go wrong there! Perfect start to the perfect day.</p>
                        </div>
                        <div class="comment">
                            <div class="comment-header">
                                <h1 class="user">samantha_panther</h1>
                                <h2 class="timestamp"><span class="timeago">2d</span> · <i class="fa fa-clock-o" aria-hidden="true"></i><span class="timestamp-tooltip">Saturday, 9 April 2022 at 17:45</span></h2>
                            </div>
                            <p>You've just inspired me to make blueberry pancakes.</p>
                            <p>The dog will be upset to know that I won't be sharing my toast this morning though :(</p>
                        </div>
                        <div class="comment">
                            <div class="comment-header">
                                <h1 class="user">x_RickyRoo_x</h1>
                                <h2 class="timestamp"><span class="timeago">2d</span> · <i class="fa fa-clock-o" aria-hidden="true"></i><span class="timestamp-tooltip">Saturday, 9 April 2022 at 17:45</span></h2>
                            </div>
                            <p>Sharing is caring :D</p>
                        </div>
                    </div>
                </article>
            </section>
        </main>

    </body>
</html>

<script>

    var lastPosts = [];
    var thesePosts = [];

    window.onload = function() {
        // DisplayPosts();
        // setInterval(UpdatePosts, 1000);
    }

    function CreatePost(e, form) {
        e.preventDefault();
        if (form.querySelector('#post').value != ""){
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("Done");
                    form.querySelector('#post').value = "";
                    UpdatePosts();
                }
            };
            request.open("POST", "assets/proc/create_post_process.php", true);
            request.send(new FormData(form));
        }       
    }

    
    function DisplayPosts() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                html = "";
                for (const [id, details] of Object.entries(response)) {
                    html += "<article id='post-" + id.replaceAll("'", "") + "' class='post'>";
                    html +=    "<h1 class='user'>" + details['username'] + "</h1>";
                    html +=    "<div class='timestamp'>";
                    html +=         "<h2><span class='timeago'>" + details['timeago'] + "</span> &#183; <i class='fa fa-clock-o' aria-hidden='true'></i></h2>";
                    html +=         "<span class='timestamp-tooltip'>" + details['timestamp'] + "</span>";
                    html +=    "</div>";
                    html +=    "<div class='text'>";
                    details['text'].forEach(function(paragraph) {
                        html +=    "<p>" + paragraph + "</p>";
                    });     
                    html +=    "</div>";
                    html += "</article>";
                }                  
                document.querySelector('#posts').innerHTML = html;
                thesePosts = response;
            }
        };
        request.open("POST", "assets/proc/retrieve_posts_process.php", true);
        request.send();
    }


    function UpdatePosts() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                lastPosts = thesePosts;
                thesePosts = response;
                for (const [id, details] of Object.entries(thesePosts)) { 
                    if (lastPosts[id] !== undefined) {
                        if (JSON.stringify(details['timeago']) !== JSON.stringify(lastPosts[id]['timeago'])) {
                            ChangeTimeago(id, details['timeago']);
                        }
                    } else {
                        ShowNewPost(id, details);
                    }

                    
                }                  

            }
        };
        request.open("POST", "assets/proc/retrieve_posts_process.php", true);
        request.send();
    }

    function ChangeTimeago(postId, newTimeago) {
        var post = document.querySelector("#post-" + postId.replaceAll("'", ""));
        post.querySelector('span.timeago').innerHTML = newTimeago;
    }

    function ShowNewPost(id, details) {
        var newPost = document.createElement("article");
        newPost.setAttribute("id", "post-" + id.replaceAll("'", ""));
        newPost.setAttribute("class", "post");
        html = ""
        html +=    "<h1 class='user'>" + details['username'] + "</h1>";
        html +=    "<div class='timestamp'>";
        html +=         "<h2><span class='timeago'>" + details['timeago'] + "</span> &#183; <i class='fa fa-clock-o' aria-hidden='true'></i></h2>";
        html +=         "<span class='timestamp-tooltip'>" + details['timestamp'] + "</span>";
        html +=    "</div>";
        html +=    "<div class='text'>";
        details['text'].forEach(function(paragraph) {
            html +=    "<p>" + paragraph + "</p>";
        });     
        html +=    "</div>";
        newPost.innerHTML = html;

        var topPost = document.querySelectorAll(".post")[0];
        document.querySelector("#posts").insertBefore(newPost, topPost);
    }
</script>