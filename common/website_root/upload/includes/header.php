<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>";
echo "\n<head>";
echo "\n\n<script src='/upload/includes/jquery-2.1.3.min.js'></script>";
echo "\n\n<link href='includes/page.css' rel='stylesheet' type='text/css' />";

echo "\n\n<title>Liskl Upload System</title>";
echo "\n\n<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
echo '<script>
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	var file = _("uploaded_file").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("uploaded_file", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "upload.php");
	ajax.send(formdata);
}
function progressHandler(event){
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
	_("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
	MakeRequest();
}
function errorHandler(event){
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	_("status").innerHTML = "Upload Aborted";
}

function MakeRequest(){
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "list_files.php", false);
	ajax.send(null);
    if (ajax.readyState==4 && ajax.status==200)
	    {
	    document.getElementById("FileList").innerHTML=ajax.responseText;
	    }
}


</script>';
echo "\n";

echo "\n</head>\n";
echo '<body onload="MakeRequest();">';

?>