<?php
require('tpl/generic.tpl.php');
echo $tpltop;

# MENU TOP
echo '<div id="topmenu"><br/>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link_current" href="index.php">Maps</a></span>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link" href="graphs.php">Graphs</a></span>';
echo '<span class="upper_menu_entry"><a class="upper_menu_link" href="faq.php">Help</a></span>';
echo '<br/><br/><hr/></div>';

# MENU LEFT
echo '<div id="leftmenu" class="leftmenu">';
require('classes/params.class.php');
$params = new params("resources/json/params.json");
echo $params->getmenu1();
echo '</div>';

# EXPLAINATION BOX
echo '<div class="textbox" id="textbox"></div>';

# MAP
echo "<div id='container'></div>";

# TOP 10
echo '<div class="top10" id="top10"></div>';



echo $tplbottom;
?>




