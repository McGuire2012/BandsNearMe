<?php
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
    $sql = "SELECT * from Show where BUserName = '$username'";
    $q = $conn->query($sql);
    //$result = $q->fetchAll();
  }
  if($resultType == "Venue")
  {
    $isPerformance = 1;
      //get table information
    $sql = "SELECT * from Show where VUserName = '$username'";
    $q = $conn->query($sql);
   // $result = $q->fetchAll();
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

    <!-- JAVASCRIPT -->
    <script type="text/javascript">
      function changeRecord()
      {
        document.myForm.action='../Processes/changeShow.php'
        document.myForm.submit();
      }
      function deleteRecord()
      {
        document.myForm.action='../Processes/deleteShow.php'
        document.myForm.submit();
      }
    </script>

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


<div class="row">
  <h3 style="text-align: center; padding-top: 100px;"> Your Upcoming Shows </h3>
</div>
<div class="row">
  <p style="text-align: center;"> Select a show to edit</p>
</div>
<hr>

<form name="myForm" method="get">
<table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th></th>
      <th>Band</th>
      <th>Venue</th>
      <th>Address</th>
      <th>Date</th>
      <th>Time</th>
      <th>Description</th>
    </tr>
  </thead>
<?php
echo  "<tbody>";
  while($result = $q->fetch(PDO::FETCH_BOTH))
 {
    $showid = $result[0];
    $ShowDesc = $result[3];
    $ShowDate = $result[5];
    $ShowTime = $result[6];
    $BandName = $result[7];
    $VenueName = $result[8];
    $VAddress = $result[9];

    echo    "<tr>";
    echo      "<td><input type='radio' name='showid' value=".$showid." ></td>";
    echo      "<td>".$BandName."</td>";
    echo      "<td>".$VenueName."</td>";
    echo      "<td>".$VAddress."</td>";
    echo      "<td>".$ShowDate."</td>";
    echo      "<td>".$ShowTime."</td>";
    echo      "<td>".$ShowDesc."</td>";
    echo    "</tr>";
  }
echo  "</tbody>";
?>
</table><!-- End Table -->
<hr>
<!-- Buttons -->
  <div class="row">
    <div class="col-md-5"></div>
    <div class="col-md-4">
      <button type="reset" class="btn btn-default" onclick="changeRecord()">Edit</button>
      <button type="submit" class="btn btn-primary" onclick="deleteRecord()">Delete</button>
    </div>
  </div>
</form><!-- End Form -->

<!-- Sidebar here -->
</div> <!--/.col-xs-12.col-sm-9-->
        <div class="col-xs-6 col-sm-3 col-sm-pull-9 sidebar-offcanvas" id="sidebar">
          <div class="list-group" style="padding-top: 50px">
            <h3 class="list-group-item-heading"><?php echo $username; ?></h3>
            <a href="../Account/AccountInfo.php" class="list-group-item">Edit Account</a>
            <a href="../Account/editProfile.php" class="list-group-item">Edit Profile</a>
            <a href="../Main/ViewShows.php" class="list-group-item active" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>View Shows</a>
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
