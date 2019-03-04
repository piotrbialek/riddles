function gameWonMultiplayer(result) {

    $(document).keypress(function (e) {
        if (e.which === 13) {
            window.location.href = "games.php";
        }
    });

    $("#buttonPlay").val("Back");

    $("#buttonPlay").bind("click", function () {
        window.location.href = "games.php";
    });

    $("#organize").fadeOut("slow", function () {
        $("#image").fadeOut("fast");
        $("#sentence").fadeOut();
        $("#info").fadeIn("slow");

        let info;


        if (result) {
            info = "<b>Congratulations!</b><br>Riddle correct:<br>" + riddle;
        }
        else {
            info = "Unfortunately, not this time!";
        }

        var typed3 = new Typed("#info", {
            strings: ["", info, "Click button or press enter to continue."],
            startDelay: 100,
            typeSpeed: 20,
            backSpeed: 10,
            loop: false,
            onComplete: function (self) {
                $("#buttons").removeClass("not_display");
                $("#buttonPlay").fadeIn("slow");
            }
        });
    });
}