<?php
require "Websockets/websockets.php";


global $db;
class Server extends WebSocketServer{

	private $_connecting = "connecting to server...";
	private $_welcome = 'Hello, welcome to echo server!!';
	private $_rsuccess = 'Saber has been registered!';
	private $_gsuccess = 'Saber has been found!';
	protected $sabers = array();

	protected function connected($user){
		$this->send($user,$this->_welcome);
	}

	protected function process($user,$message){
		$obj = json_decode($message);
		$type = $obj->{'type'};
		if($type == 'registersaber'){
			$saberid = self::randstr(5);
			$user->saberid = $saberid;
			$this->sabers[$saberid] = $user;
			$arr = array(
				"to"=>"saber",
				"cmd"=>'showsaberid',
				"saberid"=>$saberid
			);
			$package = self::createobjstr($arr);
			$this->send($user,$package);
		}
		elseif($type == 'getsaber'){
			$saberid = $obj->{'saberid'};
			$user->saberid = $saberid;
			$arr = array(
				"to"=>"owner",
				"cmd"=>'connected'
			);
			$package = self::createobjstr($arr);
			if($this->sabers[$saberid]) $this->send($user,$package);
			else $this->send($user,'Could find the Lightsaber');
		}
		elseif($type == 'mstate'){
			$a = $obj->{'a'};
			$b = $obj->{'b'};
			$g = $obj->{'g'};
			$arr = array(
				"to"=>'saber',
				"cmd"=>'move',
				"a"=>$a,
				"b"=>$b,
				"g"=>$g
			);
			$package = self::createobjstr($arr);
			$saber = $this->sabers[$user->saberid];
			if($saber) $this->send($saber,$package);
			else $this->send($user,'Could find the Lightsaber');
		}
	}

	protected function closed($user){
		unset($this->sabers[$user->saberid]);
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
$port = '9696';

$server = new Server($addr,$port);
$server->run();
