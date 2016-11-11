/**
 * 
 */

$(document).ready(function(){
  	$('.operate-area').on('click', '#close', function(event) {
  		event.preventDefault();
  		/* Act on the event */
  	})
  	.on('click', '#send', function(event) {
  		event.preventDefault();
  		var input = $('.form-control');
  		var inputVal = input.val();
  		input.val('');
  		$('#record-list').append('<li>' + inputVal + '</li>');
  	});;
});