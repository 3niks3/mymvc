<?php
class Validator{

	private $passed=false,$errors =array(),$db=null;

	public function __construct(){
		$this->db =DBN::getInstance();
	}

	public function check($source, $items =array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value =trim($source->$item);

				if($rule === 'require' && empty($value)){
					$this->addError("{$item} is require");
				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value)<$rule_value){
								$this->addError("{$item} must be at lest {$rule_value} characters");
							}
							break;
						case 'max':
							if(strlen($value)>$rule_value){
								$this->addError("{$item} cant contains more then {$rule_value} characters long");
							}
							break;
						case 'same':
							if($value!= $source->$rule_value){
								$this->addError("{$item} and {$rule_value} must match");
							}
							break;
						case 'unique':
							$check =$this->db->where('username','=', $value)->select('users');
								if($check->count()){
									$this->addError("{$item} is alredy taken");
								}
							break;
						default:
							# code...
							break;
					}
				}
			}
		}
		if(empty($this->errors)){
			return $this->passed=true;
		}
	}

	private function addError($error){
		$this->errors[]=$error;
	}

	public function errors(){
		return $this->errors;
	}
	public function passed(){
		return $this->passed;
	}

}