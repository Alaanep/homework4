<?php
  //start the session
  require_once('startsession.php');

  // Make sure the user is logged in before going any further.
  if (isset($_SESSION['user_id'])) {
    //insert the page header
    $page_title='Welcome to Twitter';
    require_once('header.php'); 

    // Generate the navigation menu
    require_once('navmenu.php');

    //insert tweet
    require_once('inserttweet.php');   

    //insert timeline
    require_once('timeline.php'); 

    //insert the page footer
    require_once('footer.php');
  } 
  else {
    //insert the page header
    $page_title='Welcome to Twitter';
    require_once('header.php'); 

    // Generate the navigation menu
    require_once('navmenu.php');

    //insert the page footer
    require_once('footer.php');

  }

  
?>
