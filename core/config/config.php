<?php
/*monsterlab v 1.0.0.10 */
 

if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");

/* settings */

$start_time=microtime(true);


$config["DEBUG"]=false;/*false*/
$config["SHOWLOG"]=true;
$config["session_max_time"]=60*20; 
$config["refurl"]=isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:null;

/*folders*/
/* dont forget to append the "/" after dir name*/

$folder=array(

"apps"=>BASEPATH."apps/",
"core"=>BASEPATH."core/",
"plugin"=>BASEPATH."plugin/",
"cache"=>BASEPATH."cache/",

"controller"=>BASEPATH."apps/controller/",
"css"=>BASEPATH."apps/css/",
"image"=>BASEPATH."apps/image/",
"js"=>BASEPATH."apps/js/",
"model"=>BASEPATH."apps/model/",
"vendor"=>BASEPATH."apps/vendor/",
"view"=>BASEPATH."apps/view/",

"fonts"=>BASEPATH."apps/css/fonts/",

"config"=>BASEPATH."core/config/",
"uploads"=>BASEPATH."apps/ext/uploads/",
"security"=>BASEPATH."core/security/",

"title"=>"IEEE"
);

$model=array("dbdriver"=>"mysqli",
		"hostname"=>"localhost",
		"username"=>"root",
		"database"=>"db",
		"password"=>"",
		"prefix"=>"");
/*
$servername = "localhost";
$username = "ieeesctsborg";
$password = "4uc6CHup#AC#";
$dbname = "ieeescts_dbone";*/
$config=array_merge($folder,$config); 
$config["db"]=$model;

ini_set("display_errors",$config["DEBUG"]);

require_once $config["security"]."Guard.php";

require_once $config["core"]."Model.php";

require_once $config["core"]."Controller.php";

require_once $config["core"]."Bootstrap.php";

/*

*/ /*
function mres($value)
{
    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}
	function cleanpost($s){
 	return strip_tags(htmlentities(trim(stripslashes($s)), ENT_NOQUOTES, "UTF-8"));
}
if(isset($_POST))
	foreach ($_POST as $key => $value) {
		$_POST[$key]=mres(cleanpost($_POST[$key]));
	}*/
 
 
$Bootstrap=new Bootstrap;


//time calculation
$end_time=microtime(true);
$total_time=$end_time-$start_time;
log_message("TIME",$total_time);