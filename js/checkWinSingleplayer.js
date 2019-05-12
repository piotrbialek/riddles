function checkWin() {
    if (riddle === temporary_sentence) {
        $("#image").fadeOut("slow", function () {
            $("#organize").fadeOut();
            $("#sentence").fadeOut();
            $("#info").fadeIn("slow");
            $("#buttonPlay").hide();

            level_completed = true;
            increaseLevel();
            $("#buttonPlay").val("Next level");

            gameWonSingleplayer(true);
        });
    }
    else if (wrong_attempts > 2) {
        $("#input").off("keyup");
        $("#buttonPlay").val("Try again");
        gameWonSingleplayer(false);
    }
}