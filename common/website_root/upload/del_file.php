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
		$query = "SELECT name FROM file WHERE id=$id;";
		$result = $dbLink->query($query);
		if($result) {
			$row = mysqli_fetch_assoc($result);
			if($result->num_rows == 1) {
				$filename = $row['name'];
				echo "files/'.$filename";
				unlink('files/'.$filename);
			}
		}
		$query = "Delete FROM file WHERE id=$id;";
		echo "$query";
		$result = $dbLink->query($query);

		@mysqli_close($dbLink);
		header('Location: /upload/index.php');
	}
} else {
	echo 'Error! No ID was passed.';
}

include('includes/footer.php');
?>



