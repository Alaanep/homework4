<?php
    //start the session
  require_once('startsession.php');

  require_once('twittervars.php');   

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }
  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
  // Grab the tweet data from the POST
  $user_id=$_SESSION['user_id'];
  $tweet=mysqli_real_escape_string($dbc, trim($_POST['tweet']));
  
    if (!empty($tweet)){
      $query = "INSERT INTO 165332CTF_tweets (user_id, tweet_date, tweet) VALUES ('" . $_SESSION['user_id']. "', NOW(), '$tweet')";
      mysqli_query($dbc, $query);
      mysqli_close($dbc);
    }
    else {
      echo '<p class="error">You havent entered your tweet.</p>';
    }
  }
?>

  <h2>Let the world know what's happening </h2>
  <form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Tweet</legend>
      <textarea id='tweet' name='tweet' rows='4' cols='40' maxlength='140'>Insert your tweet:</textarea> <br>
    </fieldset>
    <input type='submit' value='tweet' name='submit'/>
  </form>

  <?php
    //clean up $tweet variable
    $tweet='';
  ?>