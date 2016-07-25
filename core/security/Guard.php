<?php 
require_once $config['security']."function.php";

require_once $config['security']."session.php"; 
class guard
{
	function __construct()
	{
		log_message("info","** guard __construct initilized");


		 if(isset($_GET))
		{
			foreach ($_GET as $key => $value) {
				$_GET[$key]=$this->sanitizeglobals($_GET[$key]);

				log_message("info"," sanitized global _GET");
			} 
		}
			
		if(isset($_POST))
		{
			foreach ($_POST as $key => $value) {
				$_POST[$key]=$this->sanitizeglobals($_POST[$key]);
			}
				log_message("info"," sanitized global _POST"); 
		}

		if(isset($_SESSION))
		{
			foreach ($_SESSION as $key => $value) {
				$_SESSION[$key]=$this->sanitizeglobals($_SESSION[$key]);
			} 
				log_message("info"," sanitized global _SESSION");
		}
		log_message("info"," sanitized globals "); 
 
	} 
	public function sanitizeglobals($value='')
	{/*
		$value=strip_tags(htmlentities(trim(stripslashes($value)), ENT_NOQUOTES, "UTF-8"));
		$value=trim($value);*//*
		$value=strip_tags($value);*/
		$value=htmlentities($value); 
		$value=stripslashes($value);
		return $value;
	}
	public function passenc($value='')
	{
		$salt=$this->randstring(10); 
		$res=$this->encript_it($value,$salt);
		log_message("info","in password encript");
		return  array(0=>$res,1=>$salt);

	}
	public function passdec($value,$salt)
	{
		$res=$this->encript_it($value,$salt);
		log_message("info","in password decript");
		return $res;

	} 
	public 	function randstring($length="4")
	{  
		return  substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	} 
	private function encript_it($string=NULL,$salt="3h7lV6CaHP")
	{
		if(isset($string) && $string!=NULL)
		{
			$string1=substr($string,0,strlen($string)/2) ;
			$string2=substr($string,strlen($string)/2) ;

			$string=$string1.$salt.$string2;

			/*return $string;*/
			return  hash("sha1",$string); 
		}
		return false;
	}


}


