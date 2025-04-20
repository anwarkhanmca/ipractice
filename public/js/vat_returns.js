$(document).ready(function(){
	$('#allCheckSelect').on('ifChecked', function(event){
		$('.vat_returns input').iCheck('check');
	});

	$('#allCheckSelect').on('ifUnchecked', function(event){
		$('.vat_returns input').iCheck('uncheck');
	});
});