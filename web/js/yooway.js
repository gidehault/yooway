/**
 * yooway.js
 */


var Connect = {
    ajax: function (question, answer) {
        $.ajax({
            method: 'POST',
            url: 'index.php',
            data: {question: question, answer: answer}
        })
    }
}

$(document).ready(function () {
    var tilId;
    var answer;
    $('.til').draggable({
        drag: function (event, ui) {
            //catch name of til
             tilId = $(this).attr('id');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                console.log(tilId + ' va à gauche');
                answer = 'left';

            } else {
                console.log(tilId + 'va à droite');
                answer = 'right';
            }

        },
        revert: true,
        stop: function(){
            Connect.ajax(tilId, answer);
        }
    });
});