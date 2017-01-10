/**
 * yooway.js
 */

class Move {




    coloration(tilId, way) {



        let tilIdElmt = $('#' + tilId);
        //debug
        console.log('id de la tuile :' + tilId);
        //si la tuile est déjà coloré lors d'un changement de direction on efface
        // le calque et on laisse faire le reste
        if (this.way !== way){
            $('.calque').remove();
        }

        if (!$('#' + tilId + '> div').hasClass('calque')){
            tilIdElmt.append("<div class='calque'></div>");
            //color the background of calque div
            this.way = way;
            $('.calque').addClass(way).fadeIn('slow');
        }



    }
}

class Connect {
    static ajax(tilId, answer) {
        $.ajax({
            method: 'POST',
            url: 'scenario.php',
            data: {tilId: tilId, answer: answer},
            success: function (response) {
                console.log(response);
            }
        })
    }
}

let tilId;
let answer;


$(document).ready(function () {


    $('.til').draggable({
        axis: 'x',
        drag: function (event, ui) {
            let move = new Move();
            //catch name of til
            tilId = $(this).attr('id');
            //Met la tuile au dessus
            $(this).addClass('ontop');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                console.log(tilId + ' va à gauche');
                answer = 'left';
                //add green color on the til

                move.coloration(tilId, 'left');

            } else {
                console.log(tilId + 'va à droite');
                answer = 'right';
                move.coloration(tilId, 'right');

            }

        },
        stop: function () {
            Connect.ajax(tilId, answer);
            $('#' + tilId).fadeOut('slow');
        }
    });


    //Liste
    $('#list').draggable({
        axis: 'y'
    })
});