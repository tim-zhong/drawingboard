<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
body{
	overflow: hidden;
}
*{
	font-size:100px;
}
#sword{
	position: absolute;
	-webkit-transform-origin: 50% 100%;
	-moz-transform-origin: 50% 100%;
	-o-transform-origin: 50% 100%;
	transform-origin: 50% 100%;
	height:600px;
	bottom: 0px;
	left:35%;
}
#sword-container{
	position: absolute;
	top:0;
	left: 100px;
	height:90%;
	width: 100%;
}
#debug{
	position: fixed;
	top:0;
	left: 0;
	display: none;
}
</style>
<!-- <span id="xlabel"></span><br/>
<span id="ylabel"></span><br/>
<span id="zlabel"></span><br/>
<span id="ilabel"></span><br/> -->
<div id="debug">
	<span id="alphalabel"></span><br/>
	<span id="betalabel"></span><br/>
	<span id="gammalabel"></span><br/>
</div>
<div id="sword-container">
	<img id="sword" src="lightsaber.png">
</div>
<script>
var x = 0;
var y = 0;
var z = 0;

// Speed - Velocity
var vx = 0;
var vy = 0;
var vz = 0;

// Acceleration
var ax = 0;
var ay = 0;
var az = 0;
var ai = 0;
var arAlpha = 0;
var arBeta = 0;
var arGamma = 0;

var delay = 100;
var vMultiplier = 0.01;			var alpha = 0;

var alpha = 0;
var beta = 0;
var gamma = 0;


if (window.DeviceMotionEvent==undefined) {
	document.getElementById("no").style.display="block";
	document.getElementById("yes").style.display="none";
} 
else {
	window.ondevicemotion = function(event) {
		ax = Math.round(event.accelerationIncludingGravity.x * 1);
		ay = Math.round(event.accelerationIncludingGravity.y * 1);
		az = Math.round(event.accelerationIncludingGravity.z * 1);
		ai = Math.round(event.interval * 100) / 100;
		rR = event.rotationRate;
		if (rR != null) {
			arAlpha = Math.round(rR.alpha);
			arBeta = Math.round(rR.beta);
			arGamma = Math.round(rR.gamma);
		}

/*					
		ax = Math.abs(event.acceleration.x * 1000);
		ay = Math.abs(event.acceleration.y * 1000);
		az = Math.abs(event.acceleration.z * 1000);		
*/				
	}
					
	window.ondeviceorientation = function(event) {
		alpha = Math.round(event.alpha);
		beta = Math.round(event.beta);
		gamma = Math.round(event.gamma);
	}				
	

	setInterval(function() {
		// document.getElementById("xlabel").innerHTML = "X: " + ax;
		// document.getElementById("ylabel").innerHTML = "Y: " + ay;
		// document.getElementById("zlabel").innerHTML = "Z: " + az;										
		// document.getElementById("ilabel").innerHTML = "I: " + ai;										
		// document.getElementById("arAlphaLabel").innerHTML = "arA: " + arAlpha;															
		// document.getElementById("arBetaLabel").innerHTML = "arB: " + arBeta;
		// document.getElementById("arGammaLabel").innerHTML = "arG: " + arGamma;																									
		document.getElementById("alphalabel").innerHTML = "Alpha: " + alpha;
		document.getElementById("betalabel").innerHTML = "Beta: " + beta;
		document.getElementById("gammalabel").innerHTML = "Gamma: " + gamma;

		var r = gamma/2.4;
		var h = 800+(beta*8);
		var rx = -beta;
		if(gamma>0||1){
			//document.getElementById('sword').style.transform = "rotate("+rotate+"deg) rotateY("+rotatez+"deg)";
			document.getElementById('sword').style.transform = "rotate("+r+"deg)";
			document.getElementById('sword').style.WebkitTransform = "rotate("+r+"deg)";
			document.getElementById('sword').style.MozTransform = "rotate("+r+"deg)";
			document.getElementById('sword').style.height = h+"px";
			//document.getElementById('sword').style.left = 50-((beta*5)/8)+"%";
		}
	}, delay);
} 
</script>	
</body>
</html>
