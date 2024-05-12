/**
 * Get the element with id 'scroll_top' and assign it to the variable scroll_top.
 * @type {HTMLElement}
 */
let scroll_top = document.getElementById('scroll_top');

/**
 * An event listener that triggers when the user scrolls the window.
 * It checks the scroll position from the top of the document (body or html element).
 * If the scroll position is more than 20, it displays the 'scroll_top' element, otherwise it hides it.
 */
window.onscroll = function() {
    /**
     * Get the scroll position from the top of the document.
     * @type {number}
     */
    const scrollButton = document.body.scrollTop || document.documentElement.scrollTop;

    // Display the 'scroll_top' element if the scroll position is more than 20, otherwise hide it.
    scroll_top.style.display = (scrollButton > 20) ? 'block' : 'none';
};

/**
 * An event listener that triggers when the user clicks on the 'scroll_top' element.
 * It scrolls the document (body or html element) to the top.
 */
scroll_top.onclick = function() {
    // Scroll the body element to the top.
    document.body.scrollTop = 0;

    // Scroll the html element to the top.
    document.documentElement.scrollTop = 0;
}
