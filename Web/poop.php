<?php
$server = "cisvm-SenPro1";
$user = "SA";
$PW = "111#ZXC#222";


try {
    $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // $connectionInfo = array("Database" => "BandsNearMe", "UID" =>$user, "PWD"=>$PW);
   // $conn = sqlsrv_connect($server, $connectionInfo);
    
    echo "Mama we made it! "; 

$sql = "SELECT Count(BandName) FROM BAND";
$q = $conn->query($sql);
$q -> execute();
$result = $q->fetchAll();
echo "<pre>";
print_r($result);
echo "</pre>";
}
catch(PDOException $e)
    {
    echo "halp";
    }


?>

<html>
 <head>
 </head>
 <body>
 <h1>PARTY!</h1>
</body>
</html>
