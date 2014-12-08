<?php


class Manager {
	private $command = "";
	private $httpArgs = Array ();
	private $aopManager;
	private $exiting=false;
	
	public function Manager() {
		 register_shutdown_function(array($this, 'handleFatalError'));
		//set_error_handler ( $this->handleFatalError );
		$this->aopManager = new AopManager ();
	}
	public function processCommand($command) {
		$this->command = $command;
		
		if ($command == "" || $command == null) {
			$this->handleException (new Exception ( 'Command must be specified.' ) );
			return;
		}
		
		$this->httpArgs = $_REQUEST;
		
		try {
			$this->aopManager->processBefore ( $this, $command, $this->httpArgs );
			$result = $this->{$command} ( $this->httpArgs );			
			$this->aopManager->processAfter ( $this, $command, $this->httpArgs );
			
			$this->responseResult ( $result );
				
		} catch ( Exception $e ) {
			$this->handleException ( $e );
			return;
		}
	}
	private function handleException($e) {
		$this->aopManager->processBeforeError ( $this, $this->command, $e );
		$this->processError ( $e );
		$this->aopManager->processAfterError ( $this, $this->command, $e );
		
		$this->responseErrorResult ($e);

		$this->exiting=true;
		exit();
	}
	public function handleFatalError() {
		
		if(!$this->exiting){
			$error = error_get_last ();
			
			if ($error !== NULL) {
				$errno = $error ["type"];
				$errfile = $error ["file"];
				$errline = $error ["line"];
				$errstr = $error ["message"];
				
				$e = new ErrorException ( $errstr, 0, $errno, $errfile, $errline );
				
				$this->handleException($e);
			}
		}
	}
	
	public function processError($e){
		//empty
	}
	
	
	private function responseResult($data) {
		$ret = array ();
		$ret ['resultCode'] = "1";
		$ret ['resultMessage'] = "success";
		$ret ['data'] = $data;
		echo json_encode ( $ret );
	}
	private function responseErrorResult($exception) {
		$ret = array ();
		($exception->getCode () != null) ? $ret ['resultCode'] = $exception->getCode () : $ret ['resultCode'] = "-1";
		$ret ['resultMessage'] = $exception->getMessage ();
		echo json_encode ( $ret );
	}
	private function throwExceptionIfEmpty($params, $keys) {
		foreach ( $keys as $k => $v ) {
			if ($params [$v] == "" || $params [$v] == null) {
				throw new Exception ( 'parameter error.' );
			}
		}
	}
}

?>