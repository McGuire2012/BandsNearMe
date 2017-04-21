<?php
	$id=$_GET['showid'];

//Access DB
session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
//test to make sure the user is logged in
if($_SESSION['email'] == ""){
  header("Location: ../index.php");
  die();
} //This if statement and the sessionstart need to be at the top of every page except for index.php

$useremail = $_SESSION['email'];
$password = $_SESSION['passwords'];
$username = $_SESSION['username'];


//connect to the database here and search by username/e-mail or whatever you passed from the index.php login screen
$user = "SA";
$PW = "111#ZXC#222";
$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//need to grab every detail from the account table

//What I want to do here is, the php will check the account type and the user information will populate in the correct fields, and if changes are made the form is updated.
//Based on user type the forms will populate differently. Based on indiv, venue, band.

$isAdmin = 0;
$isPerformance = 0;

$sql = "SELECT UserType from USERS where UserEmail = '$useremail'";
$q = $conn->query($sql);
$result1 = $q->fetchAll();
$resultType = $result1[0][0];

if($resultType == "Admin")
{
  $isAdmin = 1;
  $isPerformance = 1;
}
if($resultType == "Band")
{
  $isPerformance = 1;
    //get table information
  $sql = "SELECT * from Show where ShowID = '$id'";
  $q = $conn->query($sql);
  //$result = $q->fetchAll();
}
if($resultType == "Venue")
{
  $isPerformance = 1;
    //get table information
  $sql = "SELECT * from Show where ShowID = '$id'";
  $q = $conn->query($sql);
 // $result = $q->fetchAll();
}


$result = $q->fetch(PDO::FETCH_BOTH);
$showid = $result[0];
$ShowDesc = $result[3];
$ShowDate = $result[5];
$ShowTime = $result[6];
$BandName = $result[7];
$VenueName = $result[8];
$VAddress = $result[9];

if($_POST['showIdentity'])
{
  $ShowDesc = $_POST['ShowDesc'];
  $ShowDate = $_POST['showDate'];
  $ShowTime = $_POST['showTime'];
  $BandName = $_POST['bandName'];
  $VenueName = $_POST['venueName'];
  $VAddress = $_POST['Vaddress'];

  $sql = "UPDATE SHOW SET SDesc = '$ShowDesc',ShowDate = '$ShowDate',ShowTime = '$ShowTime',BandName = '$BandName',VenueName = '$VenueName',VAddress = '$VAddress' where ShowID = '$id'";
    $q = $conn->query($sql);


  //Redirect back to page
  	header('Location: ../Main/ViewShows.php');
}

?>





<!DOCTYPE html>
<html lang="en">
  <head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Your Shows</title>
    <link href="../Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../Styles/form.css" rel="stylesheet">


  </head>

  <body>
<!--Top & SideNavBar -->
    <!--Top & SideNavBar -->
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
 <form class="form-horizontal" id="editShow" name ="editShow" action="" method="post">
  <fieldset>
    <div class="form-group">
      <label for="showIdentity" class="col-lg-2 control-label">ShowID</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="showIdentity" name = "showIdentity" value="<?php echo $showid; ?>" style="color:#474747" readonly="">
      </div>
    </div>
    <div class="form-group">
      <label for="bandName" class="col-lg-2 control-label">Band</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="bandName" name = "bandName" value="<?php echo $BandName ?>" style="color:#474747">
      </div>
    </div>
    <div class="form-group">
      <label for="venueName" class="col-lg-2 control-label">Venue</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="venueName" name= "venueName" value="<?php echo $VenueName ?>" style="color:#474747">
      </div>
    </div>
    <div class="form-group">
      <label for="Vaddress" class="col-lg-2 control-label">Venue Address</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="Vaddress" name= "Vaddress" value="<?php echo $VAddress ?>" style="color:#474747">
      </div>
    </div>
    <div class="form-group">
      <label for="ShowDate" class="col-lg-2 control-label">Date</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="showDate" name= "showDate" value="<?php echo $ShowDate ?>" style="color:#474747">
      </div>
    </div>
    <div class="form-group">
      <label for="showTime" class="col-lg-2 control-label">Time</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="showTime" name= "showTime" value="<?php echo $ShowTime ?>" style="color:#474747">
      </div>
    </div>
    <div class="form-group">
      <label for="text" class="col-lg-2 control-label">Description</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="textArea" name = "ShowDesc" style="color:#474747"><?php echo $ShowDesc ?></textarea>
      </div>
    </div>
    <div class="form-group">
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <a href="../Main/ViewShows.php" class="btn btn-default" role="button">Cancel</a>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
 </form> <!-- End Form-->
</div>

<!-- Sidebar here -->
</div> <!--/.col-xs-12.col-sm-9-->
        <div class="col-xs-6 col-sm-3 col-sm-pull-9 sidebar-offcanvas" id="sidebar">
          <div class="list-group" style="padding-top: 50px">
            <h3 class="list-group-item-heading"><?php echo $username; ?></h3>
            <a href="../Account/AccountInfo.php" class="list-group-item">Edit Account</a>
            <a href="../Account/editProfile.php" class="list-group-item">Edit Profile</a>
            <a href="../Main/ViewShows.php" class="list-group-item" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>View Shows</a>
            <a href="../Processes/UploadEvents.php" class="list-group-item" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Add Shows</a>
          </div>
        </div><!--/.sidebar-offcanvas-->
      
  </div><!--/row-->
</div> <!-- End Container -->


  <!-- These must be in file, and they're at the bottom so the page loads quicker -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
</body>
</html>
