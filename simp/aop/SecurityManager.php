<?php
if (isset($_REQUEST['phpsessionid'])) {
	@session_id($_REQUEST['phpsessionid']);
}
@session_start();

class SecurityManager{
	public function checkAdmin($params){
		if($_SESSION['isAdmin']!='Y'){
			throw new Exception("Only admin allowed","-201");
		}		
	}
	
	public function checkLogin($params){
		
		if($_SESSION['userid']==null){
			throw new Exception("You should log in","-202");
		}
	}
}