<?php 

if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");

/* settings */

$start_time=microtime(true);


$config['DEBUG']=false;/*false*/
$config['SHOWLOG']=true;
$config['session_max_time']=60*2; 
$config['refurl']=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;

/*folders*/
/* dont forget to append the '/' after dir name*/

$folder=array(

'apps'=>BASEPATH."apps/",
'core'=>BASEPATH."core/",
'plugin'=>BASEPATH."plugin/",
'cache'=>BASEPATH."cache/",

'controller'=>BASEPATH."apps/controller/",
'css'=>BASEPATH."apps/css/",
'image'=>BASEPATH."apps/image/",
'js'=>BASEPATH."apps/js/",
'model'=>BASEPATH."apps/model/",
'vendor'=>BASEPATH."apps/vendor/",
'view'=>BASEPATH."apps/view/",

'config'=>BASEPATH."core/config/",
'uploads'=>BASEPATH."apps/ext/uploads/",
'security'=>BASEPATH."core/security/",

'title'=>"Monsterlab"
);

$model=array('dbdriver'=>'mysqli',
		'hostname'=>'localhost',
		'username'=>'root',
		'database'=>'monsterlab',
		'password'=>'');

$config=array_merge($folder,$config); 
$config['db']=$model;

ini_set('display_errors',$config['DEBUG']);

require_once $config['security']."Guard.php";

require_once $config['core'].'Model.php';

require_once $config['core'].'Controller.php';

require_once $config['core'].'Bootstrap.php';





$Bootstrap=new Bootstrap;


//time calculation
$end_time=microtime(true);
$total_time=$end_time-$start_time;
log_message("TIME",$total_time);
