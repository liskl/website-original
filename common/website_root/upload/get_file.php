<?php

include('includes/header.php');

if(isset($_GET['id'])) {
	$id = intval($_GET['id']);
	if($id <= 0) {
		die('The ID is invalid!');
	} else {
		echo $id;
		$dbLink = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'liskl');
		if(mysqli_connect_errno()) {
			die("MySQL connection failed: ". mysqli_connect_error());
		}
		$query = "SELECT type, name, size FROM file WHERE id=$id;";
		echo "$query";
		$result = $dbLink->query($query);
		if($result) {
			if($result->num_rows == 1) {
				$row = mysqli_fetch_assoc($result);
				header("Content-Type: ". $row['type']);
				header("Content-Length: ". $row['size']);
				header("Content-Disposition: attachment; filename=". $row['name']);
				if ($fd = fopen ('files/' . $row['name'], "r")) {
				    while(!feof($fd)) {
				        $buffer = fread($fd, 4096);
				        echo $buffer;
    				}
				}
				fclose ($fd);
			} else {
				echo 'Error! No image exists with that ID.';
			}
			@mysqli_free_result($result);
		} else {
			echo "Error! Query failed: <pre>{$dbLink->error}</pre>";
		}
		@mysqli_close($dbLink);
	}
} else {
	echo 'Error! No ID was passed.';
}
?>
<br>
<br>


