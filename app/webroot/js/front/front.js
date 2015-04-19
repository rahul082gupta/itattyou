var host = window.location.host;
var proto = window.location.protocol;
var ajax_url = proto+"//"+host+"/itattyou/";

$(document).ready(function(){	

//CODE FOR AJAX PAGINATION 
	$(".pagination a").on('click',function(){	
		
		var getWaitClass= $('#pager').next().attr('class');	
		var acturl= $(this).attr('href');		
		$("."+getWaitClass).show();		
		var randNumber=randomFunc();	
			 
		$.ajax({		
			type:'post',
			url:acturl+randNumber,
			success:function(html){				 
				$(".loadPaginationContent").html(html);
				$("."+getWaitClass).hide();
			}	
		});
	
		return false;	
	});
		
	$('#back').on('click',function(){
									 
			window.history.previous.href
	});
//END OF AJAX PAGINATION CODE 


//FUNCTION FOR DATE PICKER
	/*$(function() {
		$( ".datepicker" ).datepicker({			
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true,		
			yearRange: '1930:2030',
			inline: true
		});
		
	});
	*/

});
//END OF Function

function ajax_form_submit(form,site_url,classWait)
{   
	var form = form;
	$('.'+classWait).show();	
	var req = $.post
	(	 	
		ajax_url+site_url, 
		$('.' + form).serialize(), 
		function(html)
		{	
			var explode = html.split("\n");
			var shown = false;
			$('.'+classWait).hide();
			for ( var i in explode )
			{
				if(parseInt(i)!=i)
				break;
				var explode_again = explode[i].split("|");
				if ($.trim(explode_again[0])=='error') {
					shown = true;
					$('#err_' + explode_again[1]).show();
					if($('#err_' + explode_again[1]).length>0) {
						
						if($.trim(explode_again[2])=="Password doesn't match"){
							$('#pass').val('');
							$('#conPassword').val('');
						}
						$('#err_' + explode_again[1]).html(explode_again[2]);
					}
					$('.'+classWait).hide();
				}
				else if ($.trim(explode_again[0])=='ok') {
					$('#err_' + explode_again[1]).hide();
					$('.'+classWait).hide();					
				}
			}			
			if ( ! shown ){				
				$('.'+form).submit();							
				$('.'+classWait).hide();
			}
			else {				
			}			
			req = null;
		}		
	);
	return false;
}


