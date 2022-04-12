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
            </section>
        </main>

    </body>
</html>

<script>

    var lastPosts = [];
    var thesePosts = [];

    window.onload = function() {
        DisplayPosts();
        setInterval(UpdatePosts, 1000);
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

    function CreateComment(e, input) {
        if (e.key == "Enter"){
            var postId = input.parentNode.parentNode.id.split("-")[1];

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    input.value = "";
                    UpdatePosts();
                }
            };

            var data = new FormData();
            data.append("postId", postId);
            data.append("comment", input.value);
            request.open("POST", "assets/proc/create_comment_process.php", true);
            request.send(data);
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
                    html +=    "</div>";
                    html +=    "<div class='comments'>";
                    html +=    "<textarea name='comment' rows='1' placeholder='Write a comment...' onkeyup='return CreateComment(event, this);'></textarea>";
                    for (const [commentId, comment] of Object.entries(details['comments'])) {
                        html +=    "<div id='comment-" + commentId.replaceAll("'", "") + "' class='comment'>";
                        html +=        "<h1 class='user'>" + comment['username'] + "</h1>";
                        html +=        "<div class='timestamp'>";
                        html +=            "<h2><span class='timeago'>" + comment['timeago'] + "</span> · <i class='fa fa-clock-o' aria-hidden='true'></i></h2>";
                        html +=            "<span class='timestamp-tooltip'>" + comment['timestamp'] + "</span>";
                        html +=        "</div>";
                        html +=        "<p>" + comment['text'] + "</p>";
                        html +=    "</div>";
                    }  
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
                        } else if (JSON.stringify(details['comments']) !== JSON.stringify(lastPosts[id]['comments'])){
                            ChangeComments(id, details['comments'], lastPosts[id]['comments']);
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

    function ChangeComments(postId, comments, oldComments) {
        var commentSection = document.querySelector("#post-" + postId.replaceAll("'", "") + " .comments");

        for (const [id, details] of Object.entries(comments)) { 
            if (oldComments[id] === undefined) {
                var newComment = document.createElement("div");
                newComment.setAttribute("id", "comment-" + id.replaceAll("'", ""));
                newComment.setAttribute("class", "comment");
                html =        "<h1 class='user'>" + details['username'] + "</h1>";
                html +=        "<div class='timestamp'>";
                html +=            "<h2><span class='timeago'>" + details['timeago'] + "</span> · <i class='fa fa-clock-o' aria-hidden='true'></i></h2>";
                html +=            "<span class='timestamp-tooltip'>" + details['timestamp'] + "</span>";
                html +=        "</div>";
                html +=        "<p>" + details['text'] + "</p>";
                newComment.innerHTML = html;
                commentSection.appendChild(newComment);
            } else if (details['timeago'] != oldComments[id]['timeago']) {
                var comment = commentSection.querySelector("#comment-" + id.replaceAll("'", ""));
                comment.querySelector('span.timeago').innerHTML = details['timeago'];
            }
        }

        // comments.forEach(function(comment) {
        //     console.log(oldComments);
        //     console.log(comments);
        //     if (comment in oldComments) {
        //         console.log("exists");
        //     } else {
        //         console.log("doesn't exist");
        //     }
        //     html +=    "<div class='comment'>";
        //     html +=        "<h1 class='user'>" + comment['username'] + "</h1>";
        //     html +=        "<div class='timestamp'>";
        //     html +=            "<h2><span class='timeago'>" + comment['timeago'] + "</span> · <i class='fa fa-clock-o' aria-hidden='true'></i></h2>";
        //     html +=            "<span class='timestamp-tooltip'>" + comment['timestamp'] + "</span>";
        //     html +=        "</div>";
        //     html +=        "<p>" + comment['text'] + "</p>";
        //     html +=    "</div>";
        // });  


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
        html +=    "<div class='comments'>";
        html +=    "<textarea name='comment' rows='1' placeholder='Write a comment...'></textarea>";
        html +=    "</div>";
        newPost.innerHTML = html;

        var topPost = document.querySelectorAll(".post")[0];
        document.querySelector("#posts").insertBefore(newPost, topPost);
    }
</script>