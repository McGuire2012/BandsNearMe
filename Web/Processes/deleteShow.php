<?php
	$id=$_GET['showid'];

//Access DB
 	$user = "SA";
  	$PW = "111#ZXC#222";
  	$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
 	// set the PDO error mode to exception
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Delete Record by showid
	$sql = "DELETE FROM Show WHERE ShowID = '$id'";
    $q = $conn->query($sql);

//Redirect back to page
	header('Location: ../Main/ViewShows.php');
?>