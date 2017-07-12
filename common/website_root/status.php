<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Press+Start+2P::latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>

<script>
var auto_refresh = setInterval(
function() {
	$('#load_tweets').load('/status-data.php');
}, 5000);
</script>
</head>
<body>
<div id="load_tweets"></div>
</body>
</html>