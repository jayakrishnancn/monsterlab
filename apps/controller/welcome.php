<?php if( (!defined("BASEPATH") )   )
		die("no direct script allowed  ");
/**
* 
*/
class welcome extends controller
{


  private $actmodel;
  public function __construct()
  {
    parent::__construct();
    include_once $this->config['model'].'publicmodel.php';
      log_message("info","public model included ");
      $this->actmodel=new publicmodel;
  }
  
	public function view($value='')
	{
  		log_message("info","entered in home welcome view");
  		$url=['html_start','home', 'feedback','html_end'];
  		$extcss=['home','activities','members'];
      $activities=$this->actmodel->gethomeact();
      $news=$this->actmodel->gethomenews();
      $members=$this->actmodel->gethomemembers();
  		$data=['title'=>"IEEE SCTCE  | Home",'sel'=>'home','members'=>$members,'extcss'=>$extcss,'news'=>$news,'activities'=>$activities,'config'=>$this->config];
  		$this->_view($url,$data);
  	}
	 
	
}