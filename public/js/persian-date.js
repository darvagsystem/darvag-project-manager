/**
 * Persian Date Input Handler
 * Converts Persian date inputs to proper format for backend processing
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Persian date inputs
    initializePersianDateInputs();
});

function initializePersianDateInputs() {
    const persianDateInputs = document.querySelectorAll('.persian-date');

    persianDateInputs.forEach(input => {
        // Add input event listener for real-time formatting
        input.addEventListener('input', function() {
            formatPersianDateInput(this);
        });

        // Add blur event listener for final formatting
        input.addEventListener('blur', function() {
            formatPersianDateInput(this);
        });

        // Add keydown event listener for better UX
        input.addEventListener('keydown', function(e) {
            handlePersianDateKeydown(e, this);
        });
    });
}

function formatPersianDateInput(input) {
    let value = input.value.trim();

    if (!value) return;

    // Only clean up invalid characters, don't format while typing
    value = value.replace(/[^\d\/\:\s]/g, '');

    // Just update the value without aggressive formatting
    input.value = value;
}

function formatDatePart(dateStr) {
    if (!dateStr) return null;

    // Remove any non-numeric characters except /
    dateStr = dateStr.replace(/[^\d\/]/g, '');

    // Split by /
    const parts = dateStr.split('/').filter(part => part.length > 0);

    if (parts.length === 0) return null;

    // Format each part
    let year = parts[0] || '';
    let month = parts[1] || '';
    let day = parts[2] || '';

    // Only limit if user has finished typing (not while typing)
    // Don't limit while user is still typing

    // Build formatted date
    let formatted = year;
    if (month) {
        formatted += '/' + month;
    }
    if (day) {
        formatted += '/' + day;
    }

    return formatted;
}

function formatTimePart(timeStr) {
    if (!timeStr) return null;

    // Remove any non-numeric characters except :
    timeStr = timeStr.replace(/[^\d\:]/g, '');

    // Split by :
    const parts = timeStr.split(':').filter(part => part.length > 0);

    if (parts.length === 0) return null;

    let hour = parts[0] || '';
    let minute = parts[1] || '';
    let second = parts[2] || '';

    // Limit hour to 2 digits
    if (hour.length > 2) {
        hour = hour.substring(0, 2);
    }

    // Limit minute to 2 digits
    if (minute.length > 2) {
        minute = minute.substring(0, 2);
    }

    // Limit second to 2 digits
    if (second.length > 2) {
        second = second.substring(0, 2);
    }

    // Validate hour
    if (hour && parseInt(hour) > 23) {
        hour = '23';
    }

    // Validate minute
    if (minute && parseInt(minute) > 59) {
        minute = '59';
    }

    // Validate second
    if (second && parseInt(second) > 59) {
        second = '59';
    }

    // Build formatted time
    let formatted = hour;
    if (minute) {
        formatted += ':' + minute;
    }
    if (second) {
        formatted += ':' + second;
    }

    return formatted;
}

function handlePersianDateKeydown(e, input) {
    // Allow: backspace, delete, tab, escape, enter
    if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
        // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (e.keyCode === 65 && e.ctrlKey === true) ||
        (e.keyCode === 67 && e.ctrlKey === true) ||
        (e.keyCode === 86 && e.ctrlKey === true) ||
        (e.keyCode === 88 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        return;
    }

    // Allow numbers (0-9), slash (/), colon (:), and space
    const allowedKeys = [
        48, 49, 50, 51, 52, 53, 54, 55, 56, 57, // 0-9
        96, 97, 98, 99, 100, 101, 102, 103, 104, 105, // numpad 0-9
        191, // slash / (main keyboard)
        111, // slash / (numpad)
        186, // colon :
        32  // space
    ];

    // Also allow slash key (different key codes for different keyboards)
    if (e.key === '/' || e.key === ':') {
        return;
    }

    if (!allowedKeys.includes(e.keyCode)) {
        e.preventDefault();
    }
}

// Helper function to validate Persian date format
function isValidPersianDate(dateStr) {
    if (!dateStr) return false;

    const parts = dateStr.split('/');
    if (parts.length !== 3) return false;

    const year = parseInt(parts[0]);
    const month = parseInt(parts[1]);
    const day = parseInt(parts[2]);

    // Basic validation
    if (year < 1300 || year > 1500) return false;
    if (month < 1 || month > 12) return false;
    if (day < 1 || day > 31) return false;

    return true;
}

// Export functions for global use
window.PersianDateHandler = {
    formatInput: formatPersianDateInput,
    isValidDate: isValidPersianDate,
    initialize: initializePersianDateInputs
};
