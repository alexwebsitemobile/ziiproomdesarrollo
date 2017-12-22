jQuery('input.allow-integer').keydown(function (e) {

    // Numbers
    if ((!e.ctrlKey || !e.shiftKey) && (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode >= 48 && e.keyCode <= 57)) {
        return;
    }

    // Del / Backspace / Arrows
    if ((!e.ctrlKey || !e.shiftKey) && (e.keyCode === 46 || e.keyCode === 8)) {
        return;
    }

    // Tab
    if ((!e.ctrlKey) && (e.keyCode === 9)) {
        return;
    }

    // Cut, Copy & Paste
    if ((e.ctrlKey) && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 88)) {
        return;
    }

    // Paste (alt)
    if ((e.shiftKey) && (e.keyCode === 45)) {
        return;
    }

    // Arrows
    if (e.keyCode >= 37 && e.keyCode <= 40) {
        return;
    }

    // Home && End
    if ((e.shiftKey) && (e.keyCode === 35 || e.keyCode === 36)) {
        return;
    }

    e.preventDefault();
});
