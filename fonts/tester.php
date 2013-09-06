<?php
$php_version =(float)phpversion();

date_default_timezone_set('Asia/Singapore');
require_once('functions.php');
require_once('src/autoload.php');
require_once('../config.php');

$is_mac = mac_os();

$is_android = android_os();
$is_webkit = webKit_browser();

echo "User Agent : ". $_SERVER['HTTP_USER_AGENT'];
echo "<br/>";
if($is_mac)
{
	echo "Mac OS <br/>";
}

if($is_android)
{
	echo "Android OS <br/>";
}

if($is_webkit)
{
	echo "Web Kit";
}
