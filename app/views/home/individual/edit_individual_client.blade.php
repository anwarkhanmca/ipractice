@extends('layouts.layout')

@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->

<!-- google search -->
<link rel="stylesheet" href="{{ URL :: asset('css/address_search.css') }}" />
<!-- google search -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/upload_file_other.js') }}" type="text/javascript"></script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script>
$(document).ready(function(){
  $("#dob").datepicker({minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+0"});
  $("#app_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });
  $("#spouse_dob").datepicker({ minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });

  $(".user_added_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
})
</script>
<script src="{{ URL :: asset('js/upload_profile.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/client_services.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script> 

<script src="{{ URL :: asset('js/client_allocation.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/jtablejs/renewals.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/crm_renewals.js') }}" type="text/javascript"></script>

<!-- proposal js -->
<script src="{{ URL :: asset('js/proposal.js') }}" type="text/javascript"></script>
<!-- summernote js -->
<script src="{{ URL :: asset('js/summernote.js') }}"></script>

<!-- Editor -->
<script src="{{ URL :: asset('classy-editor/js/jquery.classyedit.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL :: asset('classy-editor/css/jquery.classyedit.css') }}" />

<!-- google search -->
<script src="{{ URL :: asset('js/address_search.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc7HTLVvrPyl_cJQGPIb1GuWwq0cTC4MY&libraries=places&callback=initAutocomplete" async defer></script>
<!-- google search -->
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
    <section class="sidebar">
      <ul class="sidebar-menu">
        @include('layouts.outer_leftside')
      </ul>
    </section>
  </aside>

  <aside class="right-side {{ $right_class }}">
    @include('layouts.below_header')

    <!-- Main content -->
    {{ Form::open(array('url' => '/individual/insert-client-details', 'files' => true, 'id'=>'basicform')) }}
    <input type="hidden" name="client_id" id="client_id" value="{{ $client_details['client_id'] }}">
    <input type="hidden" name="client_type" id="client_type" value="ind">
    <input type="hidden" name="client_name" id="client_name" value="{{ $client_details['client_name'] or "" }}">
    <input type="hidden"  name="page_name"  id="page_name" value="{{ $page_name }}">
    
    
    <section class="content">
      
      <div class="row">
        
        <div class="top_bts">
          <ul>
            <li>
              COMPANIES HOUSE <button type="button" name="ind_sync_data" id="ind_sync_data" class="btn btn-danger">SYNC DATA</button>
            </li>

            <li>
              <p style="margin:0px 0 0 275px;"><a href="javascript:void(0)" class="btn btn-info" style="font-size: 18px; font-weight: bold;">
                @if(isset($user_type) && $user_type == "C")
                  {{ $client_details['initial_badge'] or "" }}
                @else
                  @if(isset($client_details['client_code']) && $client_details['client_code'] != "")
                    {{ $client_details['client_code'] }}
                  @else
                    {{ $client_details['initial_badge'] or "" }}
                  @endif
                @endif
              </a></p>
            </li>
            <li>
              <p style="margin: 6px 0 0 0;font-size: 18px; font-weight: bold;color:#00acd6">{{ $client_details['client_name'] or "" }}</p>
            </li>
          
            <li>
             <a href="/indeditclientpdf/{{$client_details['client_id']}}" class="btn btn-success" style="margin-left: 446px;"><i style="padding-right: 4px;" class="fa fa-download"></i> Generate PDF</a>
            </li>
           
            
            <!-- <li>
              <button class="btn btn-danger">REQUEST FROM OLD ACCOUNTANT</button>
            </li> -->
            <div class="clearfix"></div>
          </ul>
        </div>
      </div>

    <div class="practice_mid">
        

<div class="tabarea">
  
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg" id="header_ul">
      <li class="active" id="tab_1"><a class="open_header" data-id="1" href="javascript:void(0)">GENERAL</a></li>
      <li id="tab_2"><a class="open_header" data-id="2" href="javascript:void(0)">TAX INFORMATION</a></li>
      <li id="tab_3"><a class="open_header" data-id="3" href="javascript:void(0)">CONTACT INFORMATION</a></li>
      <li id="tab_4"><a class="open_header" data-id="4" href="javascript:void(0)">RELATIONSHIPS</a></li>
      <li id="tab_5"><a class="open_header" data-id="5" href="javascript:void(0)">OTHERS</a></li>

      @if(isset($user_type) && $user_type != "C")
        <li><a href="#" class=" btn-block btn-primary " data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field</a></li>
      @else
        <li id="tab_6"><a class="open_header" data-id="6" href="javascript:void(0)">BILLING & FEES</a></li>
      @endif

    </ul>
  <div class="tab-content">

    <div id="step1" class="tab-pane active" style="display:block;">
      <!--table area-->
      <div class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
          </div>
<div class="row">  
        
<div class="col-xs-12 col-xs-6">
 <div class="col_m2">  
  @if(isset($user_type) && $user_type != "C")              
  <div class="form-group">
    <div class="n_box1">
      <label for="exampleInputPassword1">Client Code</label>
      <input type="text" id="client_code" name="client_code" value="{{ $client_details['client_code'] or "" }}" class="form-control toUpperCase">
    </div>
  </div>
  @endif

<div class="form-group">

<div class="clearfix"></div>
<div class="n_box1">
<label for="exampleInputPassword1">Title</label>
<select class="form-control select_title" id="title" name="title">
  @if( isset($titles) && count($titles) >0 )
    @foreach($titles as $key=>$title_row)
    <option value="{{ $title_row->title_name }}" {{ (isset($client_details['title']) && ($title_row->title_name == $client_details['title']))?"selected":"" }}>{{ $title_row->title_name }}</option>
    @endforeach
  @endif
</select></div>
<div class="n_box2">
    <label for="exampleInputPassword1">First Name</label>
    <input type="text" id="fname" name="fname" value="{{ $client_details['fname'] or "" }}" class="form-control toUpperCase"></div>
<div class="n_box3">
    <label for="exampleInputPassword1">Middle Name</label>
    <input type="text" id="mname" name="mname" value="{{ $client_details['mname'] or "" }}" class="form-control"></div>
<div class="n_box4">
    <label for="exampleInputPassword1">Last Name</label>
    <input type="text" id="lname" name="lname" value="{{ $client_details['lname'] or "" }}" class="form-control toUpperCase"></div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Gender</label>
<select class="form-control" name="gender" id="gender">
  <option value="Male" {{ (isset($client_details['gender']) && $client_details['gender'] == "Male")?"selected":"" }}>Male</option>
  <option value="Female" {{ (isset($client_details['gender']) && $client_details['gender'] == "Female")?"selected":"" }}>Female</option>
</select>
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Date of Birth</label>
<input type="text" id="dob" name="dob" value="{{ (isset($client_details['dob']))?$client_details['dob']:"" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Marital Status</label>
<select class="form-control" name="marital_status" id="marital_status">
  @if(isset($marital_status) && count($marital_status))
    @foreach($marital_status as $key=>$status_row)
      <option value="{{ $status_row['marital_status_id'] }}" {{ (isset($client_details['marital_status']) && $status_row['marital_status_id'] == $client_details['marital_status'])?"selected":"" }}>{{ $status_row['status_name'] }}</option>
    @endforeach
  @endif
</select>
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Spouse Date of Birth</label>
<input type="text" id="spouse_dob" name="spouse_dob" value="{{ (isset($client_details['spouse_dob']))?date('d-m-Y', strtotime($client_details['spouse_dob'])):"" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Country of Residence</label>
<select class="form-control" name="country" id="country">
@if(!empty($countries))
  @foreach($countries as $key=>$country_row)
  @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
    <option value="{{ $country_row->country_id }}" {{ (isset($client_details['country']) && $country_row->country_id == $client_details['country'])?"selected":"" }}>{{ $country_row->country_name }}</option>
  @endif
  @endforeach
@endif
@if(!empty($countries))
  @foreach($countries as $key=>$country_row)
  @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
    <option value="{{ $country_row->country_id }}" {{ (isset($client_details['country']) && $country_row->country_id == $client_details['country'])?"selected":"" }}>{{ $country_row->country_name }}</option>
  @endif
  @endforeach
@endif
</select>
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Occupation</label>
<input type="text" id="occupation" name="occupation" value="{{ $client_details['occupation'] or "" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Nationality</label>
<select class="form-control" name="nationality" id="nationality">
@if(!empty($nationalities))
  @foreach($nationalities as $key=>$nationality_row)
    <option value="{{ $nationality_row->nationality_id }}" {{ (isset($client_details['nationality']) && $nationality_row->nationality_id == $client_details['nationality'])?"selected":"" }}>{{ $nationality_row->nationality_name }}</option>
  @endforeach
@endif
</select>
</div>
</div>

<!-- <div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Occupation</label>
<input type="text" id="occupation" name="occupation" class="form-control">
</div>
</div> -->
<div class="clearfix"></div>
</div>


<!-- This portion is for user created field -->
@if(!empty($steps_fields_users) && count($steps_fields_users) > 0)
  @foreach($steps_fields_users as $row_fields)
    @if(!empty($row_fields->step_id) && $row_fields->step_id == "1")
      <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_fields->field_name)) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields->field_id }}"><img src="/img/cross.png" width="12"></a></label>
      @if(!empty($row_fields->field_type) && $row_fields->field_type == "1")
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" value="{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}</textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"checked":"" }}/>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"selected":"" }}>{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields->field_name)])?date('d-m-Y', strtotime($client_details[strtolower($row_fields->field_name)])):"" }}" name="{{ strtolower($row_fields->field_name) }}">
      @endif
     
     
      </div>

        <div class="clearfix"></div>
      </div>
    @endif
  @endforeach
