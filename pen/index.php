<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
body{
	margin:0;
	font-family:sans-serif;
	background: #666666;
	color:#ffffff;
	font-weight:300;
}
.row{
	width:100%;
	position:absolute;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	padding:30px 10px;
}
.fleft{float:left;}
.fright{float:right;}
.clear{clear:both;}
#penform{
	position:relative;
	background: #333333;
	padding: 50px 20px;
	border-bottom: 10px solid rgba(0,0,0,0.2);
	z-index:999;
}
#boardid{
	font-size:50px;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	border:2px solid #ffffff;
	padding:10px 20px;
	background:rgba(0,0,0,0.5);
	color:#ffffff;
	outline:none;
	text-align: center;
	font-weight:300;
}
#submit{
	border:2px solid #ffffff;
	font-size:50px;
	height:100%;
	padding:10px 40px;
	background: #ffffff;
	color:#333333;
}
.button{
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	border-radius:50%;
	background:#004400;
	width:300px;
	height:300px;
	font-size:40px;
	padding-top:125px;
	margin:50px auto;
	box-shadow: 5px 5px 10px #000600;
}
#functionality{text-align:center;padding-top:0;}
#functionality_inner{
	width:90%; background:#cccccc; margin:0 5%; padding: 50px 10px;border-right: 5px solid #222222;border-bottom: 5px solid #222222;top:-900px;position:relative;
	-webkit-transition:top 250ms;
	-moz-transition:top 250ms;
	-0-transition:top 250ms;
	transition:top 250ms;
}
</style>

<div id="penform" class="row">
	<input id="boardid" class="fleft" placeholder="Board ID">
	<div id="submit" class="fleft" onclick="getboard(document.getElementById('boardid').value); return false;">DRAW</div>
	<div class="clear"></div>
</div>

<div class="row" id="functionality">
	<div id="functionality_inner">
		<div id="cali" onclick="callibrate();" class="button">Callibrate</div>
		<div id="cali" onclick="clearboard();" class="button">Clear Board</div>
	</div>
</div>

<script src="../wss/wss.js"></script>


<script>

var debug = 1;
var bid;
var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'pen');
var connected = 0;

if (window.DeviceMotionEvent==undefined || window.DeviceMotionEvent && 0) {
	// Don't support
	alert("Don't Support");
} 
else {	
	var ax;
	var ay;
	var az;
	var arAlpha;
	var arBeta;
	var arGamma;
	var alpha;
	var beta;
	var gamma;
	window.ondevicemotion = function(event) {
		ax = Math.round(event.acceleration.x * 1);
		ay = Math.round(event.acceleration.y * 1);
		az = Math.round(event.acceleration.z * 1);		
		//ai = Math.round(event.interval * 100) / 100;
		var rR = event.rotationRate;
		if (rR != null) {
			arAlpha = Math.round(rR.alpha);
			arBeta = Math.round(rR.beta);
			arGamma = Math.round(rR.gamma);
		}
		if(connected){
			sendphonedata(socket,ax,ay,az,arAlpha,arBeta,arGamma,alpha,beta,gamma);
		}			
	}
					
	window.ondeviceorientation = function(event) {
		alpha = Math.round(event.alpha);
		beta = Math.round(event.beta);
		gamma = Math.round(event.gamma);
	}	


	window.ondeviceorientation = function(event) {
		alpha = Math.round(event.alpha);
		beta = Math.round(event.beta);
		gamma = Math.round(event.gamma);
		if(connected){
			sendphonedata(socket,ax,ay,az,arAlpha,arBeta,arGamma,alpha,beta,gamma);
		}
	}		
}

</script>	
</body>
</html>
