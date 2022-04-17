/*
* Called when the user changes the vision board name text box to check if they pressed enter or exceeded max chars
* @param event - the event
* @param input - the input that that the user is altering
*/
function NameChange(event, input) {
    if (event.key == 'enter') {
        input.parentNode.submit();
    } else if (input.value.length >= input.maxLength) {
        tata.warn('Max Characters Reached', 'Board name must not exceed ' + input.maxLength + ' characters.', {
            position: 'br'
        });
    }
}

/*
* Creates a new vision board' called when the user submits the vision board creation form
* @param e - the event
* @param form - the form that the user is submitting
*/
function AddBoard(e, form) {
    e.preventDefault();
    var name = form.querySelector('#board-name');
    if (name.value != "" && name.value.length <= name.maxLength){
        // If name meets length requirements then add the vision board
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                tata.success('Vision Board Created', 'New: \'' + name.value + '\'', {
                    position: 'br'
                });
                name.value = "";
                DisplayBoards();
            }
        };
        request.open("POST", "assets/proc/add_vision_board_process.php", true);
        request.send(new FormData(form));
    } else if (name.value == "") {
        tata.error('Cannot Create Visionboard', 'Visionboard requires a name.', {
            position: 'br'
        });
    } else {
        tata.error('Cannot Create Visionboard', 'Visionboard name must not exceed ' + name.maxLength + ' characters.', {
            position: 'br'
        });
    }
}

window.onload = function() {
    DisplayBoards();
}

/*
* Displays list of user's vision boards; called on page load
*/
function DisplayBoards() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            html = "";
            for (const [id, name] of Object.entries(response)) {
                html += "<tr class='board' id='board-" + id.replaceAll("'", "") + "'>";
                html +=     "<td class='name'>" + name + "</td>";
                html +=     "<td><a class='edit-button' onclick='return EditBoard(this);'><i class='fa fa-pencil-square' aria-hidden='true'></i></a></td>";
                html +=     "<td><a class='remove-button' onclick='return RemoveBoard(this);'><i class='fa fa-minus-circle' aria-hidden='true'></i></a></td>";
                html += "</tr>";
            }
            document.querySelector('table#list').innerHTML = html;
            thesePosts = response;
        }
    };
    request.open("POST", "assets/proc/retrieve_vision_boards_process.php", true);
    request.send();
}

/*
* Removes a vision board; called when user clicks remove button
* @param button - the button element the user clicked
*/
function RemoveBoard(button) {
    var board = button.closest('tr.board');
    var boardId = board.id.split("-")[1];
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var name = board.querySelector('td.name').innerHTML;
            DisplayBoards();
            tata.success('Vision Board Removed', 'Removed \'' + name + '\'', {
                position: 'br'
            });
        }
    };
    request.open("POST", "assets/proc/remove_vision_board_process.php?id=" + boardId, true);
    request.send();
}

/*
* Takes the user to the editing area for a selected vision board; called when user clicks edit button
* @param button - the button element the user clicked
*/
function EditBoard(button) {
    var boardId = button.closest('tr.board').id.split("-")[1];
    window.location.href = "visionboard.php?id=" + boardId;
}