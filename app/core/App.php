<?php
class App{

	protected $controller ='home';

	protected $method ='index';

	protected $params =[];
	

	public function __construct(){
		$url = $this->parseUrl();
		if(empty($url)){
			$url[0]='/';
		}

		
		
		if($link =Routes::has($url[0],(Input::has())?true:false)){
			unset($url[0]);
			

			if(file_exists('../app/controllers/'.$link->controller.'.php')){
				$this->controller =$link->controller;
			}

			require_once '../app/controllers/'.$this->controller.'.php';

			$this->controller =new $this->controller;

			if(method_exists($this->controller, $link->method)){
				$this->method =$link->method;
			}

			$this->params =$url ? array_values($url):[];

		}else{

			require_once '../app/controllers/'.$this->controller.'.php';
			$this->controller =new $this->controller;

		}

		call_user_func_array([$this->controller,$this->method],$this->params);


	}

	public function parseUrl(){
		if(isset($_GET['url'])){
			return $url = explode('/',filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
		}
	}
}