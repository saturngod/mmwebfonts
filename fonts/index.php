<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$php_version =(float)phpversion();

date_default_timezone_set('Asia/Singapore');
require_once('functions.php');

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
    $font_family="Masterpiece Uni Sans";
}
else if($font_file=='myanmar3') {
	$font_file="myanmar3";
    $font_family="Myanmar3";
}
else if($font_file=='padauk') {
	$font_file="padauk";
    $font_family="Padauk";
}   
else if($font_file=='mymyanmar') {
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

$is_android = android_os();
$is_webkit = webKit_browser();

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
	if($browsername=='iPhone' or $browsername=='iPad' ) {
		$font_family="Masterpiece Uni Sans";
	    $font_file="masterpiece";
	    $font_type="ttf";
	}

	if(!$is_mac && $font_file =="masterpiece") {
		$font_family="MON3 Anonta 1";
		$font_file="mon3";
		$font_type="ttf";
	}
	
	if($is_mac && $font_file !="masterpiece") {
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

//check for android webkit because android 4.2 or later only support svg	
if($is_android && $is_webkit && ($font_file =="zawgyi"))
{
	$font_type="svg";
}

if($font_type!="")
{

	$css ="@font-face {\nfont-family:'".$font_family."';";

	$font_path=$current_url.$font_file.".".$font_type;

	if($browsername!="ie") {

		$css=$css."\nsrc:local('".$font_family."'),";
		if(($browsername=="chrome" || $browsername=="firefox")  && $is_mac && !is_force_font($font_file)) {
			$css=$css."url('".$font_path."') format('truetype-aat');\n}";			
		}
		else if($font_type=="svg")
		{
			//svg need to put format to show correctly
			$css=$css."url('".$font_path."') format('svg');\n}";	
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
	$seconds_to_cache = 86400; //24 hour
	$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
	header("Expires: $ts");
	header("Pragma: cache");
	header("Cache-Control: max-age=$seconds_to_cache");
	header("Content-type: text/css");

	echo $css;
}
