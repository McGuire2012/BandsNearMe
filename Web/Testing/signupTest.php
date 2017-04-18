<?php
  $server = "cisvm-SenPro1";
  $user = "SA";
  $PW = "111#ZXC#222";
  try {
      $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // echo "Mama we made it! ";
	
	
	$queryDateG = date("Y-m-d");
	$queryDateF = date("Y-m-d", strtotime( '-1 days' ) );
	$queryDateE = date("Y-m-d", strtotime( '-2 days' ) );
	$queryDateD = date("Y-m-d", strtotime( '-3 days' ) );
	$queryDateC = date("Y-m-d", strtotime( '-4 days' ) );
	$queryDateB = date("Y-m-d", strtotime( '-5 days' ) );
	$queryDateA = date("Y-m-d", strtotime( '-6 days' ) );
	echo $queryDateG;
	echo "</br>";
	echo $queryDateF;
	echo "</br>";
	echo $queryDateE;
	echo "</br>";
	echo $queryDateD;
	echo "</br>";
	echo $queryDateC;
	echo "</br>";
	echo $queryDateB;
	echo "</br>";
	echo $queryDateA;
		

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateA'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateA = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateB'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateB = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateC'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateC = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateD'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateD = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateE'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateE = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateF'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateF = $result[0][0];

      $sql = "SELECT Count(StartDate) FROM USERS where StartDate = '$queryDateG'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $dateG = $result[0][0];

    }
    catch(PDOException $e){
      echo "halp";
    }
  ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Test</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'User Sign-Ups');

      var usersA = <?php echo $dateA?>;
      var usersB = <?php echo $dateB?>;
      var usersC = <?php echo $dateC?>;
      var usersD = <?php echo $dateD?>;
      var usersE = <?php echo $dateE?>;
      var usersF = <?php echo $dateF?>;
      var usersG = <?php echo $dateG?>;

      var dateA = new Date();
      var dateB = new Date();
      var dateC = new Date();
      var dateD = new Date();
      var dateE = new Date();
      var dateF = new Date();
      var dateG = new Date();

      dateA.setDate(dateA.getDate() - 6);
      dateB.setDate(dateB.getDate() - 5);
      dateC.setDate(dateC.getDate() - 4);
      dateD.setDate(dateD.getDate() - 3);
      dateE.setDate(dateE.getDate() - 2);
      dateF.setDate(dateF.getDate() - 1);

      data.addRows([
        [dateA, usersA],
        [dateB, usersB],
        [dateC, usersC],
        [dateD, usersD],
        [dateE, usersE],
        [dateF, usersF],
        [dateG, usersG]
      ]);
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, {
        height: 400,
        width: 600
      });
    }
    </script>
 </head>
 <body>
   <div id="chart_div"></div>
 </body>
</html>
