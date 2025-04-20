$(document).ready(function(){
	$('.delete_user').click(function(){
		var user_id = $(this).data('user_id');
		if(confirm('Do you want to delete?')){
			$.ajax({
				type :'POST',
				url : '/sm/delete-user',
				data : {user_id : user_id},
				success : function(resp){
					$('.user_'+user_id).hide();
				}
			});
		}
	});

	$('#update_paypal').click(function(){
		var server 	= $('#server').val();
		var email 	= $('#email').val();
		var price 	= $('#price').val();
		$.ajax({
			url : '/sm/save-paypal-settings',
			type : 'POST',
			dataType : 'json',
			data : { 'server' : server, 'email' : email, 'price' : price},
			success : function(resp){
				if(resp.msg == 'success'){
					$('.message').html('<span style="color:#3c8dbc">Paypal settings updated successfully!</span>');
				}else{
					$('.message').html('<span style="color:red">There are some problem, Please try again</span>');
				}
			}
		});
	});



});