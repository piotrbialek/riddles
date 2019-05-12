$(document).on('click', '.accept', function () {
    let el = this;
    let id = el.id;
    let parent = el.parentNode;
    let row_class = parent.parentNode.className;
    let accepted;

    if (row_class.includes("notAccepted")) {
        accepted = 0;
    }
    else {
        accepted = 1;
    }

    $.ajax({
        url: '../../projekt/ajax/accept.php',
        type: 'POST',
        data: {id: id, accepted: accepted},
        success: function (response) {

            if (response < 3) {
                $('#' + id).closest('tr').fadeOut(100).fadeIn(250);

                let accepted_btn;
                let span_class;

                if (response == 1) {
                    accepted_btn = "<button id='" + id + "' class='btn-primary accept'>" +
                        "<span class='glyphicon glyphicon-ban-circle'></span>" +
                        "</button>";
                    $('#' + id).removeClass("notAccepted");
                    span_class = "green";
                } else {
                    accepted_btn = "<button id='" + id + "' class='btn-primary accept'>" +
                        "<span class='glyphicon glyphicon-ok-circle'></span>" +
                        "</button>";
                    $('#' + id).addClass("notAccepted");
                    span_class = "red";
                }

                $('#' + id).children('td[data-target=accepted]').html(accepted_btn);
                $('#' + id).children('td[data-target=accepted]').children().children().addClass(span_class);

                setTimeout(function () {
                    $('#' + id).children('td[data-target=accepted]').children().children().removeClass(span_class).fadeIn("slow");
                }, 600);
            } else {
                alert('Problem: ' + response);
            }
        }
    });
});
