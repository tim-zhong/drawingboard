var debug = 1;

function err(m){
	console.log('WebSockets Error: ' + m);
}

function msg(m){
	if(debug) console.log('Message: ' + m);
}


//socket is a defin
function wssconnect(socket,url,type){
	socket = new WebSocket(url);
	if(socket == undefined){
		err('parameter socket is not defined');
		return false;
	}
	if(url == "" || url == undefined){
		err('parameter url is invalid');
		return false;
	}
	if(!socket || socket == undefined){
		err('failed to create socket');
		return false;
	}


	socket.onopen = function(){
		msg('Open successfully');
		if(type == "board") registerboard(socket);
	}
	socket.onerror = function(){
		msg('Error occurs');
	}
	socket.onclose = function(){
		msg('Socket Closed');
	}
	socket.onmessage = function(e){
		if(e.data.indexOf('{')==-1) msg(e.data);
		else{
			var obj = JSON.parse(e.data);
			if(obj.to == "pen"&&obj.to==type){
				penprocess(obj);
			}
			else if(obj.to == "board"&&obj.to==type){
				boardprocess(obj);
			}
		}
	}
	return socket;
}

function registerboard(socket){
	if(!socket || socket == undefined){
		err('Fail to Register, No Available Socket');
		return false;
	}
	var obj = JSON.stringify({'type':"registerboard"});
	socket.send(obj);
}

function getboard(boardid){
	if(!socket || socket == undefined){
		err('Fail to Get Board , No Available Socket');
		return false;
	}
	var obj = JSON.stringify({'type':"getboard",'boardid':boardid.toLowerCase()});
	socket.send(obj);
}

function sendmotionstate(socket,a,b,g){
	if(!socket || socket == undefined){
		err('Fail to Get Lightsaber , No Available Socket');
		return false;
	}
	var obj = JSON.stringify({'type':"mstate",'a':a,'b':b,'g':g});
	socket.send(obj);
}

function sendphonedata(socket,ax,ay,az,arAlpha,arBeta,arGamma,alpha,beta,gamma){
	if(!socket || socket == undefined){
		err('Fail to Get Lightsaber , No Available Socket');
		return false;
	}
	var obj = JSON.stringify({
		'type':"phonestate",
		'ax':ax,
		'ay':ay,
		'az':az,
		'arAlpha':arAlpha,
		'arBeta':arBeta,
		'arGamma':arGamma,
		'alpha':alpha,
		'beta':beta,
		'gamma':gamma
	});
	socket.send(obj);
}

function boardprocess(obj){
	var cmd = obj.cmd;

	switch(cmd) {
		 case "upadtecoords":
			 //ax,ay,az,arAlpha,arBeta,arGamma,alpha,beta,gamma
		 	var ax = obj.ax;
		 	var ay = obj.ay;
		 	var az = obj.az;

		 	var arAlpha = obj.arAlpha;
		 	var arBeta = obj.arBeta;
		 	var arGamma = obj.arGamma;

		 	var alpha = obj.alpha;
		 	var beta = obj.beta;
		 	var gamma = obj.gamma;

	  		// document.getElementById("alphalabel").innerHTML = "Alpha: " + alpha;
			// document.getElementById("betalabel").innerHTML = "Beta: " + beta;
			// document.getElementById("gammalabel").innerHTML = "Gamma: " + gamma;

			document.getElementById("boardid").innerHTML = boardid;
			document.getElementById("ax").innerHTML = ax;
			document.getElementById("ay").innerHTML = ay;
			document.getElementById("az").innerHTML = az;
			document.getElementById("arAlpha").innerHTML = arAlpha;
			document.getElementById("arBeta").innerHTML = arBeta;
			document.getElementById("arGamma").innerHTML = arGamma;
			document.getElementById("alpha").innerHTML = alpha;
			document.getElementById("beta").innerHTML = beta;
			document.getElementById("gamma").innerHTML = gamma;
	        break;
	    case "showboardid":
	    	document.getElementById('boardid').innerHTML = "ID: "+obj.boardid;
	    	break;
	    default:
	        err('Saber: invalid cmd'+cmd)
	}
}
function penprocess(obj){
	var cmd = obj.cmd;
	switch(cmd) {
	    case "connected":
	        alert('connected');
	        connected = 1;
	        break;
	    default:
	        err('Owner: invalid cmd'+cmd)
	}
}