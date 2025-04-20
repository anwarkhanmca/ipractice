<style>
.mobile{width:300px;}
</style>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-primary" style="border-color: #0866C6">
	  <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
			<h3 class="panel-title"><i class="fa fa-file-text tiny-icon"></i> {{ $selected_page }} - Select Option</h3>
	  </div>
	  <div class="panel-body">
	  		{{ Form::open(array('url' => '/crm/createInvoice', 'class'=>'form-horizontal')) }}
			<div class="row col-md-12">
				<div class="col-md-12 input-group proposal-input-group">
					<div class="col-md-3">
						<label class="proposal-label">Payment Terms</label>
					</div>
					<div class="col-md-6 col-xs-12 mobile" >
					<select data-placeholder="Choose Payment Term" name="payment_term" style="min-width:250px;" class="form-control choosen" >
						@if(isset($invoice))
							<option value="{{ $invoice->payment_terms }}">{{ $invoice->payment_terms }}</option>
						@else 
							<option></option>
						@endif
						<option value="PIA">PIA</option>
						<option value="Net 7">Net 7</option>
						<option value="Net 10">Net 10 </option>
						<option value="Net 30">Net 30</option>
						<option value="Net 60">Net 60</option>
						<option value="Net 90">Net 90</option>
						<option value="EOM">EOM</option>
						<option value="21 MFI">21 MFI</option>
						<option value="1% 10 Net 30">1% 10 Net 30</option>
						<option value="COD">COD</option>
						<option value="Cash account">Cash account</option>
						<option value="Letter of credit">Letter of credit</option>
						<option value="Bill of exchange">Bill of exchange</option>
						<option value="CND">CND</option>
						<option value="CBS">CBS</option>
						<option value="CIA">CIA</option>
						<option value="CWO">CWO</option>
						<option value="1MD">1MD</option>
						<option value="Contra">Contra</option>
						<option value="Stage payment">Stage payment</option>
					</select>
					@if ($errors->has('payment_term')) <span style="color: red">{{ $errors->first('payment_term') }}</span> @endif

					<div class="well terms" style="margin-top:10px;padding:10px;display:none;">
						<p>Payment in advance</p>
					</div>
					</div>
					<!-- col-md-8 -->

				</div>
			<!-- col-col-md-12 input-group -->
				<div class="col-md-12 input-group proposal-input-group">
				<div class="col-md-3">
					<label class="proposal-label">Note</label>
					</div>
					<div class="col-md-9 col-xs-12">
						@if(isset($invoice))
							<textarea name="note" class="form-control" placeholder="note" style="min-width:270px;">{{ $invoice->note }}</textarea>
						@else 
							<textarea name="note" class="form-control" placeholder="note" style="min-width:270px;">If you have any question regarding this invoice please contact at: <?php echo ($company_info->telephone_no!="")?$company_info->telephone_no:"".", ".($company_info->practiceemail!="")?$company_info->practiceemail:"";?></textarea>
						@endif
							@if ($errors->has('note')) <span style="color: red">{{ $errors->first('note') }}</span> @endif
					</div>
				</div>
			<!-- col-col-md-12 input-group -->
				<div class="col-md-6 col-md-offset-3 mobile">
				<input type="hidden" name="proposal_id" value="{{ $proposal->id }}"/>
				@if(isset($invoice))
					<input type="hidden" name="invoice_id" value="{{ $invoice->id }}"/>
				@endif
				<button class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6" type="submit">Next</button>
				@if(! isset($invoice))
					<a href="{{ url('crm/viewAllProposal') }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6">Cancel</a>
				@endif
				</div>

			</div>
			<!-- row col-md-12 -->
			{{ Form::close() }}
	  </div>
</div>
	
</div>
<!-- col-md-8 col-md-offset-2 -->
</div>
<!-- row -->