<?php
    //start the session
  require_once('startsession.php');

  //insert the page header
  $page_title='Edit Profile';
  require_once('header.php');
  
  require_once('twittervars.php');   

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

  // Show the navigation menu
  require_once('navmenu.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
    $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
    $email=mysqli_real_escape_string($dbc, trim($_POST['email']));
    $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
    $picture = mysqli_real_escape_string($dbc, trim($_FILES['picture']['name']));
    $description=mysqli_real_escape_string($dbc, trim($_POST['description']));
    $picture_type = $_FILES['picture']['type'];
    $picture_size = $_FILES['picture']['size']; 
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($picture)) {
      list($picture_width, $picture_height) = getimagesize($_FILES['picture']['tmp_name']);
      if ((($picture_type == 'image/gif') || ($picture_type == 'image/jpeg') || ($picture_type == 'image/pjpeg') ||
        ($picture_type == 'image/png')) && ($picture_size > 0) && ($picture_size <= TWIT_MAXFILESIZE) &&
        ($picture_width <= TWIT_MAXIMGWIDTH) && ($picture_height <= TWIT_MAXIMGHEIGHT)) {
        // Move the file to the target upload folder
        $target = TWIT_UPLOADPATH . basename($picture);
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
        }
        else {
          // The picture file move failed, so delete the temporary file and set the error flag
          @unlink($_FILES['picture']['tmp_name']);
          $error = true;
          echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
        }
      }
      else {
        // The picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['picture']['tmp_name']);
        $error = true;
        echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (TWIT_MAXFILESIZE / 1024) .
          ' KB and ' . TWIT_MAXIMGWIDTH . 'x' . TWIT_MAXIMGHEIGHT . ' pixels in size.</p>';
      }
    }

    // Update the profile data in the database
    if (!$error) {
      if (!empty($first_name) && !empty($last_name) && !empty($birthdate) && ! empty($email) && !empty($city) && !empty($description))  {
        // Only set the picture column if there is a picture
        if (!empty($picture)) {
          $query = "UPDATE 165332CTF_user SET first_name = '$first_name', last_name = '$last_name', " .
            " birthdate = '$birthdate', email='$email', city = '$city',".
            " picture = '$picture', description='$description' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        else {
          $query = "UPDATE 165332CTF_user SET first_name = '$first_name', last_name = '$last_name', " .
            " birthdate = '$birthdate', email='$email', city = '$city', description='$description'".
            " WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT first_name, last_name, birthdate, city, picture, email, description FROM 165332CTF_user WHERE user_id = '" . $_SESSION['user_id']. "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $birthdate = $row['birthdate'];
      $city = $row['city'];
      $email=$row['email'];
      $description=$row['description'];
    }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo TWIT_MAXFILESIZE; ?>" />
    <fieldset>
      <legend>Personal Information</legend>
      <label for="firstname">First name:</label>
      <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
      <label for="lastname">Last name:</label>
      <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
      <label for="birthdate">Birthdate:</label>
      <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" /><br />
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
      <label for="city">City:</label>
      <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
      <label for="picture">Picture:</label>
      <input type="file" id="picture" name="picture" /><br />
      <label for="description">Say something about yourself</label>
      <textarea id='description' name='description' rows='4' cols='40' maxlength='100'><?php if (!empty($description)) echo $description; ?></textarea> <br>
    </fieldset>
    <input type="submit" value="Save Profile" name="submit" />
  </form>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
