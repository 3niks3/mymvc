<?php
class Hash{

	public static function make($string,$salt=''){
		return hash('sha256',$string.$salt);
	}

	public static function salt($lenght){
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $lenght);
	}

	public static function unique(){
		return self::make(uniqid());
	}

}