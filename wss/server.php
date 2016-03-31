<?php
require "Websockets/websockets.php";


global $db;
class Server extends WebSocketServer{

	private $_connecting = "connecting to server...";
	private $_welcome = 'Hello, welcome to echo server!!';
	private $_rsuccess = 'Saber has been registered!';
	private $_gsuccess = 'Saber has been found!';
	protected $boards = array();

	protected function connected($user){
		$this->send($user,$this->_welcome);
	}

	protected function process($user,$message){
		$obj = json_decode($message);
		$type = $obj->{'type'};
		$user->type="pen";

		if($type == 'registerboard'){
			$user->type="board";

			$boardid = self::randstr(4);

			$user->boardid = $boardid;
			$this->boards[$boardid] = $user;
			
			$arr = array(
				"to"=>"board",
				"cmd"=>'showboardid',
				"boardid"=>$boardid
			);
			
			$package = self::createobjstr($arr);
			$this->send($user,$package);
		}
		elseif($type == 'getboard'){
			$boardid = $obj->{'boardid'};
			//$user->saberid = $saberid;
			$arr = array(
				"to"=>"pen",
				"cmd"=>'connected'
			);
			$package = self::createobjstr($arr);
			if($this->boards[$boardid]){
				$user->boardid = $boardid;
				$this->send($user,$package);
			}
			else $this->send($user,"Couldn't find the Board");
		}
		elseif($type == 'phonestate'){
			//ax,ay,az,arAlpha,arBeta,arGamma,alpha,beta,gamma
			$ax = $obj->{'ax'};
			$ay = $obj->{'ay'};
			$az = $obj->{'az'};

			$arAlpha = $obj->{'arAlpha'};
			$arBeta = $obj->{'arBeta'};
			$arGamma = $obj->{'arGamma'};

			$alpha = $obj->{'alpha'};
			$beta = $obj->{'beta'};
			$gamma = $obj->{'gamma'};

			$arr = array(
				"to"=>'board',
				"cmd"=>'upadtecoords',
				"ax"=>$ax,
				"ay"=>$ay,
				"az"=>$az,
				"arAlpha"=>$arAlpha,
				"arBeta"=>$arBeta,
				"arGamma"=>$arGamma,
				"alpha"=>$alpha,
				"beta"=>$beta,
				"gamma"=>$gamma,
			);
			$package = self::createobjstr($arr);
			$board = $this->boards[$user->boardid];
			if($board) $this->send($board,$package);
			else $this->send($user,'Could find the Lightsaber');
		}
	}

	protected function closed($user){
		if($user->boardid){
			unset($this->boards[$user->boardid]);
		}
	}

	public function __destruct(){
		echo "Server destroyed ".PHP_EOL;
	}

	protected function createobjstr($arr){
		$result = "{";
		foreach($arr as $key=>$value){
			$result.='"'.$key.'":"'.$value.'",';
		}
		$result=rtrim($result, ",");
		$result .= "}";
		return $result;
	}

	protected function randstr($n){
		return substr(substr("abcdefghijklmnopqrstuvwxyz" ,mt_rand(0,25), 1).substr(md5(time()), 1),0,$n);
	}
}

$addr = 'ec2-52-37-132-185.us-west-2.compute.amazonaws.com';
$port = '9697';

$server = new Server($addr,$port);
$server->run();
