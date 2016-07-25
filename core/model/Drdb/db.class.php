<?php
/**
* @author jayakrishnancn
* @version 1.0
* @since 1.0
* @link jayakrishnancn@gmail.com
*/
if(!function_exists('log_message'))
{
	function log_message($info='info',$msg='')
	{
		global $config;
		if(isset($config['dev']) && $config['dev']==true)
		echo "[".$info."] ".$msg." <br/>";
	}
}
class db
{
	public $DbConn;
	private $dbdriver;
	private $hostname;
	private $port;
	private $username;
	private $password;
	private $database;

	function __construct($arg='')
	{
	if(isset($arg) && (!empty($arg)))
		$this->CreateConn($arg);
	log_message("info","db constructor invoked .");
	}//__constructor ends

	public function CreateConn($arg='')
	{
		if(isset($arg) && (!empty($arg)))
		{
			foreach ($arg as $key => $value) {
				switch ($key) {
					case 'dbdriver':$this->dbdriver=$value;break;
					case 'hostname':$this->hostname=$value;break;
					case 'port':$this->port=$value;break;
					case 'username':$this->username=$value;break;
					case 'password':$this->password=$value;break;
					case 'database':$this->database=$value;break;
					
					default:break;
				}
			}

			$this->DbConn =new mysqli($this->hostname, $this->username, $this->password, $this->database);

			if ($this->DbConn->connect_error) 
			{
				die("Connection failed: " . $this->DbConn->connect_error);
			}
			else {
				log_message("info","connected to ".$this->hostname);
			}	
		}
		else{
			log_message("info","no arguments passed on CreateConn");
		}
	}//CreateCOn ends

	public function CloseConn()
	{
		if($this->DbConn->close())
		log_message("info","close successful");
	}

public function Query($sql='',$schema=false)
{ 
    

	if( (isset($sql)) &&(!empty($sql)) )
	{
	if($schema==false)
	{
		if((isset($this->database)) &&(!empty($this->database)))
		{
			$result=$this->DbConn->query($sql);
	
			if(!$result) 
				log_message("error",$this->DbConn->error.__FILE__ .__LINE__);
			else 
				return $result;
		
		}
		else{
			log_message("error","database not found".__FILE__.__LINE__);
		}

	}
	else{
		$result=$this->DbConn->query($sql);		
		
		if(!$result) 
			log_message("error",$this->DbConn->error.__FILE__ .__LINE__);
		else 
			return $result;
	}

		
	}
	else{
		log_message("info","no sql quey provided".__FILE__ .__LINE__);
	}
}//end of Query function




	public function CreateDb($name='')
	{
		if(!$this->DbConn)
		{
			log_message("error","Connection not found");
			return false;
		}
		if((isset($name))&&(!empty($name)))
		{
			if($this->Query("CREATE DATABASE ".$name." ",true))
			{
				log_message("info","DATABASE ".$name." created");
				return true;
			}
			else{
				log_message("error","Error creating database ".$name );
				return false;
			}
		}
	} // end CreateDb



public function DropDb($TmpName="",$ServerName='localhost',$DbUsername='root',$DbPassword='')
{
	if( (isset($TmpName)) && (!empty($TmpName)) ) {
		if (!$this->DbConn) 
			$this->CreateConn($ServerName,$DbUsername,$DbPassword);

		log_message("info","DATABASE Droping...[ Db ~ DropDATABASE  --- ".__FILE__."::".__LINE__."::---- ] ");
		return $this->Query("DROP DATABASE  ".$TmpName." ",true);
	}//end of if($TableName!='_temp_default')
	else{
		log_message("error","DATABASE Not specified [ Db ~ DropTable  --- ".__FILE__."::".__LINE__."::---- ] ");	
		return false;
	}//end of else ($DATABASE!='_temp_default')

}//end of dropdb function


public function CreateTable($TmpTableName='',$param='')
{
	if(!$this->DbConn)
	{
		log_message("error","Connection not found");
		return false;
	}
	if((!isset($this->database))||(empty($this->database)))
		{
			log_message("error","database not found");
			return false;
		}
	if((isset($TmpTableName))&&(!empty($TmpTableName)) &&(isset($param))&&(!empty($param)) )
	{
		if($this->Query("CREATE TABLE ".$TmpTableName." ( ".$param." ) "))
		{
			log_message("info","Table ".$TmpTableName." created");
			return true;
		}
		else{
			log_message("error","Error creating table ".$TmpTableName );
			return false;
		}
	}
	else {
		log_message("error","invalid parameters ".__FILE__.__LINE__);
	}


} //end CreateTable

	public function DropTable($TableName="")
	{
		if( (isset($this->DbConn)) && (!empty($this->DbConn)) && (isset($this->database))  && (!empty($this->database)) )
		if( (isset($TableName)) && (!empty($TableName)) ) {
			log_message("info","Table Droping...[ Db ~ DropTable  --- ".__FILE__."::".__LINE__."::---- ] ");
			return $this->Query("DROP TABLE  ".$TableName." ",true);
		}//end of if($TableName!='_temp_default')
		else{
			return false;
			log_message("error","TableName Not specified [ Db ~ DropTable  --- ".__FILE__."::".__LINE__."::---- ] ");	
		}//end of else ($TableName!='_temp_default')

	}//end of TableDrop function



	private function SetVal($property='',$value='')
	{
		if( (!isset($value)) ||(empty($value)) || (!isset($property)) ||(empty($property)))
		{
			log_message("error","parameter(s) empty ".__FILE__.__LINE__);
			return false;
		}
		$this->$property=$value;
		return true;

	}	// end SetVal

	public function SetDatabase($value=''){
		if($this->SetVal("database",$value))
			return true;
		return false;
	}//end setDatabase

	public function Select($TmpTableName='',$wherestmt='',$columens="*")
	{
		if(!isset($TmpTableName)|| empty($TmpTableName))
		{
			return false;
		}			
		else{
			$this->Query("select ".$columens." from ".$TmpTableName." where ".$wherestmt." ");
		}
	}

	function rowinsert($table_name='', $form_data)
	{
	    // retrieve the keys of the array (column titles)
	    $fields = array_keys($form_data);

	if(isset($fields))
	foreach ($form_data as $key => $value) {
	$form_data[$key]=$this->cleanpost($form_data[$key]);
	}
	    // build the query
	    $sql = "INSERT INTO ".$table_name."(`".implode("`,`", $fields)."`) VALUES (\"".implode('","', $form_data)."\")";

	    // run and return the query result resource
	    return $this->Query($sql);
	}

/*
	private  function mres($value)
	{
	$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

	return str_replace($search, $replace, $value);
	}*/
	private function cleanpost($s){
	return strip_tags(htmlentities(trim(stripslashes($s)), ENT_NOQUOTES, "UTF-8"));
	}
 
}//end db class