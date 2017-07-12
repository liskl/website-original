<?php

include('includes/header.php');

if(isset($_FILES['uploaded_file'])) {
    if($_FILES['uploaded_file']['error'] == 0) {
        $dbLink = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'liskl');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }

        // Gather all required data
        $name = $dbLink->real_escape_string(strtolower($_FILES['uploaded_file']['name']));
        $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);

        $new_file_name = strtolower($_FILES['uploaded_file']['name']);
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], 'files/'.$new_file_name)) {
        	echo "The file ". basename( $_FILES["uploaded_file"]["name"]). " has been uploaded.";
        	$data = md5_file('files/'.$new_file_name);
        	/* echo $data; */
        }

        $size = intval($_FILES['uploaded_file']['size']);
        $query = "INSERT INTO `file` (`name`, `type`, `size`, `data`, `created`) VALUES ('{$name}', '{$mime}', {$size}, '{$data}', NOW())";
        $result = $dbLink->query($query);
        if($result) {
            echo 'Success! Your file was successfully added!';
        } else {
            echo 'Error! Failed to insert the file' . "<pre>{$dbLink->error}</pre>";
        }
    } else {
        echo 'An error accured while the file was being uploaded. ' . 'Error code: '. $_FILES['uploaded_file']['error'];
    }
    $dbLink->close();
}
else {
    echo 'Error! A file was not sent!';
}
/*header('Location: index.php');*/

?>