@endif
<!-- This portion is for user created field -->


<!-- Sub Section portion is for user created field -->
@if(!empty($subsections) && count($subsections) > 0)
  @foreach($subsections as $row_section)
    @if(!empty($row_section['parent_id']) && $row_section['parent_id'] == "1")
    <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_section['title'])) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_section" data-step_id="{{ $row_section['step_id'] }}"><img src="/img/cross.png" width="12"></a></label>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="horizontal_line"></div>
    @if(isset($row_section['children']) && count($row_section['children']) >0 )
      @foreach($row_section['children'] as $row_fields)
        <div class="form-group">
          <div class="twobox_2">
          <label for="exampleInputPassword1">{{ ucwords($row_fields['field_name']) }} 
            &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields['field_id'] }}"><img src="/img/cross.png" width="12"></a></label>
          @if(isset($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" value="{{ isset($client_details[strtolower($row_fields['field_name'])])?$client_details[strtolower($row_fields['field_name'])]:"" }}" class="form-control">
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields['field_name'])])?$client_details[strtolower($row_fields['field_name'])]:"" }}</textarea>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" {{ isset($client_details[strtolower($row_fields['field_name'])])?"checked":"" }}/>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(isset($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}" {{ (isset($client_details[strtolower($row_fields['field_name'])]) && $client_details[strtolower($row_fields['field_name'])] == $value)?"selected":"" }}>{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields['field_name'])])?date('d-m-Y', strtotime($client_details[strtolower($row_fields['field_name'])])):"" }}" name="{{ strtolower($row_fields['field_name']) }}">
          @endif
         
         
          </div>

          <div class="clearfix"></div>
        </div>
        @endforeach
      @endif
    @endif
  @endforeach
@endif
<!-- Sub Section portion is for user created field -->




                <div class="add_client_btn">
                  <button class="btn btn-danger open" type="submit">Save</button>
                  <button class="btn btn-info open" data-id="2" type="button">Next</button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-xs-12 col-xs-6" style="padding-top: 10px;">
          <input type="hidden" id="delete_staff_id" value="{{ $user_id or '' }}">
          <div class="error_image_type"></div>
          <div class="pic_area">
            <div class="profile_circle staff_image" id="image_preview">
              @if(isset($photo['profile_photo']) && $photo['profile_photo'] != "")
                <img src="/uploads/profile_photo/{{ $photo['profile_photo'] }}" class="img-circle" alt="User Image" />
              @else
                <div style="margin-top: 30px;">{{ $client_details['initial_badge'] or "" }}</div>
              @endif
            </div>

            @if(isset($user_id) && $logged_user_id == $user_id)
            <div align="center">
              <div class="upload_pic">
                <button class="btn btn-info" name="photo_save" type="submit">Save</button>
              </div>
              <div class="cancel_image">
                <span class="btn btn-default btn-file p_details">
                    Upload Photo<input type="file" name="profile_photo" id="profile_photo">
                </span>
              </div>
              <div class="cancel_image">
                <button class="btn btn-danger delete_photo" type="button">Delete</button>
              </div>
            </div>
            @endif

          </div>
        </div>


        </div>
            </div>
                  
                  <!--end table-->
        </div>
    </div>
         
        <div id="step2" class="tab-pane" style="display:none;">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      
                      <div class="row">  
                    
                    <div class="col-xs-12 col-xs-6">
                    
<div class="col_m2">                    


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">NI Number</label>
<input type="text" id="ni_number" name="ni_number" value="{{ $client_details['ni_number'] or "" }}" class="form-control">

</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Tax Reference</label>
<input type="text" id="tax_reference" name="tax_reference" value="{{ $client_details['tax_reference'] or "" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Tax Office</label>
<input type="hidden" id="tax_reference_type" value="I">
<select class="form-control" id="tax_office_id" name="tax_office_id">
  <option value="">Choose Office</option>
  @if(!empty($tax_office))
    @foreach($tax_office as $key=>$office_row)
      @if($office_row->parent_id == 0)
        <option value="{{ $office_row->office_id }}"{{ (isset($client_details['tax_office_id']) && $office_row->office_id == $client_details['tax_office_id'])?"selected":"" }}>{{ $office_row->office_name }}</option>
      @endif
    @endforeach
  @endif
    
</select>

</div>
</div>
<div class="clearfix"></div>
</div>



<div id="show_other_office" style="display:none;">
  <div class="form-group">
    <label for="exampleInputPassword1">Other Address</label>
    <select class="form-control" id="other_office_id" name="other_office_id">
      <option value="">-- Select Address --</option>
      @if(!empty($tax_office))
        @foreach($tax_office as $key=>$office_row)
        @if(!empty($office_row->parent_id) && $office_row->parent_id != 0)
          <option value="{{ $office_row->office_id }}">{{ $office_row->office_name }}</option>
        @endif
        @endforeach
      @endif
        
    </select>
  </div>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Address</label>
<textarea id="tax_address" name="tax_address" class="form-control {{ (isset($user_type) && $user_type == "C")?'disable_click':'' }}" rows="3">{{ $client_details['tax_address'] or "" }}</textarea>

