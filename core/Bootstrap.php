<?php
if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
	/*
	* 	Bootstrap
	*/
class Bootstrap{   

	protected  $controller="welcome";
	protected  $method="_404error";
	protected  $param; 
	private $model;
	public $url="welcome/view";

	public function __construct(){
		log_message("info","Bootstrap initialized");
		global $config;
		global $url;
		global $model;
		$this->model=$model;
		$url=parseurl();
		/* 
		* Router function check
		*/
		if(file_exists($config['core']."Router.php") && file_exists($config['config']."Routers.php") )
		{ 
			require_once $config['core']."Router.php";
			require_once $config['config']."Routers.php";
			log_message("info","Routers added");
		}
		/*
		*  Router ends
		*/
		if(file_exists($config['controller'].$url[0].'.php'))
		{
			$this->controller=$url[0];
		}
		else
		{
			$this->controller='error';
		}
		unset($url[0]);

		require_once $config['controller'].$this->controller.'.php';
		log_message("info","$this->controller included");

		$thispageurl=[$this->controller]; 
 
		$this->controller=new $this->controller;
		log_message("info","controller object created");

		if(isset($url[1]))
		{
			if(strtolower($url[1])!="__construct")
			{
				if(! (method_exists($this->controller,$url[1]) && $this->parent_method_exists($this->controller,$url[1])) )
				{
					if(method_exists($this->controller,$url[1]))
					{
						$this->method=$url[1];
						log_message("info","{$this->method} exist  in {controller} ");
					}
				}
			}
			else
			{
				log_message("info","__construct may exist but not alloweded as  controller/method ");
			}
			array_push($thispageurl,$this->method);
			unset($url[1]);
		}

		$url=array_filter($url);
		$thispageurl=array_merge($thispageurl,$url);
		$this->param=$url?array_values($url):[];
 		$this->thispageurl=$thispageurl;
 		/*
		* cache creation and handling 
		*/
		if(false)//!isset($_SESSION['log']))
		{
		 
			if(file_exists($config['core'].'MlCache.php'))
			{
				require_once $config['core'].'MlCache.php';
				$cache=new MlCache($config['plugin']."mlcache/cache.php",$config['cache']);			
				$cache->start($thispageurl,function(){
					global $start_time;
					//time calculation
					$end_time=microtime(true);
					$total_time=$end_time-$start_time;
					log_message("TIME",$total_time);
				});
			 
			}
		}
		$this->controller->{$this->method}($this->param);
		
		if(isset($cache))
		{ 
			$cache->end();			
		}
	}

	private function parent_method_exists($object,$method)
	{
	    foreach(class_parents($object) as $parent)
	    {
	        if(method_exists($parent,$method))
	        {
	           return true;
	        }
	    }
	    return false;
	}


}