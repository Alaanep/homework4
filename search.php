<?php
	//start the session
 	require_once('startsession.php');
	
	require_once('twittervars.php');  

	//insert the page header
	$page_title='Search';
	require_once('header.php');

	// Show the navigation menu
  	require_once('navmenu.php');

  	// Connect to the database 
  	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  	if(isset($_POST['submit'])){
  		$searchdata=mysqli_real_escape_string($dbc, trim($_POST['searchdata']));
  		if(!empty($searchdata)){
  			$query="SELECT username, first_name, last_name, user_id, birthdate, email,  description, picture FROM 165332CTF_user WHERE username='$searchdata' or first_name='$searchdata' or last_name='$searchdata' ";
  			$data=mysqli_query($dbc, $query);
  			while ($row = mysqli_fetch_array($data)) {
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
			      if (!isset($_GET['user_id']) || ($_SESSION['$user_id'] == $_GET['user_id'])) {
			        // Show the user their own birthdate
			        echo '<tr><td class="label">Birthdate:</td><td>' . $row['birthdate'] . '</td></tr>';
			      }
			      else {
			        // Show only the birth year for everyone else
			        list($year, $month, $day) = explode('-', $row['birthdate']);
			        echo '<tr><td class="label">Year born:</td><td>' . $year . '</td></tr>';
			      }
			    }
			    if(!empty($row['email'])){
			      if (!isset($_GET['user_id']) || ($_SESSION['$user_id'] == $_GET['user_id'])) {
			        //show the user their own email
			        echo '<tr><td class="label">Email:</td><td>' . $row['email'] . '</td></tr>';
			      }
			    }
			    if(!empty($row['email'])){
			      //show description
			      echo '<tr><td class="label">Description:</td><td>' . $row['description'] . '</td></tr>';

			    }
			    if (!empty($row['picture'])) {
			      echo '<tr><td class="label">Picture:</td><td><img src="' . MM_UPLOADPATH . $row['picture'] .
			        '" alt="Profile Picture" /></td></tr>';
			    }
			    echo '</table>';
			  } 
  			mysqli_close($dbc);
  		}
  		else{
  			echo '<p class="error" > We could not find anything with your search criteria. Please try again!</p>';
  		}
  	}

  	//insert the page footer
    require_once('footer.php');
?>