</div>


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postal/Zip Code</label>
<input type="text" id="tax_zipcode" name="tax_zipcode" value="{{ $client_details['tax_zipcode'] or "" }}" class="form-control {{ (isset($user_type) && $user_type == "C")?'disable_click':'' }}">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Telephone</label>
<input type="text" id="tax_telephone" name="tax_telephone" value="{{ $client_details['tax_telephone']  or "" }}" class="form-control {{ (isset($user_type) && $user_type == "C")?'disable_click':'' }}">
</div>
</div>
<div class="clearfix"></div>
</div>


<!-- This portion is for user created field -->
@if(!empty($steps_fields_users) && count($steps_fields_users) > 0)
  @foreach($steps_fields_users as $row_fields)
    @if(!empty($row_fields->step_id) && $row_fields->step_id == "2")
      <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_fields->field_name)) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields->field_id }}"><img src="/img/cross.png" width="12"></a></label>
      @if(!empty($row_fields->field_type) && $row_fields->field_type == "1")
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" value="{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}</textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"checked":"" }}/>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"selected":"" }}>{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields->field_name)])?date('d-m-Y', strtotime($client_details[strtolower($row_fields->field_name)])):"" }}" name="{{ strtolower($row_fields->field_name) }}">
      @endif
     
     
      </div>

        <div class="clearfix"></div>
      </div>
    @endif
  @endforeach
@endif
<!-- This portion is for user created field -->

<!-- Sub Section portion is for user created field -->
@if(!empty($subsections) && count($subsections) > 0)
  @foreach($subsections as $row_section)
    @if(!empty($row_section['parent_id']) && $row_section['parent_id'] == "2")
    <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_section['title'])) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_section" data-step_id="{{ $row_section['step_id'] }}"><img src="/img/cross.png" width="12"></a></label>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="horizontal_line"></div>
    @if(isset($row_section['children']) && count($row_section['children']) >0 )
      @foreach($row_section['children'] as $row_fields)
        <div class="form-group">
          <div class="twobox_2">
          <label for="exampleInputPassword1">{{ ucwords($row_fields['field_name']) }} 
            &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields['field_id'] }}"><img src="/img/cross.png" width="12"></a></label>
          @if(isset($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" value="{{ isset($client_details[strtolower($row_fields['field_name'])])?$client_details[strtolower($row_fields['field_name'])]:"" }}" class="form-control">
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields['field_name'])])?$client_details[strtolower($row_fields['field_name'])]:"" }}</textarea>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" {{ isset($client_details[strtolower($row_fields['field_name'])])?"checked":"" }}/>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(isset($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}" {{ (isset($client_details[strtolower($row_fields['field_name'])]) && $client_details[strtolower($row_fields['field_name'])] == $value)?"selected":"" }}>{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields['field_name'])])?date('d-m-Y', strtotime($client_details[strtolower($row_fields['field_name'])])):"" }}" name="{{ strtolower($row_fields['field_name']) }}">
          @endif
         
         
          </div>

          <div class="clearfix"></div>
        </div>
        @endforeach
      @endif
    @endif
  @endforeach
@endif
<!-- Sub Section portion is for user created field -->


<div class="add_client_btn">
  <button class="btn btn-info back" data-id="1" type="button">Prev</button>
  <button class="btn btn-danger" type="submit">Save</button>
  <button class="btn btn-info open" data-id="3" type="button">Next</button>

</div>
<div class="clearfix"></div>
                   </div>                  
                    
                    
                    
                    
                    
 
                   </div>
                  
                    </div>
                      
                    </div>
                  </div>
                </div>
                              <!--</div> -->
         
        <div id="step3" class="tab-pane" style="display:none;">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      
                      <div class="row">  
                    
                    <div class="col-xs-12 col-xs-6">
                    <div class="col_m2">  
                      <h3 class="box-title">Service Address</h3>  
  <div class="form-group">
  
    <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="serv" data-page_name="{{ $page_name }}">New</a> | 
@if($page_name== 'ind_client')
    <a javascript:void(0) class="editAddress" data-address_type="serv" data-page_name="{{ $page_name }}">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="serv">Delete</a> | 
@endif
    <a javascript:void(0) class="copyAddress" data-address_type="serv">Copy</a>

    </label>
  @if($page_name== 'ind_client')
      <select class="form-control get_orgoldcont_address" id="serv_address" name="serv_address" data-type="serv">
        <option value="">-- Select Address --</option>
        @if(isset($cont_address) && count($cont_address)>0)
          @foreach($cont_address as $key=>$address_row)
            <option value="{{ $address_row['address_id'] }}" {{ (isset($client_details['serv_address']) && $client_details['serv_address'] == $address_row['address_id'])?"selected":""}}>{{ $address_row['fullAddress'] }}</option>
          @endforeach
        @endif
      </select>
  @else
    <select class="form-control get_orgoldcont_address" id="serv_address" name="serv_address" data-type="serv">
      <option value="">-- Select Address --</option>
      @if(isset($cont_address) && count($cont_address)>0)
        @foreach($cont_address as $key=>$address_row)
          <option value="{{ $address_row['address_id'] }}" {{ (isset($client_details['serv_address']) && $client_details['serv_address'] == $address_row['address_id'])?"selected":""}}>{{ $address_row['fullAddress'] }}</option>
        @endforeach
      @endif
    </select>
  @endif
  </div>
<!-- <div class="form-group">
<label for="exampleInputPassword1">Address Line1</label>
<input type="text" id="serv_addr_line1" name="serv_addr_line1" value="{{ $client_details['serv_addr_line1']  or "" }}" class="form-control" />
</div>

