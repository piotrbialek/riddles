function checkWin() {
    if (riddle === temporarySentence) {
        $("#image").fadeOut("slow", function () {
            $("#organize").fadeOut();
            $("#sentence").fadeOut();
            $("#info").fadeIn("slow");
            $("#buttonPlay").hide();

            levelCompleted = true;
            increaseLevel();
            $("#buttonPlay").val("Next level");

            gameWonSingleplayer(true);

        });
    }
    else if (wrongAttempts > 2) {

        $("#input").off("keyup");
        $("#buttonPlay").val("Try again");
        gameWonSingleplayer(false);
    }
}