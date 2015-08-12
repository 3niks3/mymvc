<?php
class DB{

	private static $instance =null;
	private $pdo, $query, $error =false, $results,$count =0;
	private $where ='WHERE 1';


	private function __construct(){
		try{
			$this->pdo =new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password')); 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance =new DB();
		}
		return self::$instance;
	}

	public function query($sql){

		if($this->query = $this->pdo->prepare($sql)){
			//die($sql);
			
			if($this->query->execute()){
				$this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
				$this->count = $this->query->rowCount();
			}else{
				$this->error =true;
			}
		}
		return $this;
	}

	public function insert($table, $values){
		
		$this->error =false;
		$fields= array_keys($values);
		$fields = implode(', ', $fields);
		$fieldValues = '';
		foreach ($values as $value) {
			if($fieldValues!=''){
				$fieldValues.=', ';
			}
			$fieldValues.= '?';
		}
		
		$sql = "INSERT INTO {$table} ({$fields}) VALUES({$fieldValues})";
		//die($sql);
		if($this->query = $this->pdo->prepare($sql)){
			if(count($values)){
				$x=1;
				foreach ($values as $key => $value) {
					$this->query->bindValue($x,$value);
					$x++;
				}
			}
			if($this->query->execute()){
				return true;
			}else{
				return false;
			}
		}
	}

	public function update($table, $values){
		
		$this->error =false;
		$set ='';
		$x =1;
		foreach ($values as $key => $value) {
			$set .="{$key}=?";
			if($x <count($values)){
				$set.=', ';
			}
			$x++;
		}
		
		$sql = "UPDATE {$table} SET {$set} {$this->where}";

		if($this->query = $this->pdo->prepare($sql)){
			if(count($values)){
				$x=1;
				foreach ($values as $key => $value) {
					$this->query->bindValue($x,$value);
					$x++;
				}
			}
			if($this->query->execute()){
				self::clearParams();
				return true;
			}else{
				self::clearParams();
				return false;
			}
		}
	}

	public function select($table,$fields ='*'){
		if($fields != '*'){
			$fields =implode(', ', $fields);
		}
		
		$sql ="SELECT {$fields} From {$table} {$this->where}";
		
		if($this->query = $this->pdo->prepare($sql)){
			
			if($this->query->execute()){
				$this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
				$this->count = $this->query->rowCount();

				self::clearParams();

				return $this;
			}else{
				self::clearParams();
				return false;
			}
		}
	}


	public function get(){
		return $this->results;
	}

	public function first(){
		return $this->results[0];
	}
	public function count(){
		return $this->count;
	}


	private function clearParams(){
		$this->where='WHERE 1';
	}
	

 	public function where($field,$operation, $value)
    {
    	if($this->where =='WHERE 1'){
    		$this->where = 'WHERE '.$field.' '.$operation.' \''.$value.'\'';
    	}else{
    		$this->where .= ' AND '.$field.' '.$operation.' \''.$value.'\'';
    	}
        
        return $this;
    }

    public function orwhere($field,$operation, $value)
    {
    	if($this->where =='WHERE 1'){
    		$this->where = 'WHERE '.$field.' '.$operation.' \''.$value.'\'';
    	}else{
    		$this->where .= ' OR '.$field.' '.$operation.' \''.$value.'\'';
    	}
        
        return $this;
    }

}