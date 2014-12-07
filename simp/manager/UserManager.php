<?php
require_once '../framework/Autoload.php';
@session_start();

class UserManager extends Manager
{
	public function login($params){		
		$userParam=$params;
		unset($userParam['command']);
		$userInfo=UserInfo::readArray($userParam);
		if(count($userInfo)<=0){
			throw new Exception("Invalid user information.","-100");
		}else{
			$_SESSION['username']=$userInfo[0]['username'];
			$_SESSION['userid']=$userInfo[0]['userid'];
			$_SESSION['isAdmin']=$userInfo[0]['isAdmin'];
			$_SESSION['level']=$userInfo[0]['level'];


			$result=array();
			$result['username']=$userInfo[0]['username'];
			$result['userid']=$userInfo[0]['userid'];
			$result['isAdmin']=$userInfo[0]['isAdmin'];
			$result['level']=$userInfo[0]['level'];

			return $result;
		}
	}


	public function delete($params){
		if($params['no']==null){
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
			if(method_exists($userInfo,"set".ucfirst($k)))
				$userInfo->{"set".ucfirst($k)}(addslashes($v));
		}


		$userInfo->add();
	}

	public function update($params){
		if($params['no']==null){
			throw new Exception('Parameter error','-101');
		}

		$updateParam=$params;
		unset($updateParam['command']);

		if($updateParam['regdate']=="0000-00-00 00:00:00" || $updateParam['regdate']=="" || !$updateParam['regdate']){
			$updateParam['regdate']=date("Y-m-d H:i:s");
		}

		$userInfo=new UserInfo();
		$userInfo->readObject(array("no"=>$params['no']));

		foreach($updateParam as $k=>$v){
			if(method_exists($userInfo,"set".ucfirst($k)))
				$userInfo->{"set".ucfirst($k)}(addslashes($v));
		}


		$userInfo->update();
	}
}

$userManager=new UserManager();
$userManager->processCommand($_REQUEST['command']);

?>