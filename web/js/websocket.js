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
        var chatHtml = '<li class="self-send"><div class="chat-avatar"></div><div class="chat-content">' + inputVal + '</div></li>';
  		  $('#record-list').append(chatHtml);
        $('.chat-record').scrollTop($('.chat-record')[0].scrollHeight);
        // $('#record-list').children().last()[0].scrollIntoView();
  	});
});