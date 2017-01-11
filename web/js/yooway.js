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
    static ajax(prodRef, answer) {
        $.ajax({
            method: 'POST',
            url: 'scenario.php',
            data: {prodRef: prodRef, answer: answer},
            success: function (response) {
                console.log(response);
            }
        })
    }
}




$(document).ready(function () {
    let tilId; //id de la tuile
    let answer; //réponse donné par le sens du drag (vers la gauche : oui/j'aime, vers la droite: non/je n'aime pas
    let prodRef; //référence du produit concerné ou de la question

    $('.til').draggable({
        axis: 'x',
        drag: function (event, ui) {
            let move = new Move();
            //catch name of til
            tilId = $(this).attr('id');
            prodRef = $('#' +tilId + '>div').attr('id');
            //Met la tuile au dessus
            $(this).addClass('ontop');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                console.log(tilId + ' va à gauche, la ref est ' + prodRef);
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
            Connect.ajax(prodRef, answer);
            $('#' + tilId).fadeOut('slow');
        }
    });


    //Liste
    $('#list').draggable({
        axis: 'y'
    })
});