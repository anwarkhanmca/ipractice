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
        <?php 
            $terms=array("PIA"=>"Payment in advance",
    "Net 7"=>"seven days after invoice date",
    "Net 10"=>"ten days after invoice date",
    "Net 30"=>"thirty days after invoice date",
    "Net 60"=>"sixty days after invoice date",
    "Net 90"=>"ninty days after invoice date",
    "EOM"=>"End of Month",
    "21 MFI"=>"21st of the month following invoice date",
    "1% 10 Net 30"=>"1% discount if payment received within ten days otherwise payment 30 days after invoice date",
    "COD"=>"Cash on delivery",
    "Cash account"=>"Account conducted on a cash basis, no credit",
    "Letter of credit"=>"A documentary credit confirmed by a bank, often used for export",
    "Bill of Exchange"=>"A promise to pay at a later date, usually supported by a bank",
    "CND"=>"Cash next delivery",
    "CBS"=>"Cash before shipment",
    "CIA"=>"Cash in advance",
    "CWO"=>"Cash with order",
    "1MD"=>"Monthly credit payment of a full month's supply",
    "2MD"=>"As above plus an extra calendar month",
    "Contra"=>"Payment from the customer offset against the value of supplies purchased from the customer",
    "Stage payment"=>"Payment of agreed amounts at stage");
//dd($terms['Net 7']);
        ?>

        <div class="panel panel-primary" style="border-color: #0866C6">
            <div class="panel-heading"  style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                <h3 class="panel-title">Send Invoice by Email</h3>
            </div>
            <div class="panel-body">
            <?php 
                $client_type = Client::where('client_id', $proposal_info->customer_id)->first()->type;
            ?>
                <form action="{{ url('crm/sendInvoiceViaEmail') }}" method="post">
                    <div class="row form-group col-md-12">
                        <div class="col-md-3">
                            <label>Email To</label>
                        </div>
                        <div class="col-md-6 col-xs-12">
                        @if($client_type == 'ind')
                            <input type="text" name="email_to" value="<?php echo $customer_info['res_email']; ?>" class="form-control"  readonly placeholder="Email address"/>
                        @elseif($client_type == 'org')    
                            <input type="text" name="email_to" value="<?php //echo $customer_info->email_address; ?>" class="form-control"  readonly placeholder="Email address"/>
                        @endif    
                            @if ($errors->has('email_to')) <span style="color: red">{{ $errors->first('email_to') }}</span> @endif
                        </div>
                    </div>
                    <!--                    form-groum-->
                    <div class=" row form-group col-md-12">
                        <div class="col-md-3">
                            <label>Subject</label>
                        </div>
                        <div class="col-md-9 col-xs-12">
                        @if($client_type == 'ind')
                            <input type="text" name="subject" value="Invoice For <?php echo $customer_info['client_name']; ?>" placeholder="Subject" class="form-control"/>
                        @elseif($client_type == 'org')    
                            <input type="text" name="subject" value="Invoice For <?php echo $customer_info['business_name']; ?>" placeholder="Subject" class="form-control"/>
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
                            <textarea name="message"  class="form-control invoice_mail_summernote">
                                <?php 
                                // if(set_value('message')&&set_value('message')!=""){
                                //     echo set_value('message');
                                // }else{
                                    ?>
                                @if($client_type == 'ind')    
                                    <p>Dear <?php echo $customer_info['client_name']; ?>,<br/><br/>
                                    Thank you for the opportunity to provide service(s) to you.<br/><br/>
                                    We have attached an invoice for you in the amount of <?php echo "$"."".$proposal_info->total;?> Please remit payment
within <b><?php echo $terms[$invoice->payment_terms];?></b>.<br/><br/>Thanks you so much and we will see at your next service!
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
                                    <p>Dear <?php echo $customer_info['business_name']; ?>,<br/><br/>
                                    Thank you for the opportunity to provide service(s) to you.<br/><br/>
                                    We have attached an invoice for you in the amount of <?php echo "$"."".$proposal_info->total;?> Please remit payment
within <b><?php echo $terms[$invoice->payment_terms];?></b>.<br/><br/>Thanks you so much and we will see at your next service!
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
                            <input name="invoice_id" value="<?php echo $invoice_id;?>" type="hidden"/>
                            <button type="submit" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6"><i class="fa fa-send tiny-icon"></i> Send</button>
                            <a href="{{ url('crm/saveInvoiceAsDraftFromEmailForm/'.$invoice_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6"><i class="fa fa-save tiny-icon"></i> Save </a>
                            
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