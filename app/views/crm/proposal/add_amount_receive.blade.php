<div class="row">
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-primary" style="border-color: #0866C6">
		  <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
				<h3 class="panel-title">Add Payment</h3>
		  </div>
		  <div class="panel-body">
		  	{{ Form::open(array('url' => '/crm/saveAmountReceive', 'class'=>'form-horizontal')) }}
				<div class="input-group col-md-12 proposal-input-group">
					<div class="col-md-3 col-xs-12">
						<label class="proposal-label">Customer</label>
						</div>
						<div class="col-md-6 col-xs-12">
						<select data-placeholder="Choose Customer" id="customer" name="customer" class="form-control choosen"  style="min-width:250px;">
							<option ></option>
							<?php foreach ($customers as $customer):
							?>
							<option value="<?php echo $customer['client_id'];?>" <?php //echo set_value('customer',$customer->id);?>>{{ $customer['field_value'] }}</option>
							<?php 
								endforeach;
							?>
						</select>
						@if ($errors->has('customer')) <span style="color: red">{{ $errors->first('customer') }}</span> @endif
					</div>
				</div> 
				<!-- input-group -->
				<div class="input-group col-md-12 proposal-input-group">
					<div class="col-md-3 col-xs-12">
						<label class="proposal-label">Invoice Number</label>
						</div>
					<div class="col-md-6 col-xs-12">
					<select name="invoice_id" id="invoice" class="form-control" style="min-width:250px;">
						@if(isset($billInfo))
							<option value="<?php echo $billInfo->invoice_id;?>" selected="selected">ID: <?php echo $billInfo->invoice_id;?>, Proposal Title: <?php echo ProposalInfo::find($billInfo->proposal_id)->proposal_title; ?></option>
						@endif
					</select>
						@if ($errors->has('invoice_id')) <span style="color: red">{{ $errors->first('invoice_id') }}</span> @endif

					</div>
					</div> 
				<!-- input-group -->
				<div class="input-group col-md-12 proposal-input-group">
					<div class="col-md-3 col-xs-12">
						<label class="proposal-label">Receiving Date</label>
					</div>
					<div class="col-md-6 col-xs-12">
						<input type="text" class="form-control date" placeholder="mm/dd/yyyy" <?php echo isset($billInfo) ? "value='".date('m/d/Y', strtotime($billInfo->receiving_date))."'" : ''; ?>  style="min-width:250px;" name="receiving_date"/>
						@if ($errors->has('receiving_date')) <span style="color: red">{{ $errors->first('receiving_date') }}</span> @endif

					</div>
				</div>
<!-- input-group -->
				
				<div class="input-group col-md-12 proposal-input-group">
					<div class="col-md-3 col-xs-12">
						<label class="proposal-label">Amount</label>
					</div>
					<div class="col-md-6 col-xs-12">
						<input type="text" class="form-control" <?php echo isset($billInfo) ? 'value="'.$billInfo->amount.'"' : ''; ?> id="amount" name="amount"  style="min-width:250px;" placeholder="Amount"/>
						@if ($errors->has('amount')) <span style="color: red">{{ $errors->first('amount') }}</span> @endif
						<span class="error-msg amount_error" style="display: none;">Amount should not be greater than due amount</span>

						<div class="row col-md-12" style="margin-top:5px;">
							<div class="alert alert-info" style="padding:5px;">
								<b>Due Amount:  $ <span id="due-msg">
								@if(isset($billInfo))
								<?php echo $total_bill - $sum_paid; ?></span></b>
								@endif
							</div>
						</div>

					</div>
				
				</div>

				<div class="col-md-12">
				<div class="col-md-6 col-md-offset-3">
					@if(isset($billInfo))
						<input type="hidden" value="{{ $billInfo->id }}" name="bill_id">
					@endif
					<input type="hidden" id="proposal_amount" value="{{ isset($billInfo) ? $total_bill : 0 }}">
					<input type="hidden" id="due_amount" value="{{ isset($billInfo) ? $total_bill - $sum_paid : 0 }}">
					<button type="submit" class="btn btn-primary btn-sm proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;">Save</button>
				</div>
				</div>
<!-- input-group -->
			{{ Form::close() }}
			@if(isset($billInfo))
				<input type="hidden" value="{{ $billInfo->customer_id }}" id="bill_customer">
			@endif
		  </div>
	</div>
	</div>
	<!-- col-md-8 -->
</div>
<!-- .row -->