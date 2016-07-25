<?php
if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");

/* routing scripts */
/*
Route::to('support', function () { 
	return "welcome";
});
Route::to('signup', function () { 
	return "login/signup";
});

Route::reroute('reportproblem', function () { 
	if(!isset($_SESSION['uname']))
	{
		log_message("error","not logged for reporting problem");
		Route::to('reportproblem', function () {  
			return "error/redirt/login?msg=To report  login first.&redir=feedback/report";
		});
	}
	else{
		Route::to('reportproblem', function () { 
			log_message("info","loged and redirecting to feedback/report");
			return "feedback/report";
		});
	}
});


Route::to('logout', function () { 
	return "login/logout";
});
*/

$this->db=new db($this->model);
$re=$this->db->Query("select * from ".$config['db']['prefix']."links ");

while ($r=mysqli_fetch_assoc($re)) {
$r['from_link'].='/';

$from_link=$r['from_link'];		

		$from_link=explode('/',filter_var(rtrim($from_link, FILTER_SANITIZE_URL)));
		$from_link=array_filter($from_link); 
		
if( isset($url) && (!empty($from_link)) )
		{ if($url[0]==$from_link[0])
			{
				if(!isset($from_link[1]))
					{
						redir($r['to_link'],0,"Redirecting...");
						unset($this->db);
						die();
					}
				else {
					if($url[1]==$from_link[1]){
						redir($r['to_link'],0,"Redirecting...");
						 unset($this->db);
						die();
					}
				}
			}
				
		}

}
 unset($this->db);
