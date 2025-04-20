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
                <div class=" panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title" style="margin-top:10px;"><i class="fa fa-file-text tiny-icon"></i> Payment</h3>
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
                            <table class="table table-bordered table-striped table-hover" id="payment_table">
                                <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Receiving Date</th>
                                    <th>Amount Paid</th>
                                 
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($bills&&!empty($bills)):
                                    foreach($bills as $bill):
                                        ?>
                                        <tr>
                                            <td>
                                            <?php 
                                                $client_type = Client::where('client_id', $bill->customer_id)->first()->type;
                                                if($client_type == 'ind'){
                                                    echo StepsFieldsClient::where('client_id', $bill->customer_id)->where('field_name', 'client_name')->first()->field_value;
                                                }else {
                                                    echo StepsFieldsClient::where('client_id', $bill->customer_id)->where('field_name', 'business_name')->first()->field_value;
                                                }
                                            ?>
                                            </td>
                                            <td><?php echo $bill->invoice_id;?></td>
                                            <td><?php echo date('d/m/Y', strtotime(Invoice::find($bill->invoice_id)->created_at)); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($bill->receiving_date)); ?></td>
                                            <td><?php echo "$ ".$bill->amount;?></td>
                                            <td>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                                        <li><a href="{{ url('crm/editBill/'.$bill->id) }}"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                                     <?php //if($this->session->userdata('role')&&$this->session->userdata('role')=="ADMIN"):?>
                                                        <li><a href="{{ url('crm/deleteBill/'.$bill->id) }}" class="deleted"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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