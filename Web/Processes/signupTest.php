<?php

session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
//test to make sure the user is logged in
if($_SESSION['email'] == ""){
	header("Location: index.php");
	die();
} //This if statement and the sessionstart need to be at the top of every page except for index.php

$useremail = $_SESSION['email'];
$user = "SA";
$PW = "111#ZXC#222";
$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
}



	$queryDateG = date("Y-m-d");
	$queryDateF = date("Y-m-d", strtotime( '-1 days' ) );
	$queryDateE = date("Y-m-d", strtotime( '-2 days' ) );
	$queryDateD = date("Y-m-d", strtotime( '-3 days' ) );
	$queryDateC = date("Y-m-d", strtotime( '-4 days' ) );
	$queryDateB = date("Y-m-d", strtotime( '-5 days' ) );
	$queryDateA = date("Y-m-d", strtotime( '-6 days' ) );



      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateA'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateA = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateB'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateB = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateC'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateC = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateD'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateD = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateE'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateE = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateF'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateF = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateG'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateG = $result[0][0];


  ?>
  <!DOCTYPE html>
  <html>
  <head>
  <title>Parse Textarea</title>
  <meta charset="utf-8">
  <link href="Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="Styles/form.css" rel="stylesheet">
  <title>Test</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
  google.charts.load('current', {packages: ['corechart', 'bar']});
  google.charts.setOnLoadCallback(drawBasic);

  function drawBasic() {

    var data = new google.visualization.DataTable();
    data.addColumn('date', 'Date');
    data.addColumn('number', 'User Sign-Ups');

    var usersA = <?php echo $dateA?>;
    var usersB = <?php echo $dateB?>;
    var usersC = <?php echo $dateC?>;
    var usersD = <?php echo $dateD?>;
    var usersE = <?php echo $dateE?>;
    var usersF = <?php echo $dateF?>;
    var usersG = <?php echo $dateG?>;

    var dateA = new Date();
    var dateB = new Date();
    var dateC = new Date();
    var dateD = new Date();
    var dateE = new Date();
    var dateF = new Date();
    var dateG = new Date();

    dateA.setDate(dateA.getDate() - 6);
    dateB.setDate(dateB.getDate() - 5);
    dateC.setDate(dateC.getDate() - 4);
    dateD.setDate(dateD.getDate() - 3);
    dateE.setDate(dateE.getDate() - 2);
    dateF.setDate(dateF.getDate() - 1);

    data.addRows([
      [dateA, usersA],
      [dateB, usersB],
      [dateC, usersC],
      [dateD, usersD],
      [dateE, usersE],
      [dateF, usersF],
      [dateG, usersG]
    ]);
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, {
      height: 400,
      width: 600
    });
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
          <li><a href="about.html">About</a></li>
          <li><a href="contact.html">Contact</a></li>
  				<li><a href="uploadEvents.html" <?php if ($isPerformance == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Book Performance</a></li>

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" <?php if ($isAdmin == 1){ echo 'style="display:;"'; } else {echo 'style="display:none;"'; } ?>>Reports
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="pieTest.php">Types of User</a></li>
              <li><a href="#">Traffic</a></li>
              <li class="active"><a href="signupTest.php">User Sign-Up Rate</a></li>
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
        <br><br>
  		<div class = "col-lg-10" id="chart_div">
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
