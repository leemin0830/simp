<?php

class ErrorHandler
{
	private $logger;
	private $nl = "\n";
	private $fp = null;

	public function ErrorHandler(){
		$this->logger=new Logger();
	}
	
	public function handleError($e)
	{
		
		$this->logger->log($e->getMessage());
	}
}
