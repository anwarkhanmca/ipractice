$(document).ready(function(){
	$('#add_new_template_type').click(function(){
		var url=$(this).data('baseurl');
				
		$.ajax({
			url:url + '/template/type/new',
			type: "GET",
	    		success:function(tpl){
				$('body').append(tpl);
				$('#add_new_template_type_model').modal('show');
			},
			error:function(e){
				alert('error');
			}
		});
	});

	$('#add_new_template_type_form').on('submit',function(e){
		e.preventDefault();
		var data = $('#add_new_template_type_form').serialize();
		var url = $('#add_new_template_type_form').attr('action');
		$.ajax({
			url:url,
			data:data,
			success:function(){
				alert('Successful');
				location.reload();
			},
			error: function(){
				alert('Some error occured, Please try again');
			}
		});
	});
});
