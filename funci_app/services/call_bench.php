<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
header('Content-type: text/html; charset=UTF-8'); 
session_start();

// RECUPERATION DES POST
if(!isset($_SESSION['nuts'])){$_SESSION['nuts']=array();}
$nb=count($_SESSION['nuts']);
if(isset($_POST['combo-region'])){$_SESSION['nuts'][$nb]= $_POST['combo-region'];}
$nb=count($_SESSION['nuts']);
if(isset($_POST['indicator'])){$_SESSION['indicator']= $_POST['indicator'];}
if(isset($_POST['mode'])){$_SESSION['mode']= $_POST['mode'];}




// RECUPERATION DES NOMENCLATURES

// AFFICHAGE DU MENU
require('../classes/params.class.php');
echo '<div class="bm">';
echo '<h1>Configure your chart</h1><br/>';
$params = new params("../resources/json/params.json");
echo $params->getmenu2($_SESSION['mode'],$_SESSION['indicator']);
for($i=0;$i<count($params->ArrayIndicators);$i++){if($params->ArrayIndicators[$i]==$_SESSION['indicator']){

$indicator_label =  $params->ArrayIndicatorsLabels[$i];
$indicator_year =  $params->ArrayIndicatorsYears[$i]; 
$indicator_units =  $params->ArrayIndicatorsUnits[$i];}}

for($i=0;$i<count($params->ArrayMode);$i++){if($params->ArrayMode[$i]==$_SESSION['mode']){

$mode_label =  $params->ArrayModeLabel[$i];

}}

echo '</div><br/><hr/><br/>';

// CONSTRUCTION DES GRAPHIQUES ----------------------------------------------------------
$nuts=array();
$nuts=$_SESSION['nuts'];
$nuts=array_unique($nuts);
$nb_regions=count($nuts);



# Recuperation des tableaux csv et formatage des données
$data = "series: [{";
foreach ($nuts as $val) {
$nutsname = $val;
$csvfile=$nutsname.".csv";
$nb=count($_SESSION['nomenclature']);
for($i=0;$i<$nb;$i++){
if($nutsname==$_SESSION['nomenclature'][$i]['ID']){$nutslabel=$_SESSION['nomenclature'][$i]['NAMES'];}	

}

	$rows = array_map('str_getcsv', file('../resources/graph/'.$csvfile));
	$header = array_shift($rows);
	$csv = array();
	$data.="name : '".$nutslabel." (".html_entity_decode($nutsname).")',";	
	$data.="data: [";			
	foreach ($rows as $row) {$csv[] = array_combine($header, $row);}
		for ($i=0;$i<count($csv);$i++){
		
		if($csv[$i]['VAR']==$_SESSION['indicator'] and $csv[$i]['MODE']==$_SESSION['mode']){
			$timem = $csv[$i]['SPAN'];
			$timeh = $timem/1000;
			$data.="[".$timeh." , ".round($csv[$i]['VALUE'],1)."],";
			}
		}
		$data.="]},{";
	}
	$data=substr($data,0,-2);
	$data.="]";

	//echo $data;

# Création du graphique
$graphtitle =   ucfirst(strtolower("Accessibilty of ".$indicator_label." by ".$mode_label." in ".$indicator_year));


?>
<div id="graph" class="graph"></div>
<script>

$(function () {
Highcharts.setOptions({colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']});
$('#graph').highcharts({
chart: {

             },
plotOptions: {series: {marker: {enabled: false}}},
title: { text: '<?php echo $graphtitle; ?> ', x: 0, align: 'left'},
xAxis: {type: 'linear',title: {text: '<?php echo $mode_label;?>'},min:0,tickInterval:1},
yAxis: {title: {text: '<?php echo $indicator_units; ?>'},min: 0,endOnTick: true,maxPadding:0,plotLines: [{value: 0,width: 1,color: '#808080'}], labels: {
                    align: 'right',
                    format: '{value:.,0f}'
                },},
tooltip: {formatter: function() {return '<b>'+this.series.name+': </b><br/>'+Highcharts.numberFormat(this.y, 0) +' <?php echo $indicator_units;?>'+' reachable in '+ this.x+' hour(s)';}},
<?php echo $data;?>,
exporting: {buttons: {contextButton: {symbol: 'url(img/download2.png)',symbolX:12,symbolY:12,x: 0,symbolFill: '#B5C9DF',hoverSymbolFill: '#779ABF',text: 'Download'}}}
});});


$( "select.mode" )
  .change(function () {
    $("#menu2").submit();
  });

$( "select.indicator" )
  .change(function () {
    $("#menu2").submit();
  });




// soumission du form formNuts -------------------------------------
	$("#menu2").submit(function() {
	$.ajax({
	  url: "services/call_bench.php",
	  type: "POST",
	  cache: false,
	data: jQuery("#menu2").serialize(),
	success: function(html)
	{
	$("#benchgraph" ).empty();
	$("#benchgraph").append(html);
	}
	});
	return false;
	});


</script>
