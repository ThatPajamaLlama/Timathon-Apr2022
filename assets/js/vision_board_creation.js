// Constants
const sizes = [24, 30, 35, 42];
const fonts = ["Arial", "Comic Sans MS", "Verdana", "Times New Roman", "Courier New", "serif", "sans-serif"];
const colours = ["#63ADF2", "#D52941", "#990D35", "#2D3047", "#FF9B71", "#1B998B", "#FF9F1C", "#99C24D", "#7F0799", "#1B264F"];
const canvas = document.querySelector('#board canvas');
const widths = [200, 250, 300, 350];

// Array of drawn objects on canvas
var drawnObjects = [];

/*
 * Draws the vision board in its entirety
 * @param form - the form DOM element
 * @param ctx - context for drawing to canvas
 */
function DrawBoard(form, ctx) {
    // Clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawnObjects = [];

    // Draw images
    var imageInputs = document.querySelector('#image-inputs');
    var images = imageInputs.querySelectorAll("input");
    for (image of images) {
        DrawImage(ctx, image.value);
    }

    // Draw text
    var textInputs = document.querySelector('#text-inputs');
    var texts = textInputs.querySelectorAll("input");
    for (text of texts) {
        DrawText(ctx, text.value);
    }

    console.log(drawnObjects);
}

/*
 * Draws a text element
 * @param ctx - context for drawing to canvas
 * @param text - the text to be drawn
 */
function DrawText(ctx, text) {
    // Randomise properties of the text object
    var selectedSize = GetRandomProperty(sizes);
    var selectedFont = GetRandomProperty(fonts);
    var selectedColour = GetRandomProperty(colours);
    ctx.font = selectedSize + "px " + selectedFont;
    ctx.fillStyle = selectedColour;

    // Get width and height for positioning purposes
    var sizing = ctx.measureText(text);
    var width = sizing.width;
    var height = sizing.actualBoundingBoxAscent + sizing.actualBoundingBoxDescent;

    // Ensure that placement is suitable (within Canvas window and not overlapping or behind other elements)
    var suitablePlacement = false;
    while (!suitablePlacement) {
        var selectedPosition = GetRandomXY();
        if (selectedPosition["x"] >= width * 1.5 &&
            selectedPosition["x"] + (width * 1.5) <= canvas.width &&
            selectedPosition["y"] >= height * 1.5 &&
            selectedPosition["y"] + (height * 1.5) <= canvas.height) {
            var actualX1 = selectedPosition["x"];
            var actualX2 = Math.floor(selectedPosition["x"] + width);
            var actualY1 = selectedPosition["y"];
            var actualY2 = Math.floor(selectedPosition["y"] + height);
            if (!ObjectIntersection(actualX1, actualX2, actualY1, actualY2)){
                suitablePlacement = true;
            }
        }
    }

    // Draw text to canvas
    ctx.fillText(text, selectedPosition["x"], selectedPosition["y"]);

    // Add full positioning details to drawnObjects array
    drawnObjects.push({
        "x1": actualX1,
        "x2": actualX2,
        "y1": actualY1,
        "y2": actualY2
    });
}

/*
 * Draws an image object
 * @param ctx - context for drawing to canvas
 * @param text - the path of the image
 */
function DrawImage(ctx, text) {
    var imgObj = new Image();

    imgObj.src = text;

    imgObj.onload = function() {
        // Set size
        var newWidth = GetRandomProperty(widths);
        var ratio = imgObj.width / newWidth;
        var newHeight = imgObj.height / ratio;

        // Ensure that placement is suitable (within Canvas window and not overlapping or behind other elements)
        var suitablePlacement = false;
        while (!suitablePlacement) {
            var selectedPosition = GetRandomXY();
            if (selectedPosition["x"] + newWidth <= canvas.width && selectedPosition["y"] + newHeight <= canvas.height) {
                if (!ObjectIntersection(selectedPosition["x"], selectedPosition["x"] + newWidth, selectedPosition["y"], selectedPosition["y"] + newHeight)){
                    suitablePlacement = true;
                }
            }
        }

        // Draw image to canvas
        ctx.drawImage(imgObj, selectedPosition["x"], selectedPosition["y"], newWidth, newHeight);

        // Add full positioning details to drawnObjects array
        drawnObjects.push({
            "x1": selectedPosition["x"],
            "x2": selectedPosition["x"] + newWidth,
            "y1": selectedPosition["y"],
            "y2": selectedPosition["y"] + newHeight
        });
    }
}

/*
 * Checks if the current object being drawn would intersect with another
 * @param x1 - The first X position of the new object
 * @param x2 - The second X position of the new object
 * @param y1 - The first Y position of the new object
 * @param y2 - The second Y position of the new object
 * @returns {bool} - whether or not the object intersects with another
 */
function ObjectIntersection(x1, x2, y1, y2) {
    for (object of drawnObjects){ 
        if (!(x1 >= object["x2"] || y1 >= object["y2"] || x2 <= object["x1"] || y2 <= object["y1"])){
            return true;
        }
    }
    return false;
}

/*
 * Gets random X and Y position within canvas
 */
function GetRandomXY() {
    var position = {
        "x": Math.floor(Math.random() * canvas.width),
        "y": Math.floor(Math.random() * canvas.height)
    }
    return position;
}

/*
 * Selects random property
 * @param options - array to select a property from
 */
function GetRandomProperty(options) {
    var selected = options[Math.floor(Math.random() * options.length)]
    return selected;
}

/*
 * Add an input box for the user to add another item to the vision board
 * @param type - "text" or "image" to signify input to add
 */
function AddInput(type) {
    var textInputs = document.querySelector('#text-inputs');
    var imageInputs = document.querySelector('#image-inputs');

    var actualInputs = type=="text" ? textInputs.querySelectorAll('input') : imageInputs.querySelectorAll('input')
    var lastInput = actualInputs[actualInputs.length - 1];
    var lastInt = parseInt(lastInput.id.split("-")[1]);

    if (type == "text") {
        var newText = document.createElement('input');
        newText.type = "text";
        newText.id = "text-" + (lastInt - 1);
        newText.placeholder = "Text";
        textInputs.appendChild(newText);
    } else {
        var newImage = document.createElement('input');
        newImage.type = "text";
        newImage.id = "image-" + (lastInt - 1);
        newImage.placeholder = "Image (Link)";
        imageInputs.appendChild(newImage);
    }
    

}