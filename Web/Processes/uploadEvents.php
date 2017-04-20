<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['email'] == ""){
		header("Location: ../index.php");
		die();
	} //This if statement and the sessionstart need to be at the top of every page except for index.php

	$useremail = $_SESSION['email'];
    $username = $_SESSION['username'];
    $userType = $_SESSION['resultType'];

  if($resultType == "Admin")
 	{
   		$isAdmin = 1;
   		$isPerformance = 1;
 	}
  if($resultType == "Band" || $resultType == "Venue")
  	{
    	$isPerformance = 1;
  	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Create Shows</title>
    <link href="../Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../Styles/form.css" rel="stylesheet">
	</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
         <img src="../Styles/LocationBNMicon.png" class="navbar-brand">
          <a class="navbar-brand" href="../Main/home.php">BandsNearMe</a>
        </div>
        <div class="collapse navbar-collapse" style="background-color:#2C2929">
          <ul class="nav navbar-nav">
            <li><a href="../Main/home.php">Home</a></li>
            <li class="active"><a href="../Account/AccountInfo.php">Account</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" <?php if ($isAdmin == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Reports
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../Processes/pie.php">Types of User</a></li>
                <li><a href="../Processes/ShowDate.php">Shows Per Day</a></li>
                <li><a href="../Processes/signup.php">User Sign-Up Rate</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right" style="padding-right: 30px">
            <li><a href="../Main/about.html">About</a></li>
            <li><a href="../Main/contact.html">Contact</a></li>
          <li><a href="../Processes/logout.php">Logout</a></li>
        </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.navbar -->


 <div class="container-fluid">
      <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9 col-sm-push-3">
<!-- Content here -->

  <div class="panel panel-default">
  <div class="panel-body">
  		<div class="alert alert-dismissible alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Warning!</h4>
			<p>No Special Characters in text area!</p>
		</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-8"><h3 style="color:#4A4A4A">Book Performances</h3> </div>
	</div>
	<br>
	<br>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<p class="lead">You can either upload a file <b>or</b> use the textbox provided to create a single show or multiple shows at once!</p>
		</div>
	</div>
	<br>
<!-- FORM -->

	<form action="parseFile.php" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<h5 style="color:#4A4A4A">Select file to upload an event:</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<label class="btn btn-default" for="fileToUpload">
					Choose File<input type="file" name="fileToUpload" id="fileToUpload" style="display:none">
				</label>
				<input type="submit" value="Upload File" name="submit" class="btn btn-primary">
			</div>
		</div>
	</form>
	<br>
	<br>
	<br>
<!-- END FORM -->
	<form method="post" action="parse-textarea.php">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<p class="lead">Follow the format below to create an event by text:</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<p>Band UserName, Venue UserName, Description of show, Show date (MM/DD/YYYY), Show time (Millitary 20:00 or 8:00pm)</p>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<textarea name="moreinfo" cols="60" rows="10" placeholder="Band UserName, Venue UserName, Description of show, Show date (MM/DD/YYYY), Show time (Millitary 20:00 or 8:00pm)" required></textarea>
				<span class="help-block">To create multiple shows at once, press enter to start a new line and follow the template again.</span>
			</div>
		</div>
		<br>
		<br>
		<br>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4"></div>
					<div class="col-md-4">
					<input type="submit" value="Submit Answer" class="btn btn-primary">
					<input type="reset" class="btn btn-default">
				</div>
			</div>
		</div>
	</form>
  </div>
  </div>
<!-- Sidebar here -->
</div> <!--/.col-xs-12.col-sm-9-->
        <div class="col-xs-6 col-sm-3 col-sm-pull-9 sidebar-offcanvas" id="sidebar">
          <div class="list-group" style="padding-top: 50px">
            <h3 class="list-group-item-heading"><?php echo $username; ?></h3>
            <a href="../Account/AccountInfo.php" class="list-group-item">Edit Account</a>
            <a href="../Account/editProfile.php" class="list-group-item">Edit Profile</a>
            <a href="../Main/ViewShows.php" class="list-group-item" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>View Shows</a>
            <a href="../Processes/UploadEvents.php" class="list-group-item active" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Add Shows</a>
          </div>
        </div><!--/.sidebar-offcanvas-->
      
  </div><!--/row-->
</div> <!-- End Container -->

	<!-- These must be in file, and they're at the bottom so the page loads quicker -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
</body>
</html>
