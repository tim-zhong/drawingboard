<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
body{
	overflow: hidden;
	text-align: center;
	margin: 0;
	background: #000000;
}
*{
	font-size:40px;
}
#debug{
	position: fixed;
	top:0;
	left: 0;
	/*display: none;*/
}
#submit,#saberid{
	color:#ffffff;
	background: none;
	border:2px solid #ffffff;
	padding: 20px;
	font-size:50px;
}
#handle,#handleopened{
	position: fixed;
	left:0;
	top:0;
	width:110%;
}
#saberform{
	left:10px;
	top:10px;
	position: fixed;
}
</style>
<img id="handleopened" src="handleopen.png">
<img id="handle" src="handle.png">
<!-- <span id="xlabel"></span><br/>
<span id="ylabel"></span><br/>
<span id="zlabel"></span><br/>
<span id="ilabel"></span><br/> -->
<div id="debug">
	<span id="alphalabel"></span><br/>
	<span id="betalabel"></span><br/>
	<span id="gammalabel"></span><br/>
</div>


<form onsubmit="getsaber(document.getElementById('saberid').value); return false;" id="saberform">
	<input id="saberid">
	<input id="submit" type="submit" value="Connect">
</form>

<script src="../wss/wss.js"></script>


<script>
var debug = 1;

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9696";
socket = wssconnect(socket,url,'owner');
var connected = 0;

if (window.DeviceMotionEvent==undefined || window.DeviceMotionEvent && !debug) {
	// Don't support
} 
else {			
	window.ondeviceorientation = function(event) {
		alpha = Math.round(event.alpha);
		beta = Math.round(event.beta);
		gamma = Math.round(event.gamma);
		if(connected){
			sendmotionstate(socket,alpha,beta,gamma);
		}
	}				
}
</script>	
</body>
</html>
