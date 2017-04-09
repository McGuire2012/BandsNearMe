<!DOCTYPE html>
<html>
<head>
<title>parse Textarea</title>
<meta charset="utf-8">
</head>
<body>
<?php
$user = "SA";
$PW = "111#ZXC#222";
$conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$moreinfo=$_POST['moreinfo'];
$rows = explode(PHP_EOL, $moreinfo);

//send request to Show table to retrieve the last show ID
//array_shift($rows);
foreach($rows as $row => $data)
{
$sql = "SELECT TOP 1 * FROM Show ORDER BY ShowID DESC";
$q = $conn->query($sql);
$result = $q->fetchAll();
$lastId = $result[0][0];
$lastId = str_replace('S', '', $lastId);
$lastId = $lastId + 1;
$idLength = strlen($lastId);
$zeroAppend="0";
for ($i =1; $i <(13 - $idLength); $i++)
	{
	$zeroAppend = $zeroAppend."0";
	}
$zeroAppend = $zeroAppend.$lastId;
$showID = "S".$zeroAppend;
//get row data
$row_data = explode(',', $data);


$sql = "INSERT INTO SHOW (ShowID, BUserName, VUserName, SDesc, ShowDate, ShowTime) VALUES ('$showID','$row_data[0]','$row_data[1]','$row_data[2]','$row_data[3]','$row_data[4]')";

try{
	$q = $conn->query($sql);
	echo "$row_data[0], $row_data[1], $row_data[2], $row_data[3], $row_data[4]  has been created with show ID: $showID </br>";
    
}
catch(PDOException $e)
    {
    echo "<span style = 'color: #ff0000'>$row_data[0], $row_data[1], $row_data[2], $row_data[3], $row_data[4] was not created </span></br>";
    }
}

?>
</body>
</html>