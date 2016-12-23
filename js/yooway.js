/**
 * yooway.js
 */

$(document).ready(function(){
	$('.til').draggable({
		drag: function( event, ui ) {
			//catch name of til
			var til = $(this).attr('id');
        if (ui.originalPosition.left > ui.position.left){
        	console.log(til + ' va à gauche');
			} else {
				console.log(til + 'va à droite');
			}
		
    }
	});
});