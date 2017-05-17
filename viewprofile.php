<?php
  //start the session
  require_once('startsession.php');
  
  //insert the page header
  $page_title='View Profile';
  require_once('header.php');
  
  require_once('twittervars.php');  

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  $query = "SELECT username, first_name, last_name, birthdate, city, picture, email, description FROM 165332CTF_user WHERE user_id = '". $_SESSION['user_id'] . "'";

  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    echo '<table>';
    if (!empty($row['username'])) {
      echo '<tr><td class="label">Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['first_name'])) {
      echo '<tr><td class="label">First name:</td><td>' . $row['first_name'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
      echo '<tr><td class="label">Last name:</td><td>' . $row['last_name'] . '</td></tr>';
    }
    if (!empty($row['birthdate'])) {
      // Show the user their own birthdate
      echo '<tr><td class="label">Birthdate:</td><td>' . $row['birthdate'] . '</td></tr>';
    }
    if(!empty($row['email'])){
      //show the user their own email
      echo '<tr><td class="label">Email:</td><td>' . $row['email'] . '</td></tr>';
    }
    if(!empty($row['description'])){
      //show the user theur own description      
      echo '<tr><td class="label">Description:</td><td>' . $row['description'] . '</td></tr>';
    }
    if (!empty($row['picture'])) {
      echo '<tr><td class="label">Picture:</td><td><img src="' . TWIT_UPLOADPATH . $row['picture'] .
        '" alt="Profile Picture" /></td></tr>';
    }
    echo '</table><p>Would you like to <a href="editprofile.php">edit your profile</a>?</p>';
    
  } // End of check for a single row of user results
  else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
  }
  // Retrieve  data from MySQL to display tweets
  $query2 = "SELECT * FROM 165332CTF_tweets WHERE user_id='" . $_SESSION['user_id'] . "' ORDER BY tweet_date DESC LIMIT 3";
  $data2 = mysqli_query($dbc, $query2);
  while ($row2 = mysqli_fetch_array($data2)) {
    $tweet=$row2['tweet'];
    $tweet_date=$row2['tweet_date'];

    echo '<div class="row tweet"> ';

    if (is_file(TWIT_UPLOADPATH . $row['picture']) && filesize(TWIT_UPLOADPATH . $row['picture']) > 0) {
      echo '<div class="col-md-5"><span> On ' . $tweet_date . '</span>'; 
      echo '<img src="' . TWIT_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '" class="img-rounded img-responsive" /></div>';
      echo '<div class="col-md-7">@'. $row['first_name'] . ' tweeted:<br /> ' . ' '. $tweet . '</div>';

    }
    else {
      echo '<div class="col-md-5"><span> On ' . $tweet_date . '</span>';
      echo '<img src="' . TWIT_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row['first_name'] . '" class="img-rounded img-responsive" /></div>';
      echo '<div class="col-md-7">@'.$row['first_name'] . ' tweeted:<br />' . ' '. $tweet. '</div>';
    }
    echo '</div>';
  }

  mysqli_close($dbc);
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
