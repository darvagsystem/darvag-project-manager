/**
 * Simple Persian Date Input Handler
 * Minimal interference with user input
 */

document.addEventListener('DOMContentLoaded', function() {
    initializePersianDateInputs();
});

function initializePersianDateInputs() {
    const persianDateInputs = document.querySelectorAll('.persian-date');

    persianDateInputs.forEach(input => {
        // Only add basic input cleaning
        input.addEventListener('input', function() {
            cleanPersianDateInput(this);
        });
    });
}

function cleanPersianDateInput(input) {
    let value = input.value;

    // Only remove invalid characters, keep everything else
    value = value.replace(/[^\d\/\:\s]/g, '');

    // Update the value
    input.value = value;
}

// Export for global use
window.PersianDateHandler = {
    cleanInput: cleanPersianDateInput,
    initialize: initializePersianDateInputs
};
