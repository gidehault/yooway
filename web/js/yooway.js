/**
 * yooway.js
 */


var Connect = {
    ajax: function (tilId, answer) {
        $.ajax({
            method: 'POST',
            url: 'scenario.php',
            data: {tilId: tilId, answer: answer}
        })
    }
}

$(document).ready(function () {
    var tilId;
    var answer;
    $('.til').draggable({
        axis: 'x',
        drag: function (event, ui) {
            //catch name of til
             tilId = $(this).attr('id');
             $(this).addClass('ontop');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                console.log(tilId + ' va à gauche');
                answer = 'left';

            } else {
                console.log(tilId + 'va à droite');
                answer = 'right';
            }

        },
        stop: function(){
            $(this).fadeOut('fast');
            Connect.ajax(tilId, answer);
        }
    });

    $('#list').draggable({
        axis: 'y'
    })
});