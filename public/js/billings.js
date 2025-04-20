$(document).ready(function(){    
    $("#viewplan").click(function(){
	    $(".choose_plan").toggle();
	});

    $("#no_of_clients").keyup(function(){
	    price_calculation();
	});

	$("#no_of_months").on('change', function(){
	    price_calculation();
	});

    
});


function price_calculation()
{
	var no_of_clients 	= $('#no_of_clients').val();
	var no_of_months  	= $('#no_of_months').val();
	var perclient_price = $('#hidden_price').val();
	//alert(no_of_clients+'=='+no_of_months);
	var total = no_of_clients*no_of_months*perclient_price;
	var total_amount = total.toFixed(2);

	$.ajax({
		url : '/store-payment-data',
		type : 'POST',
		//dataType : 'json',
		data : { 'no_of_clients':no_of_clients, 'no_of_months':no_of_months, 'perclient_price':perclient_price, 'total_amount':total_amount},
		success : function(resp){
			if(no_of_clients == ""){
				$('#total_span').html('0.00');
				$('#amount').val('');
			}else{
				$('#total_span').html(total_amount);
				$('#amount').val(total_amount);
			}
		}
	});

	
}



