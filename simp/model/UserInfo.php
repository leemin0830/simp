<?php
@session_start();

// Sample Model
class UserInfo {
	private $data=array();
	
	public function UserInfo($userid='',$username='',$passwd=''){
		$this->data['userid']=$userid;
		$this->data['username']=$username;
		$this->data['$passwd']=$passwd;
	}
	
	public function get($key){
		return $this->data[$key];
	}
	
	public function set($key,$value){
		$this->data[$key]=$value;
	}
	
	//sync with database
	public function update(){
		
	}
	
	//add to database
	public function add(){
		
	}
	
	//retrieve from database
	public static function retrieve($param){
		//example
		if($param['userid']=='test'){
			return new UserInfo('test','jason','1234');
		}
		return null;
	}
}
?>