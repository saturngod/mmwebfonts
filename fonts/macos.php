<?php

include_once('functions.php');

echo  $_SERVER['HTTP_USER_AGENT'];

if(mac_os())
{
	echo "<h1>MacOS</h1>";
}
else
{
echo "<h1>not MacOS</h1>";
}
