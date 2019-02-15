window.onload = start;

function reset() {
    $('.input').val('');
}

function start() {
    $("#resetBtn").bind("click", function () {
        reset();
    });
}
	
