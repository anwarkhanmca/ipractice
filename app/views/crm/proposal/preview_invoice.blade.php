<style>
	p{margin:0px;}
	.inner-invoice{
		margin:20px;
		border:1px solid #ccc;
		padding:20px;
	}
	table{
		border-color:#ccc;
	}
	table tbody tr td,table thead tr th{
		border-color:#ccc;
		
	}
</style>
<div class="row">
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
					<h3 class="panel-title" align="center"><i class="fa fa-file-text tiny-icon"></i> Preview Invoice</h3>
			  </div>
			  <div class="panel-body">

			 		<div class="row col-md-12">
			 		<embed id="pdfcontent" src="{{ url('public/proposalPdf/Invoice/Invoice-id-'.$proposal_info->id.'.pdf') }}" style="width:100%;height:500px;" type="application/pdf"></embed>
			 		</div>
			 		<!-- row col-md-12 -->
			 		 <div class="row col-md-12">
                      <div class="col-md-10 col-md-offset-1" style="margin-top:20px;">
                          <a href="{{ url('crm/sendInvoiceViaEmailForm/'.$invoice->id.'/'.$proposal_info->id) }}" class="btn btn-primary btn-sm proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-send tiny-icon"></i> Send Via Email</a>
                        @if(Request::segment(2) == 'previewInvoice')
                          <button class="btn btn-sm btn-primary printer proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;" onclick="return printDocument();"><i class="fa fa-print tiny-icon"></i> Print</button>
                        @endif
                          <a href="{{ url('crm/downloadInvoice/Invoice-id-'.$proposal_info->id.'.pdf/'. $invoice->id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-download tiny-icon"></i> Download</a>
                          <?php
                          if(($invoice->status=="INITIATED"||$invoice->status=="DRAFT") && Bill::where('invoice_id', $invoice->id)->count() == 0){
                           ?>
                          <a href="{{ url('crm/editInvoice/'.$proposal_info->id.'/'.$invoice->id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-save tiny-icon"></i> Edit Invoice</a>
                      <?php
                  		}
                      ?>
                      	@if(Request::segment(2) == 'previewInvoice')
                          <a href="{{ url('crm/saveInvoiceAsDraft/'.$invoice->id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-save tiny-icon"></i> Save</a>
                      	@endif
                      	@if(Request::segment(2) == 'previewInvoiceFromGrid')
                      		<a href="{{ url('crm/viewAllInvoice') }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-reply tiny-icon"></i>Back</a>
                      	@endif
                      </div>
                  </div>
			  </div>
			  <!-- panel-body -->
		</div>
		<!-- panel -->
	</div>
	<!-- col-md-10 col-md-offset-1 -->
</div>
<!-- .row -->