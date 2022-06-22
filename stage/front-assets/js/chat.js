var chat_width;
var message_status = false;
var message_content;

$("#chat-button").click(function(){
	$(this).addClass("active");
	$("#page-container").css("padding-right",chat_width);
	$("#right-chat").css("width",chat_width);
	$("#right-chat").show();
	$(this).hide();
	$(".new-msg-badge").hide();

	$.ajax({
	    url:"/stage/get_message",
	    type:'post',
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    data: {},
	    success:function(req) {
	    	var data = JSON.parse(req);
	        var messages = ""; 
		    data.messages.forEach(function(msg){
		    	let message = "";
		    	var time = new Date(msg.created_at);
		    	time.setHours( time.getHours() - 3 );
		    	var mtime = time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })

		    	message += '<div class="msg">';
				message += '	<div class="msg-content">';
				message += '		<a href="#">'+getFT_name(msg.user_name)+'</a>'+msg.content;
				message += '	</div>';
				message += '	<div class="msg-time">';
				message += mtime;
				message += '	</div>';
				message += '</div>';

				messages = message + messages;
		    });
		    
		    $(".chat-content").html(messages);

		    var element = $(".chat-content")[0];
			element.scrollTop = element.scrollHeight;
	    },
	    error: function(ts) {
	        console.log(ts);
	    }
	});
});
$("#close-chat").click(function(){
	$("#right-chat").hide();
	$("#page-container").css("padding-right","0px");
	$("#chat-button").removeClass("active");
	$("#chat-button").show();
});
setChatWidth();
$(window).resize(function() {
  	setChatWidth();
});

function setChatWidth()
{
	var window_width = $(window).width();
  	if (window_width > 1700) chat_width = "400px";
  	else if (window_width > 1400) chat_width = "350px";
  	else if (window_width > 1100) chat_width = "300px";
  	else if (window_width > 800) chat_width = "250px";
  	else chat_width = "100%";

  	if ($("#chat-button").hasClass("active"))
  	{
	  	$("#page-container").css("padding-right",chat_width);
		$("#right-chat").css("width",chat_width);
	}
}
$("#open-emoti-list").click(function(){
	if ($(this).hasClass("active"))
	{
		$(".emo-list").hide();
		$(this).removeClass("active");
	}
	else
	{
		$(".emo-list").show();
		$(this).addClass("active");
	}
});
$(document).on("click", function(event){
    if($("#open-emoti-list").hasClass("active") && !$(event.target).closest(".emo-list").length && !$(event.target).closest("#open-emoti-list").length){
        $(".emo-list").hide();   
        $("#open-emoti-list").removeClass("active"); 
    }
});
$(".emo-list .emoji").click(function(){
	var emo = $(this).text();
	$("#message-input").val($("#message-input").val() + emo);
});
$("#message-down").click(function(){
	var element = $(".chat-content")[0];
 	element.scrollTop = element.scrollHeight;
});

$("#send").click(function(){
	if (!message_status)
	{
		sendMSG();
	}
});

$("#message-input").keyup(function(e) {
   var code = e.keyCode ? e.keyCode : e.which;
   if (code == 13) {  // Enter keycode
        if (!message_status)
		{
			sendMSG();
		}
   }
});
function onlySpaces(str) {
  return str.trim().length === 0;
}
function sendMSG()
{
	message_content = $("#message-input").val();
	if (message_content != null && !onlySpaces(message_content))
	{
		message_status = true;
		$("#message-input").val("");
		sendMessage();
	}
	else {
		console.log("empty");
	}
}
function sendMessage()
{
	$.ajax({
	    url:"/stage/send_message",
	    type:'post',
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    data: {message:message_content},
	    success:function(req) {
	        message_status = false;
	    },
	    error: function(ts) {
	        console.log(ts);
	    }
	});
}

var pusher = new Pusher('1a409bbea6ec2e3cb81a', {
  cluster: 'mt1',
  encrypted: true
});

var channel = pusher.subscribe('my-channel');
channel.bind('App\\Events\\SendMessage', getMessage);

function getFT_name(string)
{
	if (string.length < 10)
		return string;
	return string.slice(0,10)+"..";
}

function getMessage(data)
{
	if ($("#chat-button").hasClass("active"))
	{
		var messages = ""; 
	    data.message.messages.forEach(function(msg){
	    	let message = "";
	    	var time = new Date(msg.created_at);
	    	time.setHours( time.getHours() - 3 );
	    	var mtime = time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })

	    	message += '<div class="msg">';
			message += '	<div class="msg-content">';
			message += '		<a href="#">'+getFT_name(msg.user_name)+'</a>'+msg.content;
			message += '	</div>';
			message += '	<div class="msg-time">';
			message += mtime;
			message += '	</div>';
			message += '</div>';

			messages = message + messages;
	    });
	    
	    $(".chat-content").html(messages);

	    var element = $(".chat-content")[0];
		element.scrollTop = element.scrollHeight;
		
		$(".new-msg-badge").hide();
	}
	else
	{
		$(".new-msg-badge").show();
	}
}