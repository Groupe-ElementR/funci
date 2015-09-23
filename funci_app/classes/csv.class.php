<?php
class csv{

    function __construct($file)
    {
        $this->file = $file;
	$this->rows = array_map('str_getcsv', file('../resources/data/'.$this->file));
	$this->header = array_shift($this->rows);
	$this->field = $this->header[2];
    }

public function gettop10($title,$units)
	{
	$this->title = $title;
	$this->units = $units;	
	$output="";
	$output.= '<div><h1>The 10 regions with the best values of potential or accessibility</h1></div><div><br/>'.$this->title.' '.$this->units.'</div><br/>';
	$rows = array_map('str_getcsv', file('../resources/data/'.$this->file));
	$header = array_shift($rows);
	$csv = array();
	foreach ($rows as $row) {$csv[] = array_combine($header, $row);}
	
	$tmp = explode("_",$this->file);
	$type = $tmp[2];

	// sort	
	 function orderBy1($data, $field)
	  {
	    $code = "return strnatcmp(\$b['$field'], \$a['$field']);";
	    usort($data, create_function('$a,$b', $code));
	    return $data;	
	    //return $code;
	  }

	 function orderBy2($data, $field)
	  {
	    $code = "return strnatcmp(\$b['$field'], \$a['$field']);";
	    usort($data, create_function('$b,$a', $code));
	    return $data;	
	    //return $code;
	  }

		if($type=="POT"){$csv = orderBy1($csv, $this->field);}	
		if($type=="ACC"){$csv = orderBy2($csv, $this->field);}	

	# Display 10 elements
	$first=1;
	$output.= '<table class="tbltop10">';
	for($i=0;$i<10;$i++){ 
	if ($first==1)
	{
	
	// arrondis	
	if($csv[$i][$header[2]]<0){$precision = 2;}
	if($csv[$i][$header[2]]>=0){$precision = 0;}
	if($csv[$i][$header[2]]>1000){$precision = -1;}
	if($csv[$i][$header[2]]>10000){$precision = -2;}
	if($csv[$i][$header[2]]>100000){$precision = -3;}

	$output.= '<tr><td width="700px"><b>'.$csv[$i][$header[1]].'</b> ('.substr($csv[$i][$header[0]],0,2).')</td><td width="148px" align="right">';

if ($units=="hours"){$output.=floor($csv[$i][$header[2]] / 60).":". sprintf( "%02s" ,  $csv[$i][$header[2]] % 60 );}
else{$output.=number_format(round($csv[$i][$header[2]],$precision), $precision, '.', ' ');}
$output.='</td><td rowspan="10" ><a href="region.php"><br/><br/><a href="benchmark.php"></td></tr>';
	$first++;
	}else
	{
	$output.= '<tr><td><b>'.$csv[$i][$header[1]].'</b> ('.substr($csv[$i][$header[0]],0,2).')</td><td align="right">';
if ($units=="hours"){$output.=floor($csv[$i][$header[2]] / 60).":". sprintf( "%02s" ,  $csv[$i][$header[2]] % 60 );}
else{$output.=number_format(round($csv[$i][$header[2]],$precision), $precision, '.', ' ');}
$output.='</td></tr>';
	}

	}
	$output.= '</table>';
	$output.= '</div>';
	$output.= '</td></tr></tbody></table><br/>';
	
	//$output= '<pre>'.print_r($csv, true).'</pre>';

	return $output;
}


public function gettop()
	{
	$rows = array_map('str_getcsv', file('../resources/data/'.$this->file));
	$header = array_shift($rows);
	$csv = array();
	foreach ($rows as $row) {$csv[] = array_combine($header, $row);}
	
	$tmp = explode("_",$this->file);
	$type = $tmp[2];
	
	// sort	
	 function orderBy1($data, $field)
	  {
	    $code = "return strnatcmp(\$b['$field'], \$a['$field']);";
	    usort($data, create_function('$a,$b', $code));
	    return $data;	
	    //return $code;
	  }

	 function orderBy2($data, $field)
	  {
	    $code = "return strnatcmp(\$b['$field'], \$a['$field']);";
	    usort($data, create_function('$b,$a', $code));
	    return $data;	
	    //return $code;
	  }

		if($type=="POT"){$csv = orderBy1($csv, $this->field);}	
		if($type=="ACC"){$csv = orderBy2($csv, $this->field);}	

	$output = $csv[0][$header[1]];
	$output.="_//_";
	$output.=round($csv[0][$header[2]],2);
	return $output;

}

}






