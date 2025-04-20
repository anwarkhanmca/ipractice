<?php

/* Template Name: Download Area
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$current_user=new USER_INFO(wp_get_current_user()->ID);
$rows_client=$current_user->get_client_manager_and_user();
$base_url=  get_option("siteurl");

include 'header-dashboard.php';
?>
		<link href="<?=  bloginfo('template_url')?>/dashboard/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="<?=  bloginfo('template_url')?>/dashboard/js/jquery.dataTables.min.js"></script>
<script>
var availableTags = [
    <?php $i=1;?>
    <?php foreach ($rows_client as $row_client){?>
        <?php if($i<count($rows_client)){?>
            "<?=$row_client->client_name?>",
        <?php }else{?>
            "<?=$row_client->client_name?>"
        <?php }?>
    <?php $i++; }?>
];
var client_ids = [
    <?php $i=1;?>
    <?php foreach ($rows_client as $row_client){?>
        <?php if($i<count($rows_client)){?>
            "<?=$row_client->id?>",
        <?php }else{?>
            "<?=$row_client->id?>"
        <?php }?>
    <?php $i++; }?>
];

function hide_text_search(a){
    if(jQuery(a).val()==='Client Name'){
        jQuery(a).val('');
    }
}
function show_text_search(a){
    if(jQuery(a).val()===''){
        jQuery(a).val('Client Name');
    }
}

function export_file(file_id) {
    url = '<?=$base_url?>';
    jQuery.ajax({
		url: url+'/wp-admin/admin-ajax.php',
		data: {action:'export_to_csv_from_file_id',file_id:file_id},
		async: false,
		dataType: "html",
		type: "POST"
	}).done(function(data){
		if (data !== '0') {
			window.location.assign(url + '/page-download?filename='+ encodeURIComponent(data));
			return true;
		} else {
            alert('Failed to create download file');
			return false;
        }
	});
}

function delete_file(id,a){
    url = '<?=$base_url?>';
    var r=confirm("Are you sure you want to delete?");
    if (r===true){
        jQuery.post(url+'/wp-admin/admin-ajax.php',{action:'delete_file',id:id},function(data){
            if(data==='1'){
                jQuery(a).parent().parent().css('display','none');
				var client_name=$('#test').val().trim();
				var client_index = availableTags.indexOf(client_name);
				if (client_index >= 0) {
					// found
					reset_datatable(client_ids[client_index]);
				} else {
					reset_datatable();
				}
            }
            if(data==='0'){
                alert('Cannot delete');
            }
        },'html');
    } else {
		event.preventDefault();
	}
}

function delete_checked(event) {
    var values=jQuery('input:checkbox:checked.checkfile').map(function () {
        return this.value;
    }).get();
	if (values.length == 0) {
		alert('You must check at least one file for deleting.');
	} else {
		var r=confirm("Are you sure you want to delete these " + values.length + " checked files?");
	    if (r===true){
	        jQuery.post(url+'/wp-admin/admin-ajax.php',{action:'delete_files',ids:values},function(data){
	            if(data==='1'){
					var client_name=$('#test').val().trim();
					var client_index = availableTags.indexOf(client_name);
					if (client_index >= 0) {
						// found
						reset_datatable(client_ids[client_index]);
					} else {
						reset_datatable();
					}
	            }
	            if(data==='0'){
	                alert('Cannot delete');
	            }
	        },'html');
		}
	}
}

function form_compare_submit(a){
    var values=jQuery('input:checkbox:checked.checkfile').map(function () {
        return this.value;
    }).get();
    if(values.length!==2){
        alert('You must check two files');
		return false;
    }
	// change form action to compare
	download_form.action='<?=$base_url?>/compare/';
	return true;
}

function clear_search() {
	$('#test').val('');
	reset_datatable();
}

function reset_datatable(client_id) {
	if ($('#files').dataTable()) {
		$('#files').dataTable().fnDestroy(); 
	}

	client_id = (typeof client_id === "undefined") ? "-1" : client_id;
	client_name = $('#test').val();
	url = '<?=$base_url?>';
	template_url = '<?=bloginfo("template_url")?>';
	$('#files').dataTable( {
		"searching" : false,
		"processing": true,
		"serverSide": true,	
		"pageLength": 10,
		"order" : [1, "desc"],	
		"ajax": {
			"url" : url+'/wp-admin/admin-ajax.php',
			"type" : "POST",
			"data" : {'action': 'get_downloads', 'client_id': client_id, 'client_name': client_name}
		},
		"columnDefs": [{
			    "targets": 0,
				"orderable" : false,
			    "render": function ( data, type, full, meta ) {
					return '<input class="checkfile" type="checkbox" name="a[' + data + '] " value="' + data + '">';
				 }
	  		},{
			    "targets": 1,
				"width" : "140px"
	  		},{
			    "targets": 6,
				"orderable" : false,
			    "render": function ( data, type, full, meta ) {
				    return '<a onclick="return export_file(\'' + data + '\');" href="#">Download File</a>';
				}
		  	},{
			    "targets": 7,
				"orderable" : false,
				"width" : "40px",
			    "render": function ( data, type, full, meta ) {
				    return '<a class="delete_button" onclick="delete_file('+data+',this);"><img src="' + template_url + '/images/delete.png"/></a>';
				}
		  	}						
		]	  
	} );

	var search_client_html = '<input onclick="delete_checked(this);" name="delete_tbs" type="button" value="Delete checked files" class="btn fleft">' +
	'<div class="fleft ui-widget search_client">' +
        '<b>SEARCH: </b><input id="test" name="client_name" type="text" value="<?php if(isset($_POST['client_name'])) echo $_POST['client_name']; else echo 'Client Name';?>" onfocus="hide_text_search(this);" onblur="show_text_search(this);"/>' +
		'<a href="#" onclick="clear_search();" class="clear_search">Clear Search</a></div>' + 
		'<div class="fleft"><b>Track trial balance changes:</b> <input onclick="return form_compare_submit(this);" name="compare_tbs" type="submit" value="Compare TBs" class="btn"></div>';
    $(search_client_html).insertBefore("#files_length");

    $.ui.autocomplete.prototype._renderItem = function (ul, item) {
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append($("<a ></a>").html(item.label))
            .prependTo(ul);
    };
     $("#test" ).autocomplete({
        source: availableTags,
        select: function (event, ui) {
            var client_name=ui.item.value;
			var client_index = availableTags.indexOf(client_name);
			if (client_index >= 0) {
				// found
				reset_datatable(client_ids[client_index]);
			}
        },
        change: function (event,ui){
            var client_name=jQuery('#test').val();
			var client_index = availableTags.indexOf(client_name);
			if (client_index >= 0) {
				// found
				reset_datatable(client_ids[client_index]);
			}
        } 
     });
	$( "#test" ).keypress(function( event ) {
		if ( event.which == 13 ) {
			// enter
			if ($( "#test" ).val().trim() == '') {
				reset_datatable();
			} else {
				var client_name=$('#test').val();
				var client_index = availableTags.indexOf(client_name);
				if (client_index >= 0) {
					// found
					reset_datatable(client_ids[client_index]);
				}
			}
			$( "#test" ).autocomplete( "close" );
		}
	});
	$('#test').on('focus', function() {
		if ($('#test').val().trim() === '') {
			$('#test').autocomplete( "search", "a" );
		} else {
			$('#test').autocomplete( "search", $('#test').val().trim() );
		}
	});
}

$(document).ready(function() {
	reset_datatable();
	$('#checkall').on('change',function(){
		$('.checkfile').prop('checked', this.checked);
	});
});
</script>
<style>
	.dataTables_wrapper{
		width: 95% !important;
	}
	#files_length {
		float: right;
	}
	#files th:nth-child(1), #files th:nth-child(7), #files th:nth-child(8),
	#files td:nth-child(1), #files td:nth-child(7), #files td:nth-child(8) {
		text-align:center !important;
	}
	.clear_search {
		margin-left: 10px;
		font-size: 0.9em;
		margin-right: 50px;
	}
	.btn {
		background:#0188cc !important;
		color: #fff !important;
/*		font-weight: bold !important;*/
		border-radius: 5px !important;
		margin-right: 50px !important;
	}
	input.fleft, div.fleft, #files_legth {
		margin-bottom: 20px;
	}
</style>

<div id="primary" class="site-content">
	<div id="content" role="main">
	<div class="container">
		<div class="row">
			<div class="span9">
				<h1>Files</h1>
                <form action="" method="POST" name="download_form">
					<table id="files" class="display table table-striped table-bordered" cellspacing="0">
						<thead>
							<tr>
								<th><input type="checkbox" id="checkall"></th>
								<th>Import Date</th>
								<th>Client Name</th>
								<th>Date To</th>
								<th>Notes</th>
								<th>AP Chart</th>
								<th>Download</th>
								<th>Delete</th>
							</tr>
						</thead>
					</table>
				</form>
			</div>
		</div>
	</div>
	</div>
</div>
<?php
	// clean up
	unset($rows_client);
	$rows_client = null;
?>	
<?php include 'footer-dashboard.php';?>