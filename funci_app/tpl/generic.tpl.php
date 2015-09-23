<?php

$mypage = $_SERVER['PHP_SELF'];
$mypage = explode("/",$mypage);
$nb = sizeof($mypage)-1;
$mypage = $mypage[$nb];
if($mypage=="index.php"){$lib = "js/highmaps.js";}else{$lib = "js/highcharts.js";}

# TEMPLATE ESPON FUNC-I

$tpltop = <<<tpltop
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Functional indicators computation tool</title>
<meta name="description" content="ESPON Functional indicators">
<meta name="keywords" content="ESPON, RIATE, FIT">
<meta name="author" content="Nicolas Lambert">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="private">
<meta http-equiv="expires" content="0">
<meta name="revisit-after" content="7 days">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="styles/jquery.scombobox.css">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="img/favicon.ico">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script> 
<script type="text/javascript" src="js/jquery.ui.autocomplete.accentFolding.js"></script> 
<script type="text/javascript" src="js/funci.js"></script> 
<script type="text/javascript" src="js/jquery.scombobox.js"></script> 
<script type="text/javascript" src="js/jquery.easing.min.js"></script>
<script type="text/javascript" src="$lib"></script>
<script type="text/javascript" src="js/exporting.js"></script>
</head>
<body>
<div class="wrapper" id="wrapper">

tpltop;


$tplbottom = <<<tplbottom
</div></body></head>
tplbottom;

