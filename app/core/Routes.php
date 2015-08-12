<?php
class Routes{
	public static $routes = [
		'get'=>[
			'/'=>['controller'=>'home','method'=>'index'],
			'register'=>['controller'=>'home','method'=>'registerGet'],
			'account'=>['controller'=>'home','method'=>'accountGet'],
			'logout'=>['controller'=>'home','method'=>'logout'],

		],
		'post'=>[
			'/'=>['controller'=>'home','method'=>'indexPost'],
			'register'=>['controller'=>'home','method'=>'registerPost'],
		]
		
	];

	public static function has($route,$post =false){

		if($post){
			if(isset(self::$routes['post'][$route])){

				if(!Input::has()||!Token::check(Input::get('token'))){
					header("refresh:0") ;
				}

				return (object)self::$routes['post'][$route];
			}else{
				return false;
			}
		}else{
			if(isset(self::$routes['get'][$route])){
				return (object)self::$routes['get'][$route];
			}else{
				return false;
			}
		}

	}

}