<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

if(isset($_REQUEST["scope"])){    $scope    = $_REQUEST['scope'];    } else { $scope = "-1"; }
if(isset($_REQUEST["scale"])){    $scale    = $_REQUEST['scale'];    } else { $scale = "week"; }
if(isset($_REQUEST["interval"])){ $interval = $_REQUEST['interval']; } else { $interval = "600"; }

$full_scope = $scope . " " . $scale;

$starttime = strtotime($full_scope);
$conn = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'powergraphs');
$sql = "SELECT CAST(AVG(power) AS DECIMAL(53,4)), CAST(AVG(timedate) AS char(10)) FROM power WHERE timedate >= $starttime GROUP BY CEIL(timedate/$interval);";
$result = $conn->query($sql);

$stackArray = array();
$datesArray = array();

function str_replace_last( $search , $replace , $str ) {
    if( ( $pos = strrpos( $str , $search ) ) !== false ) {
        $search_length  = strlen( $search );
        $str    = substr_replace( $str , $replace , $pos , $search_length );
    }
    return $str;
}

function average($array) {
	 return array_sum($array) / count($array);
}
$t=0;
$power_count=0;
if ($result->num_rows > 0) {
	// output data of each row
	$value = '{'."\n\t".'"cols": ['."\n\t\t".'{"label": "Date","type": "datetime"},{"label": "Power","type": "number"}],' . "\n\t" . '"rows": [' . "\n\t\t";
	while($row = $result->fetch_assoc()) {
			$date = new DateTime();
			$date->setTimestamp($row["CAST(AVG(timedate) AS char(10))"]);
			$date->setTimezone(new DateTimeZone('America/New_York'));
			$date->sub(new DateInterval('P1M'));
			/*     	{"c": [{"v": "Date(2015,01, 18, 15, 57)"},{"v": 1.0544}]},
        			'{"c": [{"v": "Date(' . $date->format('Y, m, d, H, i') . ')"},{"v": ' . $row["CAST(AVG(power) AS DECIMAL(53,4))"] . '}]}';
			$value .= '{"v": "Date(' . $date->format('Y, m, d, H, i') . ')"}, {"v":' . $row["CAST(AVG(power) AS DECIMAL(53,4))"] . '},';
			*/

			$value .= '{"c": [{"v": "Date(' . $date->format('Y, m, d, H, i') . ')"},{"v": ' . $row["CAST(AVG(power) AS DECIMAL(53,4))"] . '}]},'."\n\t\t";
			$power_count++;
		$stackArray[] = $row["CAST(AVG(power) AS DECIMAL(53,4))"];
	}
} else {
	die("failed.");
}
$conn->close();
$value .= "]}";
echo str_replace_last(",","",$value);
//echo "<br>";
//$jsonData = stripslashes(html_entity_decode($jsonData));
//echo json_encode(json_decode($jsonData, TRUE));

?>