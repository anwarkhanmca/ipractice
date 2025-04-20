<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<style>
body{
	margin:0;padding:0;
	color:#000;
	background-color: #fff;
	font-family: arial,sans-serif;
	font-size: 14px;

}
#main{
	width:960px;
	height:auto;
	padding:30px;

	margin:0 auto;
}
.section{
	width:100%;
	margin-bottom:15px;
}
.clear{
	clear:both;
}
p{
	margin:0px;
}
.inner-invoice{
		margin:20px;
		border:1px solid #ccc;
		padding:20px;
}
table{
	
		border-color:#ccc;
		border: none;
	}
	td,th{
		padding:5px;

	}
table tbody tr td,table thead tr th{
	border:none;
	border-right:2px solid #fff;
		border-spacing: 0px;
	
	
	}
	table tbody tr td{
		background-color: #f8f8f8;
	}
table thead tr th{
	background-color: #0cf;
	padding:10px;
	text-align: center;
	color:#fff;
	border-color:#fff;
}
table thead tr th{
	text-align: left;
}
.heading{
background-color: #0cf;
color:#fff;
padding: 10px;
}
.invoice-details{
	width:300px;
}
.invoice-details b:first-child{
	width:150px;
	color:#0cf;
	margin-right:10px;
	display: inline-block;
}
	</style>


<div id="main">
	<div class="section">
		<div style="width:300px;float:left;margin-right:150px;">
	
			<h1 style="color:#666;font-size:32px;margin:10px;">INVOICE</h1>
		</div>
		<!-- left-segment -->
		<div style="width:300px;float:right;">
			<p class="invoice-details"><b style="width:150px;color:#0cf;margin-right:10px;display: inline-block;">INVOICE ID:</b> <b><?php echo $invoice->id;?></b></p>
			<p class="invoice-details"><b style="width:150px;color:#0cf;margin-right:10px;display: inline-block;">INVOICE DATE:</b>  <b><?php echo date('d/m/Y', strtotime($invoice->created_at)); ?> </b></p>
			<p class="invoice-details"><b style="width:150px;color:#0cf;margin-right:10px;display: inline-block;">PAYMENT TERMS:</b> <b> <?php echo $invoice->payment_terms;?> </b></p>
		</div>
		<!-- right-segment -->

		<div class="clear"></div>
	</div>
	<?php 
        $client_type = Client::where('client_id', $proposal_info->customer_id)->first()->type;
    ?>
	<!-- .section. -->
	<div class="section">
		<div style="width:300px;float:left;">
			<p class="heading"><b>Bill to:</b></p>
			<div style="margin:10px;">
				<?php 
            	if($client_type == 'ind'){ ?>
                	<p> <b><?php echo $customer_info['client_name'];?></b></p>
					<p><?php //echo $customer_info->billing_address;?></p>
					<p>Contact person: <?php //echo $customer_info->contact_person;?></p>
					<p>Phone: <?php echo $customer_info['res_mobile'];?></p>
					<p>Email: <?php echo $customer_info['res_email'];?></p>
            	<?php
            	}else if($client_type == 'org'){ ?>
                	<p><?php echo $customer_info['business_name'];?></p>
                	<p><?php //echo $customer_info->billing_address;?></p>
					<p>Contact person: <?php //echo $customer_info->contact_person;?></p>
					<p>Phone: <?php //echo $customer_info['res_mobile'];?></p>
					<p>Email: <?php //echo $customer_info['res_email'];?></p>
            	<?Php 
            	}
            	?>

				
			</div>
		</div>
		<!-- left-segment -->
		<div style="width:300px;float:right;">
			<p class="heading"><b>From:</b></p>
			<div style="margin:10px;">
				<p><b><?php echo $company_info->display_name; ?></b></p>
				<p>
					<?php 
                    echo $company_address->street_address. ', ' . $company_address->city. ', ' . $company_address->state. ', '; 
                    
                    if($company_address->zip != 0){
                        echo $company_address->street_address. ', ';    
                    }
                    echo Country::where('country_id', $company_address->country_id)->first()->country_name;
                	?>
            	</p>
				<p>Contact Person: <?php echo $company_info->attention;?></p>
				<p>Phone: <?php echo $company_info->telephone_no; ?></p>
				<p>Email: <?php echo $company_info->practiceemail; ?></p>
			</div>
		</div>
		<!-- right-segment -->

		<div class="clear"></div>
	</div>
	<!-- .section. -->
	<div class="section">
	 <table class="table" cellspacing="0" cellpadding="0" border="0" style="width:100%;margin:0 auto;border-bottom: none;">
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
                    <td rowspan="2" style="text-align: center;"><?php //echo $compnay_info->currency;?><?php echo $service->unit_price;?></td>
                    <td rowspan="2" style="text-align: center;"><?php echo $service->quantity?></td>
                    <td rowspan="2" style="text-align: center;"><?php echo $service->discount;?>%</td>
                    <td rowspan="2" style="text-align: center;"><?php //echo $compnay_info->currency;?><?php echo $service->tax_amount;?></td>
                    <td rowspan="2" style="border-right: 1px solid #fff"><?php //echo $compnay_info->currency;?><?php echo $service->total_amount;?></td>
                </tr>
                <tr>
                <td style="width:180px;font-size:10px;border-color:#fff;"> <?php echo $service->description;?></td>
                </tr>
        <?php
            endforeach;
            endif;
        ?>
            <tr>
                <td colspan="5" style="border:1px solid #fff;border-top-color:#fff;border-right-color:#fff;background-color:#fff;"></td>

                <td><b>Subtotal:</b></td>
                <td style="border-right: 1px solid #fff"><?php //echo $compnay_info->currency;?><?php echo $proposal_info->sub_total; ?></td>
            </tr>
                <tr>
                    <td colspan="5" style="border:1px solid #fff;border-right-color:#fff;background-color:#fff;" ></td>

                    <td><b>Sales tax:</b></td>
                    <td style="border-right: 1px solid #fff"><?php //echo $compnay_info->currency;?><?php echo $proposal_info->sales_tax; ?></td>
                </tr><tr >
                <td colspan="5" style="border:1px solid #fff;border-right-color:#ccc;background-color:#fff;"></td>

                    <td style="background-color:#0cf;color:#fff;padding:10px;border:none;"><b>Total:</b></td>
                    <td style="border-right: 1px solid #fff;background-color:#0cf;color:#fff;padding:10px;"><?php //echo $compnay_info->currency;?><?php echo $proposal_info->total; ?></td>
                </tr>
            </tbody>
        </table>
	</div>
	<!-- .section. -->
	<div class="section">
		<div>
			<h3>Note:</h3>
				<p style="margin-left:10px;"><?php echo $invoice->note;?></p>
		</div>
	</div>
	<!-- .section -->
</div>
<!-- #main -->
	
</body>
</html>