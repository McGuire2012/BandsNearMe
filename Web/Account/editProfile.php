<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['email'] == ""){
		header("Location: index.php");
		die();
	} //This if statement and the sessionstart need to be at the top of every page except for index.php

	$useremail = $_SESSION['email'];

	//connect to the database here and search by username/e-mail or whatever you passed from the index.php login screen
	$user = "SA";
	$PW = "111#ZXC#222";
	$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//need to grab every detail from the account table

	//What I want to do here is, the php will check the account type and the user information will populate in the correct fields, and if changes are made the form is updated.
	//Based on user type the forms will populate differently. Based on indiv, venue, band.
	$sql = "SELECT Username from USERS where UserEmail = '$useremail'";
	$q = $conn->query($sql);
	$result = $q->fetchAll();
	$resultName = $result[0][0];
	$name = $resultName;
  $isAdmin = 0;
  $isPerformance = 0;
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
		if($resultType == "Band")
		{
			$sql = "SELECT BandName from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
		}
		elseif ($resultType == "Venue") {
			$sql = "SELECT Venue from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
		}
		else {
			$sql = "SELECT Username from USERS where UserEmail = '$useremail'";
		  $q = $conn->query($sql);
		  $result = $q->fetchAll();
		  $resultName = $result[0][0];
			$name = $resultName;
		}
  }
if($_POST['newProfilePic'])
{
  echo "fuck this shit";
  $target_dir = 'uploads/'.$useremail.'/profilePicture'.'/';
  if (!file_exists('uploads/'.$useremail)) {
      mkdir('uploads/'.$useremail, 0777, true);
  }
  if (!file_exists('uploads/'.$useremail.'/profilePicture')) {
      mkdir('uploads/'.$useremail.'/profilePicture', 0777, true);
  }
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }
  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $sql = "update users set profilePic ='$target_file' where UserEmail = '$useremail'";
      	$q = $conn->query($sql);
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {

          echo "Sorry, there was an error uploading your file.";
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
<script>
    $(function(){
       $('updateProfilePic').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: $("updateProfilePic").serialize(),
                $('#acctCreationModal').modal('show');

            });
       });
    });
</script>
</body>
</html>
