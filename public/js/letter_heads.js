$(document).ready(function(){

	$('body').on('click', '.deleteLetterHead', function(e){
		e.preventDefault();
		// if (!!$(this).data('default')) {
		// 	alert('Cannot delete default letter head.');
		// 	e.stopPropogation();
		// }
		var lhead_id = $(this).data('lhead_id');
		
		$.ajax({
			url:'/letters/letter-head/remove',
			method: 'post',
			data: {"id" : lhead_id},
			success:function(data){
				if (data == 'success') {
					window.location.reload();
				}
			},
			error:function(data){
				alert(data);
			},
			fail:function(data){
				alert(data);
			}
		});

	});

	$('body').on('click', '.defaultLetterHead', function(){
		var lhead_id = $(this).data('lhead_id');
		
		$.ajax({
			url:'/letters/letter-head/makedefault',
			method: 'post',
			data: {"id" : lhead_id},
			success:function(data){
				if (data == 'success') {
					window.location.reload();
				}
			},
			error:function(data){
				alert(data);
			},
			fail:function(data){
				alert(data);
			}
		});

	});

});