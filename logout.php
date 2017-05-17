<?php
	if(!isset($_SESSION)){ 
      session_start(); 
    } 
	//if the user is logged in, delete the cookie to log them out
	if(isset($_SESSION['user_id'])){
		//delete the session vars by clearig the $_SESSION array
		$_SESSION=array();
		//delete the session cookie by setting its expirations to an hour ago(3600)
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),'', time() - 3600);
		}
		//destroy the session
		session_destroy();
		
	}
	//delete the user ID and username cookies by setting their expirations to an hour ago(3600)
	setcookie('user_id', $row['user_id'], time() - 3600);//expires in 30days
	setcookie('username', $row['username'], time() - 3600);//expires in 30days
	//Redirect to the home page
	$home_url='http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $home_url);
?>