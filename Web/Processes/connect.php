<?php
$user = "SA";
$PW = "111#ZXC#222";
$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "TITTTTTTIES</br>";
if($_POST['emails'])
{
  $user=$_POST['emails'];
  echo "$user</br>";
}
else {
  echo "no userName input";
}
if($_POST['passwords'])
{
  $password = $_POST['passwords'];
  echo "$password</br>";
}
else {
  echo "no password input";
}
if($_POST['repeatPasswords'])
{
  $repeatPassword = $_POST['repeatPasswords'];
  echo "$repeatPassword</br>";
    if($password != $repeatPassword)
      {
        echo "you done fucked up kid. use the same passwords dumbass.";
      }
}




 ?>
