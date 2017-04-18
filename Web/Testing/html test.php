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



<div class="container">
  <!-- FORM -->
  <div class="panel panel-default">
 <form class="form-horizontal">
  <fieldset>
		<div class="col-lg-12">
		<div class="col-lg-5"><h3><?php echo $name; ?></h3>
			</div>
			</div>
			<div class="col-lg-12">
			<div class = "col-lg-10">
        <form id = "UpdateProfile" action="upload.php" method="post">
        <form id = "updateProfilePic"action="upload.php" method="post" enctype="multipart/form-data">
            Update Profile Picture <br>
            Select image to upload:
            <input type="file" name="newProfilePic" id="newProfilePic">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
          <br>
          Description <br>
          <div class="row">
      			<div class="col-md-6">
      				<textarea name="Description" cols="60" rows="10" placeholder="Description of the Band" required></textarea>
      			</div>
      		</div>
          <br>
          Add Pictures <br>
          <a href = "PhotoUpload.html">Click here to add pictures</a>
          <br>

          <br>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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