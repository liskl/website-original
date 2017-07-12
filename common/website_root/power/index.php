<?php
error_reporting(~E_ALL);
?>

<html>
  <head>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">

	// Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
	google.setOnLoadCallback(drawChart1);
	google.setOnLoadCallback(drawChart2);

	$(document).ready(setInterval( drawChart(), 60000) );
	$(document).ready(setInterval( drawChart1(), 60000) );
	$(document).ready(setInterval( drawChart2(), 60000) );

    function drawChart() {
	    $.ajax({
	        url: "get-data.php",
	        data: {"scope":"-12","scale":"hour","interval":"60"},
	        dataType: "json",
	        success: function (json) {
	            var data = new google.visualization.DataTable(json);
	            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
	            var options = { title: 'Power Graphing 12 hour', hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}}, vAxis: {minValue: 0, width: 400, height: 240}};
	            chart.draw(data, options);
	        }
	    });
	}

    function drawChart1() {
	    $.ajax({
	        url: "get-data.php",
	        data: {"scope":"-24","scale":"hour","interval":"120"},
	        dataType: "json",
	        success: function (json) {
	            var data1 = new google.visualization.DataTable(json);
	            var chart1 = new google.visualization.AreaChart(document.getElementById('chart_div1'));
	            var options1 = { title: 'Power Graphing 24 hour', hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}}, vAxis: {minValue: 0, width: 400, height: 240}};
	            chart1.draw(data1, options1);
	        }
	    });
	}

    function drawChart2() {
	    $.ajax({
	        url: "get-data.php",
	        data: {"scope":"-7","scale":"day","interval":"420"},
	        dataType: "json",
	        success: function (json) {
	            var data2 = new google.visualization.DataTable(json);
	            var chart2 = new google.visualization.AreaChart(document.getElementById('chart_div2'));
	            var options2 = { title: 'Power Graphing 1 Week', hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}}, vAxis: {minValue: 0, width: 400, height: 240}};
	            chart2.draw(data2, options2);
	        }
	    });
	}
    </script>

  </head>
  <body>
    <div id="chart_div"  style="width: auto; height: auto;"></div>
    <div><?php $sql = "SELECT CAST(AVG(power) AS DECIMAL(53,4)), CAST(AVG(timedate) AS char(10)) FROM power WHERE timedate >= UNIX_TIMESTAMP(subdate(current_date, 1));";
    $conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs'); $result = $conn->query($sql); $row = $result->fetch_assoc(); echo "1 Day Average: ". $row["CAST(AVG(power) AS DECIMAL(53,4))"]; ?></div>
    <div id="chart_div1" style="width: auto; height: auto;"></div>
	<div><?php $sql = "SELECT CAST(AVG(power) AS DECIMAL(53,4)), CAST(AVG(timedate) AS char(10)) FROM power WHERE timedate >= UNIX_TIMESTAMP(subdate(current_date, 2));";
	$conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs'); $result = $conn->query($sql); $row = $result->fetch_assoc(); echo "2 Day Average: " . $row["CAST(AVG(power) AS DECIMAL(53,4))"]; ?></div>
    <div id="chart_div2" style="width: auto; height: auto;"></div>
    <div><?php $sql = "SELECT CAST(AVG(power) AS DECIMAL(53,4)), CAST(AVG(timedate) AS char(10)) FROM power WHERE timedate >= UNIX_TIMESTAMP(subdate(current_date, 7));";
    $conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs'); $result = $conn->query($sql); $row = $result->fetch_assoc(); echo "7 Day Average: " . $row["CAST(AVG(power) AS DECIMAL(53,4))"]; ?></div>
  </body>
</html>
