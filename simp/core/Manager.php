<?php

class Manager
{
	public $command="";
	public $httpArgs=Array();
	public $aopManager;

	public function Manager(){
		$this->aopManager=new AopManager();
	}

	public function processCommand($command){
		$this->command=$command;

		if($command=="" || $command==null){
			$this->handleException(new Exception('Command must be specified.'));
			return;
		}

		$this->httpArgs=$_REQUEST;

		try{
			$this->aopManager->processBefore($this,$command,$this->httpArgs);

			$result=$this->{$command}($this->httpArgs);
				
			$this->aopManager->processAfter($this,$command,$this->httpArgs);

				
			$this->responseResult($result);
		}catch(Exception $e){
			
			$this->aopManager->processBeforeError($this,$command,$this->httpArgs,$e);
			
			$this->handleException($e);
			
			$this->aopManager->processAfterError($this,$command,$this->httpArgs,$e);
		}

	}

	public function handleException($exception){
		$this->responseErrorResult($exception);
	}

	public function responseResult($data){
		$ret=array();
		$ret['resultCode']="1";
		$ret['resultMessage']="success";
		$ret['data']=$data;
		echo json_encode($ret);
	}

	public function responseErrorResult($exception){
		$ret=array();
		($exception->getCode()!=null)?$ret['resultCode']=$exception->getCode():$ret['resultCode']="-1";
		$ret['resultMessage']=$exception->getMessage();
		echo json_encode($ret);
	}

	public function throwExceptionIfEmpty($params,$keys){
		foreach($keys as $k=>$v){
			if($params[$v]=="" || $params[$v]==null){
				throw new Exception('parameter error.');
			}
		}
	}
}

?>