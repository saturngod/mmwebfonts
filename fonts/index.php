<?php
$php_version =(float)phpversion();

date_default_timezone_set('Asia/Singapore');
require_once('functions.php');
require_once('src/autoload.php');
require_once('../config.php');
use UnitedPrototype\GoogleAnalytics;//if you are using PHP4, remove this line

if(ENABLE_ANALYTICS &&  $php_version>=5.0) {

	// Initilize GA Tracker
	$tracker = new GoogleAnalytics\Tracker(ANALYTICS_ID, ANALYTICS_DOMAIN);

	// Assemble Visitor information
	// (could also get unserialized from database)
	$visitor = new GoogleAnalytics\Visitor();
	$visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
	$visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
	$visitor->setScreenResolution('1024x768');

	// Assemble Session information
	// (could also get unserialized from PHP session)
	$session = new GoogleAnalytics\Session();

	// Assemble Page information
	$page = new GoogleAnalytics\Page('/fonts/index.php');
	$page->setTitle('mmwebfonts');

	// Track page view
	$tracker->trackPageview($page, $session, $visitor);
}

//start page
$current_url=substr(currentPageURL(),0,-9);

$font_family="Master Piece Uni Sans";
if(isset($_GET['font']))
{
	$font_file=strtolower($_GET['font']);	
}
else {
	$font_file = "masterpiece";
}

if($font_file=='yunghkio') {
	$font_file="yunghkio";
    $font_family="Yunghkio";
}
else if($font_file=="masterpiece") {
	$font_file="masterpiece";
    $font_family="Master Piece Uni Sans";
}
else if($font_file==='myanmar3') {
	$font_file="myanmar3";
    $font_family="Myanmar3";
}
else if($font_file==='padauk') {
	$font_file="padauk";
    $font_family="Padauk";
}   
else if($font_file==='mymyanmar') {
	$font_file="MyMMUnicodeUniversal";
    $font_family="MyMyanmar Universal";
}
else if($font_file=='unimon') {
	$font_file="UniMon";
	$font_family="Uni Mon";
}
else if($font_file=='zawgyi') {
	$font_family="Zawgyi-One";
	$font_file="zawgyi";
}
else if($font_file=="mon3") {
	$font_file = "mon3";
	$font_family = "MON3 Anonta 1";
}

$browsername = get_browser_name();

$font_type = "ttf";
$is_mac = mac_os();


if($browsername=="ie")
{
	$font_type = "eot";
}

if(!is_force_font($font_file))
{
	// if(($browsername=="chrome" || $browsername=="firefox")  && $is_mac) {
	// 		$font_file="myanmar3";
	// 		$font_family="Myanmar3";
	// }

	//check and forece Masterpiece if OS is apple related
	if($browsername=='iPhone' or $browsername=='iPad') {
		$font_family="Masterpiece Uni Sans";
	    $font_file="masterpiece";
	    $font_type="ttf";
	}

	if(!$is_mac && $font_file =="masterpiece") {
		$font_family="Yunghkio";
		$font_file="yunghkio";
		$font_type="ttf";
	}
	if($is_mac && $font_file !="masterpiece" && $browsername !="android") {
		$font_family="Masterpiece Uni Sans";
		$font_file="masterpiece";
		$font_type="ttf";
	}

	/**
	* comment it because firefox support font embed in android
	**/
	//for android unicode, masterpiece is better
	// remove to check android because firefox may support unicode
	// if($browsername=="android" && $font_file!='zawgyi') {
	// 	$font_family="Masterpiece Uni Sans";
	// 	$font_file="masterpiece";
	// 	$font_type="ttf";
	// }
}


if($font_type!="")
{
	if(ENABLE_ANALYTICS &&  $php_version>=5) {
		$event = new GoogleAnalytics\Event("fonts",$font_family,$font_type);

		$tracker->trackEvent($event,$session,$visitor);
	}

	$css ="@font-face {\nfont-family:'".$font_family."';";

	$font_path=$current_url.$font_file.".".$font_type;

	if($browsername!="ie") {

		$css=$css."\nsrc:local('".$font_family."'),";
		if(($browsername=="chrome" || $browsername=="firefox")  && $is_mac && !is_force_font($font_file)) {
			$css=$css."url('".$font_path."') format('truetype-aat');\n}";			
		}
		else {
			$css=$css."url('".$font_path."');\n}";
		}
	}
	else {
			$css=$css."\nsrc:url('".$font_path."?') format('embedded-opentype');";
        	$css=$css."\n}";	
	}

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: text/css");

	//add cache for css
	$seconds_to_cache = 172800;
	$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
	header("Expires: $ts");
	header("Pragma: cache");
	header("Cache-Control: max-age=$seconds_to_cache");
	header("Content-type: text/css");

	echo $css;
}
