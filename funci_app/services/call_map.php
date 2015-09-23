<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
header('Content-type: text/html; charset=UTF-8'); 


$indicator = explode("_//_", $_POST['indicator']);
$func = explode("_//_", $_POST['functional']);
$mode = explode("_//_", $_POST['mode']);
$year = $indicator[2];



if(substr($func[1], 0,3)=="POT"){$funclabel="Potential"; $units = $indicator[3];}
if(substr($func[1], 0,3)=="ACC"){$funclabel="Accessibility"; $units = "minutes";}

$legtitle = ucfirst(strtolower("In ".$units));

$mapname= "../resources/data/".$indicator[1]."_".$mode[1]."_".$func[1].".json";
$maplegend= "../resources/data/".$indicator[1]."_".$mode[1]."_".$func[1]."_legend.json";
$maptitle=ucfirst(strtolower($funclabel." of ".$indicator[0]." (".$func[0]." ".$mode[0].") in ".$year));


?>



<script>


$(function () {

    // Prepare random data
var data = <?php include($mapname);?>

$.getJSON('resources/map/map.json', function (geojson) {

        // Initiate the chart
        $('#container').highcharts('Map', {
			
		credits: {
      enabled: false
  },
  
			chart:{
				
			borderWidth: 1,
			borderColor:"#E3E4E5",
			marginBottom: 5,
				
			},
			
			
            title : {
                text : '<?php echo $maptitle;?>',
				align: 'center'
				
            },
			

            mapNavigation: {
                  enabled: true,
				
                buttonOptions: {
					
                verticalAlign: 'top',
                },
            },		
			

			legend: {layout: 'horizontal',
            align: 'left',
			
			title:{
				text: '<?php echo $legtitle.""; ?>',
			}  
           
			},
			
            colorAxis:{dataClasses: <?php include($maplegend);?>


           },
exporting: {buttons: {contextButton: {symbol: 'url(img/download2.png)',symbolX:12,symbolY:12,x: 0,symbolFill: '#B5C9DF',hoverSymbolFill: '#779ABF',text: 'Download'}}},
		
			
            series : [{
                data : data,
                mapData: geojson,
				joinBy: ['id', 'code'],				
                name: '<?php echo $indicator[0];?>',
                states: {
                    hover: {
                        color: '#C3E87C'
                    }
                },
				borderWidth: 0.1,
				borderColor: 'white',
                dataLabels: {
                    enabled: false,
                    format: '{point.properties.postal}'
                },
				tooltip: {
                    pointFormat: '{point.nom}: {point.value} <?php echo $units;?>'
                },

			
				cursor: 'pointer',
			
				
				
            }]
        });
    });
});

</script>



