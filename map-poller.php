#!/usr/bin/env php
<?php

// Set variables for map-poller.php
$weathermap_url = '/weathermap/';

if (php_sapi_name() == 'cli') { 

$options = getopt("d");

if (isset($options['d']))
{
  echo("DEBUG!\n");
  $debug = TRUE;
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  ini_set('log_errors', 1);
#  ini_set('error_reporting', E_ALL ^ E_NOTICE);
} else {
  $debug = FALSE;
#  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  ini_set('log_errors', 0);
#  ini_set('error_reporting', 0);
}


include("../includes/defaults.inc.php");
include("../config.php");
include("../includes/definitions.inc.php");
include("../includes/functions.php");
include("../includes/polling/functions.inc.php");

$cli = TRUE;

$conf_dir = 'configs/';

if(is_dir($conf_dir)) {
	if($dh = opendir($conf_dir)) {
		while (($file = readdir($dh)) !== false) {
			if( "." != $file && ".." != $file && ".htaccess" != $file && "index.php" != $file){
				$cmd = "php ./weathermap --config $conf_dir/$file --image-uri $weathermap_url";
				$fp = popen($cmd, 'r'); 
				$read = fread($fp, 1024);
				echo $read;
				pclose($fp);
			}
		}
	}
}
} else {
exit;
}
?>
