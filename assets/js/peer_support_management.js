var lastPosts = [];
var thesePosts = [];

window.onload = function() {
    DisplayPosts();
    setInterval(UpdatePosts, 1000);
}

/*
* Creates a new post based on form inputs; called when new-post form submitted
* @param event - the event
* @param form - the form being submitted
*/
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

/*
* Checks length in accordance with maxlength every time the new-post textarea is changed
* @param event - the event
* @param input - the input being changed
*/
function PostChange(event, input) {
    var max = input.maxLength;
    if (input.value.length >= max) {
        tata.warn('Max Characters Reached', 'Post must not exceed ' + max + ' characters.', {
            position: 'br'
        });
    }
}


/*
* Likes or unlikes a post depending on current status; called when user clicks like button
* @param link - the anchor tag (like button) the user clicked
*/
function PostLike(link) {
    var postId = link.closest('.post').id.split("-")[1];
    var button = link.closest('table.likes');

    // Like post and update post to reflect new like
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


/*
* Creates a new comment based on comment input box; called when user alters text in comment textbox
* @param event - the event
* @param input - the input box being altered
*/
function CreateComment(e, input) {
    // If the user presses enter, add the comment, provided that it is not blank
    if (e.key == "Enter"){
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
        input.value = "";
    } else {
        // Adjust the height to ensure all text is visible, and also checkthey are not meeting max characters
        input.style.height = input.scrollHeight+'px';
        if (input.value.length >= input.maxLength) {
            tata.warn('Max Characters Reached', 'Comment must not exceed ' + input.maxLength + ' characters.', {
                position: 'br'
            });
        }
    }
}

/*
* Displays all posts; called when the page is first loaded
*/
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

/*
* Ensures post information is up to date; called once per second, and once every change
*/
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

/*
* Updates the timeago shown for a post; called from UpdatePosts() when timeago has changed
* @param postId - the ID of the post which timeago has changed for
* @param newTimeago - the new value for time ago, showing how long ago the post was made
*/
function ChangeTimeago(postId, newTimeago) {
    var post = document.querySelector("#post-" + postId.replaceAll("'", ""));
    post.querySelector('span.timeago').innerHTML = newTimeago;
}

/*
* Updates the comments shown for a post; called from UpdatePosts() when the comments have changed
* @param postId - the ID of the post which the comments have changed for
* @param comments - up-to-date array containing all comments with full details
* @param oldComments - outdatesd array containing all comments with full details
*/
function ChangeComments(postId, comments, oldComments) {
    var commentSection = document.querySelector("#post-" + postId.replaceAll("'", "") + " .comments");

    // Loop through all comments
    for (const [id, details] of Object.entries(comments)) { 
        if (oldComments[id] === undefined) {
            // If comment is new, add it to the comment section
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
            // If comment is old, but timeago has changed then update this
            var comment = commentSection.querySelector("#comment-" + id.replaceAll("'", ""));
            comment.querySelector('span.timeago').innerHTML = details['timeago'];
        }
    }
}

/*
* Updates the likes counter for a post; called from UpdatePosts() when likes have changed
* @param postId - the ID of the post which the likes have changed for
* @param numberOfLikes - the number of likes that the post has
* @param userLiked - whether or not the user is one of the post's likers (1 for yes, 0 for no)
*/
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

/*
* Displays a post that is not yet loaded on the page; called from UpdatePosts() when someone has made a new post
* @param id - the ID of the new post
* @param details - array containing all details of the new post including username, timeago, timestamp etc.
*/
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

    // Show the post at the top so most recent is shown first
    var topPost = document.querySelectorAll(".post")[0];
    document.querySelector("#posts").insertBefore(newPost, topPost);
}