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
                                <textarea id="post" name="post" placeholder="How did you make today a little less ordinary?" onkeyup="PostChange(event, this);" maxLength="255"></textarea>
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
                    form.querySelector('#post').value = "";
                    UpdatePosts();
                    tata.success('Created Post', 'Thanks for sharing!', {
                        position: 'br'
                    });
                }
            };
            request.open("POST", "assets/proc/create_post_process.php", true);
            request.send(new FormData(form));
        } else {
            tata.error('Cannot Create Post', 'Contents of post must not be blank.', {
                position: 'br'
            });
        }  
    }

    function PostChange(event, input) {
        var max = input.maxLength;
        if (input.value.length >= max) {
            tata.warn('Max Characters Reached', 'Post must not exceed ' + max + ' characters.', {
                position: 'br'
            });
        }
    }

    function PostLike(link) {
        var postId = link.closest('.post').id.split("-")[1];
        var button = link.closest('table.likes');
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                UpdatePosts();
            }
        };
        var data = new FormData();
        data.append("postId", postId);
        data.append("process", (button.classList.contains('active') ? "unlike" : "like"));
        request.open("POST", "assets/proc/post_like_process.php", true);
        request.send(data);
    }

    function CreateComment(e, input) {
        if (e.key == "Enter"){
            input.value = "";
            text = input.value.replace(/(\r\n|\n|\r)/gm, "");
            if (text == "") {
                tata.error('Cannot Create Comment', 'Contents of comment must not be blank.', {
                    position: 'br'
                });
            } else {
                var postId = input.parentNode.parentNode.id.split("-")[1];

                var request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        
                        UpdatePosts();
                        tata.success('Posted Comment', 'Wahoo - supporting others!', {
                            position: 'br'
                        });
                    }
                };

                var data = new FormData();
                data.append("postId", postId);
                data.append("comment", input.value);
                request.open("POST", "assets/proc/create_comment_process.php", true);
                request.send(data);
            }
        } else {
            input.style.height = input.scrollHeight+'px';
            if (input.value.length >= input.maxLength) {
                tata.warn('Max Characters Reached', 'Comment must not exceed ' + input.maxLength + ' characters.', {
                    position: 'br'
                });
            }
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
                    html += "<table class='likes" + (details['userliked'] == 1 ? " active" : "") + "'>";
                    html += "<tr>";
                    html += "<td><a onclick='return PostLike(this);'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a></td>";
                    html += "<td><span>" + details['likes'] + "</span></td>";
                    html += "</tr>";
                    html += "</table>";
                    html +=    "</div>";
                    html +=    "</div>";
                    html +=    "<div class='comments'>";
                    html +=    "<textarea name='comment' rows='1' placeholder='Write a comment...' onkeyup='CreateComment(event, this);' maxLength='255'></textarea>";
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
                        }
                        if (JSON.stringify(details['comments']) !== JSON.stringify(lastPosts[id]['comments'])){
                            ChangeComments(id, details['comments'], lastPosts[id]['comments']);
                        }
                        if (JSON.stringify(details['likes']) !== JSON.stringify(lastPosts[id]['likes'])){
                            ChangeLikes(id, details['likes'], details['userliked']);
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
    }

    function ChangeLikes(postId, numberOfLikes, userLiked) {
        var post = document.querySelector("#post-" + postId.replaceAll("'", ""));
        var likeBox = post.querySelector('table.likes');
        if (likeBox.classList.contains('active') && userLiked == 0) {
            likeBox.classList.remove('active');
        } else if (!likeBox.classList.contains('active') && userLiked == 1) {
            likeBox.classList.add('active');
        }

        likeBox.querySelector('span').innerHTML = numberOfLikes;
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
        html += "<table class='likes" + (details['userliked'] == 1 ? " active" : "") + "'>";
        html += "<tr>";
        html += "<td><a onclick='return PostLike(this);'><i class='fa fa-thumbs-up' aria-hidden='true'></i></a></td>";
        html += "<td><span>" + details['likes'] + "</span></td>";
        html += "</tr>";
        html += "</table>";
        html +=    "<div class='comments'>";
        html +=    "<textarea name='comment' rows='1' placeholder='Write a comment...'></textarea>";
        html +=    "</div>";
        newPost.innerHTML = html;

        var topPost = document.querySelectorAll(".post")[0];
        document.querySelector("#posts").insertBefore(newPost, topPost);
    }
</script>