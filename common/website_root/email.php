<html>
<body>

<?php
if (isset($_REQUEST['email']))
//if "email" is filled out, send email
  {
  //send email
  $email = $_REQUEST['email'] ;
  $subject = $_REQUEST['subject'] ;
  $message = $_REQUEST['message'] ;
#  mail("loren.lisk@liskl.com",$subject, $message, "From:" . $email);
  mail("loren.lisk@liskl.com", $subject, "from: " . $email . "\n\n" . $message, "From:" . $email);

  echo "Thank you for emailing me, <a href='http://liskl.com/'>return</a> here.";
  }
else
//if "email" is not filled out, display the form
  {
  echo "<form method='post' action='email.php'>
  Email: <input name='email' type='text'><br>
  Subject: <input name='subject' type='text'><br>
  Message:<br>
  <textarea name='message' rows='15' cols='40'>
  </textarea><br>
  <input type='submit'>
  </form>";
  }
?>

</body>
</html>
