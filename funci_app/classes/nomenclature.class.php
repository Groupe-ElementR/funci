<?php
error_reporting(0);
class nomenclature{

    function __construct($file) 
    {
	$this->file = $file;
	$myfile = "resources/nomenclature/$this->file";
	$myfile = file($myfile);
	$myfile = str_replace(",","-",$myfile);	
	$myfile = str_replace(";",",",$myfile);	
	$rows = array_map("str_getcsv", $myfile);
	$header = array_shift($rows);
	$csv = array();
	foreach ($rows as $row) {$csv[] = array_combine($header, $row);}
	$this->tab=$csv;
   }

	
	public function getlist()
	{
	$output='[';	
	$tab=$this->tab;
	for($i=0;$i<count($tab);$i++)
		{
		$output.='{value : \''.$tab[$i]['NUTS3'].'\', label : \''.addslashes($tab[$i]['NAME_NUTS3']).'\'}';
		if ($i<count($tab)-1){$output.= ', ';}
		}
	$output.=']';

	return $output;
	}

	public function getCountriesList()
	{
	$output="";
	$countries=array_unique(array_column($this->tab, 'NAME_NUTS0','NUTS0'));
	$output.= "<option value=''>--- Select a country ---</option>";	
	foreach($countries as $cle => $valeur){
	$output.= htmlentities("<option value=".$cle. ">".$valeur."</option>");
	}
	return $output;
	}

	public function getRegionsList($Nuts0)
	{
	$output="";
	$countries=array_unique(array_column($this->tab, 'NAME_NUTS3','NUTS3'));
	foreach($countries as $cle => $valeur){
	
	if (substr($cle, 0, 2)==$Nuts0){$output.= "<a href=''>".$cle. ": ".$valeur."</a><br/>";}
	}
	return $output;
	}



	
}






