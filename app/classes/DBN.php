<?php
class DBN{

	private static $instance =null;
	private $pdo, $query, $error =false, $results,$count =0;
	private $whereSql = 'WHERE 1';
	public $whereValues =array();



	private function __construct(){
		try{
			$this->pdo =new PDO('mysql:host=localhost;dbname=mymvc','root',''); 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance =new DBN();
		}
		return self::$instance;
	}

	public function query($sql){

		if($this->query = $this->pdo->prepare($sql)){
			
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
		
		$set ='';
		$x =1;
		foreach ($values as $key => $value) {
			$set .="{$key}=?";
			if($x <count($values)){
				$set.=', ';
			}
			$x++;
		}
		
		$sql = "UPDATE {$table} SET {$set} {$this->whereSql}";

		if($this->query = $this->pdo->prepare($sql)){
			if(count($values)){
				$x=1;
				$values =array_merge($values,$this->whereValues);

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
		
		$sql ="SELECT {$fields} From {$table} {$this->whereSql}";

		if($this->query = $this->pdo->prepare($sql)){

			if(count($this->whereValues)){

				foreach ($this->whereValues as $key => $value) {
					$this->query->bindValue($key+1,$value);
				}

			}
			
			if($this->query->execute()){
				$this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
				$this->count = $this->query->rowCount();
				
				$this->clearParams();
				return $this;
			}else{
				$this->clearParams();
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
		$this->whereSql='WHERE 1';
		$this->whereValues=array();
	}
	

 	public function where($field,$operation, $value)
    {
    	if($this->whereSql =='WHERE 1'){
    		$this->whereValues[] =$value;
    		$this->whereSql = 'WHERE '.$field.' '.$operation. ' ?';
    	}else{
    		$this->whereValues[] =$value;
    		$this->whereSql .= ' AND '.$field.' '.$operation.' ?';
    	} 
        
        return $this;
    }

    public function orwhere($field,$operation, $value)
    {
    	if($this->whereSql =='WHERE 1'){
    		$this->whereValues[] =$value;
    		$this->whereSql = 'WHERE '.$field.' '.$operation. ' ?';
    	}else{
    		$this->whereValues[] =$value;
    		$this->whereSql .= ' OR '.$field.' '.$operation.' ?';
    	} 
        
        return $this;
    }

}