<div class="form-group">
<label for="exampleInputPassword1">Address Line2</label>
<input type="text" id="serv_addr_line2" name="serv_addr_line2" value="{{ $client_details['serv_addr_line2']  or "" }}" class="form-control" />
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">City/Town</label>
<input type="text" id="serv_city" name="serv_city" value="{{ $client_details['serv_city']  or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">County</label>
<input type="text" id="serv_county" name="serv_county" value="{{ $client_details['serv_county']  or "" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postcode</label>
<input type="text" id="serv_postcode" name="serv_postcode" value="{{ $client_details['serv_postcode']  or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Country of Residence</label>
  <select class="form-control service_country" name="serv_country" id="serv_country">
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
        <option value="{{ $country_row->country_id }}" {{ (isset($client_details['serv_country']) && $country_row->country_id == $client_details['serv_country'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
        <option value="{{ $country_row->country_id }}" {{ (isset($client_details['serv_country']) && $country_row->country_id == $client_details['serv_country'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
<div class="clearfix"></div>
</div> -->


<div class="twobox">
<div class="twobox_40">
<div class="form-group">
<h3 class="box-title">Residential Address</h3>
</div>
</div>

<div class="twobox_40">
<div class="form-group">
<label for="exampleInputPassword1"></label>
  Copy Service address <input type="checkbox" name="res_service_same" id="res_service_same">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="form-group">

  
  <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="res" data-page_name="{{ $page_name }}">New</a> | 
@if($page_name == 'ind_client')
  <a javascript:void(0) class="editAddress" data-address_type="res" data-page_name="{{ $page_name }}">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="res">Delete</a> | 
@endif
   <a javascript:void(0) class="copyAddress" data-address_type="res">Copy</a>

   </label>

  <select class="form-control get_orgoldcont_address" id="res_address" name="res_address" data-type="res">
    <option value="">-- Select Address --</option>
    @if(isset($cont_address) && count($cont_address)>0)
      @foreach($cont_address as $key=>$address_row)
        <option value="{{ $address_row['address_id'] }}" {{ (isset($client_details['res_address']) && $client_details['res_address'] == $address_row['address_id'])?"selected":""}}>{{ $address_row['fullAddress'] }}</option>
      @endforeach
    @endif
  </select>
  </div>
<!-- <div class="form-group">
<label for="exampleInputPassword1">Address Line1</label>
<input type="text" id="res_addr_line1" name="res_addr_line1" value="{{ $client_details['res_addr_line1']  or "" }}" class="form-control" />

</div>

<div class="form-group">
<label for="exampleInputPassword1">Address Line2</label>
<input type="text" id="res_addr_line2" name="res_addr_line2" value="{{ $client_details['res_addr_line2']  or "" }}" class="form-control" />

</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">City/Town</label>
<input type="text" id="res_city" name="res_city" value="{{ $client_details['res_city']  or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">County</label>
<input type="text" id="res_county" name="res_county" value="{{ $client_details['res_county']  or "" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postcode</label>
<input type="text" id="res_postcode" name="res_postcode" value="{{ $client_details['res_postcode']  or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Country of Residence</label>
  <select class="form-control" name="res_country" id="res_country">
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
        <option value="{{ $country_row->country_id }}" {{ (isset($client_details['res_country']) && $country_row->country_id == $client_details['res_country'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
        <option value="{{ $country_row->country_id }}" {{ (isset($client_details['res_country']) && $country_row->country_id == $client_details['res_country'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
<div class="clearfix"></div>
</div> -->


<!-- <div class="form-group">

<div class="n_box01">
  <label for="exampleInputPassword1">Country Code</label>
  <input type="text" id="res_tele_code" value="{{ $client_details['res_tele_code']  or "" }}" name="res_tele_code" class="form-control" readonly />
</div>

<div class="telbox">
<label for="exampleInputPassword1">Telephone</label>
    <input type="text" id="res_telephone" name="res_telephone" value="{{ $client_details['res_telephone']  or "" }}" class="form-control"></div>
<div class="clearfix"></div>
</div>

<div class="form-group">

<div class="n_box01">
  <label for="exampleInputPassword1">Country Code</label>
  <input type="text" id="res_mobile_code" value="{{ $client_details['res_mobile_code']  or "" }}" name="res_mobile_code" class="form-control" readonly />

</div>
<div class="telbox">
<label for="exampleInputPassword1">Mobile</label>
    <input type="text" id="res_mobile" name="res_mobile" value="{{ $client_details['res_mobile']  or "" }}" class="form-control"></div>
<div class="clearfix"></div>
</div> -->
  <div class="twobox">
    <div class="twobox_1">
      <div class="form-group">
        <label for="exampleInputPassword1">Telephone</label>
        <input type="text" id="res_telephone" name="res_telephone" value="{{ $client_details['res_telephone']  or "" }}" class="form-control">
      </div>
    </div>
    <div class="twobox_2">
      <div class="form-group">
        <label for="exampleInputPassword1">Mobile</label>
        <input type="text" id="res_mobile" name="res_mobile" value="{{ $client_details['res_mobile']  or "" }}" class="form-control">
      </div>
    </div>
    <div class="clearfix"></div>
  </div>


<div class="form-group">
<label for="exampleInputPassword1">Email</label>
<input type="text" id="res_email" name="res_email" value="{{ $client_details['res_email']  or "" }}" class="form-control">
</div>

<div class="form-group">
<label for="exampleInputPassword1">Website</label>
<input type="text" id="res_website" name="res_website" value="{{ $client_details['res_website']  or "" }}" class="form-control">
</div>

<div class="form-group">
<label for="exampleInputPassword1">Skype</label>
<input type="text" id="res_skype" name="res_skype" value="{{ $client_details['res_skype']  or "" }}" class="form-control">
</div>


<!-- This portion is for user created field -->
@if(!empty($steps_fields_users) && count($steps_fields_users) > 0)
  @foreach($steps_fields_users as $row_fields)
    @if(!empty($row_fields->step_id) && $row_fields->step_id == "3")
      <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_fields->field_name)) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields->field_id }}"><img src="/img/cross.png" width="12"></a></label>
      @if(!empty($row_fields->field_type) && $row_fields->field_type == "1")
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" value="{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}</textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"checked":"" }}/>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"selected":"" }}>{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields->field_name)])?date('d-m-Y', strtotime($client_details[strtolower($row_fields->field_name)])):"" }}" name="{{ strtolower($row_fields->field_name) }}">
      @endif
     
     
      </div>

        <div class="clearfix"></div>
      </div>
    @endif
  @endforeach
@endif
<!-- This portion is for user created field -->

<!-- Sub Section portion is for user created field -->
@if(!empty($subsections) && count($subsections) > 0)
  @foreach($subsections as $row_section)
    @if(!empty($row_section['parent_id']) && $row_section['parent_id'] == "3")
    <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_section['title'])) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_section" data-step_id="{{ $row_section['step_id'] }}"><img src="/img/cross.png" width="12"></a></label>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="horizontal_line"></div>
    @if(isset($row_section['children']) && count($row_section['children']) >0 )
      @foreach($row_section['children'] as $row_fields)
        <div class="form-group">
          <div class="twobox_2">
          <label for="exampleInputPassword1">{{ ucwords($row_fields['field_name']) }} 
            &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields['field_id'] }}"><img src="/img/cross.png" width="12"></a></label>
          @if(isset($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" value="{{ isset($client_details[strtolower($row_fields['field_name'])])?$client_details[strtolower($row_fields['field_name'])]:"" }}" class="form-control">
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields['field_name'])])?$client_details[strtolower($row_fields['field_name'])]:"" }}</textarea>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" {{ isset($client_details[strtolower($row_fields['field_name'])])?"checked":"" }}/>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(isset($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}" {{ (isset($client_details[strtolower($row_fields['field_name'])]) && $client_details[strtolower($row_fields['field_name'])] == $value)?"selected":"" }}>{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(isset($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields['field_name'])])?date('d-m-Y', strtotime($client_details[strtolower($row_fields['field_name'])])):"" }}" name="{{ strtolower($row_fields['field_name']) }}">
          @endif
         
         
          </div>

          <div class="clearfix"></div>
        </div>
        @endforeach
      @endif
    @endif
  @endforeach
@endif
<!-- Sub Section portion is for user created field -->



<div class="add_client_btn">
  <button class="btn btn-info back" data-id="2" type="button">Prev</button>
  <button class="btn btn-danger" type="submit">Save</button>
  <button class="btn btn-info open" data-id="4" type="button">Next</button>
</div>
<div class="clearfix"></div>


                   </div>
 
                   </div>
                   
                    </div>
                      
                    </div>
                  </div>
                </div>
         
        <div id="step4" class="tab-pane" style="display:none;">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      
                      <div class="row">  
                    
                   <div class="col-xs-12">
 <div class="col_m2"> 
 <div class="director_table"> 
