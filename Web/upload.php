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


  //new profilePicture
if($_POST['newProfilePic'])
{
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
          header("Location: home.php");
      		die();

      } else {

          echo "Sorry, there was an error uploading your file.";
      }
  }
}






?>
