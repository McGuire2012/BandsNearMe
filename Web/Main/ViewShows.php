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
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
         <img src="../Styles/LocationBNMicon.png" class="navbar-brand">
          <a class="navbar-brand" href="../Main/home.php">BandsNearMe</a>
        </div>
        <div class="collapse navbar-collapse" style="background-color:#2C2929">
          <ul class="nav navbar-nav">
            <li><a href="../Main/home.php">Home</a></li>
            <li><a href="AccountInfo.php">Account</a></li>
            <li class="active"><a href="editProfile.php">Edit Profile</a></li>
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
            <li><a href="../Main/about.html">About</a></li>
            <li><a href="../Main/contact.html">Contact</a></li>
          <li><a href="../Processes/logout.php">Logout</a></li>
        </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.navbar -->


<table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>Your Booked Shows</th>
      <th></th>
      <th>Column heading</th>
      <th>Column heading</th>
    </tr>
  </thead>
<?php
echo  "<tbody>";
echo    "<tr>";
echo      "<td></td>";
echo      "<td>".$VenueName."</td>";
echo      "<td>".$VAddress."</td>";
echo      "<td>".$ShowDate."</td>";
echo      "<td>".$ShowTime."</td>";
echo    "</tr>";
echo  "</tbody>";
echo "</table> ";
?>

  <!-- These must be in file, and they're at the bottom so the page loads quicker -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
</body>
</html>