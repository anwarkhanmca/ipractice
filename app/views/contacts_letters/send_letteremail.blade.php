@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bottom_space{ height: 50px;}
</style>
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/letter_email.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>

@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side  {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

                <!-- Main content -->
                <section>
                <div class="eml_pan">
					 
					<div class="up_con">
						 <span></span>

						 <label>Select Clients</label>
						
						 <select style="width:290px; margin-right: 10px;float: left; border-radius: 5px !important; border:2px solid #ccc;" class="arrow form-control" name="select_client" id="select_client" >
							<option value="">Select Contact Type </option>

							<option value="org">Organisation Client</option>
							<option value="ind">Individual Client</option>
							<option value="staff">Staff</option>
							<option value="cg">Contact Groups</option>
							<option value="other">Others</option>
						  </select>
					</div>
					
					<div class="up_con">
						<div class="sel_multi"> <span>Select 1 or more </span>
							<img src="{{url()}}/img/ajax-loader.gif" />
						</div>
						<ul id="ckient_data"></ul>					
					</div>
					
					<div class="up_con ">
						<div class="selected-clients"> View selected contacts </div>
						<ul id="ckient_data2"></ul>	
					</div>
                     
					<div class="select-template pan">
					</div>
                      <div class="pan">
 
                         <div class="">
                         <span>              

						  <select style="width:290px; margin-right: 10px;float: left;" class="arrow form-control" name="add_template_type" id="add_template_type" >
							<option>Select Template Type</option>
						   
						   <!-- @if( isset($old_services) && count($old_services)>0 )
												  @foreach($old_services as $key=>$scheme_row)
													<option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
												  @endforeach
												@endif
												
												@if( isset($new_services) && count($new_services)>0 )
												  @foreach($new_services as $key=>$scheme_row)
													<option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
												  @endforeach
												@endif-->
							
							@if(!empty($template_types))
								@foreach($template_types as $key=>$type_row)
									<option value="{{ $type_row->template_type_id }}">{{ $type_row->template_type_name }}</option>
								@endforeach
							@endif
						  </select>
                           
                           
                           </span>
                           <span>
							   <input type='hidden' id="template_name" name="template_name" value=''>
							   <input type='hidden' id="base_url" value='{{url()}}'>
                           <select style="width:290px; margin-right: 10px;float: left;" id="tamplatenamefromdrop" class="arrow form-control">
                <option>Select Template Name</option>
               
              
              </select>
                           </span>
                           <div class="button_pan">
                           <span><a class="add-template btn btn-success" href="{{url('/email/template')}}" style="float:left;"><i class="fa fa-plus"></i> TEMPLATE </a></span>
                         
                           <span><a class="preview btn btn-success" id="preview_template_mail" href="javascript:void(0)"> PREVIEW </a></span>
                           <!--<span><a class="preview btn btn-success" id="preview_template_mail" href="{{url('/send-letters-emails/generate-email/preview')}}"> PREVIEW </a></span>-->
						   
                           <span><a class="generate-pdf btn btn-success" href="javascript:void(0)" id="download_template_mail"><i class="fa fa-download"></i> Generate PDF </a></span>
						   
                           <span><a class="send-mail btn btn-success" href="javascript:void(0);" id="send_template_mail"> SEND MAIL <i class="fa fa-envelope"></i></a></span>
                         
                         </div>
                           
                           <div class="clr"></div>
                         
                           <input type="text" placeholder="Subject Line" id="template_mail_subject" class="form-control" style="margin-top: 60px;" >
                          <!-- <textarea rows="10"cols="20" style="width: 100%; margin-top: 20px;"></textarea> -->
           <textarea name="template_message_body" id="template_message_body" rows="50" class="form-control" placeholder="Message" style="height: 500px;"></textarea>
                         
                         </div>
                      
                          <div class="up_con">
                          
                              <p class="t1_right" style="float: none; padding-top:0;"><a href="#">Copy Postal</a></p>
                              <span style="color: #3C8DBC;">ABEL</span>
                              <span><img src="{{url()}}/img/cross_icon.png"></span>
                          
                          
                          </div>
                      
                         <div class="up_con1">
                         
                            <span>Sign</span>
                            <span><input type="checkbox" /></span>
                         
                         
                         </div>
                         <div class="clr"></div>
                      
                      
                      </div>
                     
                      <div class="clr"></div>

                </div>
                
                
                </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->



<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="{{URL('/ckeditor457std/ckeditor.js')}}"></script>

<script type="text/javascript">
  $(window).load(function() {
    
    CKEDITOR.replace( 'template_message_body',
    { 
        //toolbar :[['Source'],['Cut','Copy','Paste','PasteText','SpellChecker'],['Undo','Redo','-','SelectAll','RemoveFormat'],['CreatePlaceholder'],[ 'Bold', 'Italic','Underline', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ], ['SpecialChar','PageBreak']],
       
        //extraPlugins : 'wordcount',
       // extraPlugins : 'wordcount,placeholder',
        //height: '400px',
      /*  wordcount : {
            showCharCount : true,
            showWordCount : true
        }*/
    });
});
</script>
      
<!-- Add to Group modal end -->

@stop

