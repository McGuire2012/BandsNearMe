<?php
session_start();
if($_SESSION['email'] == ""){
  header("Location: ../index.php");
  die();
}

$useremail = $_SESSION['email'];
$user = "SA";
$PW = "111#ZXC#222";
$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
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
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {

        echo "Sorry, there was an error uploading your file.";
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

<?php echo "profilePicture $profilePicError"?>
