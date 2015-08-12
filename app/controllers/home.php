<?php
class Home extends Controller{	

	public function index(){
		$user =new UserN;
		echo Hash::salt(32);

		if($user->isLoggedIn()){
			Redirect::to('account');
		}

		Home::view('pages/login');
	}

	public function indexPost(){
		$user =new UserN;		
		
	 	$v = new Validator();
		$v->check(Input::all(),[
			'username'=>['require'=>true],
			'password' =>['require'=>true]
		]);

		if($v->passed()){			
			if($user->login(Input::get('username'),Input::get('password'))){
				Redirect::to('account');
			}else{
				Session::flash('errors',['Incorrect username or password!']);
				Redirect::to('/');
			}			
		}else{
			Session::flash('errors',$v->errors());
			Redirect::to('/');
		}				
	}

	public function accountGet(){

		$user =new UserN;

		if(!$user->isLoggedIn()){
			Redirect::to('/');
		}

		$this->view('pages/home',$user->data());
	}

	public function registerGet(){
		$user =new UserN;

		if($user->isLoggedIn()){
			Redirect::to('account');
		}
		Home::view('pages/register');		
	}

	public function logout(){

		$user= new UserN;

		if(!$user->isLoggedIn()){
			Redirect::to('/');
		}

		$user->logout();

		Session::flash('success',['You have been seccesfuly logged out']);
		Redirect::to('/');
	}

	public function registerPost(){

		$v = new Validator();

		$v->check(Input::all(),[
			'username'=>[
				'require'=>true,
				'min'=>2,
				'max'=>20,
				'unique'=>'users',
			],
			'password'=>[
				'require'=>true,
				'min'=>4
			],
			'password_again'=>[
				'require'=>true,
				'same'=>'password'
			],
			'name'=>[
				'require'=>true,
				'min'=>2,
				'max'=>50
			]
		]);
		if($v->passed()){
			$user = new UserN();			

			$salt =Hash::salt(32);

			$user->create([
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password'),$salt),
				'user_name' => Input::get('name'),
				'joined' => Config::currenttime(),
				'salt' => $salt
			]);

			Session::flash('success',['You are register seccesfully!']);
			Redirect::to('/');
		}else{
			Session::flash('errors',$v->errors());
			Redirect::to('register');
		}
	}


}