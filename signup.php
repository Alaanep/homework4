<?php
  // Insert the page header
  $page_title = 'Sign Up';
  require_once('header.php');

  require_once('twittervars.php'); 
  // Generate the navigation menu
  require_once('navmenu.php'); 

	// Connect to the database
  	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  	if(isset($_POST['submit'])){
  		//grab the profile data from the POST
      $username=mysqli_real_escape_string($dbc, trim($_POST['username']));
      $password1=mysqli_real_escape_string($dbc, trim($_POST['password1']));
      $password2=mysqli_real_escape_string($dbc, trim($_POST['password2']));

      if(!empty($username) && !empty($password1) && !empty($password2) && $password1==$password2){
        //make sure someone isn't already registered using this username
        $query="SELECT * FROM 165332CTF_user WHERE username='$username'";

        $data=mysqli_query($dbc, $query);
        if(mysqli_num_rows($data)==0){
          //the username is unique, so insert the data into the database
          $query="INSERT INTO 165332CTF_user (username, password, join_date) VALUES ('$username', SHA('$password1'), NOW())";
          mysqli_query($dbc, $query);
          //confirm  success with the user
          echo '<p>Your new account has been successfully created. You\'re now ready to log in <a href="login.php">Log In</a>.</p>';
          mysqli_close($dbc);
          exit();
        }
        else {
          //an account already exists for this username, so display the error message
          echo '<p class="error">An account already exists for this username. Please use a different username</p>';
          $username=''; // clear the username variable so the form field is cleared
        }
      }
      else {
        echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.<p/>';
      }
  	}
    mysqli_close($dbc);
  ?>  
  <p>Please enter your username and desired password to sign up to Twitter.</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for='username'>Username:</label>
      <input type='text' id='username' name='username' 
      value="<?php if(!empty($username)) echo $username;?>" /><br />
      <label for='password1'>Password:</label>
      <input type='password' id='password1' name='password1' />
      <label for='password2'>Password(retype):</label>
      <input type='password' id='password2' name='password2' />
    </fieldset>
    <input type='submit' value='Sign Up' name='submit'/>
  </form>
<?php
  // Insert the page footer
  require_once('footer.php');
?>

