/**
 * yooway.js
 */

class Move {

    static coloration(tilId, way) {

        let tilIdElmt = $('#' + tilId);
        console.log('id de la tuile :' + tilId);
        //plif ()
        if (!$('#' + tilId + '> div').hasClass('calque')){
            tilIdElmt.append("<div class='calque'></div>");
            //color the background of calque div
            $('.calque').addClass(way).fadeIn('slow');
        }



    }
}

class Connect {
    static ajax(tilId, answer) {
        $.ajax({
            method: 'POST',
            url: 'scenario.php',
            data: {tilId: tilId, answer: answer}
        })
    }
}

let tilId;
let answer;


$(document).ready(function () {


    $('.til').draggable({
        axis: 'x',
        drag: function (event, ui) {
            //catch name of til
            tilId = $(this).attr('id');
            //Met la tuile au dessus
            $(this).addClass('ontop');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                console.log(tilId + ' va à gauche');
                answer = 'left';
                //add green color on the til

                Move.coloration(tilId, 'left');

            } else {
                console.log(tilId + 'va à droite');
                answer = 'right';
                Move.coloration(tilId, 'right');

            }

        },
        stop: function () {
            Connect.ajax(tilId, answer);
        }
    });


    //Liste
    $('#list').draggable({
        axis: 'y'
    })
});