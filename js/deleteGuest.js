// hide a guest on the home page

// adds a listener to window.onload
$(document).ready(function() {
    $("button#delete").click(function() {
        // navigates to the table row
        var info = $(this).parent().parent().text();
        // reads text and split by spaces
        info = info.trim().split(" ");
        var id = info[0].trim();
        var name = info[20].trim() + " " + info[41].trim();
    });
});