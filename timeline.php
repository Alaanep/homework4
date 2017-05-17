<?php
  //start the session
  require_once('startsession.php');

  require_once('twittervars.php');  

  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  // Retrieve  data from MySQL
  $query = "SELECT * FROM 165332CTF_tweets ORDER BY tweet_date DESC LIMIT 15";
  $data = mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($data)) {
    $user_id=$row['user_id'];
    $tweet=$row['tweet'];
    $tweet_date=$row['tweet_date'];

  	$query2="SELECT first_name, picture FROM 165332CTF_user WHERE user_id='" . $user_id . "' ";
  	$data2=mysqli_query($dbc, $query2);
  	$row2=mysqli_fetch_array($data2);

  	echo '<div class="row tweet"> ';

  	if (is_file(TWIT_UPLOADPATH . $row2['picture']) && filesize(TWIT_UPLOADPATH . $row2['picture']) > 0) {
  		echo '<div class="col-md-5"><span> On ' . $tweet_date . '</span>'; 
    	echo '<img src="' . TWIT_UPLOADPATH . $row2['picture'] . '" alt="' . $row2['first_name'] . '" class="img-rounded img-responsive" /></div>';
    	echo '<div class="col-md-7">@'. $row2['first_name'] . ' tweeted:<br /> ' . ' '. $tweet . '</div>';

    }
    else {
      echo '<div class="col-md-5"><span> On ' . $tweet_date . '</span>';
      echo '<img src="' . TWIT_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row2['first_name'] . '" class="img-rounded img-responsive" /></div>';
      echo '<div class="col-md-7">@'.$row2['first_name'] . ' tweeted:<br />' . ' '. $tweet. '</div>';
    }
    echo '</div>';
  }
  mysqli_close($dbc);
?>