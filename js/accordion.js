$(document).ready(function () { 	
	$("#accordion > li > div").click(function(){
		
		if(false == $(this).next().is(':visible')) {
			$('#accordion ul').slideUp(300);
		}
		$(this).next().slideToggle(300);
		
	});
 });
	$('#accordion ul:eq(0)').show();