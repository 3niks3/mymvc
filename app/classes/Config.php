<?php

class Config{
	

	public static function currenttime(){
		return date("Y-m-d H:i:s",time()+3*60*60);
	}
}