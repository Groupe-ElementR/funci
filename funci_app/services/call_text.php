<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
header('Content-type: text/html; charset=UTF-8'); 


$func = explode("_//_", $_POST['functional']);
$indicator = explode("_//_", $_POST['indicator']);
$units = $indicator[3];
$mode = explode("_//_", $_POST['mode']);
$year = $indicator[2];

require('../classes/csv.class.php');
$csvfilename= $indicator[1]."_".$mode[1]."_".$func[1].".csv";
$mycsv = new csv($csvfilename);
$top = explode("_//_", $mycsv->gettop());
$topname=$top[0];
$topval=$top[1];


if($topval<0){$precision = 2;}
if($topval>=0){$precision = 0;}
if($topval>1000){$precision = -1;}
if($topval>10000){$precision = -2;}
if($topval>100000){$precision = -3;}



# POT
if(substr($func[1], 0,3)=="POT"){
$topval = number_format(round($topval,$precision), $precision, '.', '');
#$funclabel="Potential";
echo '<div align="justify">';
echo '<h1>Interpretation Key</h1><br/>This map shows the amount of '.strtolower($indicator[0]).' reachable in '.$func[0].' by '.strtolower($mode[0]). '  in '.$year.'. ';
echo '<div align="justify">';
echo '<br/><h1>Example</h1><br/>';
echo 'In '.$topname.', there is a potential of '.$topval.' '.$units.' reachable in '.$func[0].'.';
$mapname = strtolower('amount_of_'.$indicator[0].'_reachable_in_'.$func[0].'_by_'.$mode[0]. '_in_'.$year.'.png');
$csvname = strtolower('amount_of_'.$indicator[0].'_reachable_in_'.$func[0].'_by_'.$mode[0]. '_in_'.$year.'.csv');
}

#ACC
$hours = floor($topval / 60);
$minutes = ($topval % 60 );


if(substr($func[1], 0,3)=="ACC"){
#$funclabel="Accessibility";
echo '<div align="justify">';
echo '<h1>Interpretation Key </h1><br/>This map shows the time needed to reach '. $func[0].' of the '.strtolower($indicator[0]).' by '.strtolower($mode[0]).' in '.$year.'. ';
echo '<br/><div align="justify">';
echo '<br/><h1>Example</h1><br/>';

if ($hours==0)
{
echo 'In '.$topname.', it would take '.$minutes.' minutes to reach '.$func[0].' of the '.strtolower($indicator[0]).'.';
}
else
{
echo 'In '.$topname.', it would take '.$hours.' hours and '.$minutes.' minutes to reach '.$func[0].' of the '.strtolower($indicator[0]).'.';
}

$mapname = strtolower('time needed to reach '. $func[0].' of the '.$indicator[0].' by '.$mode[0].' in '.$year.'.png');
$csvname = strtolower('time needed to reach '. $func[0].' of the '.$indicator[0].' by '.$mode[0].' in '.$year.'.csv');
}

echo '</div>';

$mapid='resources/map/'.$indicator[1].'_'.$mode[1].'_'.$func[1].'_LARGE.png';
$csvid='resources/data/'.$indicator[1].'_'.$mode[1].'_'.$func[1].'.csv';

echo '<br/><hr/><a href="'.$csvid.'" download="'.$csvname.'"><div>';
echo '<img src="img/download2.png"></img><img src="img/1x1.png" width="10px" height="1px"></img>Download the <b>Data</b> ';
echo '</div></a>';

echo '</div></a>';



