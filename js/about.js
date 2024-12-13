// JavaScript function to display rollover images after one second
const displayRolloverImages = () => {
    setTimeout(() => {
        // Change the image source for rollover effect
        document.getElementById('images/deer.jpg').src = 'images/deer.jpg';
        document.getElementById('images/bison.jpg').src = 'images/bison.jpg';
        // Add more images as needed
    }, 1000); // 1000 milliseconds = 1 second
};

// Call the function when the page loads
window.onload = () => {
    displayRolloverImages();
};

// JavaScript function to restore original images after two seconds
const restoreOriginalImages = () => {
    setTimeout(() => {
        // Change the image source back to the original images
        document.getElementById('images/deer.jpg').src = 'images/release.jpg';
        document.getElementById('images/bison.jpg').src = 'images/hero.jpg';
        // Add more images as needed
    }, 2000); // 2000 milliseconds = 2 seconds
};

// Call both functions when the page loads
window.onload = () => {
    displayRolloverImages();
    restoreOriginalImages();
};

document.addEventListener("DOMContentLoaded", () => {
    const images = document.querySelectorAll("#image_rollovers img");

    // process each img tag
    for (let image of images) {
        const oldURL = image.src;
        const newURL = image.id;

        // preload rollover image

        // set up event handlers for hovering an image
        image.addEventListener("mouseover", () => {
            image.src = newURL;
        });
        image.addEventListener("mouseout", () => {
            image.src = oldURL;
        });
    }
});