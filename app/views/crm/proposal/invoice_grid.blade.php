<div class="container">
    <div class="row">
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
                <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                   <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title" ><i class="fa fa-file-text tiny-icon"></i> Invoices</h3>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ url('crm/amountReceiveForm') }}" class="btn btn-md btn-default pull-right" style="margin-right:0px;color:#0C5889; margin-left: 10px;"><i class="fa fa-money tiny-icon"></i> &nbsp;Add Payment</a>
                            <a href="{{ url('crm/createProposal') }}" class="btn btn-md btn-default pull-right" style="margin-right:0px;color:#0C5889;"><i class="fa fa-plus-square tiny-icon"></i> &nbsp;Create Proposal</a>
                        </div>
                    </div> 
                    </div>
<!--                heading-->
                    <div class="panel-body">
                        <div class="table-responsive responsive-table" >
                            <table class="table table-bordered table-striped table-hover" id="invoice_table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Invoice ID</th>
                                    <th>Proposal ID</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Payment Details</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($invoices && !empty($invoices)):
                                    foreach($invoices as $invoice):
                                        ?>
                                        <tr>
                                            <td><?php echo $invoice->ProposalInfo->proposal_title ;?></td>
                                            <td><?php echo $invoice->id;?></td>
                                            <td><?php echo $invoice->proposal_id;?></td>
                                            <td>
                                            <?php
                                                $client_type = Client::where('client_id', $invoice->ProposalInfo->customer_id)->first()->type;
                                                if($client_type == 'ind'){
                                                    echo StepsFieldsClient::where('client_id', $invoice->ProposalInfo->customer_id)->where('field_name', 'client_name')->first()->field_value;
                                                }else {
                                                    echo StepsFieldsClient::where('client_id', $invoice->ProposalInfo->customer_id)->where('field_name', 'business_name')->first()->field_value;
                                                }
                                            ?>    
                                            </td>
                                            <td><?php echo "$ ".$invoice->ProposalInfo->total;?></td>
                                            <td><?php echo date('d/m/Y', strtotime($invoice->created_at)); ?></td>
                                            <td>
                                            <?php if(!empty($invoice->status)):?>
                                            <span class="btn btn-xs btn-<?php 
                                                switch ($invoice->status) {
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
                                            <?php echo $invoice->status;?>
                                            </span>
                                            <?php 
                                                endif;
                                            ?>
                                            </td>
                                            <td>
                                            <?php 
                                            if($invoice->payment_status=="Paid"):
                                                echo "<span class='btn btn-xs btn-success'>".$invoice->payment_status."</span>";
                                            elseif($invoice->payment_status=="Partially Paid"):
                                                echo "<span class='btn btn-xs btn-primary'>".$invoice->payment_status."</span>";
                                            else:
                                                echo "<span class='btn btn-xs btn-warning'>".$invoice->payment_status."</span>";
                                            endif;


                                            ?>

                                           

                                            </td>
                                            <td>
                                            <?php if(Bill::where('invoice_id', $invoice->id)->count() > 0):?>
                                                <a href="#" class="btn btn-xs btn-primary view_details"  data-invoiceid="<?php echo $invoice->id;?>"><i class="fa fa-eye tiny-icon"></i> View</a>
                                            <?php endif;?>

                                            </td>
                                            <td>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                                        <li><a href="{{ url('crm/previewInvoiceFromGrid/'. $invoice->id) }}"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>
                                                          <?php
                                                          //echo "<li>".checkInvoice($invoice->id)."hello</li>";
                                                            if(($invoice->status=="INITIATED"||$invoice->status=="DRAFT") && Bill::where('invoice_id', $invoice->id)->count() == 0){   
                                                     ?>
                                                        <li><a href="{{ url('crm/editInvoice/' . $invoice->proposal_id. '/' .$invoice->id) }}"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                                   <?php 
                                                        }
                                                   ?>
                                                        <li><a href="{{ url('crm/sendInvoiceViaEmailForm/'.$invoice->id.'/'.$invoice->proposal_id) }}"><i class="fa fa-send tiny-icon"></i>Email</a></li>
                                                        <li><a href="{{ url('crm/downloadInvoice/Invoice-id-'.$invoice->proposal_id.'.pdf/'. $invoice->id) }}" ><i class="fa fa-download tiny-icon"></i>Download</a></li>
                                                      <?php //if($this->session->userdata('role')&&$this->session->userdata('role')=="ADMIN"):?> 
                                                        <li><a href="{{ url('crm/deleteInvoice/' . $invoice->id.'/'.$invoice->proposal_id) }}" class="delete" data-url="{{ url('/crm/viewAllInvoice/check_invoice/'.$invoice->id) }}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                                                   <?php //endif;?>
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

    <!--container col-md-12 hidden-print-->

    <!-- //////////////////////////////////////INVOICE VIEW DETAILS MODAL///////////////////////////////////// -->
    <!-- Modal -->
<div class="modal fade" id="payment_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Billing History</h4>
      </div>
      <div class="modal-body">
    <table class="table table-bordered table-hover" id="bill_detail_table">
        <thead style="background-color: #0866C6; color: white;">
            <tr>
                <th>SL NO</th>
                <th>Amount</th>
                <th>Receiving Date</th>
            </tr>
        </thead>
        <tbody id="invoice-container">
           
        </tbody>
    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <!-- ///////////////////////////////////SMALL MODAL FOR MESSAGE/////////////////////
<!-- <div class="modal fade modal-sm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      
      </div>
      <div class="modal-body">
       <h4>Sorry, this invoice is already billed, you have to delete <span id="bills"></span> bill before deleting invoice.</h4>
      </div>
    
    </div>
  </div>
</div>  -->
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