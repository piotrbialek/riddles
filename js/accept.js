$(document).on('click', '.accept', function(){
        let el = this;
        let id = el.id;
        let parent = el.parentNode;
        let rowClass = parent.parentNode.className;
        let accepted;

        if (rowClass.includes("notAccepted")) {
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

                    let acceptedBtn;
                    let spanClass;

                    if (response == 1) {
                        // acceptedBtn = "<button id='" + response + "' class='btn-primary'>" +
                        acceptedBtn = "<button id='" + id + "' class='btn-primary accept'>" +
                            "<span class='glyphicon glyphicon-ban-circle'></span>" +
                            "</button>";
                        $('#' + id).removeClass("notAccepted");
                        spanClass = "green";
                    } else {
                        // acceptedBtn = "<button id='" + response + "' class='btn-primary'>" +
                        acceptedBtn = "<button id='" + id + "' class='btn-primary accept'>" +
                            "<span class='glyphicon glyphicon-ok-circle'></span>" +
                            "</button>";
                        $('#' + id).addClass("notAccepted");
                        spanClass = "red";
                    }

                    $('#' + id).children('td[data-target=accepted]').html(acceptedBtn);
                    $('#' + id).children('td[data-target=accepted]').children().children().addClass(spanClass);

                    setTimeout(function () {
                        $('#' + id).children('td[data-target=accepted]').children().children().removeClass(spanClass).fadeIn("slow");
                    }, 600);

                } else {
                    alert('Problem: ' + response);
                }
            }
        });
    });
// });