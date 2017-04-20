<?php
$user = "SA";
	$PW = "111#ZXC#222";
	$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $isAdmin = 0;
  $isPerformance = 0;
  
  echo "doing query:";
//   $sql = "SELECT * from USERS where UserEmail = 'band1@gmail.com'";
//   $q = $conn->query($sql);
//   $result = $q->fetch(PDO::FETCH_ASSOC);
//   print_r($result);
//   echo "\n";
// $username = $result['UserName'];
// echo "username =".$result['UserName'];
// echo "\n";
// echo "password =".$result['UserPW'];
$sql = "SELECT * from Show where BUserName = 'Band1'";
    $q = $conn->query($sql);
while($result = $q->fetch(PDO::FETCH_BOTH))
 {
 	print_r($result);
    $showid = $result[0];
    $ShowDesc = $result[3];
    $ShowDate = $result[5];
    $ShowTime = $result[6];
    $BandName = $result[7];
    $VenueName = $result[8];
    $VAddress = $result[9];

    echo "<table>";
    echo    "<tr>";
    echo      "<td></td>";
    echo      "<td>".$BandName."</td>";
    echo      "<td>".$VenueName."</td>";
    echo      "<td>".$VAddress."</td>";
    echo      "<td>".$ShowDate."</td>";
    echo      "<td>".$ShowTime."</td>";
    echo      "<td>".$ShowDesc."</td>";
    echo    "</tr>";
    echo "</table>";
}
// echo "Doing second query:";
// echo "\n";
// $sql = "SELECT * from BAND where BUserName = '$username'";
// 	$q = $conn->query($sql);
// 	$result = $q->fetchAll();
// 	$bandName = $result[0][1];
// 	$genre = $result[0][2];
// 	$rating = $result[0][3];
// 	$description = $result[0][4];
// print_r($result);
// $sql = "SELECT * from BAND where BUserName = '$username'";
// 	$q = $conn->query($sql);
// 	$result = $q->fetchAll();
// 	$bandName = $result[0][1];
// 	$genre = $result[0][2];
// 	$rating = $result[0][3];
// 	$description = $result[0][4];
// echo "bandname=".$bandName;
// echo "genre=".$genre;
// echo "rating=".$rating;
// echo "this working here?";
  ?>