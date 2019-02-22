$(document).on('click', '.set', function () {
    let el = this;
    // let id = (el.parentNode).id;
    let id = el.id;
    let parent = el.parentNode;
    // let rowClass = parent.className;
    let rowClass = parent.parentNode.className;
    let admin;

    if (rowClass.includes("admin")) {
        admin = 1;
    }
    else {
        admin = 0;
    }

    $.ajax({
        url: '../../projekt/ajax/setAdmin2.php',
        type: 'POST',
        data: {setAdminId: id, setAdminAdmin: admin},
        success: function (response) {

            if (response < 3) {
                $('#' + id).closest('tr').fadeOut(100).fadeIn(250);

                let user_type;
                if (response == 1) {
                    user_type = "<button id='" + id + "' class='btn-primary set'>" +
                        "<span class='glyphicon glyphicon-star button-confirm yellow'></span>" +
                        "</button>";
                    $('#' + id).addClass("admin");

                } else {
                    user_type = "<button id='" + id + "' class='btn-primary set'>" +
                        "<span class='glyphicon glyphicon-user button-confirm gray'></span>" +
                        "</button>";

                    $('#' + id).removeClass("admin");
                }

                $('#' + id).children('td[data-target=user_type]').html(user_type);
                $('#' + id).addClass("green");

                setTimeout(function () {
                    $('#' + id).removeClass("green").fadeIn("slow");
                }, 300);

            } else {
                alert('Problem: ' + response);
            }
        }
    });
});