<h3 class="box-title">RELATIONSHIPS</h3>      
@if(isset($user_type) && $user_type != "C")
    <div class="j_selectbox">
    <span>ADD NEW ENTITY</span>
    <div class="select_icon" id="select_icon"></div>
    <div class="clr"></div>
    <div class="open_toggle">
      <ul>
        <li data-value="non">NON - CLIENT</li>
        <li data-value="org">CLIENT - ORG</li>
        <li data-value="ind">CLIENT - IND</li>
      </ul>
    </div>
    </div>
@endif

<!-- <div class="form-group">
  <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> New Relationship</a> &nbsp <a href="/organisation/add-client" class="btn btn-info" target="_blank"><i class="fa fa-plus"></i> New Client - Organ</a>
</div> -->

<div class="box-body table-responsive">
<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
<input type="hidden" id="app_hidd_array" name="app_hidd_array" value="">
<input type="hidden" id="search_client_type" name="search_client_type" value="org">

<table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
  <tr>
    <td width="40%"><strong>Name</strong></td>
    <td width="40%" align="center"><strong>Relationship Type</strong></td>
    @if(isset($user_type) && $user_type != "C")
    <td width="20%" align="center"><strong>Action</strong></td>
    @endif
  </tr>

  @if(isset($relationship) && count($relationship) >0 )
    @foreach($relationship as $key=>$relation_row)
      <tr id="database_tr{{ $relation_row['client_relationship_id'] }}">
        <td width="40%">
          @if((isset($relation_row['type']) && $relation_row['type'] == "non") || (isset($relation_row['is_archive']) && $relation_row['is_archive'] == "Y") || (isset($relation_row['is_deleted']) && $relation_row['is_deleted'] == "Y") || isset($user_type) && $user_type == "C" )
            {{ $relation_row['name'] or "" }}
          @else
            <a href="{{ $relation_row['link'] or "" }}" target="_blank">{{ $relation_row['name'] or "" }}</a>
          @endif

        </td>
        <td width="40%" align="center">{{ $relation_row['relation_type'] }}</td>
        @if(isset($user_type) && $user_type != "C")
        <td width="20%" align="center">
          <a href="javascript:void(0)" data-link="{{ $relation_row['link'] or "" }}" class="delete_database_rel" data-rel_client_id="{{ $relation_row['client_id'] or "" }}" data-delete_index="{{ $relation_row['client_relationship_id'] }}"><img src="/img/cross.png" height="15"></a>
        </td>
        @endif
      </tr>
    @endforeach
  @endif

</table>

  <div class="contain_tab4" id="new_relationship" style="display:none;">
      <div class="contain_search" id="client_dropdown">
        <select class="form-control" name="rel_client_id" id="rel_client_id">
        @if(isset($allClients) && count($allClients)>0)
          @foreach($allClients as $key=>$client_row)
          <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
          @endforeach
        @endif    
        </select>
      </div>

      <div class="contain_type">
        <select class="form-control" name="rel_type_id" id="rel_type_id">
            @if(!empty($rel_types))
              @foreach($rel_types as $key=>$rel_row)
              <option value="{{ $rel_row->relation_type_id }}">{{ $rel_row->relation_type }}</option>
              @endforeach
            @endif
          </select>
      </div>

      <div class="contain_action"><button class="btn btn-success" data-client_type="org" onClick="saveRelationship('add_org')" type="button">Add</button>
      <button class="btn btn-danger" type="button" onClick="hide_relationship_div()">Cancel</button>
      </div>
    </div>

    <div class="clearfix"></div>
    


</div>
</div>

@if(isset($user_type) && $user_type != "C")
  <div style="margin-top: 10px;">
    <button type="button"  onClick="show_div()" class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>
  </div>
@endif
<!-- <div class="box-body table-responsive" style="width:50%;">
  <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
    <div class="row"><div class="col-xs-6"><h3>CLIENT (ACTING)</h3></div><div class="clearfix"></div></div>
    <input type="hidden" id="acting_hidd_array" name="acting_hidd_array" value="">
    <input type="hidden" id="relation_index" name="relation_index" value="">
  <table width="100%" class="table table-bordered table-hover dataTable" id="myActTable">
    <tr>
      <td width="32%"><strong>Name</strong></td>
      <td width="18%" align="center"><strong>Action</strong></td>
    </tr>

    @if(isset($acting) && count($acting) >0 )
    @foreach($acting as $key=>$acting_row)
      <tr id="database_acting_tr{{ $acting_row['acting_id'] }}">
        <td width="32%"><strong><a href="{{ $acting_row['link'] }}" target="_blank">{{ $acting_row['name'] }}</a></strong></td>
        <td width="18%" align="center">
          <a href="javascript:void(0)" class="edit_database_acting" data-edit_index="{{ $acting_row['acting_id'] }}" data-acting_client_id="{{ $acting_row['acting_client_id'] }}" data-link="{{ $acting_row['link'] }}"><i class="fa fa-edit"></i></a>
          <a href="javascript:void(0)" class="delete_database_acting" data-acting_client_id="{{ $acting_row['acting_client_id'] }}" data-delete_index="{{ $acting_row['acting_id'] }}"><img src="/img/cross.png" height="15"></a>
        </td>
      </tr>
    @endforeach
  @endif

  </table>

    <div class="contain_tab4" id="new_relationship_acting" style="display:none;">
      <div class="acting_select">
        <select class="form-control" name="acting_client_id" id="acting_client_id">
         @if(isset($relationship) && count($relationship) >0 )
            @foreach($relationship as $key=>$relation_row)
              @if (!in_array($relation_row['client_id'], $acting_dropdown))
                <option value="{{ $relation_row['client_id'] }}">{{ $relation_row['name'] }}</option>
              @endif
            @endforeach
          @endif
        </select>
      </div>

      <div class="contain_action"><button class="btn btn-success" data-client_type="org" onClick="saveActing('by_click', 'add_acting')" type="button">Add</button>&nbsp;&nbsp;<button class="btn btn-danger close_acting" data-client_type="org"  type="button">Cancel</button>
      </div>
    </div>
      
      <div class="clearfix"></div>

  </div>
</div>

<div style="margin-top: 10px;">
  <button type="button" class="addnew_line open_acting"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>
</div> -->

<div class="add_client_btn">
  <button class="btn btn-info back" data-id="3" type="button">Prev</button>
  <button class="btn btn-danger" type="submit">Save</button>
  <button class="btn btn-info open" data-id="5" type="button">Next</button>

