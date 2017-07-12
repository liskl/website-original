<?php
error_reporting(~E_ALL);

if(isset($_REQUEST["scope"])){    $scope    = $_REQUEST['scope'];    } else { $scope = "-1"; }
if(isset($_REQUEST["scale"])){    $scale    = $_REQUEST['scale'];    } else { $scale = "week"; }
if(isset($_REQUEST["interval"])){ $interval = $_REQUEST['interval']; } else { $interval = "600"; }
/*
echo "scope: $scope<br>
      scale: $scale<br>
      interval: $interval<br>
      ";
*/

$full_scope = $scope . " " . $scale;

?>

<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Power'],
<?PHP

	$weekago = strtotime($full_scope);
	$conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs');
	$sql = "SELECT CAST(AVG(power) AS DECIMAL(53,4)), CAST(AVG(timedate) AS char(10)) FROM power WHERE timedate >= $weekago GROUP BY CEIL(timedate/$interval);";
	$result = $conn->query($sql);

	$stackArray = array();
	$datesArray = array();

	function average($array) {
		 return array_sum($array) / count($array);
	}
	$t=0;
	$power_count=0;
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
				$date = new DateTime();
				$date->setTimestamp($row["CAST(AVG(timedate) AS char(10))"]);
				$date->setTimezone(new DateTimeZone('America/New_York'));
				$date->sub(new DateInterval('P1M'));
				echo "          [ new Date(" . $date->format('Y, m, d, H, i') . "), " . $row["CAST(AVG(power) AS DECIMAL(53,4))"] . "],<!-- ".$row["CAST(AVG(timedate) AS char(10))"]." -->\n";
				$power_count++;
			$stackArray[] = $row["CAST(AVG(power) AS DECIMAL(53,4))"];
		}
	} else {
		echo "0 results";
	}
	//echo "test" . $result->num_rows . " results.";
	$conn->close();
	echo "]);
	        var options = {
          title: 'Power Graphing ". abs($scope) ." ". $scale . " scale ( points are averaged over " . $interval . " values )',
		  hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        document.write(data.toJSON());
      }
    </script>";
?>

  </head>
  <body>
    <div id="chart_div" style="width: auto; height: auto;"></div>
    <div><?php

    function LoadPowerGraph($scope, $interval){
		$weekago = strtotime($scope);
		$t=0;
		$power_count=0;
		$table = array();
		$rows = array();

		$conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs');
		$sql = "SELECT CAST(AVG(power) AS DECIMAL(53,4)), CAST(AVG(timedate) AS char(10)) FROM power WHERE timedate >= $scope GROUP BY CEIL(timedate/$interval);";
		$result = $conn->query($sql);

		while($r = $result->fetch_assoc()) {
				$rows[] = $r;
		}
		$conn->close();
		return print_r($rows);
	}

	$values = LoadPowerGraph($full_scope, $interval); echo $values;

    ?></div>
  </body>
</html>