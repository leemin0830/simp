<?php
require_once '../core/Autoload.php';
@session_start();

class UserManager extends Manager
{
	public function login($params){		
		$userParam=$params;
		unset($userParam['command']);
		
		$userInfo=UserInfo::retrieve($userParam);
		
		if($userInfo==null){
			throw new Exception("Invalid user information.","-100");
		}else{
			$_SESSION['userid']=$userInfo->get('userid');
			$_SESSION['username']=$userInfo->get('username');

			$result=array();
			$result['userid']=$userInfo->get('userid');
			$result['username']=$userInfo->get('username');

			return $result;
		}
	}


	public function delete($params){
		if($params['userid']==null){
			throw new Exception('Parameter error','-101');
		}
		UserInfo::delete($params);
	}

	public function add($params){
		$insertParam=$params;
		unset($insertParam['command']);

		if($insertParam['regdate']=="0000-00-00 00:00:00" || $insertParam['regdate']=="" || !$insertParam['regdate']){
			$insertParam['regdate']=date("Y-m-d H:i:s");
		}

		$userInfo=new UserInfo();
		foreach($insertParam as $k=>$v){
			$userInfo->set($k,$v);
		}


		$userInfo->add();
	}

	public function update($params){
		if($params['userid']==null){
			throw new Exception('Parameter error','-101');
		}

		$updateParam=$params;
		unset($updateParam['command']);

		if($updateParam['regdate']=="0000-00-00 00:00:00" || $updateParam['regdate']=="" || !$updateParam['regdate']){
			$updateParam['regdate']=date("Y-m-d H:i:s");
		}

		$userInfo=UserInfo::retrieve($params);

		foreach($updateParam as $k=>$v){
			$userInfo->set($k,$v);
		}


		$userInfo->update();
	}
}

$userManager=new UserManager();
$userManager->processCommand($_REQUEST['command']);

?>