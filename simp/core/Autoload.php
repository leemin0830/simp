<?
$depth=substr_count($_SERVER['SCRIPT_NAME'],"/");

if($depth==4){
	define(APPLICATION_PATH,"../../");
}else if($depth==5){	
	define(APPLICATION_PATH,"../../../");
}else{
	define(APPLICATION_PATH,"../");
}

require_once APPLICATION_PATH.'/model/_config.inc.php';
require_once APPLICATION_PATH.'/framework/Constant.php';


function __autoload($className) 
{ 
    if ('parent' != $className) 
    { 
	$possibilities = array(
			'../'.'core'.DIRECTORY_SEPARATOR.$className.'.php',
			'../'.'manager'.DIRECTORY_SEPARATOR.$className.'.php',
			'../'.'model'.DIRECTORY_SEPARATOR.$className.'.php',
				
			APPLICATION_PATH.'core'.DIRECTORY_SEPARATOR.$className.'.php',
			APPLICATION_PATH.'manager'.DIRECTORY_SEPARATOR.$className.'.php',
			APPLICATION_PATH.'model'.DIRECTORY_SEPARATOR.$className.'.php',
			$className.'.php'
	);
	foreach ($possibilities as $file) {
		if (file_exists($file)) {
			require_once($file);
			return true;
		}
	}
	return false;   
	}
} 

?>