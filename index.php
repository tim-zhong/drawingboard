<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
body{
	overflow: hidden;
	background: #333333;
}
*{
	font-family: sans-serif;
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
	/*display: none;*/
}
#saberid{
	position: fixed;
	top:10px;
	left:10px;
	font-size: 40px;
	color: #ffffff;
	text-transform: uppercase;
}
</style>
<!-- <span id="xlabel"></span><br/>
<span id="ylabel"></span><br/>
<span id="zlabel"></span><br/>
<span id="ilabel"></span><br/> -->
<div id="saberid"></div>
<div id="debug">
	<span id="alphalabel"></span><br/>
	<span id="betalabel"></span><br/>
	<span id="gammalabel"></span><br/>
</div>
<div id="sword-container">
	<img id="sword" src="lightsaber.png">
</div>

<script src="wss/wss.js"></script>
<script>

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'board');


</script>	
</body>
</html>
