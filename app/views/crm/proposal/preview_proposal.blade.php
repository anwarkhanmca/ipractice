<style type="text/css">
    
   @media(max-width:460px){
    .btn-primary{
      margin-bottom:6px;
    }
   }
</style>
<script type="text/javascript">
   // function printDocument(){

   //     var doc = document.getElementById("pdfcontent");
   //          if (typeof doc.print === 'undefined') {
   //              alert("hey");
   //              setTimeout(function(){printDocument();}, 1000);
   //          } else {
   //              doc.print();
   //          //}

   //  }
</script>
<div class="container">
    <div class="col-md-10 col-md-offset-1" style="margin-top: 10px;">
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
        			<h3 class="panel-title" align="center">Preview Proposal</h3>
        	  </div>
        	  <div class="panel-body">
        			<div class="row col-md-12">
                        <iframe src="{{ url('public/proposalPdf/Proposal_attachments_merged'.$proposal_id.'.pdf') }}" style="width:100%;height:500px;"  id="pdfcontent"></iframe>
                    </div>
<!--                  row col-md-12-->
                  <div class="row col-md-12">
                      <div class="col-md-10 col-md-offset-1" style="margin-top:20px;">
                          <a href="{{ url('crm/sendProposalViaEmailForm/'.$proposal_id) }}" class="btn btn-primary btn-sm proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-send tiny-icon"></i> Send Via Email</a>
                          <a href="{{ url('crm/downloadProposal/Proposal_attachments_merged'.$proposal_id.'.pdf/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-download tiny-icon"></i> Download</a>
                          @if(Request::segment(2) == 'loadProposalPreview')
                          <a href="{{ url('crm/editProposal/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-edit tiny-icon"></i> Edit Content</a>
                          <a href="{{ url('crm/saveProposalAsDraft/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-save tiny-icon"></i> Save</a>
                          @elseif(Request::segment(2) == 'loadProposalPreviewFromGrid')
                            <?php $proposal_status = ProposalInfo::find($proposal_id)->status; ?>
                            <?php if($proposal_status == "PRINTED" || $proposal_status == "DOWNLOADED" || $proposal_status == "EMAILED"):?>
                             <a href="{{ url('crm/paymentTerms/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-plus tiny-icon"></i> Create Invoice</a>
                             <?php 
                              endif;
                             if($proposal_status == "DRAFT" || $proposal_status == "INITIATED"):?>
                              <a href="{{ url('crm/editProposal/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-edit tiny-icon"></i> Edit Content</a>
                            <?php 
                              endif;
                            ?>
                              <a href="{{ url('crm/copyProposal/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-copy tiny-icon"></i> Copy</a>

                              <a href="{{ url('crm/viewAllProposal') }}" class="btn btn-sm btn-primary proposal-button" style="margin-left:15px; margin-top: 5px; background-color: #0866C6;"><i class="fa fa-reply tiny-icon"></i> Back</a>

                          @endif
                      </div>
                  </div>
        	  </div>
        </div>
        </div>
<!--    col-md-10 col-md-offset-1-->
    </div>
<!--container col-md-12-->