jQuery(document).ready(function($) {
    $('.test').each(function(index, value) {
        $(this).html($(this).html().substring(0, 5)); // number of characters
    });
});


console.log("hello");