<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
</div align="center">
	<h1 id="header" >Statusboard</h1>
</div>
<p class="datetime">
<?php echo date('l \t\h\e jS \o\f F h:i:s A'); ?>
</p>

<style type="text/css">
body { background-color:#cccccc; margin: 0px; padding 0px; }
h1 { font-family: 'Press Start 2P', cursive; font-weight: 400; margin: 0px; padding 0px; padding-top: 10px; }
#header { text-align: center; background-color:#006699;  }
#load_tweets { font-size:24px; font-family:'Georgia', Times New Roman, Times, serif; font-weight:bold; color:#fff; }
.datetime { text-align: center; padding 0px; margin: 0px; font-size:14px; background-color:#000; }
.panel_Top_Left {  margin-right: 0px; float: left; width: 33%; text-align: center; background-color:#242424; height:30%;}
.panel_Top_Right { margin-left: 0px; float: right; width: 33%; text-align: center; background-color:#242424; height:30%;}
.panel_Top_Mid { display: inline-block; width: 33%; text-align: center; background-color:#666666; height:30%;}
.panel_Bottom_All { width: 100%; margin-top: 1px; text-align: center; background-color:#666666; height:51%;}
.container{ height:auto; width:auto; border-left:none; border-right:none; text-align:center; margin: 0px;}
.container div{ display: inline-block; vertical-align: middle; line-height: 100px ; }

</style>
<div class="container">
	<div class='panel_Top_Mid'>top mid</div>
	<div class='panel_Top_Left'>top left</div>
	<div class='panel_Top_Right'>top right</div>
	<div class='panel_Bottom_All'>Bottom all</div>
</div>