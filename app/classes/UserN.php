<?php 
class UserN{

	private $db,$data,$sessionName,$isLoggedIn= false;

	public function __construct($id =null){

		$this->db=DBN::getInstance();
		$this->sessionName ='user';

		if(!$id){
			if(Session::exists($this->sessionName)){
				$id = Session::get($this->sessionName);	

				if($this->findbyid($id)){
					$this->isLoggedIn =true;
				}
			}
		}else{
			$this->findbyid($id);
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

	public function login($username= null,$password =null){
		$user = $this->find($username);

		if($user){
			if($this->data->password === Hash::make($password,$this->data->salt)){
				Session::put($this->sessionName,$this->data->id);

				return true;
			}else{
				return false;
			}
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
	}

	public function data(){
		return $this->data;
	}

	public function isLoggedIn(){
		return $this->isLoggedIn;
	}

}