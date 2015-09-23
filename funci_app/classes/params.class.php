<?php
error_reporting(0);

class params{

    function __construct($json)
    {
        $this->json = $json = file_get_contents($json);
        $this->myparams = "cici";
	$comment = false;
        $out = '$x=';
        for ($i=0; $i<strlen($this->json); $i++)
        {
            if (!$comment)
            {
                if (($this->json[$i] == '{') || ($this->json[$i] == '['))
                    $out .= ' array(';
                else if (($this->json[$i] == '}') || ($this->json[$i] == ']'))
                    $out .= ')';
                else if ($this->json[$i] == ':')
                    $out .= '=>';
                else
                    $out .= $this->json[$i];
            }
            else
                $out .= $this->json[$i];
            if ($this->json[$i] == '"' && $this->json[($i-1)]!="\\")
                $comment = !$comment;
        }
        eval($out . ';');

	// Construction des tableaux utiles        
	$this->myparams = $x;
	$this->ArrayIndicators = array();
	foreach($this->myparams['Indicators'] as $cle=>$valeur) { array_push($this->ArrayIndicators, $valeur['id']);  }
	$this->ArrayIndicatorsLevels = array();
	foreach($this->myparams['Indicators'] as $cle=>$valeur) { array_push($this->ArrayIndicatorsLevels, $valeur['level']);  }
	$this->ArrayIndicatorsYears = array();
	foreach($this->myparams['Indicators'] as $cle=>$valeur) { array_push($this->ArrayIndicatorsYears, $valeur['year']);  }
	$this->ArrayIndicatorsUnits = array();
	foreach($this->myparams['Indicators'] as $cle=>$valeur) { array_push($this->ArrayIndicatorsUnits, $valeur['units']);  }
	$this->ArrayIndicatorsLabels = array();
	foreach($this->myparams['Indicators'] as $cle=>$valeur) { array_push($this->ArrayIndicatorsLabels, $valeur['label']);  }
	$this->ArrayPotential = array();
	foreach($this->myparams['Potentials'] as $cle=>$valeur) { array_push($this->ArrayPotential, $valeur['id']);  }
	$this->ArrayAccessibility = array();
	foreach($this->myparams['Accessibility'] as $cle=>$valeur) { array_push($this->ArrayAccessibility, $valeur['id']);  }
	$this->ArrayAccessibilityLabels = array();
	foreach($this->myparams['Accessibility'] as $cle=>$valeur) { array_push($this->ArrayAccessibilityLabels, $valeur['label']);  }
	$this->ArrayMode = array();
	foreach($this->myparams['Mode'] as $cle=>$valeur) { array_push($this->ArrayMode, $valeur['id']);  }	
	$this->ArrayModeLabel = array();
	foreach($this->myparams['Mode'] as $cle=>$valeur) { array_push($this->ArrayModeLabel, $valeur['label']);  }
    }

	public function getmenu1()
	{

# FORMULAIRE

$output= '<form id="menu1">';
$output.= '<h1>Configure your map</h1><br/>';

# Indicator
$output.= '<fieldset>';
$output.= '<legend><b><a href="faq.php#ind" title="Select an indicator">Indicators </b><img src="img/help_icon.png"></img></a></legend>';
$check=1;
foreach($this->myparams['Indicators'] as $cle=>$valeur) 
    { 
    if ($check==1){$output.= '<input type="radio" class="indicator" name="indicator" value="'.$valeur['label']."_//_".$valeur['id']."_//_".$valeur['year']."_//_".$valeur['units'].'" id="'.$valeur['id'].'"  checked="checked"/>';}
    else {$output.= '<input type="radio" class="indicator" name="indicator"value="'.$valeur['label']."_//_".$valeur['id']."_//_".$valeur['year']."_//_".$valeur['units'].'" id="'.$valeur['id'].'" />';}
    $output.= '<label for="'.$valeur['id'].'">'.$valeur['label'].'</label><br/> ';  
    $check=0;
   }
$output.= '</fieldset>';
$output.= '<br/>';

# Potential
$output.= '<fieldset id="menupot">';
$output.= '</fieldset>';
$output.= '<br/>';

# Accessibility
$output.= '<fieldset>';
$output.= '<legend><b><a href="faq.php#acc" title="Share of the indicator to be reached">Accessibility </b><img src="img/help_icon.png"></img></a></legend>';

foreach($this->myparams['Accessibility'] as $cle=>$valeur) 
    { 
    $output.= '<input type="radio" class="functional2" name="functional" value="'.$valeur['label']."_//_".$valeur['id'].'" id="'.$valeur['id'].'" />';
    $output.= '<label for="'.$valeur['id'].'">'.$valeur['label'].'</label><br/>';  
   }

$output.= '</fieldset>';
$output.= '<br/>';

# Mode
$output.= '<fieldset>';
$output.= '<legend><b><a href="faq.php#mode" title="Select an mode of transportation">Mode </b><img src="img/help_icon.png"></img></a></legend>';

$check=1;
foreach($this->myparams['Mode'] as $cle=>$valeur) 
    { 
    if ($check==1){$output.= '<input type="radio" class="mode" name="mode" value="'.$valeur['label']."_//_".$valeur['id'].'" id="'.$valeur['id'].'" checked="checked"/>';}
    else {$output.= '<input type="radio" class="mode" name="mode" value="'.$valeur['label']."_//_".$valeur['id'].'" id="'.$valeur['id'].'" />';}
    $output.= '<label for="'.$valeur['id'].'">'.$valeur['label'].'</label><br/>';
    $check=0;
   }
$output.= '</fieldset>';
$output.= '<br/>';

return $output;
	}




// MENU DES GRAPHIQUES
public function getmenu2($mode,$indicator)
{

# ------- GERER ICI LES VALEURS PAR DEFAUT
$output='';

foreach($this->myparams['Mode'] as $cle=>$valeur) 
{$mode_default=$valeur['id'];}
foreach($this->myparams['Indicators'] as $cle=>$valeur) 
{$indicator_default=$valeur['id'];
$year=$valeur['year'];
}
if($mode==''){$mode=$mode_default;$_SESSION['mode']=$mode;}
if($indicator==''){$indicator=$indicator_default;$_SESSION['indicator']=$indicator;}

$_SESSION['year']=$year;


$output.= '<form id="menu2" class="menu2" name="menu2">';
# Indicator
$output.='<select id="indicator" class="indicator" name="indicator">';
foreach($this->myparams['Indicators'] as $cle=>$valeur) 
{$output.= "<option value='".$valeur['id']."' ";
if($indicator==$valeur['id']){$output.=" selected";}
$output.="> ".$valeur['label']." </option> ";}
$output.='</select>';
$output.=" by ";
# Mode
$output.='<select id="mode" class="mode" name="mode">';
foreach($this->myparams['Mode'] as $cle=>$valeur) 
{
$output.= "<option value='".$valeur['id']."' ";
if($mode==$valeur['id']){$output.=" selected";} 
$output.="> ".$valeur['label']." </option> ";
}
$output.='</select>';
$output.=" in ".$year;
$output.= '</form>';

return $output;



}



}





