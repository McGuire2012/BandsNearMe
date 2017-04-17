<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['email'] == ""){
		header("Location: index.php");
		die();
	} //This if statement and the sessionstart need to be at the top of every page except for index.php

	$useremail = $_SESSION['email'];

	//connect to the database here and search by username/e-mail or whatever you passed from the index.php login screen
	$user = "SA";
	$PW = "111#ZXC#222";
	$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//need to grab every detail from the account table

	//What I want to do here is, the php will check the account type and the user information will populate in the correct fields, and if changes are made the form is updated.
	//Based on user type the forms will populate differently. Based on indiv, venue, band.
	$sql = "SELECT Username from USERS where UserEmail = '$useremail'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$resultName = $result[0][0];
	$name = $resultName;
  $isAdmin = 0;
  $isPerformance = 0;
  $sql = "SELECT UserType from USERS where UserEmail = '$useremail'";
  $q = $conn->query($sql);
  $result = $q->fetchAll();
  $resultType = $result[0][0];
  if($resultType == "Admin")
  {
		$sql = "SELECT Username from USERS where UserEmail = '$useremail'";
	  $q = $conn->query($sql);
	  $result = $q->fetchAll();
	  $resultName = $result[0][0];
		$name = $resultName;
    $isAdmin = 1;
    $isPerformance = 1;
  }
  if($resultType == "Band" || $resultType == "Venue")
  {
    $isPerformance = 1;
		if($resultType == "Band")
		{
			$sql = "SELECT BandName from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
		}
		elseif ($resultType == "Venue") {
			$sql = "SELECT Venue from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
		}
		else {
			$sql = "SELECT Username from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
		}
  }
	$sql = "SELECT profilePic from USERS where UserEmail = '$useremail'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$resultPicture = $result[0][0];
	$profilePicture = $resultPicture;
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Home Page</title>
    <link href="Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Styles/form.css" rel="stylesheet">
		<style>
		img	{}
		</style>
	</head>

	<body>
<!--Top & SideNavBar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
     <img src="Styles/LocationBNMicon.png" class="navbar-brand">
      <a class="navbar-brand" href="#">BandsNearMe</a>
    </div>
    <div class="collapse navbar-collapse" style="background-color:#2C2929">
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
				<li><a href="uploadEvents.html" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Book Performance</a></li>

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" <?php if ($isAdmin == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Reports
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="pieTest.php">Types of User</a></li>
            <li><a href="#">Traffic</a></li>
            <li><a href="#">User Sign-Up Rate</a></li>
          </ul>
        </li>
      </ul>
			<ul class="nav navbar-nav navbar-right">
      <li><a href="editProfile.php">Edit Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    </div><!--/.nav-collapse -->
</div><!--/.navbar -->



<div class="container">
  <!-- FORM -->
  <div class="panel panel-default">
 <form class="form-horizontal">
  <fieldset>
		<div class="col-lg-12">
		<div class="col-lg-5"><h3><?php echo $name; ?></h3>
			</div>
			</div>
			<div class="col-lg-12">
			<div class = "col-lg-10">
        <form id = "UpdateProfile" >
          Update Profile Picture <br>
          <input type="text" name="profilePic" >
          <br>
          Description <br>
          <div class="row">
      			<div class="col-md-6">
      				<textarea name="Description" cols="60" rows="10" placeholder="Description of the Band" required></textarea>
      			</div>
      		</div>
          <br>
          Add Pictures <br>
          <input type="text" name="UserName">
          <br>

          <br>
          <input type="submit" value="Submit">
        </form>
			</div>

		</div>




  </fieldset>
</form> <!-- End Form-->
 </div>

</div> <!-- End Container -->




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
</body>
</html>
