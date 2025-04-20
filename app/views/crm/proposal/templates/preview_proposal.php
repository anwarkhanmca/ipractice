<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Proposal</title>
    <style>
        body{
            width:100%;
            margin: 0;
            padding: 0;
            color:#000;
            background-color: #fff;
            font-family: arial,sans-serif;
            font-size: 14px;
        }
        #main{
            width: 960px;
            margin:0 auto;
            /*border:1px solid #ccc;*/
            padding:10px;
        }
        .section{
            padding:10px;
            border-bottom:1px solid #f5f5f5;
            margin-bottom:10px;
            /* background-color:#f5f5f5; */
            margin-bottom:10px;
        }
        .left{
            float:left;
        }
        .right{
            float:right;
        }
        .segment{
            width:300px;
        }
        .head-section p{
         margin: 3px;

        }
        .head-section h2,.head-section h3{
            margin:3px;
        }
        .head-section h3{
            background-color: #000;
            padding:10px;
            width:100%;
            color:#fff;
        }
        .standard p{
            margin: 3px;
            color:#fff;

        }
        .standard h2,.standard h3{
            margin:3px;
            color:#fff;
        }
    table{
    
        border-color:#ccc;
        border: none;
        border-spacing:none;
     border-collapse: collapse;
    }
    td,th{
        padding:5px;

    }
table tbody tr td,table thead tr th{
    border:none;
    border-right:1px solid #fff;
   
    }
table tbody tr td{
        background-color: #f8f8f8;
        border:none;
        border-right:1px solid #fff;
        border-bottom:1px solid #fff;   
        border: none;  

    }
