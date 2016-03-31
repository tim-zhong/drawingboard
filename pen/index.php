<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
</style>

<span id="alphalabel"></span><br/>
<span id="betalabel"></span><br/>
<span id="gammalabel"></span><br/>

<form onsubmit="getboard(document.getElementById('boardid').value); return false;" id="penform">
	<input id="boardid">
	<input id="submit" type="submit" value="Draw!">
</form>

<script src="../wss/wss.js"></script>


<script>

var debug = 1;

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
