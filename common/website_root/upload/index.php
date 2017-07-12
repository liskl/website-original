<?php include('includes/header.php'); ?>



<div class="upload-form center">
	<h1 class="header"> File Upload </h1><br>
	<div class="instruction">
	<fieldset>
			<legend>Instructions</legend>
				Step 1): Click Choose File and select the file for upload.<br>
				Step 2): Click Upload, Filesize limited: <?php echo ini_get('memory_limit'); ?><br>
			</fieldset>
		<br>
		<br>
	</div>

<!-- curl -i -X POST -H "Content-Type: multipart/form-data" -F "uploaded_file=@/vault/unsorted/odin2880.img" liskl.com/upload/upload.php --progress-bar 1> /dev/null | tee /dev/null -->

    <form id="upload_form" method="post" enctype="multipart/form-data">
    	<div class="button">
    		<input type="file" class="select" id="uploaded_file" name="uploaded_file">
        	<input type="button" class="upload" value="Upload file"  onclick="uploadFile()" >
        </div>
    </form>
    <progress id="progressBar" value="0" max="100"></progress>&nbsp;<br>
	<h3 id="status"></h3>
  	<p id="loaded_n_total"></p>&nbsp;
</div>
<?php

echo '<div id="FileList">No files displayed.</div>';
include('includes/footer.php');

?>