table thead tr th{
    background-color: #000;
    padding:10px;
    text-align: center;
    color:#fff;
    border-color:#fff;
}
table thead tr th{
    text-align: left;
}
        img.logo{
            width:100px;
            height:auto;
            max-height: 100px;
        }
        .hide-colunm{
            border:none;
        }
        .top h2,.top p{color:#000;}
    </style>
</head>
<body>
<div id="main">
    <div class="section head-section standard top" >
        <div class="segment left top" >
            <p><img src="<?php echo url('public/practice_logo/'. $company_info->practice_logo) ?>" class="logo"/> </p>
            <p><span style="color:#000;font-weight: bold;"> Proposal ID: </span><?php echo $proposal_info->id;?></p>
            <p><span style="color:#000;font-weight: bold;">Date:</span> <?php echo date('d/m/Y', strtotime($proposal_info->created_at)); ?></p>
        </div>
<!--        segment left-->
        <div class="segment right top" style="width: 330px;">
            <h2 ><?php echo $company_info->display_name; ?></h2>
            <p>
                <?php 
                    echo $company_address->street_address. ', ' . $company_address->city. ', ' . $company_address->state. ', '; 
                    
                    if($company_address->zip != 0){
                        echo $company_address->street_address. ', ';    
                    }
                    echo Country::where('country_id', $company_address->country_id)->first()->country_name;
                ?>
            </p>
            <p><?php echo $company_info->practiceemail; ?></p>
            <p><?php echo $company_info->telephone_no; ?></p>
            <?php if($company_info->practicewebsite!=""):?>
            <p><?php echo $company_info->practicewebsite; ?></p>
        <?php endif;?>
        </div>
        <!--        segment right-->
        <div style="clear: both"></div>

    </div>
    <?php 
        $client_type = Client::where('client_id', $proposal_info->customer_id)->first()->type;
    ?>
<!--    .section-->
    <div class="section head-section ">
        <div style="width:100%">
            <h3>Proposal for:</h3>
            <?php 
            if($client_type == 'ind'){ ?>
                <p><?php echo @$customer_info['client_name'];?></p>
            <?php
            }else if($client_type == 'org'){ ?>
                <p><?php echo @$customer_info['business_name'];?></p>
            <?Php 
            }
            ?>
            <p><?php 
            if($client_type == 'org'){
                // echo 'Organiation email and mobile';
                echo 'Organiation email and mobile';
            } else if($client_type == 'ind'){
                echo "Phone: ".$customer_info['res_mobile'] . ", Email: ".$customer_info['res_email'];
            }    
            //echo ($customer_info->contact_person!=$customer_info->customer_name&&!empty($customer_info->contact_person))? $customer_info->contact_person.", ":"";
            // echo "Phone: ".$customer_info['res_mobile'] . ", Email: ".$customer_info['res_email'];
            ?> </p>
        </div>
        <div class="segment left" >
            <h3>Billing Address:</h3>
            <p><?php //echo $customer_info->billing_address;?></p>
        </div>
<!--        segment left-->
        <div class="segment right" style="width:330px;">
            <h3>Service Address:</h3>
            <p><?php //echo $customer_info->service_address;?></p>
        </div>
        <!--        segment right-->
        <div style="clear: both"></div>

   <!-- </div>

    <div class="section head-section ">-->
        <br/>
        <p>We have a proposed pricing for <?php echo @$customer_info['client_name'];?> located at <?php //echo $customer_info->service_address;?>. <?php //echo $compnay_info->business_type;?> and price are enlisted bellow.
        If you have any question regarding this proposal, please let us know. Thank you.<p>

        <table class="table" cellspacing="0" cellpadding="0" border="0" style="width:100%">
            <thead>
                <tr><th style="width:50px;">SL No.</th>
                    <th style="width:180px;">Product</th>
                    <th>Unit Price</th>
                    <th>Qunatity</th>
                    <th>Discount</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php if($service_products):
            $i=0;
                foreach($service_products as $service):
            ?>
                <tr>
                <td rowspan="2"><?php echo ++$i;?></td>
                    <td style="width:180px;">
                    
                    <?php echo Service::find ($service->service_id)->service_name; ?>
                    </td>
                    <td rowspan="2" style="text-align: center;"><?php echo "$ ".$service->unit_price;?></td>
                    <td rowspan="2"><?php echo $service->quantity?></td>
                    <td rowspan="2"><?php echo $service->discount;?>% </td>
                    <td rowspan="2" style="text-align: center;"><?php echo "$ ".$service->tax_amount;?></td>
                    <td rowspan="2" style="border-right: 1px solid #fff;text-align:center;"><?php echo "$ ".$service->total_amount;?></td>
                </tr>
                <tr>
                <td style="width:180px;font-size:10px;"> <?php echo $service->description;?></td>
                </tr>
        <?php
            endforeach;
            endif;
        ?>
            <tr>
                <td colspan="5" style="border:1px solid #fff;background-color:#fff;"></td>

                <td style=""><b>Subtotal:</b></td>
                <td style="border-right: 1px solid #fff;"><?php echo "$ ".$proposal_info->sub_total; ?></td>
            </tr>
                <tr>
                    <td colspan="5" style="border:1px solid #fff;background-color:#fff;" ></td>

                    <td style=""><b>Sales tax:</b></td>
                    <td style="border-right: 1px solid #fff;"><?php echo "$ ".$proposal_info->sales_tax; ?></td>
                </tr><tr>
                <td colspan="5" style="border:1px solid #fff;background-color:#fff;"></td>

                    <td style="background-color:#000;color:#fff;"><b>Total:</b></td>
                    <td style="border-right: 1px solid #fff;background-color:#000;color:#fff;"><?php echo "$ ".$proposal_info->total; ?></td>
                </tr>
            </tbody>
        </table>
<h3 style="background: none;color:#000;width:200px;border-bottom:2px solid #999;margin-top:30px;">&nbsp;</h3>
        <p><b><?php echo $company_address->attention;?></b></p>
        <p><?php echo $company_info->display_name;?></p>
        <p><?php echo $company_info->telephone_no;?></p>
        <p><?php echo $company_info->practiceemail;?></p>

    </div>
    <!--    .section-->
    <?php
        if(isset($note)&&!empty($note)):
    ?>
    <div class="section head-section ">
    <h3>Additional note:</h3>
        <p><?php echo $note->note;?></p>
        </div>
    <!--    .section-->
    <?php endif;?>
    <?php if(isset($attachments)&&count($attachments)>0):?>
    <div class="section head-section " style="border-bottom: none;">
  
        <h3>Addendum:</h3>
       
        <ol style="padding-left:20px;font-size:14px;">
           <?php
           foreach($attachments as $attachment):

           ?>
            <li><?php echo Attachment::find($attachment->attachment_id)->title; ?></li>
            <?php
            endforeach;
            ?>
        </ol>
    </div>
    <!--    .section-->
    <?php endif; ?>

    <div style="clear: both"></div>
</div>
<!--.main-->
</body>
</html>