<?php

        $json = file_get_contents("../resources/json/params.json");
	$comment = false;
        $out = '$x=';
        for ($i=0; $i<strlen($json); $i++)
        {
            if (!$comment)
            {
                if (($json[$i] == '{') || ($json[$i] == '['))
                    $out .= ' array(';
                else if (($json[$i] == '}') || ($json[$i] == ']'))
                    $out .= ')';
                else if ($json[$i] == ':')
                    $out .= '=>';
                else
                    $out .= $json[$i];
            }
            else
                $out .= $json[$i];
            if ($json[$i] == '"' && $json[($i-1)]!="\\")
                $comment = !$comment;
        }
        eval($out . ';');

$params = $x;


if (isset($_POST['functional'])){$func = explode("_//_", $_POST['functional']);}
$mode = explode("_//_", $_POST['mode']);
$mode = $mode[1];


for ($i = 0; $i < sizeof($params['Mode']); $i++) {
if ($params['Mode'][$i]['id'] == $mode){$myarray = $params['Mode'][$i]['potentials'][0];}
}


$output= '<legend><b><a href="faq.php#pot" title="Reachable potentials in ...">Potential </b><img src="img/help_icon.png"></img></a></legend>';
$check = 1;
foreach($myarray as $cle=>$valeur) 
    { 
	if ($check==1){$select = "checked=\"checked\"";}else{$select="";}

    $output.= '<input type="radio" class="functional2" name="functional" value="'.$valeur['label']."_//_".$valeur['id'].'" id="'.$valeur['id'].'" '.$select.'/>';
    $output.= '<label for="'.$valeur['id'].'">'.$valeur['label'].'</label><br/>'; 
$check = 0;
     }

echo $output;


