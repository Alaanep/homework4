<?php
	//if the session vars aren't set, try to set them with a cookie
  	if(!isset($_SESSION['user_id'])){
    	if(isset($_COOKIE['user_id']) && isset($_COOKIE['username'])){
      	$_SESSION['user_id']=$_COOKIE['user_id'];
      	$_SESSION['username']=$_COOKIE['username'];
    	}
  	}

	// Start the session
    if(!isset($_SESSION)){ 
      session_start(); 
    } 
	require_once('twittervars.php');

?>