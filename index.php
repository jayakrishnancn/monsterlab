<?php 
define('MONSTER',"1.0");

define('BASEPATH',"");

define('HTTPPATH',"http://$_SERVER[HTTP_HOST]/ieee/");

define('ABSPATH',dirname(__FILE__)); 

if(file_exists("./core/config/config.php"))
{
	require_once './core/config/config.php';
	exit;
}
?>error in configs : MONSERLAB* framework..