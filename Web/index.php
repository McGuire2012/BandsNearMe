<?php
session_start();
unset($_SESSION['email']);
 unset($_SESSION['passwords']);
$user = "SA";
$PW = "111#ZXC#222";
$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_POST['emails'])
{



  $user=$_POST['emails'];
  $_SESSION['email'] = $user;
        $sql = "SELECT count(UserEmail) from USERS where UserEmail = '$user'";
        $q = $conn->query($sql);
        $result = $q->fetchAll();
        $resultCount = $result[0][0];

        if($resultCount == "1")
        {

          $email = "<br><p class='text-success'>You have a correct email for login.</p>";
        }
        else {
          $email = "<br><p class='text-danger'>no such email on file.</p>";
          $emailGood = "<script>$(function() { $('#loginModal').modal('show'); });</script>";
        }
}

if($_POST['passwords'])
{
  $password = $_POST['passwords'];


  $sql = "select UserPW from USERS where UserEmail = '$user'";
  $q = $conn->query($sql);
  $result = $q->fetchAll();
  $resultPass = $result[0][0];

  if($resultPass == $password)
  {

    $passwordRight = "<br><p class='text-success'>you got email and password right!</p>";
    //redirect to home page now.
    header("Location: Main/home.php");
    die();
  }
  else {
    $passwordRight = "<br><p class='text-danger'>Invalid password</p>";
  }
}

if($_POST['repeatPasswords'])
{
  if($resultCount == "1")
  {

    $emailError = "<br><p class='text-danger'>Email is already on file. Either login or use a different email.</p>";
  }
  $repeatPassword = $_POST['repeatPasswords'];
  //echo "$repeatPassword</br>";
    if($password != $repeatPassword)
      {
        $accountCreate = "<script>$(function() { $('#acctCreationModal').modal('show'); });</script>";
        $passError = "<br><p class='text-danger'>Passwords do not match, please try again.</p>";
      }
      else {
        if($resultCount == "1")
        {
          $accountCreate = "<script>$(function() { $('#acctCreationModal').modal('show'); });</script>";
          $emailError = "<br><p class='text-danger'>Email is already on file. Either login or use a different email.</p>";
        }
        else {
          $_SESSION['passwords']=$password;
          $emailError = "<br><p class='text-success'>New Account CREATED!</p>";
          //redirect to account creation page.
          header("Location: Account/createProfile.php");
          die();
          ;
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

    <title>Login</title>
    <link href="Styles/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="Styles/cover.css" rel="stylesheet">
	<link href="Styles/login.css" rel="stylesheet">


  </head>


<body>



<!-- Trigger the modal with buttons -->
<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"></h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="Main/home.php">Home</a></li>
                  <li><a href="Main/about.html">About</a></li>
                  <li><a href="Main/contact.html">Contact</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading"></h1>
            <p class="lead"></p>
            <p class="lead" style="padding-top: 300px">
              <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#loginModal">Login</button>
			  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#acctCreationModal">Create Account</button>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>© 2017 BandsNearMe, Inc.</p>
            </div>
          </div>

        </div>

      </div>

    </div>




<!-- LOGIN MODAL FORM -->
<!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>

    <!--Modal Body -->
  <form id = "login-form" action="" method="post"> <!--form-->
      <div class="modal-body">
        <label for="inputEmail" class="col-md-1 control-label">Email</label>
        <div class="col-md-12">
          <input type="text" class="form-control" name = "emails" id="inputEmail"   placeholder="Email" required>
        </div>
        <br>
        <?php echo "$email";?>

        <label for="inputPassword" class="col-md-1 control-label">Password</label>
        <div class="col-md-12">
           <input type="password" class="form-control" name = "passwords" id="inputPassword"  placeholder="Password" required>
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Remember Password
                </label>
              </div>
              <?php echo "$passwordRight";?>
        </div>
      </div>
    <!-- Modal Footer -->
      <div class="modal-footer">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-0">
          <button type="submit" class="btn btn-primary"  >Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </form><!-- end form -->

  </div>
</div>
<!-- ACCOUNT CREATION MODAL FORM -->
<!-- Modal -->
<div id="acctCreationModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>

    <!--Modal Body -->
  <form id = "create-form" action="" method="post"> <!--form-->
      <div class="modal-body">
        <label for="inputEmail" class="col-md-1 control-label">Email</label>
        <div class="col-md-12">
          <input type="text" class="form-control" name = "emails" id="inputEmail" placeholder="Email" required>
        </div>
        <br>
        <?php echo "$emailError"; ?>
        <label for="inputPassword" class="col-md-1 control-label">Password</label>
        <div class="col-md-12">
           <input type="password" class="form-control" name ="passwords" id="inputPassword" placeholder="Password" required>
          <br>
          <input type="password" class="form-control" name = "repeatPasswords" id="repeatPassword" placeholder="Repeat Password" required>
          <span class="error"><?php echo "$passError";?></span>

          <input type="checkbox" required>*By creating an account you agree to our <a href="#">Terms & Privacy</a>.
          <br>
        </div>
      </div>
    <!-- Modal Footer -->
      <div class="modal-footer">
        <div class="col-lg-8 col-lg-offset-0">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </form><!-- end form -->

  </div>
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
  <script>
      $(function(){
         $('login-form').on('submit', function(e){
              e.preventDefault();
              $.ajax({
                  type: "POST",
                  data: $("login-form").serialize();
              });
         });
      });

  </script>
  <script>
      $(function(){
         $('create-form').on('submit', function(e){
              e.preventDefault();
              $.ajax({
                  type: "POST",
                  data: $("create-form").serialize();
                  $(function() { $('#acctCreationModal').modal('show'); });
              });
         });
      });


  </script>

<?php echo $emailGood; echo $accountCreate;?>
</body>
</html>
