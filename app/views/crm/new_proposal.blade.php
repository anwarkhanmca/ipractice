@extends('layouts.layout')

@section('mycssfile')
<link href="{{URL :: asset('css/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->

<!-- Loader Css -->
<link href="{{URL :: asset('css/loader.css')}}" rel="stylesheet" type="text/css" />

<!-- google search -->
<link rel="stylesheet" href="{{ URL :: asset('css/address_search.css') }}" />
<!-- google search -->
@stop

@section('myjsfile')
<!-- proposal js -->
<script src="{{ URL :: asset('js/proposal.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/proposal_preview.js') }}" type="text/javascript"></script>

<!-- chart js -->
<script src="{{ URL :: asset('js/clients.js') }}"></script>
<!-- summernote js -->
<script src="{{ URL :: asset('js/summernote.js') }}"></script>
<!-- choosen js -->
<script src="{{ URL :: asset('js/chosen.js') }}"></script>
<!-- datepicker js -->
<script src="{{ URL :: asset('js/datepickerbootstrap/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL :: asset('js/jquery.mask.min.js') }}" type="text/javascript"></script>


<!-- end proposal js -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->
<script src="{{ URL :: asset('js/forecast.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/crm.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL :: asset('js/jquery.form.js') }}"></script> --> 
<script src="{{ URL :: asset('js/plugins/jquery.quicksearch.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- page script -->

<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery.price_format.2.0.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>

<script src="{{ URL :: asset('js/contact_email_templates.js') }}"></script>


@if(isset($page_open) && $page_open == '1')
<script type="text/javascript">
$(window).load(function() {
  CKEDITOR.replace( 'coverLtrText', {height:600});
  CKEDITOR.replace( 'termsText', {height:600});  
});
</script>
@endif

<script type="text/javascript">
$(document).ready(function(){
  $("#ProsStartDate").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
  $("#ProsEndDate").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});

  $('.priceRound').priceFormat({
        prefix: '',
        //centsSeparator: '.',
        //thousandsSeparator: ',',
        //centsLimit: '',
    });

});
</script>

<!-- google search -->
<script src="{{ URL :: asset('js/address_search.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc7HTLVvrPyl_cJQGPIb1GuWwq0cTC4MY&libraries=places&callback=initAutocomplete" async defer></script>
<!-- google search -->
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            @include('layouts.inner_leftside')
        </section>
        <!-- /.sidebar -->
    </aside>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side {{ $right_class }}">
  
    <!-- Content Header (Page header) -->
    @include('layouts.below_header')
<input type="hidden" name="base_url" value="{{ url() }}" id="base_url">
<input type="hidden" value="{{ $encryptProposalId or '0' }}" id="encryptProposalId">
<input type="hidden" id="proposal_id" value="{{ $proposalId or '' }}">

<div class="createProposal" style="text-align: center; color: green;"></div>
    <!-- Main content -->
<section class="content">
  <div class="practice_mid">
    <div class="tabarea">
      <div class="tab-content">
        <div id="tab" class="tab-pane {{ ($tab_no == '1')?'active':'' }}">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-tabsbg">
              <li class="{{ (isset($tab_no) && $tab_no == '1')?'active':'' }}"><a href="/crm/new-proposal"><b>CREATE PROPOSAL</b></a></li>
              <li><a href="javascript:void(0)" class="goToProposalPreview"><b>PREVIEW</b></a></li>
              <li class="dropdown" style="float: right;">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle"><b>ACTION</b><b class="caret"></b></a>
                <ul class="dropdown-menu proposal-dropdown-menu proposal_ul" id="CreateProposalActionDrop">
                  <li><a href="javascript:void(0)" data-save_type="D" class="saveProposals">Save</a></li>

                  <li style="display: {{($from_page == 'template')?'none':'block';}}"><a href="javascript:void(0)" data-save_type="DC" class="saveProposals">Save & Close</a></li>
                  <li style="display: {{($from_page == 'template')?'none':'block';}}"><a href="javascript:void(0)" data-save_type="F" class="saveProposals">Save as Final</a></li>
                  <li style="display: {{($from_page == 'template')?'none':'block';}}"><a href="javascript:void(0)" data-save_type="T" class="saveProposals">Save as Template</a></li>

                </ul>
              </li> 
            </ul>
            <div class="tab-content">
              @include('crm/proposal/proposals/new_proposal')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</section>


</aside><!-- /.right-side -->

@include("crm.modal.prospect")

@include("crm.modal.lead_source")
@include("crm.proposal.modal.modal")
@include("contacts_letters.modal")

<div class="modal fade" id="FirstPlusA-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:435px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">ADD NEW CLIENT - <span id="poPTypE"></span></h4>
        <div class="clearfix"></div>
      </div>

      <div class="modal-body">
        <div class="col-md-12" id="FirstPlusOrgIcon">
          <div class="col-md-6">
            <a href="/organisation/add-client" class="btn btn-info" target="_blank">+ CLIENT - KEY IN</a>
          </div>
          <div class="col-md-6">
            <a href="/import-from-ch/{{ base64_encode('org_list') }}" target="_blank" class="btn btn-info"> IMPORT COMPANY/LLP</a>
          </div>
        </div>
        <div class="col-md-12" id="FirstPlusIndIcon">
          <div class="col-md-6">
            <a href="/individual/add-client" class="btn btn-info" target="_blank">+ CLIENT - KEY IN</a>
          </div>
          <div class="col-md-6">
            <a href="/import-from-ch/{{ base64_encode('ind_list') }}" target="_blank" class="btn btn-info"> IMPORT FROM CH</a>
          </div>
        </div>

        <div class="clearfix"></div>
      </div>    
  </div>
  </div>
</div>


<!-- loader on page loading start -->
<div class="overlay">
  <div class="loading-img"><img src="/img/spinner.gif" /></div>
</div>


@stop



