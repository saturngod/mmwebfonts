<?php

function get_browser_name() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match("/Firefox/",$user_agent))
	{
		return "firefox";
	}
	else if(preg_match("/iPhone/",$user_agent))
	{
		return "iPhone";
	}
	else if(preg_match("/iPad/",$user_agent))
	{
        if(preg_match("/iPad; U;/",$user_agent))
        {
            return "android";
        }
        
		return "iPad";
	}
	else if(preg_match("/Android/",$user_agent))
	{
		return "android";
	}
	else if(preg_match("/Chrome/",$user_agent))
	{
		return "chrome";
	}
	else if(preg_match("/Safari/",$user_agent))
	{
		return "safari";
	}
	else if(preg_match("/Opera/",$user_agent))
	{
		return "opera";
	}
	else if(preg_match("/IEMobile/",$user_agent))
	{
		return "iemobile";
	}
	else if(preg_match("/MSIE/",$user_agent))
	{
		return "ie";
	}
}

function get_ie_version()
{
	preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

	if (count($matches)>1){
	  //Then we're using IE
	  $version = $matches[1];

		return $version;
	}
	return 0;
}

function mac_os() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match("/Macintosh/",$user_agent))
	{
		return true;
	}
	return false;
}

function android_os()
{
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match("/Android/",$user_agent))
	{
		return true;
	}
	return false;
}

function webKit_browser()
{
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match("/WebKit/",$user_agent))
	{
		return true;
	}
	return false;
}

function currentPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["PHP_SELF"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
 }
 return $pageURL;
}
