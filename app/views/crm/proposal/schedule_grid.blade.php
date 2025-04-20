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
                            <h3 class="panel-title" ><i class="fa fa-file-text tiny-icon"></i> Scedule</h3>
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
                            <table class="table table-bordered table-striped table-hover" id="schedule_table">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Proposal Title</th>
                                    <th>Proposal ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($schedules&&!empty($schedules)):
                                    foreach($schedules as $schedule):
                                        ?>
                                        <tr>
                                        <?php 
                                        $client_type = Client::where('client_id', $schedule->customer_id)->first()->type;

                                        $customer_info = StepsFieldsClient::where('client_id', $schedule->customer_id)->lists('field_value', 'field_name');

                                        ?>
                                            <?php 
                                                if($client_type == 'ind'){ ?>
                                            <td><?php echo $customer_info['client_name'];?></td>
                                            <td><?php echo $customer_info['res_mobile'];?></td>
                                            <td><?php echo $customer_info['res_email'];?></td>
                                            <?php } elseif($client_type == 'org'){ ?>
                                                <td><?php echo $customer_info['business_name'];?></td>
                                                <td></td>
                                                <td></td>
                                            <?php 
                                            }    
                                            ?>
                                            <td><?php echo $schedule->proposal_title;?></td>
                                            <td><?php echo $schedule->proposal_id;?></td>
                                            <td><span class="btn btn-xs btn-<?php 
                                            switch($schedule->status){
                                                case "Done":
                                                            echo "success";
                                                            break;
                                                 case "In Progress":
                                                            echo "primary";
                                                            break;
                                                 case "Canceled":
                                                            echo "warning";
                                                            break;
                                            }
                                            ?>"><?php echo $schedule->status;?></span></td>
                                          
                                            <td>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                                    <?php if($schedule->status!="Done"):?>
                                                        <li><a href="{{ url('crm/toggleScheduleStatus/Done/'.$schedule->id) }}"><i class="fa fa-check-square-o tiny-icon"></i>Done</a></li>
                                                    <?php endif;?>
                                                    <?php if($schedule->status!="Canceled"):?>
                                                        <li><a href="{{ url('crm/toggleScheduleStatus/Canceled/'.$schedule->id) }}"><i class="fa fa-times-circle tiny-icon"></i>Canceled</a></li>
                                                    <?php endif;?>
                                                    <?php if($schedule->status!="In Progress"):?>
                                                        <li><a href="{{ url('crm/toggleScheduleStatus/In Progress/'.$schedule->id) }}"><i class="fa fa-spinner tiny-icon"></i>In Progress</a></li>
                                                    <?php endif;?>
                                                        <li><a href="{{ url('crm/deleteSchedule/'. $schedule->id) }}" class="deleted"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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