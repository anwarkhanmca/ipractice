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
	  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
	    <section class="sidebar">
        @include('layouts/inner_leftside')
			</section>
	  </aside>

    <aside class="right-side {{ $right_class }}">
      @include('layouts.below_header')
	    <!-- Main content -->
	    <section class="content">
				<div class="page_loader"><img src="/img/spinner.gif"></div>
				<div class="practice_mid">
        {{ Form::open(array('action'=>'HmrcController@getFormData', 'method'=> 'post')) }}
					<div class="tabarea">
            <div class="nav-tabs-custom">
          		<div class="tab-content">
							<input type="hidden" class="getpageurl" value="{{url()}}/hmrc/authorisations" />
                
                <div id="tab_1" class="tab-pane active">
                  <!--table area-->
                 <div class="container frm_page">
				 					<div class="get_cl_name"style="display:none;"></div>









		<div class="row">
			<div class="col-md-6">
				<div class="form-group client_reserorr">
					<label>Client Name</label>
					<select class="form-control clientdetails" name="client_id" id="tab1_client">
            <option value="">--Select--</option>
            <option value="{{$client_id}}">{{ $admin_name or "" }}</option>
            @if(!empty($relationship))
							@foreach($relationship as $key=>$cr)
								@if(isset($cr['name']) && $cr['name'] != "" && $cr['type'] == 'org' )
                  <option value="{{ $cr['client_id'] }}">{{ $cr['name'] }}</option>
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
							<input type="text" name="name_agent" value="{{ $practice_details->legal_name or '' }}" class="form-control disable_click">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>SA Agent ID</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="sa_agent_id" value="{{ $practice_details->agentsa or '' }}" class="form-control disable_click">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>CT Agent ID</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="ct_agent_id" value="{{ $practice_details->agentct or '' }}" class="form-control disable_click">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>PAYE Agent ID</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="paye_agent_id" value="{{ $practice_details->agentpaye or '' }}" class="form-control disable_click">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Address </label>
						</div>
						<div class="col-md-9">
							<textarea  name="agent_address" class="form-control disable_click">{{$pysicaladdress or '' }}</textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Post Code</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="agent_post_code" value="{{ $practice_address['phy_zip'] or ''}}" class="form-control disable_click">
						</div>
					</div>
				</div>
				
				<div class="form-group clearfix form-horizontal">
					<div class="row">
						<div class="col-md-3">
							<label>Telephone Number</label>
						</div>
						<div class="col-md-9">
							<input type="text" name="agent_tel_no" value="{{ $practices['telephone_no'] or ''}}" class="form-control disable_click">
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
					@if(!empty($indclient))
						@foreach($indclient as $key=>$client_row)        
	            <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
						@endforeach
					@endif
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