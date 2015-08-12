<?php

class Input{

	public static function has($type ='post'){
		switch($type){
			case 'post':
				return (!empty($_POST))?true :false;
				break;
			case 'get':
				return (!empty($_GET))?true :false;
				break;
			default:
				return false;
				break;
		}
	}

	public static function get($item){
		if(isset($_POST[$item])){
			return $_POST[$item];
		}else if(isset($_GET[$item])){
			return $_Get[$item];
		}
		return'';
	}

	private static function getarray($array){
		if(!is_array($array)){
			return '';
		}

		$data;

		foreach ($array as $key => $value) {
			$data[$key] =$value;
		}
		return $data;
	}

	public static function all($type = 'post'){
		$data;
		switch($type){
			case 'post':
				return (object)self::getarray($_POST);
				break;
			case 'get':
				return (object)self::getarray($_GET);
				break;
			default:
				return '';
				break;
		}
	}
}