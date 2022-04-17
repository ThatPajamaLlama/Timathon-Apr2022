/*
 * Check if input has reached max length to show a warning toast.
 * @param input - the input element to validate
 */
function LengthValidation(input) {   
    var max = input.maxLength;
    if (input.value.length >= max) {
        tata.warn('Max Characters Reached', input.placeholder + ' must not exceed ' + max + ' characters.', {
            position: 'br'
        });
    }
}