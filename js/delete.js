$(document).ready(function () {
    $('.delete').click(function () {
        let el = this;
        let id = el.id;
        let column = "riddles";
        let row = $(el).closest('tr');
        // AJAX Request
        $.ajax({
            url: '../../projekt/ajax/delete.php',
            type: 'POST',
            data: {id: id, columnName: column},
            success: function (response) {

                if (response == 1) {
                    // Remove row from HTML Table
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