<?php
include_once('fonts.php');
include_once('functions.php');

if(isset($_GET['font']))
{
    
    $browsername = get_browser_name();
    $is_android = android_os();
    $is_webkit = webKit_browser();
    $is_mac = mac_os();

    $font = searchFont($_GET['font'],$fonts);

    //if IE and less than version 9
    //show EOT 
    //if IS_MAC AND font not support Mac
    //show default mac font
    //if IS_CHROME and not support CHROMe
    //show default font
    //else
    //show font
    if($browsername=='ie' && get_ie_version() < 9)
    {
        showFont($font['font_family'],$font["font_file_eot"],"embedded-opentype");
    }
    else if($is_android && $is_webkit && $_GET['font'] == "zawgyi")
    {
        showFont($font['font_family'],$font["font_file"],"svg");
    }
    else if(($is_mac && !$font['support_mac']) || ($browsername=="chrome" && !$font['support_chrome']) || (!$is_mac && !$font['support_windows']))
    {
        showFont($font['font_family'],"mon3.ttf","");
    }
    else
    {
        showFont($font['font_family'],$font["font_file"],"");
    }
}

//////
function searchFont($font,$fonts)
{
    foreach ($fonts as $value) {
        if(strtolower($value['name'])==strtolower($font))
        {
            return $value;
        }
    }
    return false;
}

/////
function showFont($font_family,$font_file,$fomat="")
{

    $current_url=substr(currentPageURL(),0,-9);

    $css ="@font-face {\nfont-family:'".$font_family."';";
    $font_path=$current_url.$font_file;

    if($fomat=="")
    {
        $css=$css."\nsrc:local('".$font_family."'),";
        $css=$css."url('".$font_path."');\n}";
    }
    else {
        $css=$css."\nsrc:url('".$font_path."?') format('".$format."');\n}";
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