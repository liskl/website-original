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
	$conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs');
	$sql = "SELECT * FROM power WHERE 1=1;";
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
			$min=($t - 0.5);
			$max=($t + 0.5);
			$range=range($min, $max, 0.001);
			if (!in_array($row["power"], $range)) {
				$date = new DateTime();
				$date->setTimestamp($row["timedate"]);
				$date->setTimezone(new DateTimeZone('America/New_York'));
				$date->sub(new DateInterval('P1M'));
				echo "          [ new Date(" . $date->format('Y, m, d, H, i') . "), " . $row["power"] . "],<!-- ".$row["timedate"]." -->\n";
				$power_count++;
				$t=$row["power"];
			}
			$stackArray[] = $row["power"];

		}
	} else {
		echo "0 results";
	}
	//echo "test" . $result->num_rows . " results.";
	$conn->close();
	echo "]);
	        var options = {
          title: 'Power Graphing',
		  hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>";
?>

  </head>
  <body>
    <div id="chart_div" style="width: auto; height: auto;"></div>
    <div><?php echo "average value: ". round(average($stackArray), 2) . " Kilowatts" ?></div>
    <div><?php echo "count value: ". $power_count . " Measurements"

    ?></div>
  </body>
</html>