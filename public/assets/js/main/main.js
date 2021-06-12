function $(selector, first = true) {
    if (first) {
        return document.querySelector(selector);
    } else {
        return document.querySelectorAll(selector);
    }
}
