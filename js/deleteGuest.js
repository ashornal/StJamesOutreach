// hide a guest on the home page

// adds a listener to window.onload
$(document).ready(function() {
    $("p.text-warning").hide();

    $("button#delete").click(function() {
        // navigates to the table row
        var info = $(this).parent().parent().text();
        // reads text and split by spaces
        info = info.trim().split(" ");
        var newInfo = new Array();
        for (var i = 0; i < info.length; i++) {
            if (info[i] != " ") newInfo.push(info[i]);
        }
        console.log(newInfo);
        var id = info[0].trim();
        var name = info[20].trim() + " " + info[41].trim();
        var message = "Are you sure you want to delete " + name + " (#" + id + ")?";

        $("#deleteMessage").html(message);
        // delete the guest by id

        $("#confirmDelete").click(function() {
            var hideGuest = $.post('model/hideGuest.php', {id: id});

            // display success, then reload the page
            hideGuest.done(function () {
                $("p.text-warning").show();
                setTimeout(location.reload.bind(location), 1500);
            });
        });
    });
});