<style type="text/css">
    .to-mail{
        width:300px;

    }
 @media(max-width:360px){
    .to-mail{
        width:100%;
        margin-right:5px;

    }
   }
</style>

<div class="container">
    <div class="col-md-8 col-md-offset-2">
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
                <h3 class="panel-title">Send Proposal via Email</h3>
            </div>
            <div class="panel-body">
            <?php 
                $client_type = Client::where('client_id', $proposal_info->customer_id)->first()->type;
            ?>
                <form action="{{ url('crm/sendProposalViaEmail') }}" method="post">
                    <div class="row form-group col-md-12">
                        <div class="col-md-3">
                            <label>Email To</label>
                        </div>
                        <div class=" col-sm-6 col-xs-12">
                            @if($client_type == 'ind')
                            <input type="text" name="email_to" value="<?php echo $customer_info['res_email']; ?>" class="form-control" placeholder="Email address"/>
                            @elseif($client_type == 'org')
                                <input type="text" name="email_to" value="<?php //echo $customer_info['res_email']; ?>" class="form-control" placeholder="Email address"/>
                            @endif
                            @if ($errors->has('email_to')) <span style="color: red">{{ $errors->first('email_to') }}</span> @endif
                        </div>
                    </div>
                    <!--                    form-groum-->
                    <div class=" row form-group col-md-12">
                        <div class="col-md-3">
                            <label>Subject</label>
                        </div>
                        <div class="col-md-9">
                            @if($client_type == 'ind')
                            <input type="text" name="subject" value="Proposal For <?php echo $customer_info['client_name']; ?>" placeholder="Subject" class="form-control"/>
                            @elseif($client_type == 'org')
                                <input type="text" name="subject" value="Proposal For <?php echo $customer_info['business_name']; ?>" placeholder="Subject" class="form-control"/>

                            @endif
                            @if ($errors->has('subject')) <span style="color: red">{{ $errors->first('subject') }}</span> @endif
                        </div>
                    </div>
                    <!--                    form-groum-->
                    <div class="row form-group col-md-12">
                        <div class="col-md-3">
                            <label>Email Body</label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="message"  class="form-control mail_summernote">
                                <?php //if(set_value('message')&&set_value('message')!=""){
                                    //echo set_value('message');
                                // }else{
                                    ?>
                                    @if($client_type == 'ind')
                                        <p>Dear <?php echo $customer_info['client_name']; ?>,<br/>
                                        We have created an estimate for <?php echo $customer_info['client_name']; ?> on <?php echo date('d/m/Y', strtotime($proposal_info->created_at));?>. Please check the attached file for pricing.<br/><br/>If you have any questions regarding this pricing, please contact us over phone at <b><?php echo  $company_info->telephone_no;?></b> or over email at: <b><?php echo  $company_info->practiceemail;?></b>.<br/><br/>We will feel lucky to do business with you.
                                        <br/><br/>Thank you for your time and consideration.
                                            </p>
                                        <?php echo  $company_info->display_name;?><br/>
                                        <?php 
                                            echo $company_address->street_address. ', ' . $company_address->city. ', ' . $company_address->state. ', '; 
                    
                                            if($company_address->zip != 0){
                                                echo $company_address->street_address. ', ';    
                                            }
                                            echo Country::where('country_id', $company_address->country_id)->first()->country_name;
                                        ?><br/>
                                        <?php echo  $company_info->telephone_no;?><br/>
                                        <?php echo  $company_info->practiceemail;?><br/>
                                        <?php echo  $company_info->practicewebsite;?>
                                    @elseif($client_type == 'org')
                                        <p>Dear <?php echo $customer_info['business_name']; ?>,<br/>
                                        We have created an estimate for <?php echo $customer_info['business_name']; ?> on <?php echo date('d/m/Y', strtotime($proposal_info->created_at));?>. Please check the attached file for pricing.<br/><br/>If you have any questions regarding this pricing, please contact us over phone at <b><?php echo  $company_info->telephone_no;?></b> or over email at: <b><?php echo  $company_info->practiceemail;?></b>.<br/><br/>We will feel lucky to do business with you.
                                        <br/><br/>Thank you for your time and consideration.
                                            </p>
                                        <?php echo  $company_info->display_name;?><br/>
                                        <?php 
                                            echo $company_address->street_address. ', ' . $company_address->city. ', ' . $company_address->state. ', '; 
                    
                                            if($company_address->zip != 0){
                                                echo $company_address->street_address. ', ';    
                                            }
                                            echo Country::where('country_id', $company_address->country_id)->first()->country_name;
                                        ?><br/>
                                        <?php echo  $company_info->telephone_no;?><br/>
                                        <?php echo  $company_info->practiceemail;?><br/>
                                        <?php echo  $company_info->practicewebsite;?>
                                    @endif

                                <?php
                                // }

                                ?>
                            </textarea>
                            @if ($errors->has('message')) <span style="color: red">{{ $errors->first('message') }}</span> @endif
                        </div>
                    </div>
                    <!--                    form-groum-->
                    <div class="row">
                        <div class="col-md-9 col-md-offset-3">
                            <input name="proposal_id" value="<?php echo $proposal_id;?>" type="hidden"/>
                            <button type="submit" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6"><i class="fa fa-send tiny-icon"></i> Send</button>
                            <a href="{{ url('crm/saveProposalAsDraftFromEmailForm/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6"><i class="fa fa-save tiny-icon"></i> Save </a>
                            
                        </div>
                    </div>
                    <!--                    row-->
                </form>
            </div>
            <!--            panel-body-->
        </div>
        <!--        panel panel-primary-->
    </div>
    <!--    col-md-8 col-md-offset-2-->
</div>
<!--container col-md-12-->