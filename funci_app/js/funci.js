$(document).ready(function(){

// Au chargement
$('#container').css({height:$( window ).height()-80});	
$('#top10').css({top:$( window ).height()});	


	  $.ajax({
	  url: "services/refresh_menu.php",
	  type: "POST",
	  cache: false,
	  data: jQuery("#menu1").serialize(),
	  success: function(html){
	$("#menupot").hide();
	$("#menupot").fadeOut(0, "linear");
	$("#menupot").empty();
	$("#menupot").append(html);
	$("#menupot").fadeIn( 0, "linear" );
	$("#menupot").show();
	$('#menu1').change();
 	}
	});

// submit menu 1 (maps) -------------------------------------
	$( "#menu1").change(function() {

	  $.ajax({
	  url: "services/call_map.php",
	  type: "POST",
	  cache: false,
	  data: jQuery("#menu1").serialize(),
	  success: function(html){
	$("#container").hide();
	//$("#container").fadeOut(100, "linear");
	$("#container").empty();
	$("#container").append(html);
	$("#container").fadeIn(100, "linear" );
	$("#container").show();
 	}
	});


	  $.ajax({
	  url: "services/call_top10.php",
	  type: "POST",
	  cache: false,
	  data: jQuery("#menu1").serialize(),
	  success: function(html){
	$("#top10").empty();
	$("#top10").hide();
	$("#top10").append(html);
	$("#top10").show();
	$("#top10").fadeIn("slow");	
 	$("#top10").show();	 
	}
	});

	  $.ajax({
	  url: "services/call_text.php",
	  type: "POST",
	  cache: false,
	  data: jQuery("#menu1").serialize(),
	  success: function(html){
	$("#textbox").empty();
	$("#textbox").hide();
	$("#textbox").append(html);
	$("#textbox").show();
	$("#textbox").fadeIn("slow");	
 	$("#textbox").show();	 
	}
	});

	return false;	
	});

//---------------

	$('input[type=radio][name=mode]').change(function() {
	  $.ajax({
	  url: "services/refresh_menu.php",
	  type: "POST",
	  cache: false,
	  data: jQuery("#menu1").serialize(),
	  success: function(html){
	$("#menupot").hide();
	$("#menupot").fadeOut(0, "linear");
	$("#menupot").empty();
	$("#menupot").append(html);
	$("#menupot").fadeIn( 0, "linear" );
	$("#menupot").show();
	$('#menu1').change();
 	}
	});

	return false;	
	});

//-------------------


});

  $(function() {
    $( document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  });









