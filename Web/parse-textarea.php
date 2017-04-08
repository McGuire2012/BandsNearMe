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
echo "we're in";
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
echo "halp";
//get row data
    $row_data = explode(',', $data);
echo "$row_data[0]";

$sql = "INSERT INTO SHOW (ShowID, BUserName, VUserName, SDesc, ShowDate, ShowTime) VALUES ('$showID','$row_data[0]','$row_data[1]','$row_data[2]','$row_data[3]','$row_data[4]')";
//$sql = "INSERT INTO SHOW (ShowID, BandName, VenueName, SDesc, ShowDate, ShowTime) VALUES ('S0000000000012','Willy Wonka','Chocolate Factory','Chocolate wasted', '2018-02-16', '03:30')";

    

    $info[$row]['band']           = $row_data[0];
    $info[$row]['venue']         = $row_data[1];
    $info[$row]['description']  = $row_data[2];
    $info[$row]['date']       = $row_data[3];
    $info[$row]['time']       = $row_data[4];
    

    //display data
    echo "$showID</br>";
    echo ' BAND: ' . $info[$row]['band'] . '<br />';
    echo ' VENUE: ' . $info[$row]['venue'] . '<br />';
    echo ' DESCRIPTION: ' . $info[$row]['description'] . '<br />';
    echo ' DATE: ' . $info[$row]['date']  . '<br />';
    echo ' TIME: ' . $info[$row]['time']  . '<br />';
try{
	$q = $conn->query($sql);
       // $q -> execute();
}
catch(PDOException $e)
    {
    echo "$e";
    }
}

?>
</body>
</html>