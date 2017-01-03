/**
 * yooway.js
 */

class Colorization
{

    static left (tilId){
        console.log('id de la tuile :' + tilId);
        //place upside the rhe tilId
        $('#' + tilId).append("<div id='calque'></div>");
//color the background of calque div
        $('#calque').addClass('left').fadeIn('fast');
    }
}

class Connect
{
     static ajax (tilId, answer) {
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
             $(this).addClass('ontop');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                console.log(tilId + ' va à gauche');
                answer = 'left';
                //add green color on the til
                //TODO à terminer et à améliorer
                Colorization.left(tilId);

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


    //Liste
    $('#list').draggable({
        axis: 'y'
    })
});