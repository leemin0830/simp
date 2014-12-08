<?
$depth=substr_count($_SERVER['SCRIPT_NAME'],"/");

define("APPLICATION_PATH","../");

if($depth==4){
	define("APPLICATION_PATH","../../");
}else if($depth==5){	
	define("APPLICATION_PATH","../../../");
}

require_once APPLICATION_PATH.'core/Constant.php';


function __autoload($className) 
{ 
    if ('parent' != $className) 
    { 
	$possibilities = array(
			APPLICATION_PATH.'core'.DIRECTORY_SEPARATOR.$className.'.php',
			APPLICATION_PATH.'manager'.DIRECTORY_SEPARATOR.$className.'.php',
			APPLICATION_PATH.'model'.DIRECTORY_SEPARATOR.$className.'.php',
			APPLICATION_PATH.'aop'.DIRECTORY_SEPARATOR.$className.'.php',
				
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