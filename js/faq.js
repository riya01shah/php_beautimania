$(document).ready(() => {
    // Function to show answer when hovering over question
    $('#faq_rollovers li').on('mouseenter', function() {
       $(this).find('p').removeClass('hidden');
   });

   // Function to hide answer when mouse leaves question
   $('#faq_rollovers li').on('mouseleave', function() {
       $(this).find('p').addClass('hidden');
   });

}); 