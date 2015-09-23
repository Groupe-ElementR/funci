<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
header('Content-type: text/html; charset=UTF-8'); 

$indicator = explode("_//_", $_POST['indicator']);
$func = explode("_//_", $_POST['functional']);

$mode = explode("_//_", $_POST['mode']);
if(substr($func[1], 0,3)=="POT"){$funclabel="Amount of ";}
if(substr($func[1], 0,3)=="ACC"){$funclabel="Accessibility to ";}
$csvname= $indicator[1]."_".$mode[1]."_".$func[1].".csv";

if(substr($func[1], 0,3)=="POT"){
$maptitle=ucfirst(strtolower($funclabel.$indicator[0]." reachable in ".$func[0]." (".$mode[0].")"));
$units = $indicator[3];
}

if(substr($func[1], 0,3)=="ACC"){

$maptitle=ucfirst(strtolower($funclabel.$func[0]." of the ".$indicator[0]." (".$mode[0].")"));
$units = "hours";
}

require('../classes/csv.class.php');
$mycsv = new csv($csvname);

echo $mycsv->gettop10($maptitle,$units);



