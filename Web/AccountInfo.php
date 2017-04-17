<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['email'] == ""){
		header("Location: index.php");
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
  
  if($resultType == "Band")
  {
	$isPerformance = 1;
    $sql = "SELECT * from BANDS where BUserName = '$username'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$bandName = $result[0][0];
	$genre = $result[0][1];
	$rating = $result[0][2];
	$description = $result[0][3];
	
	$sql = "SELECT * from USERS where UserName = '$username'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$password = $result[0][0];
	//$userType = $result[0][1];
	$userEmail = $result[0][2];
	//$startDate = $result[0][3];
	
  } else if ($resultType == "Venue")
  {
	$isPerformance = 1;
	$sql = "SELECT * from VENUE where VUserName = '$username'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$venueName = $result[0][0];
	$venueLoc = $result[0][1];
	$rating = $result[0][2];
	$description = $result[0][3];
	
	$sql = "SELECT * from USERS where UserName = '$username'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$password = $result[0][0];
	//$userType = $result[0][1];
	$userEmail = $result[0][2];
	//$startDate = $result[0][3];
	
  } else
  {
	$sql = "SELECT * from USERS where UserName = '$username'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$password = $result[0][0];
	//$userType = $result[0][1];
	$userEmail = $result[0][2];
	//$startDate = $result[0][3];
  }
  
  

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

	<!-- Javascript here please -->
	<script>
	function getUserType(){
		var userType = "<?php echo $resultType ?>";
		if(userType == "Band" )
		{
			doBand();
		} else if ( userType == "Venue" ){
			doVenue();
		} else if ( userType == "Admin" )
		{
			doIndiv(); //possibly change this later
		} else
		{
			doIndiv();
		}
	}

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
	</head>

<body onload="getUserType()">

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
    </div><!--/.nav-collapse -->
</div><!--/.navbar -->


<div class="container">

<!----------------- Indiv User --------------------->
<!-------------------  FORM  ----------------------->
<div class="panel panel-default">
 <form class="form-horizontal" id="indivUser" action="" method="post" style="display:none;">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
      <div class="col-lg-10">
        <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo $userEmail ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
 </form> <!-- End Form-->
</div>

<!----------------- BANDS --------------------->
<!----------------  FORM  --------------------->
<div class="panel panel-default">
 <form class="form-horizontal" id="BUser" action="" method="post" style="display:none;">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
      <div class="col-lg-10">
        <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo $userEmail ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Textarea</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="textArea"></textarea>
        <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
      </div>
    </div>
    <div class="form-group">
      <label class="col-lg-2 control-label">Radios</label>
      <div class="col-lg-10">
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
            Option one is this
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
            Option two can be something else
          </label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
 </form> <!-- End Form-->
</div>

<!----------------- VENUES --------------------->
<!------------------ FORM  --------------------->

</div> <!-- End Container -->


	<!-- These must be in file, and they're at the bottom so the page loads quicker -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	
	<script>
    $(function(){
       $('indivUser').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: $("indivUser").serialize(),

            });
       });
    });
</script>
<script>
    $(function(){
       $('BUser').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: $("BUser").serialize(),
            });
       });
    });
</script>
<script>
    $(function(){
       $('VUser').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: $("VUser").serialize(),
            });
       });
    });
</script>
</body>
</html>