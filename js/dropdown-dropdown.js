$(document).ready(function () {
    $('.dropdown-submenu a.drop-drop').on("click", function (e) {
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});