 <?php
  $server = "cisvm-SenPro1";
  $user = "SA";
  $PW = "111#ZXC#222";

  try {
      $conn = new PDO("sqlsrv:server=cisvm-SenPro1;Database=BandsNearMe;ConnectionPooling=0", $user, $PW);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // echo "Mama we made it! ";

      $sql = "SELECT Count(usertype) FROM USERS where UserType = 'admin'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $adminNum = $result[0][0];
      $sql = "SELECT Count(usertype) FROM USERS where UserType = 'band'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $bandNum = $result[0][0];
      $sql = "SELECT Count(usertype) FROM USERS where UserType = 'indiv'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $indivNum = $result[0][0];
      $sql = "SELECT Count(usertype) FROM USERS where UserType = 'venue'";
      $q = $conn->query($sql);
      $result = $q->fetchAll();
      $venueNum = $result[0][0];

    }
    catch(PDOException $e){
      echo "halp";
    }
  ?>



<html>
 <head>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
     google.charts.load('current', {'packages':['corechart']});
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
       var adminNum = <?php echo $adminNum ?>;
       var bandNum = <?php echo $bandNum ?>;
       var indivNum = <?php echo $indivNum ?>;
       var venueNum = <?php echo $venueNum ?>;


       var data = google.visualization.arrayToDataTable([
         ['User Types', 'Totals'],
         ['Administrators',     adminNum],
         ['Bands',      bandNum],
         ['Individuals',  indivNum],
         ['Venues', venueNum]
       ]);

       var options = {
         title: 'My Daily Activities'
       };

       var chart = new google.visualization.PieChart(document.getElementById('piechart'));

       chart.draw(data, options);
     }
   </script>
 </head>
 <body>
   <div id="piechart" style="width: 900px; height: 500px;"></div>

 </body>
</html>
