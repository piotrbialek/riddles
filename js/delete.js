$(document).ready(function () {
    $('.delete').click(function () {
        let el = this;
        let id = el.id;
        let row = $(el).closest('tr');

        $.ajax({
            url: '../../projekt/ajax/delete.php',
            type: 'POST',
            data: {id: id},
            success: function (response) {
                if (response == 1) {
                    row.addClass("red");
                    row.fadeOut(800, function () {
                        $(this).remove();
                    });
                } else {
                    alert('Problem: ' + response);
                }
            }
        });
    });
});


