//new

$(function() {
    //attach the a function to the click event of the 
    //"Add Box Attribute" button that will add a new row
   var cloneCount = 0;
   
   
 	
    $('.addnew_line').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				
                $(".dpick").datepicker("destroy");      
				
				
				
				var $newRow = $('#TemplateRow').clone(true);
			
            	$newRow.find('#date_picker').val('');
				$newRow.find('.dpick').val('');
        		$newRow.find('#details').val('');
                $newRow.find('#amount').val('');
		
        	
				var noOfDivs = $('.makeCloneClass').length + 1;
				 $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
				//cloneCount++;
				//alert('#dpick'+ noOfDivs);
				$('#BoxTable tr:last').after($newRow);
			
				 $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
                  $('.amountformat').priceFormat({
        prefix: '',
       // centsSeparator: '.',
       // thousandsSeparator: ',',
       // centsLimit: '',
    });
				return false;
			
	})
$(function() {
    $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});
			  
});	
$(function() {
    $("#eddpick").datepicker({dateFormat: 'dd-mm-yy'});
});
	// "remove row" check box
  
	
})

//new

$(document).ready(function(){      
    $('.DeleteBoxRow').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRow").size();
    //alert(size);return false;
		if(size>2){
        	$(this).closest('tr').remove();
		}
    });
        
        

$(".forecasttext").keydown(function(event) {
    if ( event.keyCode == 46 || event.keyCode == 8 ) {
        // let it happen, don't do anything
    }else {
	   if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
        }	
    }

});
    
    
$("#crmdashboard").change(function(){
    //$("#before_show").show();
    //$("#after_show").hide();
    $('.overlay').show();
    setTimeout(function(){
        $('.overlay').hide();
    },1000);

    var value   = $(this).val();
    var user_id = $('#user_id').val();
    if(value == "live"){
        $('#dashboard_frame').attr('src','/chartphp/demos/basic/live-dashboard.php?user_id='+user_id);
    }else{
        $('#dashboard_frame').attr('src','/chartphp/demos/basic/sales-dashboard.php?user_id='+user_id);
    }
});

$('#dashboard_frame').load(function(){
    show_graph();
});


    
  
$('#mailingnotes').click(function() {
    $('#composemailingnotes-modal').modal('show');
});




});//main document end




function show_graph()
{
    $("#before_show").hide();
    $("#after_show").show();
}
  