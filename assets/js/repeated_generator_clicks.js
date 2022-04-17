/*
 * Shows a message and animates it when the user clicks the generator button multiple times
 * @param counter - the number of times the user has clicked the button
*/
function MultipleClicks(counter) {
    if (counter == 2) {
        multiclick.classList.add('active');
    } else if (counter > 2) {
        if (counter == 3) {
            multiclick.classList.remove('active');
        }
        // Use jiggle class and ensure animation finishes
        multiclick.classList.remove('jiggle');
        void multiclick.offsetWidth;
        multiclick.classList.add('jiggle');
    }
}
