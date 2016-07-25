<?php
if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
		
class controller{  
	protected $config;
	protected $guard; 
		
	public function __construct(){
		global $config;
		$this->config['session_max_time']=60*1;
		$this->config=$config; 
		$this->guard=new guard;  
		log_message("info","*controller class initialized"); 
	} 

	public function _view($url=[],$data=[])
	{ 
		$title=(!empty($config['title']))?$config['title']:"Monsterlab";
		if(isset($data))
			foreach ($data as $key => $value) {
				$$key=$value; 
			}
		if(is_array($url))
		foreach ($url as $value)
		{

			if(file_exists($this->config['view'].$value.".php"))
			{ 
				require_once  $this->config['view'].$value.".php";
 			}
			else 
				log_message("error","$value not found");
		}
		else{

			if(file_exists($this->config['view'].$url.".php"))
			{
				require_once $this->config['view'].$url.".php";
 			}
			else 
				log_message("error","$url not found");	
		} 
	}
 
	public function _404error(){ 
		$this->_error('404 Error','Page Not Found Or Moved');
	}
	public function _autherror(){ 
		$this->_error('401 Error','Page not Foud Or Authentication Problem ');
	}
	public function _401error(){ 
		$this->_error('401 Error','Page not Foud Or Authentication Problem ');
	}
	public function _400error(){ 
		$this->_error('400 Error','Bad request  ');
	}
	public function _403error(){ 
		$this->_error('400 Error','Page / file Forbidden  ');
	} 
	public function _error($h='',$msg=''){
		include_once $this->config['view']."default/error.php";
	}
	public function parent_method_exists($object,$method)
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