<?php
session_start();
session_unset();
include('services/array_column.php');
require('tpl/generic.tpl.php');
echo $tpltop;

# MENU TOP
echo '<div id="topmenu"><br/>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link" href="index.php">Maps</a></span>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link_current" href="graphs.php">Graphs</a></span>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link" href="faq.php">Help</a></span>';
echo '<br/><br/><hr/></div>';


# MENU LEFT
echo '<div id="leftmenu" class="leftmenu">';
echo '<div class="boxtitle" id="boxtitle"><h1>Configure your chart</h1></div><br/>'; 

$myfile = "resources/nomenclature/nomenclature.csv";
$myfile = file($myfile);
$myfile = str_replace(",","-",$myfile);	
$myfile = str_replace(";",",",$myfile);	
$rows = array_map("str_getcsv", $myfile);
$header = array_shift($rows);
$csv = array();
foreach ($rows as $row) {$csv[] = array_combine($header, $row);}
$tab=$csv;
$_SESSION['nomenclature']=$csv;
$countries=array_unique(array_column($tab, 'NAMES','ID'));
echo '<form id="formRegion"><select id="combo-region" class="combo-region" name="combo-region">';
foreach($countries as $cle => $valeur){
echo "<option value=".$cle.">".htmlentities($valeur, ENT_QUOTES, 'UTF-8')."</option>";
}
echo '</select>';
echo '</form>';
echo '<div class="regionlist" id="regionlist" name="regionlist">';
echo '</div>';
echo '</form>';
echo '</div>';


echo '<div class="regiongraph" id="benchgraph"></div>';



echo $tplbottom;


?>

<script>
$('#combo-region').scombobox({fullMatch: false});

$( "select.combo-region" )
  .change(function () {
    $("#formRegion").submit();
  });


// soumission du form formRegion -------------------------------------
	$("#formRegion").submit(function() {
	$.ajax({
	  url: "services/call_bench.php",
	  type: "POST",
	  cache: false,
	data: jQuery("#formRegion").serialize(),
	//data: jQuery("#formRegion").val(),
	success: function(html)
	{
	$("#benchgraph" ).empty();
	$("#benchgraph").append(html);
	$("#boxtitle" ).empty();
	$("#boxtitle").append("<h1>Add a territorial unit</h1>");
	}
	});
	return false;
	});

</script>
