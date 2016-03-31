<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
span{font-size:40px;}
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

<script src="wss/wss.js"></script>
<script>

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'board');

</script>	
</body>
</html>
