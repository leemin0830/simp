<?php
class AopManager {
	private $config;
	public function AopManager() {
		$this->loadConfig ();
	}
	private function loadConfig() {
		$fname = '../core/aopconfig.json';
		
		$fh = fopen ( $fname, 'r' );
		$str = fread ( $fh, filesize ( $fname ) );
		$str = str_replace ( "\n", "", $str );
		$str = str_replace ( "\r", "", $str );
		$str = str_replace ( "\t", "", $str );
		
		$this->config = json_decode ( $str, true );
	}
	
	// TODO : passing parameter
	public function processBefore($obj, $method, $params) {
		$this->processAOP ( 'before', $obj, $method, $params );
	}
	public function processAfter($obj, $method, $params) {
		$this->processAOP ( 'after', $obj, $method, $params );
	}
	public function processBeforeError($obj, $method, $params) {
		$this->processAOP ( 'beforeError', $obj, $method, $params );
	}
	public function processAfterError($obj, $method, $params) {
		$this->processAOP ( 'afterError', $obj, $method, $params );
	}
	private function processAOP($type, $obj, $method, $params) {
		if ($this->config == null)
			return;
		
		$className = get_class ( $obj );
		
		if($this->config[$className]!=null)
		{
			$aopDefaultList = $this->config [$className] ['all'] [$type];
			if($method!=null){
				$aopMethodList = ($this->config[$className][$method]!=null)?$this->config [$className] [$method] [$type]:null;
			}else{
				$aopMethodList=null;
			}

			if ($aopMethodList != null && $aopDefaultList != null) {
				$aopList = array_merge ( $aopDefaultList, $aopMethodList );
			} else if ($aopMethodList != null) {
				$aopList = $aopMethodList;
			} else if ($aopDefaultList != null) {
				$aopList = $aopDefaultList;
			}
			
//			echo 'start ' . $type . ' aop method execution';
			
			for($i = 0; $i < count ( $aopList ); $i ++) {
				$targetClassName = $aopList [$i] ['class'];
				$targetMethod = $aopList [$i] ['method'];
					
//				echo 'aop ' . $type . '- class : ' . $targetClassName . ', method : ' . $targetMethod;
					
				$c = new $targetClassName ();
				$c->{$targetMethod} ( $params );

			}
		}
	}
}

?>