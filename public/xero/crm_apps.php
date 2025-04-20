<?php
	include('../../app/library/XeroApi.php');
	include ('../file-and-sign/connect.php');
	$_SESSION['admin_details'] = XeroApi::get_session();
	//echo '<pre>';print_r($_SESSION);die;
?>
<?php include('public.php');?>

<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/mps_style.css" rel="stylesheet" type="text/css" />
<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />



<!-- <div class="container">
    <div class="row"> -->
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="panel panel-primary">
                <div class=" panel-heading" style="color:#fff;background-color:#0866C6; border-color: #0866C6;">
                    <h3 class="panel-title"><i class="fa fa-list tiny-icon"></i> &nbsp;Connected Apps</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="dataTables_wrapper form-inline no-footer">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr role="row">
                                        <th width="40%" colspan="2">Provider</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="85%">Xero : <a href="javascript:void(0)">https://app.xero.com</a></td>
                                        <td width="15%" align="center" id="disconnectBtn">
                                        	<?php if(!isset($_SESSION['access_token'.$group_id])){?>
												<button type="button" onclick="import_from_xero();" style="color: #0866c6;">Connect</button>
											<?php }else{?>
												<button type="button" onclick="disconnect_from_xero();" style="color: #0866c6;">Disconnect</button>
											<?php }?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div>
</div> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script>
function import_from_xero(){
    url='/xero/public.php?authenticate=1';
    newwindow=window.open(url,'name','left=300,top=100,height=600,width=750,scrollbars=1');
    if (window.focus) {newwindow.focus();}
    return false;
}

function disconnect_from_xero(){
	window.location.href = '/xero/public.php?sesson_destroy=1';
	//window.location.href = '/xero/public.php?refresh=1';
	return false;
}
</script>