</div>
<div class="clearfix"></div>
</div>
</div>
                   
                   
                   </div>
                   

                  
                    </div>
                      
                    </div>
                  </div>
                </div>

  <div id="step5" class="tab-pane" style="display:none;">
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
        
        <div class="row">  
          <div class="col-xs-12 col-xs-6">
            <div class="col_m2"> 
              <div class="other_table"> 

            @if(isset($user_type) && $user_type != "C")
              <div id="show_other_user_client" style="display:none">
                <div class="form-group">
                  <label for="exampleInputPassword1">Please send invitations from the Manage User section under settings</label>
                </div>

                <table width="100%" class="table table-bordered table-hover dataTable" id="myOtherTable">
                <tr>
                  <td align="center"><strong>Related Organisations</strong></td>
                  <td align="center"><strong>Status</strong></td>
                  <td align="center"><strong>Action</strong></td>
                </tr>
              @if(isset($user_id) && $user_id != "")
                <tr id="other_action_tr">
                  <td align="center"><a href="#" data-target="#relation_client-modal" data-toggle="modal">View</a></td>
                  <td align="center"><a href="javascript:void(0)" data-user_id="{{ $user_id or "" }}" data-client_id="{{ $client_id or "" }}" class="active_t" data-status="A" id="client_user_status">Active</a></td>
                  <td align="center"><a href="javascript:void(0)" data-user_id="{{ $user_id or "" }}" data-client_id="{{ $client_id or "" }}" class="delete_invited_client"><img src="/img/cross.png" height="15"></a></td>
                </tr>
              @endif
                </table>
              </div>

              <div class="twobox">

              @if(isset($user_type) && $user_type != "C")
              <div>
                <div class="form-group">
                  <label style="width: 120px!important;">AML Checks Done</label>
                  <input type="checkbox" name="aml_checks" value="1" {{ (isset($client_details['aml_checks']) && $client_details['aml_checks'] == "1")?"checked":"" }} />
                </div>
              </div>

              <!-- <div class="twobox_02">
              <div class="form-group">
              <label for="exampleInputPassword1">Acting?</label>
              <input type="checkbox" name="acting" value="1" {{ (isset($client_details['acting']) && $client_details['acting'] == "1")?"checked":"" }} />
              </div>
              </div> -->
              @endif

              <div class="clearfix"></div>
              </div>

              <table width="100%" border="0">
                <tbody>
                  <tr>
                    <td width="45%"><button class="btn btn-danger">Download Passport &amp; Utility docs</button></td>
                    
                    @if(isset($files['passport1']) && $files['passport1'] != "")
                    <td width="22%">
                      <span class="btn btn-default btn-file"><a href="/uploads/passports/{{ $files['passport1'] }}" download="{{ $files['passport1'] }}">Download</a></span>
                    </td>
                    <td>{{ $files['passport1'] }}</td>
                    @else
                      <td width="22%">
                        <span class="btn btn-default btn-file">Download</span>
                      </td>
                      <td>&nbsp;</td>
                    @endif
                      
                    </td>
                    <td>&nbsp;</td>
                  </tr>
    
                  <tr>
                    <td>&nbsp;</td>
                    @if(isset($files['passport2']) && $files['passport2'] != "")
                    <td>
                      <span class="btn btn-default btn-file"><a href="/uploads/passports/{{ $files['passport2'] }}" download="{{ $files['passport2'] }}">Download</a></span>
                    </td>
                    <td>{{ $files['passport2'] }}</td>
                    @else
                      <td>
                        <span class="btn btn-default btn-file">Download</span>
                      </td>
                      <td>&nbsp;</td>
                    @endif
                    
                  </tr>
                  <tr>
                    <td><button class="btn btn-success">Other Documents</button></td>
                    @if(isset($files['document1']) && $files['document1'] != "")
                      <td>
                        <span class="btn btn-default btn-file"><a href="/uploads/documents/{{ $files['document1'] }}" download="{{ $files['document1'] }}">Download</a></span>
                      </td>
                      <td>{{ $files['document1'] }}</td>
                    @else
                      <td>
                        <span class="btn btn-default btn-file">Download</span>
                      </td>
                      <td>&nbsp;</td>
                    @endif
                    
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    @if(isset($files['document2']) && $files['document2'] != "")
                      <td>
                        <span class="btn btn-default btn-file"><a href="/uploads/documents/{{ $files['document2'] }}" download="{{ $files['document2'] }}">Download</a></span>
                      </td>
                      <td>{{ $files['document2'] }}</td>
                    @else
                      <td>
                        <span class="btn btn-default btn-file">Download</span>
                      </td>
                      <td>&nbsp;</td>
                    @endif
                    
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>

  <div class="other_table">
    <!-- <h3 class="box-title">Services <a href="#" class="add_to_list" data-toggle="modal" data-target="#services-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef; font-size: 19px;"></i></a></h3>
      <div class="clearfix"></div> -->

      <div class="form-group">
        <table class="table table-bordered table-hover myServTable" id="myServTable" class="myServTable" width="100%">
      <thead>
        <tr>
          <td width="4%"><input type="checkbox" id="AllCkeck"></td>
          <td width="56%">
            <div style="float: left; font-size: 17px; font-weight: bold">Services</div>
            <div style="float: right;">
              <a href="#" class="add_to_list" data-toggle="modal" data-target="#services-modal"><i class="fa fa-cog fa-fw settings_icon"></i></a>
            </div>
          </td>
          <td width="40%" colspan="2">
            <div style="float: left; font-size: 17px; font-weight: bold">Staff</div>
            <div style="float: left; margin-left: 4px; padding-top: 4px"><a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
          </td>
        </tr>
      </thead>

      <tbody>
        @if( isset($allServices) && count($allServices)>0 )
          @foreach($allServices as $key=>$service_row)
            @if(isset($service_row['added_from']) && $service_row['added_from'] != 'timesheet')
            <tr id="hide_service_tr_{{ $service_row['service_id'] }}">
              <td align="center"><span class="custom_chk"><input type="checkbox" class="serviceCheck" value="{{ $service_row['service_id'] }}" data-service_id="{{ $service_row['service_id'] }}" data-client_id="{{ $client_details['client_id'] }}" name="other_services[]" {{ (isset($services_id) && in_array($service_row['service_id'], $services_id))?"checked":"" }} /></span></td>
              <td><strong>{{ $service_row['service_name'] }}</strong></td>
              <td width="30%" class="{{$client_details['client_id']}}_staff_table_drop_{{$service_row['service_id']}}">
              @if(isset($service_row['allocated_staffs']) && count($service_row['allocated_staffs']) >0)
                <select class="form-control newdropdown {{ (isset($services_id) && in_array($service_row['service_id'], $services_id))?'':'disable_click' }}" id="staff_dropdown_{{ $service_row['service_id'] }}">
                <!-- table_select staff_dropdown-->
                  @foreach($service_row['allocated_staffs'] as $key=>$staff_row)
                    <option value="{{ $staff_row['staff_id'] or "" }}">{{ $staff_row['staff_name'] or "" }}</option>
                  @endforeach
                </select>
              @endif
              </td>

              <td width="10%" align="center" id="service_edit_td_{{ $service_row['service_id'] }}"><a href="javascript:void(0)" class="openAllocation openAllocation_{{ $client_details['client_id'] }} {{ (isset($services_id) && in_array($service_row['service_id'], $services_id))?'':'disable_click' }}" data-client_id="{{ $client_details['client_id'] }}" data-service_id="{{ $service_row['service_id'] or '0'}}" data-page_name="edit_ind_form">Edit</a></td>

              <!-- <td width="10%" align="center" id="service_edit_td_{{ $service_row['service_id'] }}">
                <a href="javascript:void(0);" class="openServicesStaff {{ (isset($services_id) && in_array($service_row['service_id'], $services_id))?'':'disable_click' }}" data-service_id="{{ $service_row['service_id'] }}" data-client_id="{{ $client_details['client_id'] }}" data-service_name="{{ $service_row['service_name']}}" data-client_name="{{$client_details['client_name'] or ""}}"  data-page="edit_client" data-client_type="ind">Edit</a>
              </td> -->
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>

        <!-- <table width="100%" id="myServTable" class="myServTable">
          <tbody>
            @if( isset($old_services) && count($old_services)>0 )
              @foreach($old_services as $key=>$service_row)
                <tr>
                  <td align="center" width="40%"><span class="custom_chk"><input type='checkbox' name='other_services[]' value='{{ $service_row->service_id }}' {{ (isset($services_id) && in_array($service_row->service_id, $services_id))?"checked":"" }} /><strong>{{ $service_row->service_name }}</strong></span></td>
                  <td align="center" width="60%"></td>
                </tr>
              @endforeach
            @endif

            @if( isset($new_services) && count($new_services)>0 )
              @foreach($new_services as $key=>$service_row)
            <tr id="hide_service_tr_{{ $service_row->service_id }}">
              <td align="center" width="40%"><span class="custom_chk"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" {{(isset($services_id) && in_array($service_row->service_id,$services_id))?"checked":"" }}/><strong>{{ $service_row->service_name }}</strong></span></td>
              
              <td width="60%"><a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a></td>
            </tr>
              @endforeach
            @endif

          </tbody>
        </table> -->
      </div>
    
    <div class="clearfix"></div>
  </div>

