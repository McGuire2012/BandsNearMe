<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['username'] == ""){
		header("Location: index.php");
		die();
	} //This if statement and the sessionstart need to be at the top of every page except for index.php

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
	</script>

	<script>
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
        <li><a href="#">Home</a></li>
        <li class="active"><a href="#about">Account</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div><!--/.nav-collapse -->
</div><!--/.navbar -->



<div class="container">
  <!-- FORM -->
  <div class="panel panel-default">
 <form class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
        <div class="checkbox">
          <label>
            <input type="checkbox"> Checkbox
          </label>
        </div>
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
      <label for="select" class="col-lg-2 control-label">Selects</label>
      <div class="col-lg-10">
        <select class="form-control" id="select">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
        <br>
        <select multiple="" class="form-control">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
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

</div> <!-- End Container -->



	<!-- These must be in file, and they're at the bottom so the page loads quicker -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
</body>
</html>
