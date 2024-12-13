$(document).ready(function () {

    // open logout dialog
    $("#logoutBtn").click(function () {
        $("#logoutDialog").fadeIn();
    });

    // close (cancel) button click to close dialog
    $("#cancelLogout").click(function () {
        $("#logoutDialog").fadeOut();
    });

    // click confirm button to log out and redirect back to login
    $("#confirmLogout").click(function () {
        window.location.href = "../index.html";
    });

    // open contact us dialog
    $("#openDialogBtn").click(function () {
        $("#contactDialog").addClass("open");
    });

    // close (cancel) button click to close contact us dialog
    $(".close").click(function () {
        $("#contactDialog").removeClass("open");
    });


    // click confirm contact us dialog button
    $("#contactForm").submit(function (event) {
        event.preventDefault(); // Prevent form submission

        alert("Form submitted successfully!");
        // Clear form fields
        this.reset();
        // Close the dialog
        $("#contactDialog").removeClass("open");
    });


    // static quotes list 
    const quotes = [
        "The only way to do great work is to love what you do. - Steve Jobs",
        "Success is not final, failure is not fatal: It is the courage to continue that counts. - Winston Churchill",
        "Innovation distinguishes between a leader and a follower. - Steve Jobs"
    ];


    // using this function random generate one index and using that index to suffle quotes
    function generateQuote() {
        const randomIndex = Math.floor(Math.random() * quotes.length);
        $('#quoteText').text(quotes[randomIndex].split('-')[0]);
        $('#author').text(quotes[randomIndex].split('-')[1]);
    }

    // click generate button to execute generateQuote funtion and suffle quotes
    $('#generateBtn').click(function () {
        generateQuote();
    });

    // Generate initial quote on page load
    generateQuote();


});

