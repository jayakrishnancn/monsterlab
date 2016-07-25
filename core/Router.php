<?php
/**
* 
*/


class Route 
{
	public static function to($var='',$fn){

		global $url;
		if( isset($url) && (!empty($var)) )
		{
			if($url[0]==$var)
			{
				$tmpurl=seperateslash($fn());
				foreach ($tmpurl as $key => $value) 
				{
					$url[$key]=$value;
				} 
			}
		}
	

	}
	public static function reroute($var='',$fn){
		global $url;
		if( isset($url) && (!empty($var)) )
		{ if($url[0]==$var)
			{
				$fn();
			}
				
		}
	}
	public  function redirect_url($var='',$fn){
		echo "SAd";
		global $url;
		
		if( isset($url) && (!empty($var)) )
		{ if($url[0]==$var)
			{
				$fn();
			}
				
		}
	}
	/*public static function replace($str='',$rep='')
	{
		$serverqs=isset($_SERVER['REDIRECT_QUERY_STRING'])?$_SERVER['REDIRECT_QUERY_STRING']:''; 
		if($str===''||$rep==='')
			return;
		 
			if(!is_array($serverqs))
			{
				//$serverqs=str_replace($str, $rep,$serverqs);
				if(($pos=strpos($serverqs, $str))!==false)
				{

					global $url; 
					$remaining_serverqs=$url;//change to trim $serverqs[0 to ($pos+(strlen($str))]
					$rep=array_filter(explode('/',$rep));
					$url=array_merge($rep,$remaining_serverqs);
				} 
			}  

	}*/

}

