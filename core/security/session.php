<?php
defined('MONSTER') OR exit('No direct script access allowed');

@log_message("info","inside session.php");

$session_max_time=isset($config['session_max_time'])?$config['session_max_time']:60*2;//2 mins

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}  
if ( is_session_started() === FALSE ){ 
        session_start();
        @log_message("info","new session started");
       
}

if(!isset($_SESSION['ml-time']) || (empty($_SESSION['ml-time'])))
{
     $_SESSION['ml-time']=time();
}
if(time() >$_SESSION['ml-time']+$session_max_time  )
{
    session_unset();
    session_destroy();
    @log_message("info","session ended");
} 

/*
*   to prevent Session Stealing with javascript
*/
ini_set('session.cookie_httponly', 1); 
        @log_message("info","session.cookie_httponly set to 1");

/*  session start here */  

/*
*   to prevent Session Fixation
*  regenerate sessionid each  20 request (counted bcoz if freq used may lead to over head and slow the web )
*
*/
    if(!isset($_SESSION['session_request_count']))$_SESSION['session_request_count'] = 0;

if (++$_SESSION['session_request_count'] >= 20) {
    $_SESSION['session_request_count'] = 0;
    session_regenerate_id(true);
        @log_message("info","session_request_count set to 0 and id regenerated ");
}
        @log_message("info","session_request_count increased to ".$_SESSION['session_request_count']." ");
 
