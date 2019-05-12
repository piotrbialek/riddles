window.onload = start;

var wrong_attempts = 0;
var wrong_guesses = "";
var right_guesses = "";
var temporary_sentence = "";
var displayed_sentence = "";
var level_completed = false;

riddle = riddle.toUpperCase();
description = description.toUpperCase();
category = category.toUpperCase();

function drawLines() {
    for (let i = 0; i < riddle.length; i++) {
        if (riddle.charAt(i) === " ") {
            temporary_sentence = temporary_sentence + " ";
        }
        else {
            temporary_sentence = temporary_sentence + "_";
        }
    }
    displayed_sentence = temporary_sentence;
    showSentence();
}

function showSentence() {
    $("#sentence").html(displayed_sentence);
}

String.prototype.setLetter = function (place, sign) {
    if (place > this.length - 1) return this.toString();
    else return this.substr(0, place) + sign + this.substr(place + 1);
}

function checkLetterInSentence(input_letter) {
    let correct_letter = 0;

    for (let i = 0; i < riddle.length; i++) {
        let sentence_letter = riddle.charAt(i);

        if (sentence_letter === input_letter) {
            temporary_sentence = temporary_sentence.setLetter(i, input_letter);
            displayed_sentence = temporary_sentence;
            displayed_sentence = displayed_sentence.replace(
                new RegExp(sentence_letter, "g"),
                '<span class="l green hideLetter correctLetter">' + sentence_letter + '</span>'
            );
            setTimeout(function () {
                $(".l").fadeOut("fast", function () {
                    $(".l").removeClass("hideLetter").fadeIn("fast");
                });
            }, 100);
            correct_letter++;
        }
    }

    if (correct_letter > 0) {
        right_guesses += input_letter + " ";
        $("#rightGuesses").text(right_guesses);
        $("#sentence").removeClass("red");
        $("#sentence").addClass("gray");
        showSentence();

        $("#input").addClass("greenBlink");
        setTimeout(function () {
            $("#input").removeClass("greenBlink").fadeIn("slow");
        }, 200);
    }
    else {
        wrong_guesses += input_letter + " ";
        $("#wrongGuesses").text(wrong_guesses);
        $(".correctLetter").removeClass("green");
        $("#sentence").removeClass("gray");
        $("#sentence").addClass("red");

        $("#input").addClass("redBlink");
        setTimeout(function () {
            $("#input").removeClass("redBlink").fadeIn("slow");
        }, 200);

        wrong_attempts++;
        let img = "image/szubienica_img/img" + wrong_attempts + ".png";
        $("#image").fadeOut("fast", function () {
            $("#image").html('<img src="' + img + '" alt="hangerMan' + wrong_attempts + '" />');
            $("#image").fadeIn();
        });
    }
}

// checks if this particular letter has already been entered
function checkGuesses(letter) {
    let in_guesses = 0;
    let guesses = right_guesses.concat(wrong_guesses);
    for (let i = 0; i < guesses.length; i++) {
        if (guesses.charAt(i) === letter) {
            in_guesses++;
        }
    }
    return in_guesses;
}

function checkLetter() {
    let input_field = $("#input");
    if (input_field.val() === " "
        || input_field.val().length > 1
        || !isNaN(input_field.val())) // || $("#input").val() == "undefined"
    {
        $("#info").text("incorrect input");
        $("#input").val("");

        $("#input").addClass("blueBlink");
        setTimeout(function () {
            $("#input").removeClass("blueBlink").fadeIn("slow");
        }, 200);
    }
    else {
        let input_letter = input_field.val().toUpperCase();

        $("#info").text("");
        input_field.val("");

        if (checkGuesses(input_letter) === 0) {
            checkLetterInSentence(input_letter);
        }
        else {
            $("#info").html("repeated letter " + input_letter);
            $("#sentence").addClass("gray");
        }
        checkWin();
    }
}

function start() {
    $("#category, #description, #sentence, #image, #organize, #buttonNext, #buttonTryAgain").hide();

    $("#input").keypress(function (e) {
        let regex = new RegExp("^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ]{1}");
        let str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $("#sentence").html("");
    $("#sentence").addClass("gray");
    $("#info").text("");
    $("#rightGuesses").text(right_guesses);
    $("#wrongGuesses").text(wrong_guesses);
    $("#input").val("");

    var typed = new Typed("#category", {
        strings: ["CATEGORY", category],
        typeSpeed: 30,
        backSpeed: 30,
        onComplete: function (self) {
            var typed2 = new Typed("#description", {
                strings: [description],
                startDelay: 1000,
                typeSpeed: 30,
                onComplete: function (self) {
                    $("#image, #organize, #sentence").fadeIn();
                    $("#input").focus();
                }
            });
        }
    });

    $("#category").fadeIn("slow");
    $("#description").fadeIn("slow");
    drawLines();
//        let img = "image/transparent/wisielec0.png";
    let img = "image/szubienica_img/img0.png";
    $("#image").html('<img src="' + img + '" alt="hangerMan" />');

    $("#input").on("keyup", function (event) {
        checkLetter();
    });
}



