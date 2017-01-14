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
        if (this.way !== way) {
            $('.calque').remove();
        }

        if (!$('#' + tilId + '> div').hasClass('calque')) {
            tilIdElmt.append("<div class='calque'></div>");
            //color the background of calque div
            this.way = way;
            $('.calque').addClass(way).fadeIn('fast');
        }


    }
}
class Screen {
    /**
     * response contient l'id de til, le type de tuile(question, combo, produit), et le contenu
     * @param response
     */
    constructor(response) {
        this.scenario = JSON.parse(response);
        console.log(this.scenario);
    }

    display() {
        for (let key in this.scenario) {
            switch (this.scenario[key].type) {
                case 'produit':
                    console.log(this.scenario[key]);
                    $('#' + key).addClass('til').html(
                        '<div class="' + this.scenario[key].type + '">' +
                        '<img src="' + this.scenario[key].img + '" alt="illustration">' +
                        '<div class="price">' +
                        '<p>' + this.scenario[key].price + '</p>' +
                        '</div>' +
                        '<div class="answer like">' +
                        '<img src="img/left.png" alt="to the left">' +
                        "<div>J'aime</div>" +
                        "</div>" +
                        '<div class="answer dislike">' +
                        '<img src="img/right.png" alt="to the right">' +
                        "<div>Je n'aime pas</div>" +
                        "</div>" +
                        '</div>'
                    );
                    break;
                case 'list':
                    $('#' + key).addClass('til');
                    break;
                case 'yesNoQuestion':
                    $('#' + key).addClass('til');
                    break;

            }

        }


    }

    question() {
        let questionDivELmt = $('#' + this.scenario.til);

        $('#question').text(this.scenario.scenario);
        $('#' + this.scenario.til + ' div:first-child').attr('id', this.scenario.nextStep);
        // remet en place la til
        $('.calque').remove();
        questionDivELmt.css({top: 0, left: 0}).fadeIn('fast');

        if (this.scenario.action) {
            console.log('#' + this.scenario.action.til + ' #illustration');
            $('#' + this.scenario.action.til + '#illustration').attr('src', this.scenario.action.illustration)
        }
    }

}
class Connect {
    static ajax(prodRef, answer, tilId) {
        if (prodRef && answer && tilId) {
            $.ajax({
                method: 'POST',
                url: '/scenario',
                data: {prodRef: prodRef, answer: answer, tilId: tilId},
                success: function (response) {
                    let screen = new Screen(response)
                    screen.display();
                }
            })
        } else {
            $.ajax({
                method: 'POST',
                url: '/scenario',
                success: function (response) {
                    let screen = new Screen(response)
                    screen.display();
                }
            })
        }

    }
}
Connect.ajax();

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
            prodRef = $('#' + tilId + '>div').attr('id');
            //Met la tuile au dessus
            //$(this).addClass('ontop');
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
        handle: 'img, p, li',
        zIndex: 100,
        stop: function () {
            $('.calque').remove();
            $('#' + tilId).toggle('puff', function () {
                Connect.ajax(prodRef, answer, tilId);
            });


        }
    });


    //Liste
    $('#list').draggable({
        axis: 'y'
    })
});