

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
  <script>
    checkValid(){
      document.write("FUCK THIS SHIT");
      <?
        echo $user;
        echo $password;

      ?>
    }
  </script>

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
                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Contact</a></li>
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
  <form action="connect.php" method="post"> <!--form-->
      <div class="modal-body">
        <label for="inputEmail" class="col-md-1 control-label">Email</label>
        <div class="col-md-12">
          <input type="text" class="form-control" id="inputEmail"   placeholder="Email" required>
        </div>
        <br>
        <label for="inputPassword" class="col-md-1 control-label">Password</label>
        <div class="col-md-12">
           <input type="password" class="form-control" id="inputPassword"  placeholder="Password" required>
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Remember Password
                </label>
              </div>
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
  <form> <!--form-->
      <div class="modal-body">
        <label for="inputEmail" class="col-md-1 control-label">Email</label>
        <div class="col-md-12">
          <input type="text" class="form-control" id="inputEmail" placeholder="Email" required>
        </div>

        <br>
        <label for="inputPassword" class="col-md-1 control-label">Password</label>
        <div class="col-md-12">
           <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
          <br>
          <input type="password" class="form-control" id="repeatPassword" placeholder="Repeat Password" required>
          <br>
          <input type="checkbox" required>By creating an account you agree to our <a href="#">Terms & Privacy</a>.
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
</body>
</html>
