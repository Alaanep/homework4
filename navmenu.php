<?php
	// Generate the navigation menu
 	if(isset($_SESSION['username'])){
    echo '<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
		echo '<li class="nav-item"><a class="nav-link" href="viewprofile.php">View Profile</a></li>';
		echo '<li class="nav-item"><a class="nav-link" href="editprofile.php">Edit Profile</a></li>';
    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out (' . $_SESSION['username'] . ')</a></li>';
?>
  <li class="nav-item">
    <form method='post' action='search.php'>
      <input type='text' id='searchdata' name='searchdata' />
      <input type='submit' value='search' name='submit' />
    </form>  
  </li>
<?php
  }
    else {
      echo '<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
      echo '<li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>';
      echo '<li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>';
    }
?>
    </ul>
  </div>
</nav>
<div class='container mainContainer'>
  <div class='row'>
    <div class="col-md-8">