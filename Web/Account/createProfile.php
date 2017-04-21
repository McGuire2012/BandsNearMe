<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['email'] == ""){
		header("Location: ../index.php");
		die();
	} //This if statement and the sessionstart need to be at the top of every page except for index.php

	$useremail = $_SESSION['email'];
  $password = $_SESSION['passwords'];
	//connect to the database here and search by username/e-mail or whatever you passed from the index.php login screen
	$user = "SA";
	$PW = "111#ZXC#222";
	$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//need to grab every detail from the account table

	//What I want to do here is, the php will check the account type and the user information will populate in the correct fields, and if changes are made the form is updated.
	//Based on user type the forms will populate differently. Based on indiv, venue, band.





  $todayDate = $queryDateG = date("Y-m-d");
  $isAdmin = 0;
  $isPerformance = 0;
  $sql = "SELECT UserType from USERS where UserEmail = '$useremail'";
  $q = $conn->query($sql);
  $result = $q->fetchAll();
  $resultType = $result[0][0];
  if($resultType == "Admin")
  {
    $isAdmin = 1;
    $isPerformance = 1;
  }
  if($resultType == "Band" || $resultType == "Venue")
  {
    $isPerformance = 1;
  }
  if($_POST['UserName'])
  {
    $username = $_POST['UserName'];
  $sql = "SELECT count(UserName) from USERS where UserName = '$username'";
  $q = $conn->query($sql);
  $result = $q->fetchAll();
  $resultCount = $result[0][0];
  if($resultCount == "1")
  {
    $errorISH = "<span style = 'color:red;'>An error has occured</span><br>";
    $usernameError = "<br><span style = 'color:red;'>Username already in user. Please choose another one.</span>";
  }
  else {
    $usernameError = "<br>you're good";
    if($_POST['BandName'])
    {
      $bandname = $_POST['BandName'];
      $bandDescription = $_POST['BandDesc'];
      $bandGenre = $_POST['Genre'];
      $sql = "INSERT INTO USERS (UserName, UserPW, UserType, UserEmail, BandName, StartDate, ProfilePic) Values ('$username','$password', 'Band','$useremail', '$bandname', '$todayDate', '..\Styles\bandIcon.jpg')";
      $q = $conn->query($sql);
        $sql = "INSERT INTO BAND (BUserName, BandName, Genre, BRating, BDesc, NumOfRatings) Values ('$username','$bandname', '$bandGenre', '0', '$bandDescription', '0')";
        $q = $conn->query($sql);
        header("Location: ../Main/home.php");
        die();


      //header("Location: home.php");
    //  die();
    }
    elseif ($_POST['VenueName']) {
      $venuename = $_POST['venueName'];
      $VenueDescription = $_POST['VenueDesc'];
			$VenueAddress = $_POST['VAddress'];

      $sql = "INSERT INTO USERS (UserName, UserPW, UserType, UserEmail, VenueName, StartDate, ProfilePic) Values ('$username','$password', 'Venue','$useremail', '$venuename', '$todayDate', '..\Styles\venueIcon.jpg')";
      $q = $conn->query($sql);
      $sql = "INSERT INTO Venue (VUserName, VenueName, VRating, VDesc, NumOfRatings, VAddress) Values ('$username','$venuename', '0', '$venueDescription', '0', '$VAddress')";
      $q = $conn->query($sql);
      header("Location: ../Main/home.php");
      die();
    }
    else {
      $sql = "INSERT INTO USERS (UserName, UserPW, UserType, UserEmail, StartDate, ProfilePic) Values ('$username','$password', 'Indiv','$useremail', '$todayDate', '..\Styles\userIcon.jpg')";
      $q = $conn->query($sql);
      header("Location: ../Main/home.php");
      die();
    }

  }


}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Home Page</title>
		<link href="../Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../Styles/form.css" rel="stylesheet">
		<script>
    function doIndiv(){
        document.getElementById('indivUser').style.display = '';
        document.getElementById('BUser').style.display = 'none';
        document.getElementById('VUser').style.display = 'none';
      }

      function doBand(){
        document.getElementById('indivUser').style.display = 'none';
        document.getElementById('BUser').style.display = '';
        document.getElementById('VUser').style.display = 'none';
      }
      function doVenue(){
        document.getElementById('indivUser').style.display = 'none';
        document.getElementById('BUser').style.display = 'none';
        document.getElementById('VUser').style.display = '';
      }
    </script>

    <!-- GOOGLE MAPS -->
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCY8dAB_B3DQCGh_TiiuWWB0w9qGwhhqdg&callback=initMap"
    async defer></script>

  </head>

	<body>
<!--Top & SideNavBar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
     <img src="../Styles/LocationBNMicon.png" class="navbar-brand">
      <a class="navbar-brand" href="../Processes/logout.php">BandsNearMe</a>
    </div>
    <div class="collapse navbar-collapse" style="background-color:#2C2929">
      <ul class="nav navbar-nav navbar-right"  style="padding-right: 30px">
        <li><a href="../Processes/logout.php">Cancel</a></li>
      </ul>
    </div><!--/.nav-collapse -->
</div><!--/.navbar -->


