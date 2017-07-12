<?php

define('IMAGEPATH', "/vault/system/vhosts/com.liskl/power/archives/");

foreach(array_reverse(glob(IMAGEPATH.'*.png')) as $filename){
	if(basename($filename) == "index.php"){
	true;
	} else {
	echo "<img src='".basename($filename)."'><br>\n";
	}
}

 ?>
