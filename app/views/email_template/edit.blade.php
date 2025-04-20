<!-- By PK -->

@extends('layouts.layout')

@section('myjsfile')
<!--<script src="http://cdn.ckeditor.com/4.5.2/standard-all/ckeditor.js"></script>-->
<script src="{{url('ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{ URL :: asset('js/contact_email_templates.js') }}"></script>
<script src="{{ URL :: asset('js/template_type.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(window).ready(function() {
    CKEDITOR.replace( 'template_message_body'); 
});
</script>	
@stop

@section('content')

<style>
	ul#showPlaceholders {
		padding-top: 16px;
	}
	a.addThisPlaceholder {
		font-weight: bold;
		font-size: 14px;
		line-height: 25px;
	}
	select#getPlaceholder {
		border-radius: 4px!important;
	}
	a.addThisPlaceholder {
    font-weight: bold;
    font-size: 14px;
    line-height: 25px;
    cursor: pointer;
}
</style>

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

    <!-- Main content -->
    <section class="content">
      
      <div class="practice_mid">
	    @if(Session::has('success'))
	      <p style="color:#00a65a; font-size:15px;">{{ Session::get('success') }}</p>
	    @endif

	    @if(Session::has('error'))
	      <p style="color:red; font-size:15px;">{{ Session::get('error') }}</p>
	    @endif
    
	   	<div class="tabarea">
	   	{{ Form::open(array('url' => '/email/template/edit', 'files' => true)) }}
		   	<div class="col-md-12">
		   		<div class="tab_topcon">
		          <div class="top_bts" style="float:left;">
		            <ul style="padding:0;">
		              <li>
		                <a class="btn btn-block btn-success" href="/letters/templates" style="width:124px;">
			            <i class="fa fa-plus"></i> List templates</a>
		              </li>
		              <li>
		              	<button type="submit" name="save" id="save" class="btn btn-info">Save As Template</button>
		              </li>
		              <!-- <li>
			              <button class="btn btn-info">UPLOAD LETTERHEAD</button>
			            </li>
			            
						<li>
			              <a class="btn btn-block btn-success" href="{{url('/placeholders')}}" style="width:124px;">
			                <i class="fa fa-code"></i> Placeholders</a>
			            </li> -->
		              <div class="clearfix"></div>
		            </ul>
		          </div>
		          <div class="top_search_con">
		           <div class="top_bts">
		            <ul style="padding:0;">

		              <div class="clearfix"></div>
		            </ul>
		          </div>
		          </div>
		          <div class="clearfix"></div>
		        </div>
	        </div>

            <div class="col-md-12" style="padding-left: 0px;">
				<div class="col-md-8">
				    <input type="hidden" name="template_id" id="template_id" value="{{$templateData['id']}}">
					<!-- <div class="form-group">
					  <div class="input_box_g">
						<label for="">Template Name</label>
						<input type="text" class="form-control" name="template_name" id="template_name" value="{{$templateData['name']}}" placeholder="Template Name">
					  </div>

					  <div class="input_dropdown">
						  <label>Type <a href="javascript:void(0);" data-baseurl="{{url()}}" id="add_new_template_type" >Add New</a></label>
						  <select class="form-control" name="template_type" id="template_type" >
							<option>Select Template Type</option>
							@if(!empty($template_types))
								@foreach($template_types as $key=>$type_row)
							  		@if($templateData['type'] == $type_row->template_type_id) 
							  			<option selected='true' value="{{ $type_row->template_type_id }}" >{{ $type_row->template_type_name }}</option>
							  		@else
										<option  value="{{ $type_row->template_type_id }}" >{{ $type_row->template_type_name }}</option>
									@endif
							  	@endforeach
							@endif

						  </select>
					  </div>
					  <div class="clearfix"></div>      
					</div> --> 

					<div class="form-group">
						  <!-- <label for="template_subject">Message Subject</label> -->
						<input name="template_subject" id="template_subject" type="text" class="form-control" value="{{$templateData['subject']}}" placeholder="Message Subject">
						<div class="clearfix"></div>     
					</div>

					  <!--<div class="form-group">
						  <label for="placeHolder">Copy this Placeholder and Paste</label>
						  <input name="placeHolder" id="placeHolder" type="text" class="form-control">
					  </div>-->

					<div class="form-group">
						<textarea name="template_message" id="template_message_body" class="form-control" placeholder="Message" style="height: 250px;">{{$templateBody}}</textarea>
					</div>

				  	<!-- <div class="form-group new_temp">                                
						<div class="btn btn-success btn-file">
							<i class="fa fa-paperclip"></i> Attachment
							<input type="file" name="add_file" id="add_file" />
						</div>
					</div> -->
					<!-- <div class="email_btns2">
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					  <button type="submit" name="save" id="save" class="btn btn-info pull-left save_t">Save</button>
					</div> -->
				  </div>
			  
			  	<div class="col-md-4" style="margin-top: -23px;">
					<div class="input_dropdownbn">
						<label style="margin-top: 0">Insert Placeholder</label>
						<select class="form-control newdropdown" id="changePlaceHolder">
	                        <option value="">Select Placeholder Type</option>
	                        <option value="general">General</option>
	                        <option value="org">Organisation Details</option>
	                        <option value="ind">Individual Details</option>
	                        <option value="staff">Staff Details</option>
	                        <option value="practice">Practice Details</option>
	                        <option value="address">Organisation Address Details</option>
	                        <option value="other">Other Contacts</option>
	                    </select>
						<ul class="placeholderList"><!-- Ajax Call --></ul>
					</div>
			  </div>
			  </div>
			  {{ Form :: close() }}
		  </div>
          <div class="clearfix"></div>
      </div>
    </section>
    <!-- /.content -->
  </aside>
            <!-- /.right-side -->
        
  </div>

        <!-- ./wrapper --> 

@stop



