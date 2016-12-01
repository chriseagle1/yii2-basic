/**
 * 
 */

var source = '<li class="self-send">'
+    '<div class="chat-avatar"></div>'
+    '<div class="trangle"></div>'
+    '<div class="chat-content">{{tmplData}}</div>'
+    '<div style="clear:both;"></div>'
+ '</li>';

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
        if (inputVal !== '') {
            var chatRender = template.compile(source);
        
            $('#record-list').append(chatRender({tmplData: inputVal}));
            $('.chat-record').scrollTop($('.chat-record')[0].scrollHeight);
        } else {
            alert('发送内容不能为空');
        }
  	});
    $('.edit-area').on('keydown', '', function(event) {
        /* Act on the event */
        if (event.keyCode == 13) {
          event.preventDefault();
          $('#send').click();
        };
    });
});