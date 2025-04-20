@extends('layouts.layout') @section('mycssfile')
<link href="/file-and-sign/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="/file-and-sign/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

<!-- select search-->
<link href="{{ URL :: asset('css/select2.min.css') }}" rel="stylesheet" />
@stop
@section('myjsfile') 
<script src="{{ URL :: asset('/js/invited_client.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="/file-and-sign/js/jquery.filer.min.js?v=1.0.5"></script>
<script type="text/javascript" src="/js/custom.js?v=1.0.5"></script>

<!-- select search-->
<script src="{{ URL :: asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".putClientName").select2({
	  placeholder: "Select Client"
	});
})
	
</script>
@stop
 
@section('content')
<input type="hidden" id="user_type" value="C">
<input type="hidden" name="client_id" id="client_id" value="">
<input type="hidden" id="portal" value="{{$portal or ''}}">

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
        	<div class="tab-content">

<div id="tab_1">
	<!--table area-->
	<div class="box-body">
		<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
			<div class="row">
				<div class="col-xs-6"></div>
				<div class="col-xs-6"></div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="col_m2">
						<div class="col_m2">
<form method="post" action="" name="my_form" id="my_form" enctype="multipart/form-data">
	<div class="search_area">
		<div class="col-md-12">
			<div class="col-md-4" style="padding-left: 0px;">
				<select class="form-control putClientName">
					<option value="">Select Client</option>
					@if(isset($client_details) && count($client_details) >0)
	                   @foreach($client_details as $key => $value)
	                   		@if(!empty( $value['client_name'] ))
	                   			<option value="{{$value['client_id']}}">{{$value['client_name']}}</option>
	                  			<!-- <li><a href='javascript:void(0)' class='putClientName' data-client_name='{{$value['client_name']}}' data-client_id='{{$value['client_id']}}'>{{$value['client_name']}}</a></li> -->
	               			@endif
	               		@endforeach
	               	@endif
				</select>
			</div>

		<!-- <div class="j_selectbox_big">
		    <span id="showClientName">Select Client</span>
		    <div class="select_icon" id="select_icon_type"></div>
		    <div class="clr"></div>
            <div class="open_dropdown open_client_drop" style="display:none;">
              <input type='text' class="email_top search_text" id='client_name'/>
		      <ul class="document_ul" id="search_client">
                @if(isset($client_details) && count($client_details) >0)
                   @foreach($client_details as $key => $value)
                   		@if(!empty( $value['client_name'] ))
                  			<li><a href='javascript:void(0)' class='putClientName' data-client_name='{{$value['client_name']}}' data-client_id='{{$value['client_id']}}'>{{$value['client_name']}}</a></li>
               			@endif
               		@endforeach
               	@endif
		      </ul>
		    </div>
		</div> -->
			<div class="col-md-4" style="padding-left: 0px; width: 28%">
				<div class="j_selectbox_big">
				    <span>View or Search Documents</span>
				    <div class="select_icon disable_click" id="select_icon"></div>
				    <div class="clr"></div>
				    <div class="open_toggle" style="display: none;">
				      <ul class="document_ul" id="document_ul"></ul>
				    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="upload_a">
					<a href="JavaScript:void(0)" class="upload_new">Upload New Document</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>

<div class="frame_box">

<div id="content" class="avoid-clicks">
    <input type="file" name="files[]" id="filer_input2" multiple="multiple">
</div>

<div class="showdocument" style="display:none;"> 
	<iframe id="showdocument" width="100%" height="500" src=""></iframe> 
</div> 

<div class="clearfix"></div>
</div>
<div class="clearfix"></div>

</form>
					</div>
					</div>
		
				</div>	
			</div>
		</div>
		</div>
	</div>
								<!--end table-->
							</div>
		</section>
		<!-- /.content -->
	</aside>
	<!-- /.right-side -->
</div>

@stop