<?php

class Logger
{
	private $log_file = 'logfile.log';
	private $nl = "\n";
	private $fp = null;

	/**
	 * Logs a message.
	 *
	 * @param  $sMessage @type string The message.
	 */
	public function log($sMessage)
	{
		try{
			$this->write(sprintf("%s log [%d]: %s\n",date('r'), getmypid(), trim($sMessage)));
		}catch(Exception $e){
			
		}
	}

	public function file($path) {
		$this->log_file = $path;
	}
	public function write($message) {
		if (!$this->fp) {
			$this->open();
		}
		$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
		$time = date('H:i:s');
		fwrite($this->fp, "$time ($script_name) $message". $this->nl);
	}

	public function close() {
		fclose($this->fp);
	}

	private function open() {
		$lfile = $this->log_file;
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$this->nl = "\r\n";
		}
		$today = date('Y-m-d');
		$result=$this->fp = fopen($lfile . '_' . $today, 'a');
		if($result==false){
			throw new Exception("Can't open $lfile!");
		}
	}
}
