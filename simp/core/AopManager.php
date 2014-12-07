<?php
class AopManager{
	private $config;
	
	public function AopManager(){
		$this->loadConfig();
	}
	
	private function loadConfig(){
		$fname='../../framework/aopconfig.json';
		if(!file_exists($fname)){
			$fname='../framework/aopconfig.json';
		}
		$fh=fopen($fname, 'r');
		$str=fread($fh, filesize($fname));
		$str=str_replace("\n", "", $str);
		$str=str_replace("\r", "", $str);
		$str=str_replace("\t", "", $str);
		
		$this->config=json_decode($str,true);
	}
	
	//TODO : passing parameter
	public function processBefore($obj,$method,$params){
		processAOP('before',$obj,$method,$params);
	}

	
	public function processAfter($obj,$method,$params){
		processAOP('after',$obj,$method,$params);	
	}
	
	public function processBeforeError($obj,$method,$params){
		processAOP('beforeError',$obj,$method,$params);
	}
	
	
	public function processPost($obj,$method,$params){
		processAOP('afterError',$obj,$method,$params);
	}
	
	
	private function processAOP($type,$obj,$method,$params){
		if($this->config==null)return;
		
		$className=get_class($obj);
		$aopDefaultList=$this->config[$className]['all'][$type];
		$aopMethodList=$this->config[$className][$method][$type];
		
		if($aopMethodList!=null && $aopDefaultList!=null){
			$aopList=array_merge($aopDefaultList,$aopMethodList);
		}else if($aopMethodList!=null){
			$aopList=$aopMethodList;
		}else if($aopDefaultList!=null){
			$aopList=$aopDefaultList;
		}
		
		for ($i=0;$i<count($aopList);$i++){
			$targetClassName=$aopList[$i]['class'];
			$targetMethod=$aopList[$i]['method'];
				
			$c=new $targetClassName;
			$c->{$targetMethod}($params);
		}
	}
}


?>