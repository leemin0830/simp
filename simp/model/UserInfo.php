<?php
// Sample Model
class UserInfo {
	public function get($array = array()) {
		$array ['id'] = 'simp';
		$array ['email'] = '';
		return $array;
	}
	public static function all($array = array()) {
		$array [0]=array();
		$array [0] ['id'] = 'simp';
		$array [0] ['email'] = '';
		
		$array [1]=array();
		$array [1] ['id'] = 'simp2';
		$array [1] ['email'] = '';
		
		return $array;
	}
	
	public function add($array = array()) {
		$array ['id'] = 'simp';
		$array ['email'] = '';
		return $array;
	}
	public static function delete($array = array()) {
		$array ['id'] = 'simp';
		$array ['email'] = '';
		return $array;
	}
	public static function update($array = array()) {
		$array ['id'] = 'simp';
		$array ['email'] = '';
		return $array;
	}
}
?>