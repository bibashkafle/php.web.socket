<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8' />
<style type="text/css">
<!--
.chat_wrapper {
	width: 500px;
	margin-right: auto;
	margin-left: auto;
	background: #CCCCCC;
	border: 1px solid #999999;
	padding: 10px;
	font: 12px 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.chat_wrapper .message_box {
	background: #FFFFFF;
	height: 150px;
	overflow: auto;
	padding: 10px;
	border: 1px solid #999999;
}
.chat_wrapper .panel input{
	padding: 2px 2px 2px 5px;
}
.system_msg{color: #BDBDBD;font-style: italic;}
.user_name{font-weight:bold;}
.user_message{color: #88B6E0;}
-->
</style>
</head>
<body>	

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<script language="javascript" type="text/javascript"> 

$(document).ready(function(){

	//var ws = new WebSocket("ws://10.7.1.83:8082");
	var ws = new WebSocket("ws://10.1.1.115:8082");
     ws.onopen = function(evt)
     {
     	$('#message_box').append("<div class=\"system_msg\">Welcome!</div>");
     };
     ws.onmessage = function (evt) 
     { 
        var received_msg = evt.data;
        var data = JSON.parse(received_msg);
        if(data.status=="0")
        {

        	if( data.name != undefined  && data.message != undefined && data.name!="" && data.message!="")
        	{
        		$('#message_box').append("<div><span class=\"user_name\" style=\"color:#4285F4\">"+data.name+"</span> : <span class=\"user_message\">"+data.message+"</span></div>");
        	}
        }       
     };
     ws.onclose = function()
     { 
        $('#message_box').append("<div class=\"system_msg\">Thank You!</div>");
     };

	$('#send-btn').click(function(){ //use clicks message send button	
		var mymessage = $('#message').val(); //get message text
		var myname = $('#name').val(); //get user name
		$('#message').val("");
		if(myname == ""){ //empty name?
			alert("Enter your Name please!");
			return;
		}
		if(mymessage == ""){ //emtpy message?
			alert("Enter Some message Please!");
			return;
		}		
		//prepare json data
		var msg = {
			name: myname,
			message: mymessage
		};

		ws.send(JSON.stringify(msg));
	});
});
</script>
<div class="chat_wrapper">
<div class="message_box" id="message_box"></div>
<div class="panel">
<input type="text" name="name" id="name" placeholder="Your Name" maxlength="10" style="width:20%"  />
<input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:60%" />
<button id="send-btn">Send</button>
</div>
</div>

</body>
</html>