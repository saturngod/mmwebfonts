<?php
require_once('functions.php');
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

$browsername = get_browser_name();
$font_type = "ttf";
$is_mac = mac_os();

if($browsername=="ie")
{
	$font_type = "eot";
}

if(($browsername=="chrome" || $browsername=="firefox")  && $is_mac) {
	$font_file="myanmar3";
	$font_family="Myanmar3";
}

//check and forece Masterpiece if OS is apple related
if($browsername=='iPhone' or $browsername=='iPad' and $font_file!='myanmar3') {
	$font_family="Masterpiece Uni Sans";
    $font_file="masterpiece";
    $font_type="ttf";
}

if(!$is_mac && $font_file =="masterpiece") {
	$font_family="Yunghkio";
	$font_file="yunghkio";
	$font_type="ttf";
}
if($is_mac && ($font_file=="padauk" || $font_file=="yunghkio")) {
	$font_family="Masterpiece Uni Sans";
	$font_file="masterpiece";
	$font_type="ttf";
}

//for android unicode, masterpiece is better
if($browsername=="android" && $font_file!='zawgyi') {
	$font_family="Masterpiece Uni Sans";
	$font_file="masterpiece";
	$font_type="ttf";
}

//zawgyi font support all browser
if($font_file=='zawgyi') {
	$font_family="Zawgyi-One";
	$font_file="zawgyi";
	if($browsername=="ie")
	{
		//IE mobile still not support font embed
		$font_type="eot";
	}
	else {
		$font_type="ttf";
	}
}

if($font_type!="")
{
	$css ="@font-face {\nfont-family:".$font_family.";";

	$font_path=$current_url.$font_file.".".$font_type;

	if($browsername!="ie") {
		$css=$css."\nsrc:local('".$font_family."'),";
		$css=$css."url('".$font_path."');\n}";
	}
	else {
		$css=$css."\nsrc:url('".$font_path."?') format('embedded-opentype');";
        $css=$css."\n}";
	}
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: text/css");
	echo $css;
}
