$(document).ready(function(){
	$('#table_name').change(function(){
		getSetTableFields(this);
	});
	
	
	$('#add_placeholder').click(function(){
		resetFields();
	});

	$('.edit_placeholder').click(function(){
		var id=$(this).data('placeholder_id');
		$.ajax({
			url:'/placeholder/'+id,
			dataType: "json",
			success:function(data){
				data=data[0];
				$('#placeholder_id').val(id);
				$('#module').val(data.module);
				$('#table_name').val(data.table);
				getSetTableFields('#table_name');
				$('#field_name').val(data.field);				
				$('#compose-modal').modal('show');
			}
		});
	});
});

function getSetTableFields(ths){
	var url=$('#baseurl').val();
	var table = $(ths).val();	
	$.ajax({
		url:url + '/table/fields/'+table,
		type: "GET",
		success:function(data){
			$('#field_name').html(data);
		},
		error:function(e){
			alert('error');
			$('#field_name').html('');
		}
	});
}

function resetFields(){
	$('#placeholder_id').val('');
	$('#module').val('');
	$('#table_name').val('');
	$('#field_name').val('');
}
