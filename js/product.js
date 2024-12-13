$(document).ready(function() {
    // Preload images and captions
    console.log("Product page JavaScript loaded!");
    $('#image_list a').each(function() {
        var imageURL = $(this).attr('href');
        var caption = $(this).attr('title');
        $('<img>').attr('src', imageURL).attr('alt', caption).appendTo('#gallery').hide();
    });

    // Event handler for clicking on links
    $('#image_list a').click(function(evt) {
        evt.preventDefault(); // Cancel the default action of the link
        var imageURL = $(this).attr('href');
        var caption = $(this).attr('title');
        
        // Slide out current image and caption
        $('#image').slideUp(2000);
        $('#caption').slideUp(2000, function() {
            // Set new image and caption after sliding out
            $('#image').attr('src', imageURL).slideDown(2000);
            $('#caption').text(caption).slideDown(2000);
        });
    });

    // Move focus to the first link on page load
    $('#image_list a:first').focus();
});