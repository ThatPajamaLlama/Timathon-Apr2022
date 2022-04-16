<?php
session_start();

include "assets/inc/user_access_control.php";
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
                    <h1>What is a Bucket List?</h1>
                    <p>A bucket list is a list of experiences or achievements that you hope to accomplish during your lifetime.</p>
                    <p>Creating one is a great way to keep track of your aspirations, allowing you to focus on what you can do to achieve them.</p>
                    <h1>Your Progress</h1>
                    <p>You have completed <span id="completed">4</span> out of your <span id="total">5</span> bucket list items. <span id="message">What a great start!</span></p>
                    <div id="chart">
                        <canvas id="bucket-list-progress-canvas"></canvas>
                    </div>
                </section>
            </div>
        </main>

    </body>
</html>

<script src="assets/js/tata.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.js"></script>

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
            }
        };
        request.open("POST", "assets/proc/retrieve_bucket_list_process.php", true);
        request.send();

        DisplayProgress();
    }

    var myPiechart = null;
    const completeColour = "65, 242, 133";
    const incompleteColour = "255, 99, 132";
    const completedSpan = document.querySelector('#info span#completed');
    const totalSpan = document.querySelector('#info span#total');
    const messageSpan = document.querySelector('#info span#message');
    function DisplayProgress() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);

                const piechartArea = document.getElementById('bucket-list-progress-canvas').getContext('2d');

                var completedIndex = response['labels'].indexOf('Complete');
                var completed = 0;
                if (completedIndex != -1) {
                    completed = response['data'][completedIndex];
                }
                completedSpan.innerHTML = completed;

                var total = response['data'].reduce(function(a, b){
                    return a + b;
                }, 0);
                totalSpan.innerHTML = total;

                var message;
                if (total == 0 || completed == 0) {
                    message = "Let's get started!";
                } else if (total == completed) {
                    message = "Wow - amazing job!";
                } else if (completed/total > 0.5) {
                    message = "You're doing awesome!";
                } else if (completed/total > 0.25) {
                    message = "You're doing great!";
                } else {
                    message = "What a great start!";
                }
                messageSpan.innerHTML = message;

                if (myPiechart !== null) {
                    myPiechart.destroy();
                }

                var backgroundColours = [];
                var outlineColours = [];
                if (response['labels'].length == 1) {
                    if (response['labels'][0] == "Complete") {
                        backgroundColours.push("rgba(" + completeColour + ", 0.2)");
                        outlineColours.push("rgba(" + completeColour + ", 1.0)");
                    } else {
                        backgroundColours.push("rgba(" + incompleteColour + ", 0.2)");
                        outlineColours.push("rgba(" + incompleteColour + ", 1.0)");
                    }
                } else {
                    backgroundColours.push("rgba(" + completeColour + ", 0.2)");
                    outlineColours.push("rgba(" + completeColour + ", 1.0)");
                    backgroundColours.push("rgba(" + incompleteColour + ", 0.2)");
                    outlineColours.push("rgba(" + incompleteColour + ", 1.0)");
                }

                if (total > 0) {
                    myPiechart = new Chart(piechartArea, {
                        type: 'pie',
                        data: {
                            labels: response['labels'],
                            datasets: [{
                                label: 'Bucket list items',
                                data: response['data'],
                                backgroundColor: backgroundColours,
                                borderColor: outlineColours,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Completion Status'
                                }
                            }
                        }
                    });
                }
                
            }
        };
        request.open("POST", "assets/proc/retrieve_bucket_list_stats_process.php", true);
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