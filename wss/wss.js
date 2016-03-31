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
		 	var ax = obj.ax+0;
		 	var ay = obj.ay+0;
		 	var az = obj.az+0;

		 	var arAlpha = obj.arAlpha;
		 	var arBeta = obj.arBeta;
		 	var arGamma = obj.arGamma;

		 	var alpha = obj.alpha;
		 	var beta = obj.beta;
		 	var gamma = obj.gamma;

		 	if(!originalalphaset){
				originalalpha = window.innerWidth/2;
				originalalphaset = 1;
			}
			if(!originalbetaset){
				originalbeta = window.innerHeight/2;
				originalbetaset = 1;
			}

	  		// document.getElementById("alphalabel").innerHTML = "Alpha: " + alpha;
			// document.getElementById("betalabel").innerHTML = "Beta: " + beta;
			// document.getElementById("gammalabel").innerHTML = "Gamma: " + gamma;
			// l = ax/50;
			// t = -az/50;


			// document.getElementById('test_square').style.left = currentleft+l+'px';
			// document.getElementById('test_square').style.top = currenttop+t+'px';
			// if(currentleft<1000&&currentleft>0) currentleft+=(l+0);
			// if(currenttop<1000&&currenttop>0) currenttop+=(t+0);

			l = originalalpha-alpha;
			t = -(beta-originalbeta);

			l*=speed;
			t*= speed;


			document.getElementById('test_square').style.left = currentleft+l+'px';
			document.getElementById('test_square').style.top = currenttop+t+'px';

			document.getElementById("ax").innerHTML = 'X acceleration: '+ax;
			document.getElementById("ay").innerHTML = 'Y acceleration: '+ay;
			document.getElementById("az").innerHTML = 'Z acceleration: '+az;
			document.getElementById("arAlpha").innerHTML = 'Rotation alpha acceleration: '+arAlpha;
			document.getElementById("arBeta").innerHTML = 'Rotation beta acceleration: '+arBeta;
			document.getElementById("arGamma").innerHTML = 'Rotation gamma acceleration: '+arGamma;
			document.getElementById("alpha").innerHTML = 'Rotation alpha: '+alpha;
			document.getElementById("beta").innerHTML = 'Rotation beta: '+beta;
			document.getElementById("gamma").innerHTML = 'Rotation gamma: '+gamma;
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