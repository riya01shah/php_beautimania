// String : declare image folder base path
let basePath = "../img/";

$(document).ready(function () {
    // String :  assign image path to images variable
    let image1 = basePath + '1.jpg';
    let image2 = basePath + '2.jpg';
    let image3 = basePath + '3.jpg';

    // List : add images in lmagelist
    var imageList = [image1, image2, image3];

    // int : current image index
    var currentIndex = 0;

    //tag : initialize slideshow
    var slideshowContainer = $('.slideshow');


    //showNextImage suffle image (change image index and assign path)
    function showNextImage() {
        currentIndex = (currentIndex + 1) % imageList.length;
        slideshowContainer.css('background-image', 'url(img/' + imageList[currentIndex] + ')');

    }

    // Show first image
    showNextImage();

    // Start slideshow
    setInterval(showNextImage, 4000); // Change slide every 4 seconds

});

