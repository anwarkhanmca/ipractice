<div class="container">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            @if(Session::has('info_msg'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ Session::get('info_msg') }}
                        </div>
                    </div>
                </div>
            @endif    
            <div class="panel panel-primary" style="border-color: #0866C6">
                <div class=" panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                     <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title" style="margin-top:10px;"><i class="fa fa-file-text tiny-icon"></i> &nbsp;{{ $content_header or "" }}</h3>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ url('crm/amountReceiveForm') }}" class="btn btn-md btn-default pull-right" style="margin-right:0px;color:#0C5889; margin-left: 10px;"><i class="fa fa-money tiny-icon"></i> &nbsp;Add Payment</a>
                            <a href="{{ url('crm/createProposal') }}" class="btn btn-md btn-default pull-right" style="margin-right:0px;color:#0C5889;"><i class="fa fa-plus-square tiny-icon"></i> &nbsp;Create Proposal</a>
                        </div>
                    </div>
                </div>
<!--                heading-->
                    <div class="panel-body">
                        <div class="table-responsive" >
                            <table class="table table-bordered table-striped table-hover" id="proposal_table">
                                <thead style="background-color: #0866C6; color: white">
                                <tr>
                                    <th>Title</th>
                                    <th>Proposal ID</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Creation Date</th>
                                    <th>Status</th>
                                    <th>Invoiced</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(isset($proposal) && count($proposal) >0):
                                    foreach($proposal as $proposal):
                                        ?>
                                        <tr>
                                            <td><?php echo $proposal->proposal_title;?></td>
                                            <td><?php echo $proposal->id;?></td>
                                            <td><?php 
                                                $client_type = Client::where('client_id', $proposal->customer_id)->first()->type;
                                                if($client_type == 'ind'){
                                                    echo StepsFieldsClient::where('client_id', $proposal->customer_id)->where('field_name', 'client_name')->first()->field_value;
                                                }else {
                                                    echo StepsFieldsClient::where('client_id', $proposal->customer_id)->where('field_name', 'business_name')->first()->field_value;
                                                }
                                            ?></td>
                                            <td><?php echo "$ ".$proposal->total;?></td>
                                            <td><?php echo date('d/m/Y', strtotime($proposal->created_at));?></td>
                                            <td>
                                            <?php if($proposal->status!=""){?>
                                            <span class="btn btn-xs btn-<?php 
                                                switch ($proposal->status) {
                                                    case 'DOWNLOAD':
                                                        echo "success";
                                                        break; 
                                                    case 'DRAFT':
                                                        echo "info";
                                                        break;
                                                    case 'EMAILED':
                                                        echo "warning";
                                                        break;
                                                     case 'INITIATED':
                                                        echo "primary";
                                                        break;
                                                  
                                                    default:
                                                        echo "success";
                                                        break;
                                                }
                                            ?>">
                                            <?php echo $proposal->status;?>
                                            </span>
                                        <?php }?>
                                            </td>
                                            <td>
                                                <span class="{{ 'btn btn-xs btn-'.((Invoice::where('proposal_id', $proposal->id)->first()) ? 'success' :'warning') }}">
                                                    {{ ((Invoice::where('proposal_id', $proposal->id)->first()) ? 'YES' :'NO') }}
                                                </span>
                                            </td>
                                            <td>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                                     <?php if($proposal->proposal_template!=""):?>
                                                        <li><a href="{{ url('crm/loadProposalPreviewFromGrid/'.$proposal->id) }}"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>
                                                        <li><a href="{{ url('crm/sendProposalViaEmailForm/'.$proposal->id) }}"><i class="fa fa-send tiny-icon"></i>Email</a></li>
                                                        <li><a href="{{ url('crm/downloadProposal/Proposal_attachments_merged'. $proposal->id.'.pdf/'.$proposal->id) }}"><i class="fa fa-download tiny-icon"></i>Download</a></li>
                                                        <li><a href="{{ url('crm/copyProposal/'.$proposal->id) }}"><i class="fa fa-copy tiny-icon"></i>Copy</a></li>
                                                    <?php 
                                                     endif;

                                                    if($proposal->status=="DRAFT"||$proposal->status=="INITIATED"):?>
                                                        <li><a href="{{ url('crm/editProposal/'.$proposal->id) }}"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                                    <?php endif;?>
                                                    <?php if(($proposal->status=="PRINTED"||$proposal->status=="DOWNLOADED"||$proposal->status=="EMAILED") && !(Invoice::where('proposal_id', $proposal->id)->first())):?>

                                                        <li><a href="{{ url('crm/paymentTerms/'.$proposal->id) }}" ><i class="fa fa-file-text tiny-icon"></i>Create Invoice</a></li>
                                                     <?php
                                                      endif;
                                                        if(Invoice::where('proposal_id', $proposal->id)->first()):
                                                     ?>
                                                        <li><a href="{{ url('crm/previewInvoice/'. (Invoice::where('proposal_id', $proposal->id)->first()->id)) }}" ><i class="fa fa-file-text tiny-icon"></i>Preview Invoice</a></li>

                                                 <?php 
                                                    endif;
                                              
                                                    ?>

                                                       <?php
                                                       

                                                        //if($this->session->userdata('role')&&$this->session->userdata('role')=="ADMIN"): ?>
                                                                                                                        <!-- proposal-delete is not working class. Please solve it -->
                                                        <li><a href="{{ url('crm/deleteProposal/'.$proposal->id) }}" class="delete" data-url="{{ url('/crm/viewAllProposal/check_proposal/'.$proposal->id) }}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                                                    
                                                 <?php 
                                                    //endif;
                                                 ?>
                                                    </ul>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?> 
                                </tbody>
                            </table>

                        </div>
                        <!--table-responsive-->

                    </div>
                    <!-- panel-body-->
                </div>
                <!-- panel-->
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>

    <div class="modal fade modal-sm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      
      </div>
      <div class="modal-body">
       <h4 id="message_modal"></h4>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> 