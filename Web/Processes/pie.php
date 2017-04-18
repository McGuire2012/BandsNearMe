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

  $isAdmin = 0;

  $sql = "SELECT UserType from USERS where UserEmail = '$useremail'";
  $q = $conn->query($sql);
  $result1 = $q->fetchAll();
  $resultType = $result1[0][0];

  if($resultType == "Admin")
  {
    $isAdmin = 1;
  }


?>



<div id="admin" style="display: none;">
  <?php
  $server = "cisvm-SenPro1";
  $user = "SA";
  $PW = "111#ZXC#222";

  try {
      $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Mama we made it! ";

      $sql = "SELECT Count(Admin) FROM USERS";
      $q = $conn->query($sql);
      $q -> execute();
      $result = $q->fetchAll();
      echo htmlspecialchars($result);
    }
    catch(PDOException $e){
      echo "halp";
    }
  ?>
</div>

<div id="band" style="display: none;">
  <?php
  $server = "cisvm-SenPro1";
  $user = "SA";
  $PW = "111#ZXC#222";

  try {
      $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Mama we made it! ";

      $sql = "SELECT Count(Band) FROM USERS";
      $q = $conn->query($sql);
      $q -> execute();
      $result = $q->fetchAll();
      echo htmlspecialchars($result);
    }
    catch(PDOException $e){
      echo "halp";
    }
  ?>
</div>

<div id="indiv" style="display: none;">
  <?php
  $server = "cisvm-SenPro1";
  $user = "SA";
  $PW = "111#ZXC#222";

  try {
      $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Mama we made it! ";

      $sql = "SELECT Count(Indiv) FROM USERS";
      $q = $conn->query($sql);
      $q -> execute();
      $result = $q->fetchAll();
      echo htmlspecialchars($result);
    }
    catch(PDOException $e){
      echo "halp";
    }
  ?>
</div>

<div id="venue" style="display: none;">
  <?php
  $server = "cisvm-SenPro1";
  $user = "SA";
  $PW = "111#ZXC#222";

  try {
      $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Mama we made it! ";

      $sql = "SELECT Count(Venue) FROM USERS";
      $q = $conn->query($sql);
      $q -> execute();
      $result = $q->fetchAll();
      echo htmlspecialchars($result);
    }
    catch(PDOException $e){
      echo "halp";
    }
?>
</div>

<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Types of Users</title>
    <link href="Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Styles/form.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var adminDiv = document.getElementById("admin");
        var bandDiv = document.getElementById("band");
        var indivDiv = document.getElementById("admin");
        var venueDiv = document.getElementById("admin");

        var adminNum = adminDiv.textContent;
        var bandNum = bandDiv.textContent;
        var indivNum = indivDiv.textContent;
        var venueNum = venueDiv.textContent;


        var data = google.visualization.arrayToDataTable([
          ['User Types', 'Totals'],
          ['Administrators',     adminNum],
          ['Bands',      bandNum],
          ['Individuals',  indivNum],
          ['Venues', venueNum]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
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
        <li><a href="home.php">Home</a></li>
				<li><a href="../Account/AccountInfo.php">Account</a></li>
				<li><a href="../Account/editProfile.php">Edit Profile</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" <?php if ($isAdmin == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Reports
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="active"><a href="../Processes/pie.php">Types of User</a></li>
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
			<div class = "col-lg-10" id="piechart" style="width: 900px; height: 500px;">

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
