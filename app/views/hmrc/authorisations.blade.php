@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->

<style>
.frm_page label{ margin-top:0px !important; width: auto !important;}
.form-title {margin:0px; padding-bottom:10px; border-bottom:1px solid #ccc; margin-bottom:10px;}
.form-control-small{border:1px solid #ccc;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
.address-bar {border-radius:0px; -moz-border-radius:0px; -webkit-border-radius:0px; border-bottom:0px;}
.add-area input[type="text"]{border-radius:0px; -moz-border-radius:0px; -webkit-border-radius:0px;}

</style>
@stop

@section('myjsfile')
<script src="{{URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/authorisations.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->

<script src="{{ URL :: asset('js/page_loading.js') }}"></script>

@stop

@section('content')
 <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @include('layouts/inner_leftside')

                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')
    <!-- Main content -->
    <section class="content">
    <!-- page loading processing sign -->
		<div class="page_loader"><img src="/img/spinner.gif"></div>



      <div class="practice_mid">
        {{ Form::open(array('action'=>'HmrcController@getFormData', 'method'=> 'post')) }}


          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
             
             <li class="{{ ($page_open == 1)?'active':'' }}"><a href="javascript:void(0)" data-tab_no="1" class="head_tab" data-url="/hmrc/authorisations/1">FORM 64-8</a></li>
             <li class="{{ ($page_open == 2)?'active':'' }}"><a data-tab_no="2" class="head_tab" href="javascript:void(0)" data-url="/hmrc/authorisations/2">FORM FBI -2</a></li>
             <li class="{{ ($page_open == 3)?'active':'' }}"><a data-tab_no="3" class="head_tab" href="javascript:void(0)" data-url="/hmrc/authorisations/3">FORM VAT 484</a></li>
             <li class="{{ ($page_open == 4)?'active':'' }}"><a data-tab_no="4" class="head_tab" href="javascript:void(0)" data-url="/hmrc/authorisations/4">FORM SA 401</a></li>
             <li class="{{ ($page_open == 5)?'active':'' }}"><a data-tab_no="5" class="head_tab" href="javascript:void(0)" data-url="/hmrc/authorisations/5">FORM VAT 600FRS</a></li>
             <li class="{{ ($page_open == 6)?'active':'' }}"><a data-tab_no="6" class="head_tab" href="javascript:void(0)" data-url="/hmrc/authorisations/6">FORM SA1</a></li>
             <!--   <li class="active"><a data-toggle="tab" href="#tab_1">FORM 64-8</a></li>
                <li class=""><a data-toggle="tab" href="#tab_2">FORM FBI -2</a></li>
                <li class=""><a data-toggle="tab" href="#tab_3">FORM VAT 484</a></li>
                <li class=""><a data-toggle="tab" href="#tab_4">FORM SA 401</a></li>
                <li class=""><a data-toggle="tab" href="#tab_5">FORM VAT 600FRS</a></li>
                <li class=""><a data-toggle="tab" href="#tab_6">FORM SA1</a></li>       -->                                                          
              </ul>


              <div class="tab-content">

              	<input type="hidden" class="getpageurl" value="{{url()}}/hmrc/authorisations" />
                
                <div id="tab_1" class="tab-pane show_div {{ ($page_open == 1)?'active':'' }}">
                  <!--table area-->
                 <div class="container frm_page">
				 <div class="get_cl_name"style="display:none;"></div>









		<div class="row">
			<div class="col-md-6">
				<div class="form-group client_reserorr">
					<label>Client Name</label>
					<select class="form-control clientdetails" name="client_id" id="tab1_client">
            <option value="">--Select--</option>
            @if(!empty($client_details))
							@foreach($client_details as $key=>$client_row)
								@if($client_row['client_name'] != "")
                  <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
                 @endif
							@endforeach
	          @endif
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group" id="reserror">
					<label>Responsible Person</label>
				<select class="form-control resperson" name="responsible_person" id="responsibleperson" >
						
                        <option value=""></option>
                        
					</select>
				</div>
			<!--	<div class="row">
					<div class="form-group">
						<div class="col-md-2">
							<label>UTR</label>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control" />
						</div>
						<div class="col-md-2">
							<label>NI Number</label>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control" />
						</div>
					</div>
				</div> -->
			</div>
			<div class="col-md-2">
				<label>Download</label>
				<button class="btn btn-success" id="downloads"><span class="glyphicon glyphicon-download-alt"></span> Download</button>
			</div>
		</div>
		<hr>
		
		<div class="row">
			<div class="col-md-6">
            <h3 class="form-title top_no">Client Details</h3>
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Reference</label>
						</div>
						<div class="col-md-3">
							<input type="text" id="tab1reference" name="reference" value="" class="form-control">
						</div>
						<div class="col-md-2">
							<label>CRN</label>
						</div>
						<div class="col-md-4">
							<input type="text" id="crn"  name="crn" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">                                 
							<label>Paye Reference</label>
						</div>
						<div class="col-md-2">
							<input type="text" id="payereferencesamll" name="payereferencesamll" class="form-control">
						</div>
						<div class="col-md-1">
							<label>/</label>
						</div>
						<div class="col-md-6">
							<input type="text" id="payereference" name="payereference" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Corporation Tax Reference</label>
						</div>
						<div class="col-md-2">
							<input type="text" id="corporationtaxreferencesmall" name="corporationtaxreferencesmall" class="form-control" value="{{ $orgclient['utrsamllbox'] or '' }}">
						</div>
						<div class="col-md-1">
							<label>/</label>
						</div>
						<div class="col-md-6">
							<input type="text" id="corporationtaxreference" name="corporationtaxreference" class="form-control" value="{{ $orgclient['tax_reference'] or '' }}">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>VAT Number </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="vat_number" name="vat_number" value="" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea class="form-control" name="tab1address" id="tab1address"> </textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Postcode </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab1postcode" name="tab1postcode" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab1telephonenumber" name="tab1telephonenumber" value="" class="form-control"/>
                            
                            

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
			<h3 class="form-title top_no">Agent Details</h3>
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Name of Agent </label>
						</div>
						<div class="col-md-9">
							<input type="text" name="name_agent" value="{{ $practice_details->legal_name or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>SA Agent ID</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="sa_agent_id" value="{{ $practice_details->agentsa or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>CT Agent ID</label>
						</div>
						<div class="col-md-9">
							<input type="text"  name="ct_agent_id" value="{{ $practice_details->agentct or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>PAYE Agent ID</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="paye_agent_id" value="{{ $practice_details->agentpaye or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea  name="agent_address" class="form-control">{{$pysicaladdress or '' }}</textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="agent_post_code" value="{{ $practice_address['phy_zip'] or ''}}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number</label>
						</div>
						<div class="col-md-9">
							<input type="text"  name="agent_tel_no" value="{{ $practices['telephone_no'] or ''}}" class="form-control">
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12"><hr></div>
		</div>
		
		<div class="row">
			<div class="col-md-12"><p class="form_title1">Please Tick the box(es) and provide the reference(s) requested only for those matters for which you want to HMRC to deal with your ageint</p></div>
			
		</div>
		
		<div class="row">
			<div class="col-md-3">
			<h3 class="form-title">Self Assessment</h3>
            
          <div class="form-group clearfix">
          	<div class="row">
			<div class="col-md-6" >
				<label>Self Assessment</label>
			</div>
				
			<div class="col-md-6"style="  margin-left: -28px;">
            	<div style="float:left; margin-top:5px;">
                <input type="checkbox" class="selfassessmentclass" name="selfassessmentid" id="selfassessmentid" />
                </div>
                
				<select class="form-control pull-left selfassessment" name="selfassessment" style="width:75%;">
                	<option value="">--Select--</option>
					<option value="Individual">Individual</option>
                    <option value="Partnership">Partnership</option>
                    <option value="Trust">Trust</option>
				</select>
			
			</div>
			<!--<div class="col-md-7">
				Tax Credits&nbsp;&nbsp;&nbsp;<input type="checkbox" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee PAYE Scheme&nbsp;&nbsp;&nbsp;<input type="checkbox" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAT&nbsp;&nbsp;&nbsp;<input type="checkbox" />
			</div>-->
            </div>
			</div>
            
            
            <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>UTR </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab1selfutr" name="tab1selfutr" class="form-control" >
						</div>
					</div>
				</div>
                  
                <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>NI Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab1selfninumber" name="tab1selfninumber" class="form-control" >
						</div>
					</div>
				</div>
            
			<div class="form-group clearfix">
			<label>Client is self employed</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="client_self" />
			</div>
			<div class="form-group clearfix">
			<label>UTR not yet issued</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="client_utr" />
			</div>
			<div class="form-group clearfix">
			<label>Send statement of account to agent</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="account_statement" />
			</div>
			</div>
			
			<div class="col-md-3">
			<h3 class="form-title">Tax Credits</h3>
			<div class="form-group clearfix">
			<label>Tax Credits</label>&nbsp;&nbsp;&nbsp;<input id="tax_credits" type="checkbox" name="tax_credits"/>
			</div>
            
            <div class="form-group jointclaimant clearfix">
			<label>Joint Claimant - use same agent</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="joint_claimant" id="chk_sameagent" />
			</div>
			
            <div class="jointclaimant2">
            <div class="form-group clearfix">
				<label>Joint Claimant Details</label>
				<select disabled class="form-control indclientdetails-empty" id="indclientdetailstab1-empty" name="indclientdetailstab1-empty">	
				</select>
				
				<select disabled class="form-control indclientdetails" id="indclientdetailstab1" name="indclientdetailstab1" style="display:none;">
				<option value="">--Select Client--</option>
					@foreach($indclient as $key=>$client_row)        
                        <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
					@endforeach
				</select>
			</div>
            
            <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Name</label>
						</div>
						<div class="col-md-9">
							<input disabled type="text" id="tab1indname" name="tab1indname" class="form-control">
						</div>
					</div>
				</div>
                
                <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>NI Number</label>
						</div>
						<div class="col-md-9">
							<input disabled type="text" id="tab1indnum" name="tab1indnum" class="form-control">
						</div>
					</div>
				</div>
            
			</div><!-- jointclaimant end -->
			</div>
			
			<div class="col-md-2">
			<h3 class="form-title">Corporation Tax</h3>
		<div class="form-group clearfix">
			<label>Corporation Tax</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="corporation_tax" />
			</div>
        
			
			
		
			</div>
			
            <div class="col-md-2">
			<h3 class="form-title">PAYE</h3>
			<div class="form-group clearfix">
			<label>PAYE Scheme</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="paye_scheme" />
			</div>
            	
			</div>
            
            
			<div class="col-md-2">
			<h3 class="form-title">VAT</h3>
			<div class="form-group clearfix">
			<label>VAT</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="vat"/>
			</div>
            	<div class="form-group clearfix">
			<label>Not yet registered for VAT</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="registered_vat" />
			</div>
			</div>
		</div>
	</div>
                
                </div>

                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane show_div {{ ($page_open == 2)?'active':'' }}">
                  <div class="container frm_page">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group client_tab2">
					<label>Client Details</label>
		
					<select class="form-control clientdetails" id="client_name_tab2" name="table_clientID2">
            <option value="">--Select--</option>
            @if(!empty($client_details))
							@foreach($client_details as $key=>$client_row)
                @if($client_row['client_name'] != "")
                 <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
                 @endif
		
                @endforeach
            @endif
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group " id="resSec_tab2">
					<label>Responsible Person</label>
				<select class="form-control resperson" id="responsible_tab2"  name="responsible_tab2"  >
						
                        <option value=""></option>
                        
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<label>Download</label>
				<button class="btn btn-success download_tab2"><span class="glyphicon glyphicon-download-alt"></span> Download</button>
			</div>
		</div>
		<hr>
		
		<div class="row">
			<div class="col-md-6">
             <h3 class="form-title top_no">Client Details</h3>
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Reference</label>
						</div>
						<div class="col-md-9">
                        <input type="text" id="tab2reference" name="tab2_reference" value="" class="form-control">
							
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Paye Reference</label>
						</div>
						<div class="col-md-2">
							<input type="text" id="tab2payereferencesamll" name="tab2payereferencesamll" class="form-control">
						</div>
						<div class="col-md-1">
							<label>/</label>
						</div>
						<div class="col-md-6">
							<input type="text" id="tab2payereference" name="tab2payereference" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
                	<div class="row">
						<div class="col-md-3">
							<label>Account office reference</label>
						</div>
						<div class="col-md-2">
							<input type="text" id="tab2accountofficereferencesmall" name="tab2accountofficereferencesmall" class="form-control">
						</div>
						<div class="col-md-1">
							<label>p</label>
						</div>
						<div class="col-md-6">
							<input type="text" id="tab2accountofficereference" name="tab2accountofficereference" class="form-control">
						</div>
					</div>
				<!--	<div class="row">
						<div class="col-md-3">
							<label>Account office reference</label>
						</div>
						<div class="col-md-9">
							<input type="text"  maxlength="1" class="form-control-small"  value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;" />
						</div>
					</div> -->
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea id="tab2address" name="tab2address" class="form-control"> </textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab2postcode" name="tab2postcode" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number </label>
						</div>
						<div class="col-md-9">
                        <input type="text" id="tab2telephonenumber" name="tab2telephonenumber" value="" class="form-control"/>
							
						</div>
					</div>
				</div>
				<hr>
				
				<div class="form-group clearfix form-horizontal">
                    <div class="twobox">
						<div class="twobox_1">
						<div class="form-group">
						  	<label style="margin-left: 18px;">Tick one or both of the following</label>
						  
						</div>
						</div>
						<div class="twobox_2">
                            <div class="col-md-3"><label>Date</label>
						</div>
						<div class="col-md-9">
                        <input type="text" id="" value="" name="datepiker" class="form-control datepiker">
							
						</div>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                        
                        <hr>
                        
                        <div class="col-md-6">
							I authorised the agent named above to use PAYE online services to receive information over the internet from HMRC on my behalf <input type="checkbox" name="paye_online_services" />
						</div>
						<div class="col-md-6">
							Contractor in construction industry scheme to authorise the agent name d above to use online services to receive information over the internet from HMRC on my behalf <input type="checkbox" name="industry_scheme" />
						</div>
				
				</div>
			</div>
			<div class="col-md-6">
			<h3 class="form-title">Agent Details</h3>
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Name of agent </label></div>
						<div class="col-md-9">
							<input type="text" name="agent_name_tab2" value="{{ $practice_details->legal_name or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Agents Government Gateway Identifier</label></div>
						<div class="col-md-9">
							<input type="text" name="agent_govt_gateway_identifier_tab2" value="{{ $practice_details->gatewayagentidentifier or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>PAYE Agent ID</label></div>
						<div class="col-md-9">
							<input type="text" name="paye_agent_ID_tab2" value="{{ $practice_details->agentpaye or '' }}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Address </label></div>
						<div class="col-md-9">
							<textarea  name="agent_address_tab2" class="form-control">{{$pysicaladdress or '' }}</textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Post Code</label></div>
						<div class="col-md-9">
							<input type="text" name="postcode_tab2" value="{{ $practice_address['phy_zip'] or ''}}" class="form-control"/>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Telephone Number</label></div>
						<div class="col-md-9">
							<input type="text" name="tel_nub_tab2" value="{{ $practices['telephone_no'] or ''}}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Fax Number</label></div>
						<div class="col-md-9">
							<input type="text" name="fax_nbr_tab2" value="{{ $practices['fax_no'] or ''}}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Agent contact name</label></div>
						<div class="col-md-9">
							<input type="text" name="agent_contact_name_tab2" value="{{$username->fname or ''}} {{$username->lname or ''}}" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"><label>Email address</label></div>
						<div class="col-md-9">
							<input type="text" name="agent_email_tab2" value="{{ (isset($username['email']) && $username['email'] != '')?$username['email']:'' }}" class="form-control">
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
                </div>
               <div id="tab_3" class="tab-pane show_div {{ ($page_open == 3)?'active':'' }}">
                  <div class="container frm_page">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" id="client_name_selectedtab3">
								<label>Client Details</label>
								<select class="form-control clientdetails" name="client_id_tab3" id="clientdetailstab3">
				          <option value="">--Select--</option>
				          @foreach($client_details as $key=>$client_row)
				            @if($client_row['client_name'] != "")
                      <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
                    @endif
				          @endforeach
				        </select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group" id="resSec_tab3">
							<label>Responsible Person</label>
							<select class="form-control resperson res_tab3" name="responsible_tab3" id="responsibleperson">
									
				                    <option value=""></option>
				                    
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<label>Download</label>
							<button class="btn btn-success" id="download_tab3"><span class="glyphicon glyphicon-download-alt download_tab3"></span> Download</button>
						</div>
					</div>
        
        	<div class="col-md-6">
            
            <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
						<label>Business Type</label>
						</div>
						<div class="col-md-9">
						
                            <input type="text" name="business_tab3" class="form-control businesstype" value="">
						</div>
					</div>
				</div>

			</div>
            
            	<div class="col-md-6">
                
                 <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
				     	<label>Position</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="positiontab3" name="position_tab3" class="form-control">
						</div>
					</div>
				</div>
                

			</div>
        <div class="clr"></div>
        
		<hr>
        
        
        <input type="hidden" id="tab3cname" class="form-control">
		
		<div class="row">
			<div class="col-md-6">
			
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>VAT Registration Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="vat_numbertab3" name="vat_number_tab3" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea class="form-control" name="tab3_address" style="display:none;" id="tab3address"> </textarea>
							<textarea class="form-control" name="tab3_address-trade" id="tab3_address-trade"> </textarea>
							<!--<textarea class="form-control" name="tab3_address-trade" id="tab3address-trade" style="display:none;"> </textarea>-->
						</div>
					</div>
				</div>
				
			
                
                <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab3postcode" name="tab3_postcode" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab3telephonenumber" name="tab3_telnumber" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>FAX Number </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="contacttab3fax" name="tab3_faxnumber" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3"> 
							<label>Business email</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="bnameemail" name="tab3_businessemail" class="form-control">
						</div>
					</div>
				</div>
				
			<!--	<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Website addresses</label>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Account name</label>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Sort Code</label>
						</div>
						<div class="col-md-9">
							<input type="text"  maxlength="1" class="form-control-small"  value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;" />&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Account Number</label>
						</div>
						<div class="col-md-9">
							<input type="text"  maxlength="1" class="form-control-small"  value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
						</div>
					</div>
				</div>-->
				
				<hr>
				
				<!--<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<label>VAT Stager</label>
							<hr>
						</div>
						<div class="col-md-6">
							March, June, September and December <input type="checkbox" />
						</div>
						<div class="col-md-6">
							April, July, October and January <input type="checkbox" />
						</div>
					</div>
					<div class="row">
					<div class="col-md-6">
							May, August, November and February <input type="checkbox" />
						</div>
						<div class="col-md-6">
							I wish to apply for monthly returns <input type="checkbox" />
						</div>
					</div>
				</div>-->
			</div>
			<div class="col-md-6">
			
            <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Account Name</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="bankaccname" name="tab3_acc_name" class="form-control">
						</div>
					</div>
				</div>
				
                <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Sort Code</label>
						</div>
						<div class="col-md-9" >
							<input type="text" id="sortcode1" name="tab3_sortcode1" style="text-align: center;"  maxlength="1" class="form-control-small"  value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text" id="sortcode2" name="tab3_sortcode2" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;" />&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" id="sortcode3" name="tab3_sortcode3" style="text-align: center;" maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text" id="sortcode4" name="tab3_sortcode4" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" id="sortcode5" name="tab3_sortcode5" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text" id="sortcode6" name="tab3_sortcode6" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							
						</div>
					</div>
				</div>
                
                 <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Account Number</label>
						</div>
						<div class="col-md-9" >
							<input type="text" id="tab3accountnumber1" name="tab3_acc_nbr1" style="text-align: center;"  maxlength="1" class="form-control-small"  value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text" id="tab3accountnumber2" name="tab3_acc_nbr2" style="text-align: center;"   maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;" />
							<input type="text"  id="tab3accountnumber3" name="tab3_acc_nbr3" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text" id="tab3accountnumber4" name="tab3_acc_nbr4" style="text-align: center;"   maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text"  id="tab3accountnumber5" name="tab3_acc_nbr5" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text" id="tab3accountnumber6" name="tab3_acc_nbr6" style="text-align: center;"   maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
                            <input type="text"  id="tab3accountnumber7" name="tab3_acc_nbr7" style="text-align: center;"  maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							<input type="text" id="tab3accountnumber8" name="tab3_acc_nbr8" style="text-align: center;"   maxlength="1" class="form-control-small" value="" name="vat_no2" size="1" style="width:25px;"/>
							
						</div>
					</div>
				</div>
                
                <div class="col-md-12" id='vat_stagger'>
                <div class="form-group clearfix form-horizontal">
                <h3 class="form-title">VAT Stagger</h3>
                <div class="form-group">
					March,June,September and December<input type="checkbox" id="vatsager1" name="tab3_vatsager1" />
				</div>
                <div class="form-group">
					May,August, November and February<input type="checkbox" id="vatsager2" name="tab3_vatsager2" />
				</div>
                <div class="form-group">
					April,July, October and january<input type="checkbox" id="vatsager3" name="tab3_vatsager3" />
				</div>
                <div class="form-group">
					Monthly<input type="checkbox" id="vatsager4" name="tab3_vatsager4" />
				</div>
                
                </div>
                </div>
                
                
                
                
			<!--	<div class="form-group clearfix form-horizontal">
				<label>Tick all the boxes that apply</label>
				<div class="row">
				<div class="col-md-6">
					Changes to business contact details <input type="checkbox" />
				</div>
				<div class="col-md-6">
					Change VAT Return dates <input type="checkbox" />
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
					Changes Bank details <input type="checkbox" />
				</div>
				<div class="col-md-6">
					Transfer of the business <input type="checkbox" />
				</div>
				</div>
				</div>
				
			
				
				<div class="form-group clearfix form-horizontal">
				<h3 class="form-title">Any other changes</h3>
				<label>Declaration - <span style="font-weight:normal;">To be signed by</span></label>
				<div class="clearfix"></div>
					Accountant <input type="checkbox" />&nbsp;&nbsp;&nbsp;&nbsp;
					Client <input type="checkbox" />
				</div>	-->
			</div> 
            
            <div class="col-md-12">
						<h3 class="form-title" style="font-size: 18px !important;">Tick all the Boxes that apply</h3>
             <div class="col-md-2">
            <div class="form-group clearfix" >
			<label>Trading Address</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="tab3_ch_trading_address" />
			</div>
            </div>           
						
            <div class="col-md-2">
            <div class="form-group clearfix" style="width:260px;">
			<label>Business Name</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="tab3_ch_business_contact_dtl" />
			</div>
            </div>
            
            <div class="col-md-2">
                        <div class="1form-group 1clearfix">
			<label>VAT Return Dates</label>&nbsp;&nbsp;&nbsp;<input id="tab3_ch_vat" type="checkbox" name="tab3_ch_vatreturndate"  />
			</div>
            </div>
            
            <div class="col-md-2">
                        <div class="form-group clearfix">
			<label>Bank details</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="tab3_ch_bankdtl" />
			</div>
            </div>
            
            <div class="col-md-3">
                        <div class="form-group clearfix">
			<label>Transfer of the business</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="tab3_trnsfr_business" />
			</div>
            </div>
                        
			</div>
                        
                 <div class="col-md-12">
                   <div class="col-md-6">
                   <div class="form-group">
				<label>Any Other Changes</label>
				<textarea name="tab3_other_ch" rows="8" cols="50" style="width:100%;"></textarea>
				</div>
                
                
                <h3 class="form-title" style="font-size: 18px !important;">Declaration</h3>
                
                <div style="margin-bottom: 10px;">
                 <span style="width: 125px; float: left;">None</span>
                 <span style="float: left;"><input type="radio" name="tab3_declaration" checked="checked" id="none" /></span>
                <div class="clr"></div>
                </div>
                
                
                <div style="margin-bottom: 10px;">
                 <span style="width: 125px; float: left;">Signed by Agent</span>
                 <span style="float: left;"><input type="radio" name="tab3_declaration" value="agent" id="signedbyagent" /></span>
                <div class="clr"></div>
                </div>
                
                
                <div style="margin-bottom: 20px;">
                 <span style="width: 125px; float: left;">Signed by Client</span>
                 <span style="float: left;"><input type="radio" name="tab3_declaration" value="client" id="signedbyclient" /></span>
                <div class="clr"></div>
                </div>
                
                <input type="hidden" id="loggedinusername" value="{{$username->fname or ''}} {{$username->lname or ''}}" />
                
                <input type="hidden" id="loggedclent" value="" />
                
                <div class="col-md-6" style="padding: 0; margin: 0 40px 0 0; width:250px;">
							<div class="form-group clearfix" style="padding: 0; margin: 0 0 0 0; width:250px;">
								<label>Name</label>
								<input type="text" value="" name="tab3_decname" id="decname" class="form-control">
							</div>
						
				</div>
                
                <div class="col-md-6" style="padding: 0; margin: 0; width:250px;">
							<div class="form-group clearfix" style="padding: 0; margin: 0; width:250px;">
								<label>Position</label>
								<input type="text" id="decposition" name="tab3_decposition" class="form-control">
							</div>
						
				</div>
                
                
                <div class="clr"></div>
                
                
                
                   </div>
                   
                   <div class="col-md-6">
                   <div class="form-group clearfix">
					<h3 class="form-title">Transfer of the business</h3>
					<p>If you have transferred your business to new owner, give the details of the new owner</p>
					<div class="row">
                    <div class="col-md-12">
                    	<div class="form-group clearfix">
							<label>The owner is</label>
							<div class="clearfix"></div>
							An Individual <input type="radio" name="tab3_company_business" value="Individual"/>&nbsp;&nbsp;&nbsp;&nbsp;
							A Company <input type="radio" name="tab3_company_business" value="Company"/>
						</div>
                        </div>
                        
						<div class="col-md-6">
							<div class="form-group clearfix">
								<label>Name</label>
								<input type="text" name="tab3_trnsfr_bus_name" class="form-control" />
							</div>
						
						</div>
						<div class="col-md-6">
					
						
						<div class="form-group clearfix">
							<label>Date of transfer <i>DD MM YYYY</i></label>
							<div class="clearfix"></div>
                            	<div class="col-md-9">
                        <input type="text" id="" value="" name="tab3_trnsfr_bus_date" class="form-control datepiker">
							
						</div>
												</div>
						</div>
                        <div class="col-md-12">
                        	<div class="form-group clearfix add-area">
								<label>Address</label>
								<input type="text" name="tab3_address_bar1" class="form-control address-bar" />
								<input type="text" name="tab3_address_bar2" class="form-control address-bar" />
								<input type="text"name="tab3_address_bar3" class="form-control address-bar" />
								<input type="text" name="tab3_address_bar4" class="form-control address-bar" />
								<input type="text" name="tab3_business_postcode" class="form-control" placeholder="Postcode"/>
							</div>
                        </div>
						<div class="col-md-12">
						<div class="form-group clearfix">
						<label>Does the new owner wish to apply to keep the exiting VAT registration number?</label>
						</div>
							<div class="form-group clearfix" style="width:260px;">
							
								<label>Yes</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="vat_yes" />
								<label>No</label>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="vat_no" />
								</div>

						</div>
                        
					</div>
				</div>
                   </div>
                   
                   
                 </div>         
                        
            
            
		</div>
		
	</div>
                </div>
               <div id="tab_4" class="tab-pane show_div {{ ($page_open == 4)?'active':'' }}">
                  <div class="container frm_page">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group" id="appended_val">
					<label>Client Details</label>
					<select class="form-control clientdetails" id="client_name_tab4" name="client_name_tab4">
            <option value="">--Select--</option>
            @if(!empty($orgclient))
							@foreach($orgclient as $key=>$client_row)
                @if($client_row['business_type'] == 'LLP' || $client_row['business_type'] == 'Partnership')
              		<option value="{{ $client_row['client_id'] }}">{{ $client_row['business_name'] }}</option>
                  @endif
              @endforeach
            @endif
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group" id="res_person_tab4">
					<label>Responsible Person</label>
					<select class="form-control resperson res_person_name_tab4" id="responsibleperson" name="res_person_name_tab4">
						
                        <option value=""></option>
                        
					</select>
				</div>
                <input type="hidden" value="{{$page_open}}" id="pageno" />
                
			</div>
			<div class="col-md-2">
				<label>Download</label>
				<button class="btn btn-success download_tab4" ><span class="glyphicon glyphicon-download-alt"></span> Download</button>
			</div>
		</div>
        
	<h3 class="form-title">Partnership Details</h3>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea class="form-control" id="tab4address" name="partnership_address_tab4"> </textarea>
						</div>
					</div>
				</div>
				
                <div class="form-group clearfix form-horizontal">
                    <div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4postcode" name="partnership_postcode_tab4" class="form-control">
						</div>
					</div>
                </div>
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Nature of trade</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4naturetrade" name="nature_trade_tab4" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>When did you join the partnership </label>
						</div>
						<div class="col-md-9">
							<input type="text" id="" name="partnership_date_tab4" class="form-control datepiker">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Partnership UTR</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4utr" name="Partnership_utr_tab4" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Registration No.</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4registrationnumber" name="tab4_registration_nbr" class="form-control">
						</div>
					</div>
				</div>
                
                <div class="form-group clearfix">
				Please tick this box if the partnership is engaged in sharefishing, Otherwise leave blank <input type="checkbox"  name="partnership_engaged_tab4"/>
				</div>
                
                
                
                
			</div>
			
			<div class="col-md-6">
            
            <div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
                        <div class="col_left">
							<label>Title</label>
                            </div>
                            <div class="col_right" >
                            <select class="form-control select_title" id="tab4title" name="title_tab4">
                              @if(!empty($titles))
                                @foreach($titles as $key=>$title_row)
                                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                                @endforeach
                              @endif
                            </select>
                    </div>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="tab4fname" name="f_name" placeholder="First Name">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="tab4mname" name="m_name" placeholder="Middle Name">
						</div>
                        <div class="col-md-3">
							<input type="text" class="form-control" id="tab4lname" name="l_name" placeholder="Last Name">
						</div>
					</div>
				</div>
            
            
            
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Date of Birth</label>
						</div>
						<div class="col-md-3">
							<input type="text" id="tab4dob" class="form-control" name="DOB">
						</div>
                        	<div class="col-md-3">
							<label>NI Number</label>
						</div>
						<div class="col-md-3">
							<input type="text" id="tab4ninumber" name="ni_number_tab4" class="form-control">
						</div>
					</div>
				</div>
				
			
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>UTR</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4resputr" name="resputr_tab4" class="form-control">
						</div>
					</div>
				</div>
				
				
				
				
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea class="form-control" id="tab4resaddress" name="tab4_resaddress"> </textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4postcide" class="form-control" name="tab4_postcide">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab4telephone" class="form-control" name="tab4telephone" >
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12"><hr></div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
			<h3 class="form-title">Absent National Insurance Number</h3>
			<div class="form-group clearfix">
				<label>If you believe that you do not need a UK National Insurance number please give your reasons here</label>
				<textarea class="form-control" name="insurance_nbr_tab4"></textarea>
			</div>
			</div>
			
			<div class="col-md-6">
            
				<div class="form-title" style="padding-bottom:2px;">
            <span class="col_left text_h">UK Resident</span>
            <div class="col_right">
				Your are a UK resident <input type="checkbox" name="UK_resident_tab4"/>
				</div>
                <div class="clr"></div>
            </div>
            
            
                
                
			<div class="row">
			<div class="col-md-6">
				
				<div class="form-group clearfix">
				You have come to work in the UK from a non-EU country within the last 12 months <input type="checkbox" name="non_EU_tab4" />
				</div>
                
				<!--<div class="form-group clearfix">
				You have recently arrived in the UK but you're not sure how long you will be staying <input type="checkbox" />
				</div>-->
			</div>
			
			<div class="col-md-6">
			<div class="form-group clearfix">
				You have recently arrived in the UK but you're not sure how long you will be staying<input type="checkbox" name="UK_tab4" />
				</div>
				
				<!--<div class="form-group clearfix form-horizontal">
				<div class="row">
					<div class="col-md-6">
					<label>When did you self employment begin</label>
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" />
					</div>
				</div>
				</div>-->
                
			</div>
			</div>
            
            
            
            
			</div>
		</div>
        
        <hr />
        
        <div class="row">
			<div class="col-md-6">
           <!-- <div class="form-group clearfix">
				When did you join the partnership <input type="checkbox" />
				</div>
                -->
                <div class="form-group clearfix">
				Please tick this box if you are intitled to a share of the profits, losses and other income from partnership, Otherwise leave blank <input type="checkbox" name="intitled_partnership"/>
				</div>
            </div>
            
            <div class="col-md-6">
            <div class="form-group clearfix">
					<div class="col-md-6" style="padding-left:0;">
					<label>When did your self employment begin</label>
					</div>
					<div class="col-md-6">
						<input type="text"  name="self_emp_date" class="form-control datepiker" />
					</div>
				</div>
                
                 <div class="form-group clearfix">
				You are the nominated Partner of the Partnership you are joining <input type="checkbox" name="nominated_Partnership"/>
				</div>
                
            </div>
            
            </div>
        
        
        
        
        
	</div>
                </div>
                <div id="tab_5" class="tab-pane show_div {{ ($page_open == 5)?'active':'' }}">
                  <div class="container frm_page">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group" id="selected_val_tab5">
					<label>Client Details</label>
					<select class="form-control clientdetails" id="clientdetailstab5" name="client_name_tab5">
                    <option value="">--Select--</option>
                    @if(!empty($orgclient))
						@foreach($orgclient as $key=>$client_row)
                        <option value="{{ $client_row['client_id'] }}">{{ $client_row['business_name'] }}</option>
                        @endforeach
                    @endif
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group selected_res_person">
					<label>Responsible Person</label>
				<select class="form-control resperson responsibleperson_tab5" id="responsibleperson" name="res_person_tab5">
						
                        <option value=""></option>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<label>Download</label>
				<button class="btn btn-success" id="download_tab5" ><span class="glyphicon glyphicon-download-alt"></span> Download</button>
			</div>
		</div>
		<hr>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea class="form-control" id="tab5address" name="tab5_address"> </textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab5postcode" name="tab5_postcode" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="tab5telephonenumber" name="tab5_tel_nbr" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>VAT Registration Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" id="vat_numbertab5"  name="vat_number_tab5" class="form-control" />
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
							<label>Nature of Trade</label>
							<textarea class="form-control" id="naturetrade" name="naturetrade_tab5"></textarea>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group clearfix">
							<label>Status <i>For example director, partner, proprietor</i></label>
							<input type="text" id="statusproprietor"  name="status_proprietor_tab5" class="form-control">
				</div>
				
				<div class="form-group clearfix">
							<label>Reason</label>
							<textarea class="form-control" name="reason_tab5" ></textarea>
				</div>
				
				<div class="form-group clearfix">
					<div class="row">
						<div class="col-md-6">
							<p>You will be notified of the start date for using the FRS. This will be from the beginning of the VAT period after we receive your appliction. If you prefer another date write the date and reason below.</p>
							<label>Date <i>DD MM YYYY</i></label>
							<input type="text" class="form-control datepiker" name="reason_date_tab5">
						</div>
						<div class="col-md-6">
							<p>Enter the flat rate percentage that you will use for this trade sector.</p>
							<p><i>Note: enter the full rate even if you are entitled to the 1% reduction.</i></p>
							<input type="text" class="form-control" name="rate_trade_tab5">
						</div>
					</div>
				</div>
	</div>
	</div>
	</div>
                </div>
                <div id="tab_6" class="tab-pane show_div {{ ($page_open == 6)?'active':'' }}">
                
                <div class="container frm_page">
		<div class="row">
			<div class="col-md-6" style="padding-left: 0;">
            <div class="col-md-9">
				<div class="form-group selected_val_tab6">
					<label>Client Name</label>
                    <select class="form-control clientdetails" name="selected_client_tab6" id="selected_client_tab6">
                    <option value="">--Select--</option>
                    @if(!empty($indclient))
					  @foreach($indclient as $key=>$client_row)
                        <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
                      @endforeach
                    @endif
					</select>
				</div>
                </div>
                
                 <div class="col-md-3">
                 <label>Title</label>
                <select class="form-control select_title" id="tab6title" name="title">
  @if(!empty($titles))
    @foreach($titles as $key=>$title_row)
    <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
    @endforeach
  @endif
</select>
             </div>   
                
			</div>
            	<div class="col-md-6" style="padding-left: 0;">
			
			
            <div class="col-md-3">
				<label>First Name</label>
			<input type="text" name="tab6fname" id="tab6_fname"class="form-control">
			</div>
            <div class="col-md-3">
				<label>Middle Name</label>
			<input type="text" name="tab6_mname" id="tab6mname"class="form-control">
			</div>
            
             <div class="col-md-3">
				<label>Last Name</label>
			<input type="text" name="tab6_lname" id="tab6lname"class="form-control">
			</div>
            <div class="col-md-3">
				<label>Download</label>
				<button class="btn btn-success download_tab6"><span class="glyphicon glyphicon-download-alt"></span> Download</button>
			</div>
            
            </div>
            
		</div>
		<hr>
		   
                <div class="row">
			<div class="col-md-6">
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Date of Birth</label>
						</div>
						<div class="col-md-3">
							<input type="text" name="tab6_dob" id="tab6dob" value="" class="form-control datepiker">
						</div>
						
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>NI Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="tab6_ninumber" id="tab6ninumber" class="form-control">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>UTR</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="tab6utr" id="tab6utr" class="form-control" />
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
					<div class="col-md-3">
							<label>Address</label>
							</div>
							<div class="col-md-9">
							<textarea id="tab6address" name="tab6_address" class="form-control"></textarea>
							</div>
					</div>
				</div>
				
					<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="tab6_postcode" id="tab6postcode" class="form-control" />
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="tab6_tel_nbr" id="tab6tele" class="form-control" />
						</div>
					</div>
				</div>
				
				
	</div>
			
			<div class="col-md-6">
            <div class="form-group clearfix form-horizontal">
					<h3 class="form-title">Previous Name</h3>
					<div class="row">
						<div class="col-md-3">
							<label>Previous Surname</label>
						</div>
						<div class="col-md-3">
							<input type="text" name="p_surname" class="form-control" />
						</div>
						<div class="col-md-3">
							<label>Date of change</label>
						</div>
						<div class="col-md-3">
							<input type="text" id="" name="date_change" value="" class="form-control datepiker">
						</div>
					</div>
				</div>
                
                <h3 class="form-title">Previous Self Assessment</h3>
				<div class="form-group clearfix">
					You have been registered for Self Assessment before <input type="checkbox" name="befor_assessment" />
				</div>
				
		<div class="form-group clearfix form-horizontal">
			<h3 class="form-title">National Insurance</h3>
			<div class="row">
				<div class="col-md-3">
					<p>If you believe that you do not need  a UK National Insurance Number please give your reasons here</p>
				</div>
				<div class="col-md-9">
					<textarea class="form-control" name="nin_reason"></textarea>
				</div>
			</div>
		</div>
        
				
				
				<!--<h3 class="form-title">Reasons for Needing to complete a Tax Return</h3>
				
				<div class="form-group clearfix">
							<div class="col-md-4 col-md-offset-8 text-center"><strong>Event Date</strong></div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">I became Company Director</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">I have been getting income from land and property in the UK</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">I have been getting taxable foreign income in excess of &euro; 300 a year</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">I receive annual income from a trust or settlement</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">My annual income will exceed &euro; 100,000</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">I have been getting untaxed income that cannot be collected through my PAYE tax code</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<label>Any other reasons give details below</label>
					<textarea class="form-control"></textarea>
				</div>
				
				<h3 class="form-title">Date of Registration</h3>
				<div class="form-group clearfix form-horizontal">
					<label class="col-md-8">Date this registration applies from</label>
					<div class="col-md-4">
						<input type="text" class="form-control" />
					</div>
				</div>-->
	</div>
	</div>
    
    
    <div class="row">
    <div class="col-md-12">
    <h3 class="form-title">Reason for Needing to complete a Tax Return</h3>
    <div class="reason_con">
    <p><strong>Tell us by ticking a box for any of the following reasons that apply to you and entering the relevant<i> DD MM YYYY </i> </strong></p>
   <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>I become a company director</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="cmpny_director" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>On</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date1" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div>  
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>I have been getting income from Land and Property in the UK</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="getting_income" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>from</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date2" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div>  
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>I have been getting taxable foregin income in excess of &pound;300 a year</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="taxable_income" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>from</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date3" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div> 
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>I receive annual income from a trust of or settlement</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="annual_trust_income" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>from</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date4" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div> 
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>My annual income will exceed &pound;100,000</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="annual_income" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>from</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date5" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div> 
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>I have been getting untaxed income that cannot be collected through my PAYE tax code</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="untaxed_income" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>from</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date6" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div>
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>My Income is over &pound;50,000 and my partner or I will keep getting Child Benefit Payments on or after 7 January 2013</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="benefit_payments"/>
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label>from</label>
        </div>
        <div class="col-md-10">
        <input type="text" name="date7" class="form-control datepiker" />
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div>
        
        <div class="row">   
<div class="col-md-8 no_pad_left">
<div class="col-md-10">
<label>I have Capital Gains Tax to pay</label>

 </div>
<div class="col-md-2">
<input type="checkbox" name="capital_tax_pay" />
</div>
<div class="clr"></div>
</div>
                
        <div class="col-md-4 no_pad_left">
        <div class="col-md-2">
        <label></label>
        </div>
        <div class="col-md-10">
        <label>for the tax year ending</label>
        <div class="clr"></div>
        	<div class="form-group">
            <input type="text" id=""  name="tax_year_ending" maxlength="4" style=" width: 90px; text-align: center;" class="form-control" placeholder="- - - -">
          <!--  <select name="years" class="form-control newdropdown" style="width: 150px;">
                <?php 
                //for($p=1900; $p<=20000; $p++)
               // {
              //  echo "<option value=".$p.">".$p."</option>";
             //   }
                ?>    
            </select> -->
            
            
         <!--<input type="text" id="" value="" class="form-control datepiker"> -->
        </div>
        <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div>  
             
    </div>
    
    </div>
    </div>
    
    <div class="row">
       <div class="col-md-6">
         
    <div class="form-group">
    <h3 class="form-title" style="font-size: 18px !important;">Any other reasons give details below</h3>
    <textarea name="other_reason" class="form-control"></textarea>
    </div>
         </div> 
         
         <div class="col-md-6">
         <h3 class="form-title" style="font-size: 18px !important;">Date of Registration</h3>
    
    <div class="col-md-6">
    <input type="text" name="registration_date" id="" value="" class="form-control datepiker ">
    </div>
    <div class="clr"></div>
         </div>
     
    </div>
    
    
    
                </div>
                
                
                
                
                
                
                </div>                                                                
                <!-- /.tab-pane -->
              </div>


            </div>


          </div>
      {{ Form::close() }}
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>

@stop
<!-- time-->