<?php
class Redirect{
	//private static $route='/mymvc/public/';
	public static function to($location=null){
		if($location){
			if(substr($location, 0,1)=='/'){
				$location=substr($location, 1);
			}
			header('Location: /mymvc/public/'.$location);
			exit();
		}
	}

}