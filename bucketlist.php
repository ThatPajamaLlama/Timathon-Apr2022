<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="bucket-list" class="user-area flex-container">
        <?php include "assets/inc/sidemenu.php";?>
        
        <main>
            <div class="flex-container">
                <section id="editor">
                    <form class="flex-container" onsubmit="return AddItem(event, this);">
                        <input type="text" id="item" name="item" placeholder="Enter a new bucket list item..." onkeyup="if (event.key == 'enter') {this.parentNode.submit();}"/>
                        <button type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    </form>
                    <table id="list">
                        <!-- Filled in using JS -->
                    </table>
                </section>
                <section id="info">
                    <h1>Bucket List</h1>
                    <p>Creating a bucket list is a great way to keep track of your life's goals.</p>
                    <h1>Your Progress</h1>
                </section>
            </div>
        </main>

    </body>
</html>

<script src="assets/js/tata.js"></script>

<script>
    // First time display of list
    window.onload = function() {
        DisplayItems();
    }

    function DisplayItems() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                html = "";
                for (const [id, details] of Object.entries(response)) {
                    html += "<tr class='item' id='item-" + id.replaceAll("'", "") + "'>";
                    html +=     "<td><input type='checkbox'" + (details['completed'] == 1 ? "checked" : "") + " onchange='return ChangeCompletion(this);'/></td>";
                    html +=     "<td>" + details['item'] + "</td>";
                    html +=     "<td><a class='remove-button' onclick='return RemoveItem(this);'><i class='fa fa-minus-circle' aria-hidden='true'></i></a></td>";
                    html += "</tr>";
                }
                document.querySelector('table#list').innerHTML = html;
                thesePosts = response;
            }
        };
        request.open("POST", "assets/proc/retrieve_bucket_list_process.php", true);
        request.send();
    }

    function AddItem(e, form) {
        e.preventDefault();
        if (form.querySelector('#item').value != ""){
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    form.querySelector('#item').value = "";
                    DisplayItems();
                    tata.success('Bucket List Changed', 'New item added', {
                        position: 'br'
                    });
                }
            };
            request.open("POST", "assets/proc/add_bucket_list_item_process.php", true);
            request.send(new FormData(form));
        }       

    }

    function RemoveItem(button) {
        var itemId = button.closest('tr.item').id.split("-")[1];
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                DisplayItems();
                tata.success('Bucket List Changed', 'Item removed', {
                    position: 'br'
                });
            }
        };
        request.open("POST", "assets/proc/remove_bucket_list_item_process.php?id=" + itemId, true);
        request.send();
    }

    function ChangeCompletion(button) {
        var itemId = button.closest('tr.item').id.split("-")[1];
        var completionStatus = (button.checked ? 1 : 0);
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                DisplayItems();
                if (completionStatus == 1) { 
                    tata.success('Bucket List Changed', 'Activity marked as complete', {
                        position: 'br'
                    });
                } else {
                    tata.success('Bucket List Changed', 'Activity marked as incomplete', {
                        position: 'br'
                    });
                }
            }
        };
        var data = new FormData();
        data.append("id", itemId);
        data.append("complete", completionStatus);
        request.open("POST", "assets/proc/change_bucket_list_item_process.php", true);
        request.send(data);

    }


</script>