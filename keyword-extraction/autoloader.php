<?php
function autoloader($class) {
  $this_dir = dirname(__FILE__);
  $dirs = [
    $this_dir.'/api',
    $this_dir.'/impl'
  ];
  foreach($dirs as $dir) {
    $file = $dir.'/'.$class.'.php';
    if(file_exists($file))
      require $file;
  }
}

spl_autoload_register('autoloader');
?>