<!-- Container -->
<div class="container">
  <div class="panel panel-default">

      <!-- Error Code -->
        <br><br>
        <?php echo $errorISH; ?>


        <!-- Radio Button Choices -->
          <form class="form-horizontal" id = "userChoice" >
            <div class= "row">
              <div class="col-md-6 col-md-offset-3">
                <input type="radio" name="choice" value="indiv" onclick="doIndiv()">Individual User
                <input type="radio" name="choice" value="band" onclick="doBand()">Band
                <input type="radio" name="choice" value="venue" onclick="doVenue()">Venue
              </div>
            </div>
          </form>
      
<!-- Indiv User Form -->
    <form class="form-horizontal" id = "indivUser"  action = "" method = "post" style = "display:none;">
      <fieldset>
        <div class="form-group">
          <label for="Email" class="col-lg-2 control-label">E-mail</label>
            <div class="col-lg-10">
              <input style="color:#474747" type="email" class="form-control" name="Email" <?php echo 'value = "'.$useremail.'"'; ?>>
            </div>
        </div>
        <div class="form-group">
          <label for="Password" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-10">
              <input style="color:#474747" class="form-control" type="password" name="Password" <?php echo 'value = "'.$password.'"'; ?>>
            </div>
        </div>
        <div class="form-group">
          <label for="Username" class="col-lg-2 control-label">Username</label>
            <div class="col-lg-10">
              <input style="color:#474747" class="form-control"  type="text" name="UserName">
        <?php echo $usernameError; ?>
            </div>
        </div>
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <button type="submit" class="btn btn-primary" >Submit</button>
          </div>
        </div>
      </fieldset>
    </form>

<!-- Band Form -->
      <form class="form-horizontal" id = "BUser"  action = "" method = "post" style = "display:none;">
        <fieldset>
        <div class="form-group">
          <label for="Email" class="col-lg-2 control-label">E-mail</label>
            <div class="col-lg-10">
              <input style="color:#474747" type="email" class="form-control" name="Email" <?php echo 'value = "'.$useremail.'"'; ?>>
            </div>
        </div>
        <div class="form-group">
          <label for="Password" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-10">
              <input style="color:#474747" class="form-control" type="password" name="Password" <?php echo 'value = "'.$password.'"'; ?>>
            </div>
        </div>
        <div class="form-group">
          <label for="Username" class="col-lg-2 control-label">Username</label>
            <div class="col-lg-10">
              <input style="color:#474747" class="form-control"  type="text" name="UserName">
        <?php echo $usernameError; ?>
            </div>
        </div>
        <div class="form-group">
          <label for="BandName" class="col-lg-2 control-label">Band Name</label>
            <div class="col-lg-10">
              <input type="text" name="BandName">
            </div>
        </div>
        <div class="form-group">
          <label for="Genre" class="col-lg-2 control-label">Genre</label>
            <div class="col-lg-10">
              <input type="text" name="Genre">
            </div>
        </div>
        <div class="form-group">
          <label for="BandDesc" class="col-lg-2 control-label">Description</label>
    			<div class="col-lg-10">
    				<textarea name="BandDesc" cols="60" rows="10" placeholder="Description of the Band" required></textarea>
    			</div>
    		</div>
        <br>
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <button type="submit" class="btn btn-primary" >Submit</button>
          </div>
        </div>
        </fieldset>
      </form>

<!-- Venue Form -->
      <form class="form-horizontal" id = "VUser"  action = "" method = "post" style = "display:none;">
        <fieldset>
        <div class="form-group">
          <label for="Email" class="col-lg-2 control-label">E-mail</label>
            <div class="col-lg-10">
              <input style="color:#474747" type="email" class="form-control" name="Email" <?php echo 'value = "'.$useremail.'"'; ?>>
            </div>
        </div>
        <div class="form-group">
          <label for="Password" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-10">
              <input style="color:#474747" class="form-control" type="password" name="Password" <?php echo 'value = "'.$password.'"'; ?>>
            </div>
        </div>
        <div class="form-group">
          <label for="Username" class="col-lg-2 control-label">Username</label>
            <div class="col-lg-10">
              <input style="color:#474747" class="form-control"  type="text" name="UserName">
        <?php echo $usernameError; ?>
            </div>
        </div>
        <div class="form-group">
          <label for="VenueName" class="col-lg-2 control-label">Venue Name</label>
            <div class="col-lg-10">
              <input type="text" name="VenueName">
            </div>
        </div>
        <div class="form-group">
          <label for="VenueName" class="col-lg-2 control-label">Venue Name</label>
            <div class="col-lg-10">
              <input type="text" name="VenueName">
            </div>
        </div>
        <div class="form-group">
          <label for="VenueDesc" class="col-lg-2 control-label">Description</label>
          <div class="col-lg-10">
            <textarea name="VenueDesc" cols="60" rows="10" placeholder="Description of the Venue" required></textarea>
          </div>
        </div>
        <br>
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <button type="submit" class="btn btn-primary" >Submit</button>
          </div>
        </div>
        </fieldset>
      </form>

<!-- End Forms -->

 </div>
</div> <!-- End Container -->




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

</body>
</html>