@else

  <!-- <div class="form-group">
    <strong>Download form 64-8(Agent Authorisation)</strong>
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Tax Return Required</label>
    <input type="checkbox" name="ptr" value="10" {{ (isset($client_details['other_services']) && in_array(10, unserialize($client_details['other_services'])))?"checked":"" }} />
  </div> -->


  <!-- <div class="twobox_03">
    <div class="form-group">
      <select class="form-control">
        <option value="">-- Select Business Name --</option>
        @if(isset($relation_list) && count($relation_list) >0 )
          @foreach($relation_list as $key=>$relation_row)
            @if(isset($relation_row['status']) && $relation_row['status'] == "I" )
              <option value="{{ $relation_row['client_id'] or "" }}">{{ $relation_row['client_name'] or "" }}</option>
            @endif
          @endforeach
        @endif
      </select>
    </div>
  </div> -->



  <!-- <div class="form-group">
    <div class="other_left_sec">
      <label for="exampleInputPassword1">Select Service</label>
      <table width="100%" class="table table-bordered" style="margin-bottom: 0px;">
        <tbody><tr>
          <td><strong>Name</strong></td>
          <td align="center"><strong>SA/NI</strong></td>
          <td align="center"><strong>TC</strong></td>
          <td align="center"><strong>CT</strong></td>
          <td align="center"><strong>PAYE</strong></td>
        </tr>
        <tr>
          <td><input type="checkbox"></td>
          <td align="center"><input type="checkbox"></td>
          <td align="center"><input type="checkbox"></td>
          <td align="center"><input type="checkbox"></td>
          <td align="center"><input type="checkbox"></td>
        </tr>
      </tbody></table>
    </div>
    <div class="clearfix"></div>
  </div> -->

  <!-- <div class="form-group">
    <div class="download_pdf">
      <button class="btn download_icon"></button>
    </div>
    <div class="clearfix"></div>
  </div> -->

  <div class="form-group">
    <table width="100%" border="0" id="other_upload_table">
      <tbody>
        <tr>
          <td width="45%">
            <button class="btn btn-danger">Upload Passport &amp; Utility docs</button>
          </td>
          <td width="22%">
              <span class="btn btn-default btn-file"> Upload
                  <input type="file" class="upload_file" name="passport1"  id="passport1">
               </span>
          </td>
          <td id="apassport1">
            @if(isset($files['passport1']) && $files['passport1'] != "")
            {{ $files['passport1'] }} <a href="javascript:void(0)" data-id="{{ $files['client_file_id'] }}" data-column="passport1" data-path="uploads/passports/" class="delete_files"><img src="/img/cross.png" height="12"></a>
            @endif
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><span class="btn btn-default btn-file"> Upload
            <input type="file" class="upload_file" name="passport2" id="passport2">
            </span></td>
          <td id="apassport2">
            @if(isset($files['passport2']) && $files['passport2'] != "")
              {{ $files['passport2'] }} <a href="javascript:void(0)" data-id="{{ $files['client_file_id'] }}" data-column="passport2" data-path="uploads/passports/" class="delete_files"><img src="/img/cross.png" height="12"></a>
            @endif
          </td>
        </tr>
        <tr>
          <td><button class="btn btn-success">Other Documents</button></td>
          <td><span class="btn btn-default btn-file"> Upload
            <input type="file" class="upload_file" name="document1" id="document1">
            </span></td>
          <td id="adocument1">
            @if(isset($files['document1']) && $files['document1'] != "")
              {{ $files['document1'] }} <a href="javascript:void(0)" data-id="{{ $files['client_file_id'] }}" data-column="document1" data-path="uploads/documents/" class="delete_files"><img src="/img/cross.png" height="12"></a>
            @endif
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><span class="btn btn-default btn-file"> Upload
            <input type="file" class="upload_file" name="document2" id="document2">
            </span></td>
          <td id="adocument2">
            @if(isset($files['document2']) && $files['document2'] != "")
              {{ $files['document2'] }} <a href="javascript:void(0)" data-id="{{ $files['client_file_id'] }}" data-column="document2" data-path="uploads/documents/" class="delete_files"><img src="/img/cross.png" height="12"></a>
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>

  <!-- <div style="height: 1px; width: 100%; background: #00c0ef; margin-bottom: 10px;"></div>

  <div class="form-group">
    <strong>Download form 64-8(Agent Authorisation)</strong>
  </div>
  <div class="form-group">
    <select class="form-control clientdetails" name="client_id" id="tab1_client" style="width: 50%;">
      <option value="">-- Select Business Name --</option>
      @if(isset($relation_list) && count($relation_list) >0 )
        @foreach($relation_list as $key=>$relation_row)
          @if(isset($relation_row['status']) && $relation_row['status'] == "I" )
            <option value="{{ $relation_row['client_id'] or "" }}">{{ $relation_row['client_name'] or "" }}</option>
          @endif
        @endforeach
      @endif
    </select>
  </div>

  <div class="form-group" style="width: 50%;">
    <select class="form-control resperson" name="responsible_person" id="responsibleperson">
      <option value="">-- Select Business Name --</option>
    </select>
  </div>

  <div class="form-group">
    <strong>Select Service</strong>
  </div>

  <div class="form-group">
    <table width="100%" style="margin-bottom: 0px;">
      <tbody>
        <tr>
          <td style="width: 40%">Tax Return Required</td>
          <td><input type="checkbox" class="selfassessmentclass" name="selfassessmentid" id="selfassessmentid" /></td>
        </tr>
        <tr>
          <td>Tax Credits</td>
          <td><input id="tax_credits" type="checkbox" name="tax_credits"/></td>
        </tr>
        <tr>
          <td>Corporation Tax</td>
          <td><input type="checkbox" name="corporation_tax" /></td>
        </tr>
        <tr>
          <td>PAYE Scheme</td>
          <td><input type="checkbox" name="paye_scheme" /></td>
        </tr>
        <tr>
          <td>VAT</td>
          <td><input type="checkbox" name="vat"/></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="form-group">
    <button class="btn btn-success">Download form 64-8</button>
  </div> -->
  <div class="form-group">
    <a href="/generate-form/{{$client_id}}" class="btn btn-success" target="_blank">GENERATE FORM 64-8</a>
  </div>

@endif




<div class="clearfix"></div>

</div>


