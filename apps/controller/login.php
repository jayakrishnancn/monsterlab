<?php 
if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
/**
* 
*/
class login extends controller
{
	private $model;
	public function __construct()
	{
		parent::__construct();
		include_once $this->config['model'].'login.php';
			log_message("info","model included ");
			$this->model=new loginModel;
	}
	
	public function view($value='')
	{
		
		
		if($this->model->isloged())
		{
			$to="";
			if($this->model->isadmin())
				$to="admin";
			redir(HTTPPATH.$to);
				return; 

		}
		$msg=null;

		if(isset($_POST['uname']) || isset($_POST['pass']))
		{
			if(isset($_POST['uname']) && (!empty($_POST['uname'])) && isset($_POST['pass']) && (!empty($_POST['pass'])) )
			{/*
						$pass=$this->guard->passenc($_POST['pass']); 
						$this->model->insertUser($_POST['uname'],$pass[0],$pass[1]);*/
						 

				$pass=$this->guard->passdec($_POST['pass'],$this->model->findsalt($_POST['uname']));
				
				$re=$this->model->checkuser($_POST['uname'],$pass);
				
				$num=mysqli_num_rows($re);
 
				if($num==1)
				{
					$to="admin";
					log_message("info","redirecting set to user");

					$r=mysqli_fetch_assoc($re);
					$_SESSION['uname']=$r['uname'];


					$_SESSION['log']=true;
					if($r['isadmin']==1)
					{
						$to="admin";
						log_message("info","redirecting set to  admin");

					}
					else
					{
						$this->logout();
					}
					if(isset($_POST['redir']) && (!empty($_POST['redir'])))
					{
						$to=$_POST['redir'];	
						log_message("info","redirecting set to {$_POST['redir']}");
					}
					

						redir(HTTPPATH.$to);
					return ;
				} 
				else{
					$msg="User not found ! <br/>Check username and password";
				}
			}
		else{
			if(empty($_POST['uname']))
				$msg="Username is empty";
			if(empty($_POST['pass']))
				$msg="Password is empty";
			if(empty($_POST['uname']) && empty($_POST['pass']))
				$msg="Empty Username and Password ";
		}
		}	
  		$url='login';
  		$data=['title'=>"Monsterlab | login",'sel'=>'login','config'=>$this->config,'msg'=>$msg];
  		$this->_view($url,$data);
  	}
 
	 public function logout()
	{
		session_unset();
		if ( is_session_started() !== FALSE )
			session_destroy();
		log_message("info","session ended");
		if(isset($_SESSION['uname']))
		{
			$this->_error("cant logout","please reload page");
			log_message("error","session  unset".__FILE__.__LINE__);
		}
		else
		{ 				
				log_message("info","log out successful ".__FILE__.__LINE__);
				redir(HTTPPATH."login?msg=logout successful");
				return; 
		}
	}
	
	
}