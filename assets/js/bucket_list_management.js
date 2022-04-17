// First time display of list
window.onload = function() {
    DisplayItems();
}

/*
* Show all user's bucket list items
*/
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

// Variables and constants used to display progress (piechart and text)
var myPiechart = null;
const completeColour = "65, 242, 133";
const incompleteColour = "255, 99, 132";
const completedSpan = document.querySelector('#info span#completed');
const totalSpan = document.querySelector('#info span#total');
const messageSpan = document.querySelector('#info span#message');

/*
* Show the progress the user has made incl. pie chart and text
*/
function DisplayProgress() {
    // AJAX to obtain statistics on complete and incomplete bucket list items
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);

            const piechartArea = document.getElementById('bucket-list-progress-canvas').getContext('2d');

            // Show how many items the user has completed
            var completedIndex = response['labels'].indexOf('Complete');
            var completed = 0;
            if (completedIndex != -1) {
                completed = response['data'][completedIndex];
            }
            completedSpan.innerHTML = completed;

            // Count total number of bucket list items and display
            var total = response['data'].reduce(function(a, b){
                return a + b;
            }, 0);
            totalSpan.innerHTML = total;

            // Select and display appropriate message based on completion percentage
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

            // If piechart previously drawn, destroy it to replace with new.
            if (myPiechart !== null) {
                myPiechart.destroy();
            }

            // Select appropriate colours for complete and incomplete segments of piechart
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

            // If the user has bucket list items, show a piechart of complete and incomplete using Chart.JS
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

/*
* Called when user changes value of input box to show warning if about to exceed max characters
* @param event - the event
* @param input - the input element
*/
function ItemChange(event, input) {
    if (event.key == 'enter') {
        input.parentNode.submit();            
    } else if (input.value.length >= input.maxLength) {
        tata.warn('Max Characters Reached', 'Bucket list item must not exceed ' + input.maxLength + ' characters.', {
            position: 'br'
        });
    }
}

/*
* Called when user tries to add new item to bucket list to add it
* @param e - event
* @param form - the form element that has been submitted
*/
function AddItem(e, form) {
    e.preventDefault();

    // If user has not left item blank, then add it.
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
    } else {
        tata.error('Cannot Add Item', 'Item must not be left blank.', {
            position: 'br'
        });
    }  

}

/*
* Called when user tries to remove a bucket list item
* @param button - the button element the user clicked
*/
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

/*
* Called when user ticks/unticks a bucket list item to change its status
* @param button - the button element the user clicked
*/
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
