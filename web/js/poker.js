$(document).ready(function(){
  	var clicked = "Nope.";
    var mausx = "0";
    var mausy = "0";
    var winx = "0";
    var winy = "0";
    var difx = mausx - winx;
    var dify = mausy - winy;

    $("html").mousemove(function (event) {
        mausx = event.pageX;
        mausy = event.pageY;

        if (clicked != "Nope.") {
            var dragDiv = $('#' + clicked);
            var newx = event.pageX - difx;
            var newy = event.pageY - dify;
            dragDiv.css({top: newy + 'px', left: newx + 'px'});
        }
    });

    $(".poker-list").mousedown(function (event) {
        clicked = $(this).attr('id');
        difx = event.pageX - $(this).offset().left;
        dify = event.pageY - $(this).offset().top;
    });

    $("html").mouseup(function (event) {
        clicked = "Nope.";
        difx = 0;
        dify = 0;
    });
});