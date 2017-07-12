<?PHP
session_start();

error_reporting(E_ALL);

$hostName="localhost";
$userName="root";
$password="M3zM3r1z3d";
$databaseName="powergraphs";

function databaseExists($databaseName, $hostName, $userName, $passwd){
	// Define Defaults
	$returnValue=FALSE;
	// Try Connecting to Mysql Server
	$conn = new mysqli($hostName, $userName, $passwd);
	if ($conn->connect_error) {
		// if failed: exit;

	} else {
		// if success: test for database existance;
		if ($conn->select_db($databaseName)) {
			// database does exist
			$returnValue=TRUE;
		} else {
			// database doesn't exist: need to build it;
			if (!$conn->select_db($databaseName)) {
				$sql = "CREATE DATABASE powergraphs";
				if ($conn->query($sql) === TRUE) {
					$conn->select_db($databaseName);
					echo "Database created successfully<br>\n";

					// create the table needed

					$sql1="CREATE TABLE power ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					                            power VARCHAR(6) NOT NULL,
					                            voltage VARCHAR(6) NOT NULL,
					                            kVA VARCHAR(6) NOT NULL,
					                            timedate VARCHAR(10) NOT NULL UNIQUE,
					                            add_date TIMESTAMP);";
					if ($conn->query($sql1) === TRUE) {
						echo "Table created successfully<br>\n";
						$returnValue=TRUE;
					}
				} else {
					echo "Error creating database: " . $conn->error;
				}
			}
		}
	}
	$conn->close();
	return $returnValue;
}
if(!$result = databaseExists($databaseName, $hostName, $userName, $password)){
    echo "fail";
}else{
// passed
    if(!empty($_GET['power'])){
        $power=		$_GET['power'];
	    $voltage=	$_GET['voltage'];
	    $kVA=		$_GET['kVA'];
    	$timedate=	$_GET['timedate'];
//		echo "$power, $voltage, $kVA, $timedate\n<br>";

    	$sql = "INSERT INTO power (power, voltage, kVA, timedate) VALUES('" . $power . "', '" . $voltage . "', '" . $kVA . "', '" . $timedate . "');";

		$conn = new mysqli($hostName, $userName, $password, $databaseName);
		if ($conn->query($sql) === TRUE) {
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
    }

	$conn = new mysqli($hostName, $userName, $password, $databaseName);
	$sql = "SELECT * FROM power WHERE 1=1;";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$date = new DateTime();
			$date->setTimestamp($row["timedate"]);
			echo "power: " . $row["power"]. " - timedate: " . $date->format('Y-m-d H:i:s') . "<br>";
		}
	} else {
		echo "0 results";
	}
	$conn->close();
}
?>