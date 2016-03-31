<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
span{font-size:40px;}

#test_square{display: block; position: absolute; top:100px; left:100px; background: #dedede; width:50px; height:50px;}
</style>
<span id="boardid"></span><br/>
<span id="ax"></span><br/>
<span id="ay"></span><br/>
<span id="az"></span><br/>
<span id="arAlpha"></span><br/>
<span id="arBeta"></span><br/>
<span id="arGamma"></span><br/>
<span id="alpha"></span><br/>
<span id="beta"></span><br/>
<span id="gamma"></span><br/>

<div id="test_square">
</div>

<script src="wss/wss.js"></script>
<script>
var originalalpha = 0;
var originalalphaset = 0;
var currentleft = 600;
var currenttop = 600;

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'board');

</script>	
</body>
</html>
