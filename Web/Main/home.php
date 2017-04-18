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
	$username = $name;
	$_SESSION['username'] = $name;
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
			$sql = "SELECT BDesc from BAND where BUserName = '$username'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $Bdesc = $result[0][0];
			$Bdesc = '<div class = "col-lg-10">
								<h4>Description</h4>
								<p>'.$Bdesc.' </p>
								</div>';
		}
		elseif ($resultType == "Venue") {
			$sql = "SELECT VenueName from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
			$sql = "SELECT VDesc from VENUE where VUserName = '$username'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $Vdesc = $result[0][0];
			$Vdesc = '<div class = "col-lg-10">
								<h4>Description</h4>
								<p>'.$Vdesc.' </p>
								</div>';
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
      <a class="navbar-brand" href="home.php">BandsNearMe</a>
    </div>
		<div class="collapse navbar-collapse" style="background-color:#2C2929">
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
				<li><a href="../Account/AccountInfo.php">Account</a></li>
				<li><a href="../Account/editProfile.php">Edit Profile</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" <?php if ($isAdmin == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Reports
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../Processes/pie.php">Types of User</a></li>
            <li><a href="#">Traffic</a></li>
            <li><a href="../Processes/signup.php">User Sign-Up Rate</a></li>
          </ul>
        </li>
      </ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
      <li><a href="../Processes/logout.php">Logout</a></li>
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
			<img <?php echo 'src = "'.$profilePicture.'"'; ?> class = "thumbnail" width="200" height="200" />
			</div>
			</div>
			<div class="col-lg-12">
			<div class = "col-lg-10">
				<h4>Photos</h4>
				<p><?php
				$directory = "uploads/$useremail"."/";
				$images = glob($directory."*.*");
				if($images[0] == null)
				{
					echo "You current have no photos uploaded.";
				}
				else {
					foreach ($images as $image) {
						echo '<img style=" float:left; display:inline" src = "'.$image.'" class = "thumbnail" width ="150" height = "150" />';
					}
				}

				?>
				</p>

			</div>
			<?php echo $Vdesc;?>
			<?php echo $Bdesc;?>
			<div class = "col-lg-10">
				<h4>Favorites</h4>
				<p><?php
				$sql = "SELECT Count(Username) from Favorite where UserName = '$username'";
			  $q = $conn->query($sql);
			  $result = $q->fetchAll();
			  $resultCount = $result[0][0];
				if($resultCount > 0)
				{
					$sql = "SELECT BUserName, VUserName from Favorite where UserName = '$username'";
				  $q = $conn->query($sql);
				  $result = $q->fetchAll();
					for($i =0; $i<$resultCount; $i++)
					{
						if($result[i][0]!= null)
						{
							$bandResult = $result[i][0];
							echo "You liked the band: $bandResult<br>";
						}
						else {
							$venueResult = $result[i][1];
							echo "You liked the band: $venueResult<br>";
						}
					}

				}
				else
				{
					echo "<p>You have no favorite. Go like some venue and bands!!</p>";
				}
				?> </p>
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
