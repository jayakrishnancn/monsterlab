<?php 

if( (!defined("BASEPATH") ) || (!defined("ABSPATH")) )
		die("no direct script allowed  ");

/*

common core  functions 

*/

function redir($to,$time=0,$msg=false)
{
	echo "<script>setTimeout(\"location.href='{$to}'\",{$time});</script>";
	if($msg)
		echo "Redirecting .. please wait.";
}
/*$a=array(['log_message']);*/
function log_message($info='info',$msg='',$var='',$disp=true)
{ 
	global $config;
	/*global $a;*/
	if(isset($config['DEBUG']) && isset($config['SHOWLOG']) && (isset($info)) && (isset($msg)))
	{
		if($config['DEBUG'] && $config['SHOWLOG'])
		{
			if($disp)
			{
				$info=strtoupper($info);
				switch (strtoupper($info)) {
					case 'INFO':
						echo "<b style='color:#1fa67b'>[".$info ."]</b> ";
						break;
					case 'ERROR':
						echo "<b style='color:#f46d57'>[".$info ."]</b> ";
						break;
					case 'TIME':
						echo "<b style='color:#3366cc'>[".$info ."]</b> ";
						break;  
					case 'CACHE':
						echo "<b style='color:#F34FFF'>[".$info ."]</b> ";
						break; 
					default:
						echo "<b style='color:#555555'>[".$info ."]</b> ";
						break;
				} 
				$trace=debug_backtrace()[0];  
				echo "<b>".$msg."</b> <i style='color:#6F3F9F'>{ ";
				echo ($trace['file']); 
				echo " :[";
				echo ($trace['line']); 
				echo "] }</i>";
				echo "<br/><br/>\n";
			} 
	/*			array_push($a,[$info=>$msg]);*/

		}
	} 
}
/*
function disp_log()
{
	global $a;
	foreach ($a as $key => $value) {
		foreach ($value as $keys => $values) {
			echo "[<b>".$keys ."</b>] : <i style='color:#cc0000'>".$values."</i><br/>";
	}
	}
}*/





	function parseurl()
	{
	$url=isset($_GET['url'])? strip_tags($_GET['url']) :"welcome/view";
	
	$url=seperateslash($url);
	$url[1]=isset($url[1])?$url[1]:"view";//method

	$url[2]=isset($url[2])?$url[2]:[];// arg
	return $url;
	}

	function seperateslash($url){
		$url.='/';
		$url=rtrim($url, FILTER_SANITIZE_URL);
		$url=explode('/',filter_var(rtrim($url, FILTER_SANITIZE_URL)));
		$url=array_filter($url); 
		
			return $url;
	}


function session($index=false)
{
	if($index)
	{
		if(isset($_SESSION[$index])  &&  (!empty($_SESSION[$index]))  )
			return $_SESSION[$index]; 

	} 
	return false;
	
}








/*
*	user input validation
*-----------------------
*
*/
function filter_specialchar($var=" "){  
$from=array(
	'!' ,
	'@' , 
	'$' ,
	'%' ,
	'^' , 
	'*' ,
	'(' ,
	')' ,
	'_' ,
	'-' ,
	'+' ,
	'<' ,
	'>' ,
	'?' ,
	'/' ,
	'\\' ,
	'|' ,
	'[' ,
	']' ,
	'{' ,
	'}' ,
	'.' ,
	',' ,
	':' ,
	'"' ,
	"'" ,
	';' ,
	'=' 
	);
$to  =array(
	"&#33;",   /* ! */
	"&#64",	  /* @ */ 
	"&#36",	  /* $ */
	"&#37",	  /* % */
	"&#94",	  /* ^ */ 
	"&#42",	  /* * */
	"&#40",	  /* ( */
	"&#41",	  /* ) */
	"&#95",	  /* _ */
	"&#45",	  /* - */
	"&#43",	  /* + */
	"&#60",	  /* < */
	"&#62",	  /* > */
	"&#63",	  /* ? */
	"&#47",	  /* / */
	"&#92",	  /* \ */
	"&#124",	  /* | */
	"&#91",	  /* [ */
	"&#93",	  /* ] */
	"&#123",	  /* { */
	"&#125",	  /* } */
	"&#46",	  /* . */
	"&#44",	  /* , */
	"&#58",	  /* : */
	"&#34",	  /* " */
	"&#39",	  /* ' */
	"&#59",	  /* ; */
	"&#61"	  /* = */
	);
/*$vars= str_replace($from,$to,$var);*/
if(preg_match("([^a-zA-Z\.@\s&#])",$var))
$var=str_replace($from,$to, $var);

return $var;
}


function saintizeurl($url)
{
	if(isset($url))
		return filter_var(rtrim($url, FILTER_SANITIZE_URL));
	else return false;
}
function cleantohtml($s){
 	return strip_tags(htmlentities(trim(stripslashes($s)), ENT_NOQUOTES, "UTF-8"));
}