<!-- This portion is for user created field -->
@if(!empty($steps_fields_users) && count($steps_fields_users) > 0)
  @foreach($steps_fields_users as $row_fields)
    @if(!empty($row_fields->step_id) && $row_fields->step_id == "5")
      <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_fields->field_name)) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields->field_id }}"><img src="/img/cross.png" width="12"></a></label>
      @if(!empty($row_fields->field_type) && $row_fields->field_type == "1")
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" value="{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}</textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"checked":"" }}/>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"selected":"" }}>{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields->field_name)])?date('d-m-Y', strtotime($client_details[strtolower($row_fields->field_name)])):"" }}" name="{{ strtolower($row_fields->field_name) }}">
      @endif
     
     
      </div>

        <div class="clearfix"></div>
      </div>
    @endif
  @endforeach
@endif
<!-- This portion is for user created field -->

<!-- Sub Section portion is for user created field -->
@if(!empty($subsections) && count($subsections) > 0)
  @foreach($subsections as $row_section)
    @if(!empty($row_section['parent_id']) && $row_section['parent_id'] == "5")
    <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_section['title'])) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_section" data-step_id="{{ $row_section['step_id'] }}"><img src="/img/cross.png" width="12"></a></label>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="horizontal_line"></div>
    @if(isset($row_section['children']) && count($row_section['children']) >0 )
      @foreach($row_section['children'] as $row_fields)
        <div class="form-group">
          <div class="twobox_2">
          <label for="exampleInputPassword1">{{ ucwords($row_fields['field_name']) }} 
            &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields['field_id'] }}"><img src="/img/cross.png" width="12"></a></label>
          @if(!empty($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields->field_name) }}" value="{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}" class="form-control">
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39">{{ isset($client_details[strtolower($row_fields->field_name)])?$client_details[strtolower($row_fields->field_name)]:"" }}</textarea>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"checked":"" }}/>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(!empty($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}" {{ isset($client_details[strtolower($row_fields->field_name)])?"selected":"" }}>{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date" value="{{ isset($client_details[strtolower($row_fields->field_name)])?date('d-m-Y', strtotime($client_details[strtolower($row_fields->field_name)])):"" }}" name="{{ strtolower($row_fields->field_name) }}">
          @endif
         
         
          </div>

          <div class="clearfix"></div>
        </div>
        @endforeach
      @endif
    @endif
  @endforeach
@endif
<!-- Sub Section portion is for user created field -->



<div class="add_client_btn">
<!-- <button class="btn btn-info">Next</button> -->
<button class="btn btn-info back" data-id="4" type="button">Prev</button>
<button class="btn btn-danger save" type="submit">Save</button>

</div>
<div class="clearfix"></div>
</div>
                   
                   
     </div>
     

    
      </div>
        
      </div>
    </div>
  </div><!--step5 end-->

  <div id="step6" class="tab-pane" style="display: none;">
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">  
          <div class="col-xs-12">
            <div class="col_m2"> 

              @include('home.include.billing_fees')


            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- step6-->
       

</div>
          </div>
          



            
          </div>
        
    



      </div>
    </section>

{{ Form::close() }}

                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->



<!-- COMPOSE MESSAGE MODAL -->
<!-- <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW FIELD</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/individual/save-userdefined-field', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="ind" />
    <input type="hidden" name="back_url" value="edit_ind" />
    <input type="hidden" name="client_id" value="{{ $client_details['client_id'] }}" />
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputPassword1">Select Section</label>
          <select class="form-control show_subsec" name="step_id" id="step_id" data-client_type="ind">
            @if( isset($steps) && count($steps) >0 )
              @foreach($steps as $key=>$step_row)
                @if($step_row->step_id != '4' && $step_row->status == "old")
                  <option value="{{ $step_row->step_id }}">{{ $step_row->title }}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Subsection Name</label>
          <select class="form-control subsec_change" name="substep_id" id="substep_id">
            <option value="">-- Select sub section --</option>
            @if( isset($substep) && count($substep) >0 )
              @foreach($substep as $key=>$substep_row)
                <option value="{{ $substep_row['step_id'] }}">{{ $substep_row['title'] }}</option>
              @endforeach
            @endif
            <option value="new">Add new ...</option>
          </select>
        </div>
        <div class="input-group show_new_div" style="display:none;">
            <input type="text" class="form-control" name="subsec_name" id="subsec_name">
           <span class="input-group-addon"> <a href="javascript:void(0)" class="add_subsec_name" data-client_type="ind">Save</a></span>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Field Name</label>
          <input type="text" id="field_name" name="field_name" class="form-control">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Field Type</label>
          <select class="form-control user_field_type" name="field_type" id="field_type">
            @if(!empty($field_types))
              @foreach($field_types as $key=>$field_row)
                <option value="{{ $field_row->field_type_id }}">{{ $field_row->field_type_name }}</option>
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group" style="display:none;" id="show_select_option">
          <label for="exampleInputPassword1">Options</label>
          <textarea name="select_option" cols="40" rows="3"></textarea>
          Give options width ',' separator
        </div>
        
        <div class="modal-footer1 clearfix">
          <div class="email_btns1">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary pull-left save_text" name="save">Save</button>
          </div>
        </div>
      </div>
    {{ Form::close() }}
  </div>
    /.modal-content
  </div>
  /.modal-dialog
</div>


Relationship Add To List Modal Start
<div class="modal fade" id="add_to_list-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:404px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div id="add_to_msg_div" style="text-align: center; color: #00acd6"></div>
        <div class="form-group" style="width:70%">
          <label for="name">Type</label>
          <select class="form-control" name="add_to_type" id="add_to_type">
            <option value="ind">Individual</option>
            <option value="org">Organisation</option>
          </select>
        </div>

        <div class="form-group" id="add_to_client_text">

<div class="clearfix"></div>
<div class="n_box18_18">
<label for="exampleInputPassword1">Title</label>
<select class="form-control select_title" id="add_to_title" name="add_to_title">
          <option value="Mr" selected="">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Miss">Miss</option>
        <option value="Dr">Dr</option>
        <option value="Professor">Professor</option>
        <option value="Rev">Rev</option>
        <option value="Sir">Sir</option>
        <option value="Dame">Dame</option>
        <option value="Lord">Lord</option>
        <option value="Lady">Lady</option>
        <option value="Captain">Captain</option>
        <option value="The Hon">The Hon</option>
        <option value="Other">Other</option>
      </select></div>
<div class="n_box27_27">
    <label for="exampleInputPassword1">First Name</label>
    <input type="text" id="add_to_fname" name="add_to_fname" value="" class="form-control toUpperCase"></div>
<div class="n_box22_22">
    <label for="exampleInputPassword1">Middle Name</label>
    <input type="text" id="add_to_mname" name="add_to_mname" value="" class="form-control toUpperCase"></div>
<div class="n_box27_27">
    <label for="exampleInputPassword1">Last Name</label>
    <input type="text" id="add_to_lname" name="add_to_lname" value="" class="form-control toUpperCase"></div>
<div class="clearfix"></div>
</div>

        <div class="form-group" style="width:70%; display:none;" id="add_to_business">
          <label for="name">Business Name</label>
          <input class="form-control toUpperCase" type="text" name="add_to_name" id="add_to_name">
        </div>
       
        <div class="modal-footer1 clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-primary pull-left save_t relation_add_client" id="add_to_save" name="save">Save</button>
            <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
      
    </div>
    /.modal-content
  </div>
  /.modal-dialog
</div> -->
<!-- Relationship Add To List Modal End-->

@include("home.include.client_modal_page")

@include("home.include.services_modal")

@include("settings.include.allocation_modal")

@include("crm.proposal.modal.modal")
@stop