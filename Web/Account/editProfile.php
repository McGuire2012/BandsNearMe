<?php
	session_start();// if this is not at the top of a page then it won't work and u will hate yourself for 300 mins trying to figure out why
	//test to make sure the user is logged in
	if($_SESSION['email'] == ""){
		header("Location: ../index.php");
		die();
	} //This if statement and the sessionstart need to be at the top of every page except for index.php

	$useremail = $_SESSION['email'];
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

	if (empty($_FILES['fileToUpload']['name'])) {
	;
	}
	else
	{

	$target_dir = '../uploads/'.$useremail.'/';
	if (!file_exists('../uploads/'.$useremail)) {
	    mkdir('../uploads/'.$useremail, 0777, true);
	}
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        $profilepicError = "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        $profilepicError = "File is not an image.";
	        $uploadOk = 0;
	    }
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    $profilepicError = "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	     $profilepicError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    $profilepicError = "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {

	        $profilepicError = "Sorry, there was an error uploading your file.";
	    }
	}

	}


	if (empty($_FILES['newProfilePic']['name'])) {
	  ;
	}
	else
	{

		$profilepicError = "<br>Mama we made it!";
	  $target_dir = '../uploads/'.$useremail.'/profilePicture'.'/';
	  if (!file_exists('../uploads/'.$useremail)) {
	      mkdir('../uploads/'.$useremail, 0777, true);
	  }
	  if (!file_exists('../uploads/'.$useremail.'/profilePicture')) {
	      mkdir('../uploads/'.$useremail.'/profilePicture', 0777, true);
	  }
	  $target_file = $target_dir . basename($_FILES["newProfilePic"]["name"]);
	  $uploadOk = 1;
	  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	  // Check if image file is a actual image or fake image
	  if(isset($_POST["submit"])) {
	      $check = getimagesize($_FILES["newProfilePic"]["tmp_name"]);
	      if($check !== false) {
	          $profilepicError = "<br>File is an image - " . $check["mime"] . ".";
	          $uploadOk = 1;
	      } else {
	          $profilepicError = "<br>File is not an image.";
	          $uploadOk = 0;
	      }
	  }

	  // Check file size
	  if ($_FILES["newProfilePic"]["size"] > 500000) {
	      $profilepicError = "<br>Sorry, your file is too large.";
	      $uploadOk = 0;
	  }
	  // Allow certain file formats
	  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	  && $imageFileType != "gif" ) {
	      $profilepicError = "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	      $uploadOk = 0;
	  }
	  // Check if $uploadOk is set to 0 by an error
	  if ($uploadOk == 0) {
	      $profilepicError = "<br>Sorry, your file was not uploaded.";
	  // if everything is ok, try to upload file
	  } else {
	      if (move_uploaded_file($_FILES["newProfilePic"]["tmp_name"], $target_file)) {
	        $sql = "update users set profilePic ='../uploads/$useremail/profilePicture/".$_FILES["newProfilePic"]["name"]."' where UserEmail = '$useremail'";
	      	$q = $conn->query($sql);
	          $profilepicError = "<br>The file ". basename( $_FILES["newProfilePic"]["name"]). " has been uploaded.";
	      } else {

	          $profilepicError = "<br>Sorry, there was an error uploading your file.";
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

    <title>Edit Profile</title>
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


<!-- Error Messages -->
<?php
	if (isset($homePhotoError)) {
	echo	"<div class='alert alert-dismissible alert-danger'>";
  	echo		"<button type='button' class='close' data-dismiss='alert'>&times;</button>";
  	echo		"<strong>".$homePhotoError."</strong>";
	echo	"</div>";
	}
	if (isset($profilepicError)) {
	echo	"<div class='alert alert-dismissible alert-danger'>";
  	echo		"<button type='button' class='close' data-dismiss='alert'>&times;</button>";
  	echo		"<strong>".$profilepicError."</strong>";
	echo	"</div>";
	}
	if (isset($profilepicSuccess)) {
	echo	"<div class='alert alert-dismissible alert-success'>";
  	echo		"<button type='button' class='close' data-dismiss='alert'>&times;</button>";
  	echo		"<strong>".$profilepicSuccess."</strong>";
	echo	"</div>";
	}
?>
  <!-- FORM -->
<div class="panel panel-default">
 <form class="form-horizontal" id = "UpdateProfile" action="" method="POST" enctype="multipart/form-data">
  <fieldset>
  
      <div class="form-group">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <h4 style="color:#4A4A4A">Update Profile Picture</h4>
        </div>
      </div>
      <div class="form-group">
          <div class="col-md-4"></div>
          <div class="col-md-4">
           <!-- <h5 style="color:#4A4A4A">Select image to upload:</h5> -->
           <label for="newProfilePic" class="control-label">Select image to upload:</label>
          </div>
      </div>
      <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <label class="btn btn-default" for="newProfilePic">
              Choose File<input type="file" name="newProfilePic" id="newProfilePic" style="display:none">
            </label>
        </div>
      </div>
  <br>
  <br>
  <div class="form-group">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h4 style="color:#4A4A4A">Add Pictures to Profile</h4>
        </div>
    </div>
		<div class="form-group">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<label for="fileToUpload" class="control-label">Select image to upload:</label>
				</div>
		</div>
		<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<label class="btn btn-default" for="fileToUpload">
						Choose File<input type="file" name="fileToUpload" id="fileToUpload" style="display:none">
					</label>
			</div>
		</div>
  <br>
  <br>
    <div class="form-group">
    <div class="col-md-5"></div>
    <div class="col-md-4">
      <button type="submit" name = "submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
  <br>
  <br>
  </form>
  </fieldset>
 </div>

<!-- Sidebar here -->
</div> <!--/.col-xs-12.col-sm-9-->
        <div class="col-xs-6 col-sm-3 col-sm-pull-9 sidebar-offcanvas" id="sidebar">
          <div class="list-group" style="padding-top: 50px">
            <h3 class="list-group-item-heading"><?php echo $username; ?></h3>
            <a href="../Account/AccountInfo.php" class="list-group-item">Edit Account</a>
            <a href="../Account/editProfile.php" class="list-group-item active">Edit Profile</a>
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
