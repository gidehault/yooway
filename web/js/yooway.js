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
        for (let til in this.scenario) {
            switch (this.scenario[til].type) {
                case 'wine':
                    $('#' + til).addClass('til').html(
                        '<div id="' + this.scenario[til].id + '"></div>' +
                        '<div id="type" class="' + this.scenario[til].type + '">' +
                        '<img src="' + this.scenario[til].img + '" alt="illustration">' +
                        '<div class="price">' +
                        '<p>' + this.scenario[til].price + '</p>' +
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
                    ).css({top: 0, left: 0}).fadeIn('fast');
                    break;
                case 'list':
                    let li = "";
                    for (let key in this.scenario[til].item) {
                        li += '<li class="list" id="'+ this.scenario[til].item[key] +'"><div>' + this.scenario[til].item[key] + '</div></li>'
                    }
                    $('#' + til).addClass('til select').html('<ul id="list">' + li + ' </ul>')
                    break;
                case 'questionWithChoice':
                    $('#' + til).addClass('til yooway-question').html(
                        '<div id="' + this.scenario[til].id + '"></div>' +
                        '<div id="type" class="' + this.scenario[til].type + '">' +
                        '<p>' + this.scenario[til].content + '</p>' +
                        '<div class="answer like">' +
                        '<img src="img/left.png" alt="to the left">' +
                        '<p>' + this.scenario[til].left + '</p>' +
                        '</div>' +
                        '<div class="answer dislike">' +
                        '<img src="img/right.png" alt="to the right">' +
                        '<p>' + this.scenario[til].right + '</p>' +
                        '</div>' +
                        '</div>'
                    ).css({top: 0, left: 0}).fadeIn('fast');
                    break;

                case 'yesNoQuestion':
                    $('#' + til).addClass('til yooway-question').html(
                        '<div id="' + this.scenario[til].id + '"></div>' +
                        '<div id="type" class="' + this.scenario[til].type + '">' +
                        '<p id="question">' + this.scenario[til].content + '</p>' +
                        '<div class="answer like">' +
                        '<img src="img/left.png" alt="to the left">' +
                        '<p>yes</p>' +
                        '</div>' +
                        '<div class="answer dislike">' +
                        '<img src="img/right.png" alt="to the right">' +
                        '<p>no</p>' +
                        '</div>' +
                        '</div>'
                    ).css({top: 0, left: 0}).fadeIn('fast');
                    break;

            }

        }


    }

}
class Connect {
    static ajax(type, nom, answer, tilId) {
        if (type && answer && tilId) {
            $.ajax({
                method: 'POST',
                url: '/scenario',
                data: {type: type, prodRef: nom, answer: answer, tilId: tilId, init: 0},
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

    static firstTime() {
        $.ajax({
            method: 'POST',
            url: '/scenario',
            data: 'init=1',
            success: function (response) {
                let screen = new Screen(response)
                screen.display();
            }
        })
    }


}

Connect.firstTime();

$(document).ready(function () {



    //Bouton hard reset Reset
    $('#row-3').after('<button id="reset">Reset</button>');
    $('#reset').click(function () {
        $.ajax({
            method: 'POST',
            url: '/scenario',
            data: 'reset=1',
            success: function () {
                alert("Hard Reset effectué")
            }
        })
    })

    $('.list').click(function(){
        console.log(this.id);
        let type = "selection"
        let answer = this.id;
        $.ajax({
            method: 'POST',
            url: '/scenario',
            data: {"answer": answer, "type": type},
            success: function(reponse){
                console.log('retour selection : ' +reponse)
            }

        })
    })
    //Drag des tuiles
    let tilId; //id de la tuile
    let answer; //réponse donné par le sens du drag (vers la gauche : oui/j'aime, vers la droite: non/je n'aime pas
    let prodRef; //nom du produit concerné ou de la question
    let type;
    let critere;


    $('.til').draggable({
        axis: 'x',
        drag: function (event, ui) {
            let move = new Move();
            //catch name of til
            tilId = $(this).attr('id');
            prodRef = $('#' + tilId + '>div').attr('id');
            type = $('#' + tilId + ' #type').attr('class');
            //Met la tuile au dessus
            //$(this).addClass('ontop');
            //Detecte la direction du drag
            if (ui.originalPosition.left > ui.position.left) {
                answer = 'left';
                //add green color on the til

                move.coloration(tilId, 'left');

            } else {
                answer = 'right';
                move.coloration(tilId, 'right');

            }

        },
        handle: 'img, p, li',
        zIndex: 100,
        stop: function () {
            $('.calque').remove();
            $('#' + tilId).toggle('puff', function () {
                Connect.ajax(type, prodRef, answer, tilId, critere);
            });


        }
    });


    //Liste
    $('#list').draggable({
        axis: 'y'
    })
});
