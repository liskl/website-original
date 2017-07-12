<?php

function human_filesize($bytes) {
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(",", "." , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

$dbLink = new mysqli('localhost', 'root', 'M3zM3r1z3d', 'liskl');
if(mysqli_connect_errno()) {
	die("MySQL connection failed: ". mysqli_connect_error());
}
$sql = 'SELECT `id`, `name`, `type`, `size`, `data`,`created` FROM `file` ORDER BY name';
$result = $dbLink->query($sql);
$number=0;
if($result) {
	if($result->num_rows == 0) {
		echo '<div id="FileList"><p>There are no files in the database</p></div>';
	} else {
		echo "<div id='FileList'>\n\t<table width='100%'>\n\t\t<tr>\n\t\t\t<td><b>Name</b></td>\n\t\t\t<td class='hide' ><b>Mime</b></td>\n\t\t\t<td class='hide' ><b>md5</b></td>\n\t\t\t<td><b>Size</b></td>\n\t\t\t<td class='hide' ><b>Created</b></td>\n\t\t\t<td><b>Download</b></td>\n\t\t\t<td>Delete</td>\n\t\t</tr>";
		while($row = $result->fetch_assoc()) {
			$hr_size = human_filesize($row['size']);
			if ($number % 2 == 0) { $OddOrEven="filelistEven"; } else { $OddOrEven="filelistOdd"; }
			echo "\n\t\t<tr>\n\t\t\t<td class='{$OddOrEven}'>&nbsp;&nbsp;{$row['name']}</td>\n\t\t\t<td class='hide {$OddOrEven}' >{$row['type']}</td>\n\t\t\t<td class='hide {$OddOrEven}' ><b>{$row['data']}</b></td>\n\t\t\t<td class='{$OddOrEven}'>{$hr_size}</td>\n\t\t\t<td class='hide {$OddOrEven}' >{$row['created']}</td>\n\t\t\t<td class='{$OddOrEven}'><a href='get_file.php?id={$row['id']}'>Link</a></td>\n\t\t\t<td class='{$OddOrEven}'><a href='del_file.php?id={$row['id']}'>X</a></td>\n\t\t</tr>\n";
			$number++;
			} ;
		echo "\t</table>\n</div>";
	}
	$result->free();
} else {
	echo 'Error! SQL query failed:';
	echo "<pre>{$dbLink->error}</pre>";
}
$dbLink->close();
?>