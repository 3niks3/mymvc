<?php 
class User{

	private $db,$data,$sessionName,$isLoggedIn,$cookieName;

	public function __construct($user =null){
		$this->db=DBN::getInstance();
		$this->sessionName ='user';

		if(!$user){
			if(Session::exists($this->sessionName)){
				$user = Session::get($this->sessionName);	

				if($this->findbyid($user)){
					$this->isLoggedIn =true;
				}else{
					//log out
				}
			}
		}else{
			$this->findbyid($user);
		}
	}

	public function create($values){
		if(!$this->db->insert('users',$values)){
			Session::flash('error','Problem to register user');
			header('Location: index.php');
		}
	}

	public function update($fields,$id =null){
		if(!$id && $this->isLoggedIn()){
			$this->db->where('id','=',$this->data->id)->update('users',$fields);
		}
	}

	public function find($username = null){
		if($username){
			$user=$this->db->where('username','=',$username)->select('users');

			if($user->count()){
				$this->data =$user->first();
				return true;
			}
		}
		return false;
	}

	public function findbyid($id = null){
		if($id){
			$user=$this->db->where('id','=',$id)->select('users');

			if($user->count()){
				$this->data =$user->first();
				return true;
			}
		}
		return false;
	}

	public function login($username= null,$password =null,$remember = false){
		$user = $this->find($username);

		if($user){
			if($this->data->password === Hash::make($password,$this->data->salt)){
				Session::put($this->sessionName,$this->data->id);

				if($remember){
					$hash =Hash::unique();
					$hashCheck=$this->db->where('user_id','=',$this->data->id)->select('users_session');
					if(!$hashCheck->count()){
						$this->db->insert('users_session',['user_id'=>$this->data->id,'hash'=>$hash]);
					}else{
						$hash =$hashCheck->first()->hash;
					}

					Cookie::put($this->cookieName,$hash,Config::get('remember/cookie_expiry'));

				}

				return true;
			}
		}else{
			return false;
		}

		return false;
	}

	public function loginbyid($id){
		$user = $this->findbyid($id);

		if($user){
			Session::put($this->sessionName,$this->data->id);
			return true;
		}else{
			return false;
		}

		return false;
	}

	public function logout(){

		$this->db->query("DELETE From users_session WHERE user_id = ".Session::get($this->sessionName));

		Session::delete($this->sessionName);
		Cookie::delete(Config::get('remember/cookie_name'));
	}

	public function data(){
		return $this->data;
	}

	public function isLoggedIn(){
		return $this->isLoggedIn;
	}

}