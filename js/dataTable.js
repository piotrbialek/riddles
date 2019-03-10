$(document).ready(function () {
    $('#sorted-table').DataTable({
        responsive: true,
        searching:false,
        lengthChange: false,
        paging: false,
        info: false,
        order: [[0, "desc"]],
        language: {
            "emptyTable": "No data to display"
        }
    });
});