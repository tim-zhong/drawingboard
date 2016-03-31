<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
span{font-size:50px;}
</style>
<span id="boardid"></span><br/>
<span id="alphalabel"></span><br/>
<span id="betalabel"></span><br/>
<span id="gammalabel"></span><br/>

<script src="wss/wss.js"></script>
<script>

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'board');

</script>	
</body>
</html>
