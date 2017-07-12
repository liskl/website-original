<?php

class Cache
{
  public $start_time;
  public $cache_file;
  public $to_create;

  function __construct()
  {
    $this->to_create = TRUE;
    $this->Start();
  }

  function Start()
  {
    $this->start_time = microtime();
    $cache_time = 10; // use cache files for 60 seconds

    $str = $_SERVER['REQUEST_URI'];

    if(isset($_SESSION['user_name']))
      $str .= $_SESSION['user_name'];

    foreach ($_GET as $k => $v)
      $str .= $k . $v;

    foreach ($_POST as $k => $v)
      $str .= $k . $v;

    $this->cache_file = $_SERVER['DOCUMENT_ROOT']
        . "/cache/" . md5($str) . ".html";

    if (file_exists($this->cache_file)
        && (time() - $cache_time < filemtime($this->cache_file)))
    {
      include($this->cache_file);
      $end_time = microtime();
      echo "";
      $this->to_create = FALSE;
      exit;
    }

    ob_start();
  }

  function End()
  {
    $fp = fopen($this->cache_file, 'w');
    fwrite($fp, ob_get_contents());
    fclose($fp);
    ob_end_flush();

    $end_time = microtime();
    echo "";
  }

  function __destruct()
  {
    if ($this->to_create)
      $this->End();
  }
}

#$cache = new Cache();

?>
