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
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script>
$(document).ready(function(){
    $("#dob").datepicker({minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+0"});
    $(".app_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });
    $("#spouse_dob").datepicker({ minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });

    $(".user_added_date").datepicker({ minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });

});

</script>
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>

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
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

    <!-- Main content -->
    {{ Form::open(array('url' => '/individual/insert-client-details', 'files' => true, 'id'=>'basicform')) }}
    <input name="client_id" id="client_id" type="hidden" value="new">
    <section class="content">

      <div class="row">
        <div class="top_bts">
          <ul>
            <!-- <li>
              <button class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            </li>
            <li>
              <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
            </li>
            <li>
              <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
            </li>
            <li>
              <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
            </li>
            <li>
              <button class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
            </li>
            <li>
              <button class="btn btn-success">IMPORT FROM CSV</button>
            </li> -->
            <!-- <li>
              <button class="btn btn-primary">REQUEST FROM CLIENT</button>
            </li>
            <li>
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
         
        <li><a href="#" class=" btn-block btn-primary " data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field
         
        </a></li>
        
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
                
<div class="form-group">

<div class="n_box1">
<label for="exampleInputPassword1">Client Code</label>
  <input type="text" id="client_code" name="client_code" class="form-control toUpperCase"></div>
</div>

<div class="form-group">

<div class="clearfix"></div>
<div class="n_box1">
<label for="exampleInputPassword1">Title</label>
<select class="form-control select_title" id="title" name="title">
  @if(!empty($titles))
    @foreach($titles as $key=>$title_row)
    <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
    @endforeach
  @endif
</select></div>
<div class="n_box2">
    <label for="exampleInputPassword1">First Name</label>
    <input type="text" id="fname" name="fname" class="form-control toUpperCase"></div>
<div class="n_box3">
    <label for="exampleInputPassword1">Middle Name</label>
    <input type="text" id="mname" name="mname" class="form-control"></div>
<div class="n_box4">
    <label for="exampleInputPassword1">Last Name</label>
    <input type="text" id="lname" name="lname" class="form-control toUpperCase"></div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Gender</label>
<select class="form-control" name="gender" id="gender">
  <option value="Male">Male</option>
  <option value="Female">Female</option>
</select>
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Date of Birth</label>
<input type="text" id="dob" name="dob" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Marital Status</label>
<select class="form-control" name="marital_status" id="marital_status">
  @if(!empty($marital_status))
    @foreach($marital_status as $key=>$status_row)
    <option value="{{ $status_row->merital_status_id }}">{{ $status_row->status_name }}</option>
    @endforeach
  @endif
</select>
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Spouse Date of Birth</label>
<input type="text" id="spouse_dob" name="spouse_dob" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Country</label>
<select class="form-control" name="country_id" id="country_id">
@if(!empty($countries))
  @foreach($countries as $key=>$country_row)
  @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
    <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
  @endif
  @endforeach
@endif
@if(!empty($countries))
  @foreach($countries as $key=>$country_row)
  @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
    <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
  @endif
  @endforeach
@endif
</select>
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Occupation</label>
<input type="text" id="occupation" name="occupation" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Nationality</label>
<select class="form-control" name="nationality_id" id="nationality_id">
@if(!empty($nationalities))
  @foreach($nationalities as $key=>$nationality_row)
    <option value="{{ $nationality_row->nationality_id }}">{{ $nationality_row->nationality_name }}</option>
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
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39"></textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" />
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" name="{{ strtolower($row_fields->field_name) }}">
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
          @if(!empty($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" class="form-control">
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39"></textarea>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" />
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(!empty($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date" name="{{ strtolower($row_fields['field_name']) }}">
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
                  <!-- <button class="btn btn-danger back" data-id="1" type="button">Prev</button> -->
                  <button class="btn btn-danger" type="submit">Save</button>
                  <button class="btn btn-info open" data-id="2" type="button">Next</button>
                </div>
                <div class="clearfix"></div>
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
<input type="text" id="ni_number" name="ni_number" class="form-control">

</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Tax Reference</label>
<input type="text" id="tax_reference" name="tax_reference" class="form-control">
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
  @if(!empty($tax_office))
    @foreach($tax_office as $key=>$office_row)
      @if($office_row->parent_id == 0)
        <option value="{{ $office_row->office_id }}">{{ $office_row->office_name }}</option>
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
<textarea id="tax_address" name="tax_address" class="form-control" rows="3">{{ $tax_office_by_id->address  or "" }}</textarea>

</div>


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postal/Zip Code</label>
<input type="text" id="tax_zipcode" name="tax_zipcode" value="{{ $tax_office_by_id->zipcode  or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Telephone</label>
<input type="text" id="tax_telephone" name="tax_telephone" value="{{ $tax_office_by_id->telephone  or "" }}" class="form-control">
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
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39"></textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" />
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" name="{{ strtolower($row_fields->field_name) }}">
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
          @if(!empty($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" class="form-control">
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39"></textarea>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" />
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(!empty($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date"  name="{{ strtolower($row_fields['field_name']) }}">
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
  <button class="btn btn-info open"data-id="3" type="button">Next</button>
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
                        <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="serv">New</a> | <a javascript:void(0) class="editAddress" data-address_type="serv">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="serv">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="serv">Copy</a></label>
                        <select class="form-control get_orgoldcont_address" id="serv_address" name="serv_address" data-type="serv">
                          <option value="">-- Select Address --</option>
                          @if(isset($cont_address) && count($cont_address)>0)
                            @foreach($cont_address as $key=>$address_row)
                              <option value="{{ $address_row['address_id'] }}" {{ (isset($client_details['serv_address']) && $client_details['serv_address'] == $address_row['address_id'])?"selected":""}}>{{ $address_row['fullAddress'] }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>

<!-- <div class="form-group">
  <label for="exampleInputPassword1">Select or Add</label>
   <select class="form-control get_oldcont_address" id="get_oldserv_address" data-type="serv">
    <option value="">-- Select Address --</option>
    
    @if(!empty($cont_address))
        @foreach($cont_address as $key=>$address_row)
            @if (isset($address_row['serv_addr_line1']) && $address_row['serv_addr_line1'] !="")
              <option value="{{ $address_row['client_id'] }}_serv"> {{ $address_row['serv_addr_line1'] }}</option>
           @endif
           @if (isset($address_row['res_addr_line1']) && $address_row['res_addr_line1'] !="")
                <option value="{{ $address_row['client_id'] }}_res"> {{ $address_row['res_addr_line1'] }}</option>
           @endif
        @endforeach
     @endif
        
    </select>
</div> -->

<!-- <div class="form-group">
<label for="exampleInputPassword1">Address Line1</label>
<input type="text" id="serv_addr_line1" name="serv_addr_line1" class="form-control" />
</div>

<div class="form-group">
<label for="exampleInputPassword1">Address Line2</label>
<input type="text" id="serv_addr_line2" name="serv_addr_line2" class="form-control" />
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">City/Town</label>
<input type="text" id="serv_city" name="serv_city" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">County</label>
<input type="text" id="serv_county" name="serv_county" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postcode</label>
<input type="text" id="serv_postcode" name="serv_postcode" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Country</label>
  <select class="form-control service_country" name="serv_country" id="serv_country">
 
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
        <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
        <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
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

<!-- <div class="form-group">
  <label for="exampleInputPassword1">Select or Add</label>
   <select class="form-control get_oldcont_address" id="get_oldres_address" data-type="res">
      <option value="">-- Select Address --</option>
      
      @if( isset($cont_address) )
        @foreach($cont_address as $key=>$address_row)
          @if (isset($address_row['serv_addr_line1']) && $address_row['serv_addr_line1'] !="")
            <option value="{{ $address_row['client_id'] }}_serv">{{$address_row['serv_addr_line1']}}</option>
          @endif
          @if(isset($address_row['res_addr_line1']) && $address_row['res_addr_line1'] !="")
            <option value="{{ $address_row['client_id'] }}_res">{{ $address_row['res_addr_line1'] }}</option>
          @endif
           
        @endforeach
       @endif
       
   </select>
</div> -->

<div class="form-group">
  <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="res">New</a> | <a javascript:void(0) class="editAddress" data-address_type="res">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="res">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="res">Copy</a></label>
  <select class="form-control get_orgoldcont_address" id="res_address" name="res_address" data-type="res">
    <option value="">-- Select Address --</option>
    @if(isset($cont_address) && count($cont_address)>0)
      @foreach($cont_address as $key=>$address_row)
        <option value="{{ $address_row['address_id'] }}">{{ $address_row['fullAddress'] }}</option>
      @endforeach
    @endif
  </select>
</div>

<!-- <div class="form-group">
<label for="exampleInputPassword1">Address Line1</label>
<input type="text" id="res_addr_line1" name="res_addr_line1" class="form-control" />

</div>

<div class="form-group">
<label for="exampleInputPassword1">Address Line2</label>
<input type="text" id="res_addr_line2" name="res_addr_line2" class="form-control" />

</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">City/Town</label>
<input type="text" id="res_city" name="res_city" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">County</label>
<input type="text" id="res_county" name="res_county" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postcode</label>
<input type="text" id="res_postcode" name="res_postcode" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Country</label>
  <select class="form-control" name="res_country" id="res_country">
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
        <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
    @if(!empty($countries))
      @foreach($countries as $key=>$country_row)
      @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
        <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
<div class="clearfix"></div>
</div> -->

<div class="twobox">
  <div class="twobox_1">
    <div class="form-group">
      <label for="exampleInputPassword1">Telephone</label>
      <input type="text" id="res_telephone" name="res_telephone" class="form-control">
    </div>
  </div>
  <div class="twobox_2">
    <div class="form-group">
      <label for="exampleInputPassword1">Mobile</label>
      <input type="text" id="res_mobile" name="res_mobile" class="form-control">
    </div>
  </div>
  <div class="clearfix"></div>
</div>

<div class="form-group">
  <label for="exampleInputPassword1">Email</label>
  <input type="text" id="res_email" name="res_email" class="form-control">
</div>

<div class="form-group">
  <label for="exampleInputPassword1">Website</label>
  <input type="text" id="res_website" name="res_website" class="form-control">
</div>

<div class="form-group">
  <label for="exampleInputPassword1">Skype</label>
  <input type="text" id="res_skype" name="res_skype" class="form-control">
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
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39"></textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" />
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date" name="{{ strtolower($row_fields->field_name) }}">
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
      <label for="exampleInputPassword1">{{ ucwords($row_section['title']) }} 
        &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_section" data-step_id="{{ $row_section['step_id'] }}"><img src="/img/cross.png" width="12"></a></label>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="horizontal_line"></div>
    @if(isset($row_section['children']) && count($row_section['children']) >0 )
      @foreach($row_section['children'] as $row_fields)
        <div class="form-group">
          <div class="twobox_2">
          <label for="exampleInputPassword1">{{ ucwords(str_replace("_", " ", $row_fields['field_name'])) }} 
            &nbsp;<a href="javascript:void(0)" title="Delete Field ?" class="delete_user_field" data-field_id="{{ $row_fields['field_id'] }}"><img src="/img/cross.png" width="12"></a></label>
          @if(!empty($row_fields['field_type']) && $row_fields['field_type'] == "1")
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" class="form-control">
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39"></textarea>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" />
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(!empty($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date"  name="{{ strtolower($row_fields['field_name']) }}">
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

<!-- <div class="form-group">
  <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> New Relationship</a> &nbsp <a href="/organisation/add-client" class="btn btn-info" target="_blank"><i class="fa fa-plus"></i> New Client - Organ</a>
</div> -->

<div class="box-body table-responsive">
<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
<input type="hidden" id="app_hidd_array" name="app_hidd_array" value="">
<!-- <input type="hidden" id="search_client_type" name="search_client_type" value="org">
<input type="hidden" id="rel_client_id" name="rel_client_id" value=""> -->
<table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
  <tr>
    <td width="40%"><strong>Business Name</strong></td>
    <!-- <td width="30%" align="center"><strong>Appointment Date</strong></td> -->
    <td width="40%" align="center"><strong>Relationship Type</strong></td>
    <td width="20%" align="center"><strong>Action</strong></td>
  </tr>
</table>

  <div class="contain_tab4" id="new_relationship" style="display:none;">
    <div class="contain_search" id="client_dropdown">
      <select class="form-control" name="rel_client_id" id="rel_client_id"></select>
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
    
    <div class="contain_action"><button class="btn btn-success" onClick="saveRelationship('add_ind')" type="button">Add</button>
    <button class="btn btn-danger" type="button" onClick="hide_relationship_div()">Cancel</button></div>
  </div>
<div class="clearfix"></div>
</div>
</div>

<div style="margin-top: 10px;">
  <button type="button"  onClick="show_div()" class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>
</div>

<!-- <div class="box-body table-responsive" style="width:63%;">
  <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
    <div class="row"><div class="col-xs-6"><h3>CLIENT (ACTING)</h3></div><div class="clearfix"></div></div>
    <input type="hidden" id="acting_hidd_array" name="acting_hidd_array" value="">
    <input type="hidden" id="relation_index" name="relation_index" value="">
  <table width="100%" class="table table-bordered table-hover dataTable" id="myActTable">
    <tr>
      <td width="32%"><strong>Name</strong></td>
      <td width="18%" align="center"><strong>Action</strong></td>
    </tr>

  </table>

    <div class="contain_tab4" id="new_relationship_acting" style="display:none;">
      <div class="acting_select">
        <select class="form-control" name="acting_client_id" id="acting_client_id">
          
        </select>
      </div>

      <div class="contain_action"><button class="btn btn-success" data-client_type="org" onClick="saveActing('by_click', 'add_acting')" type="button">Add</button>&nbsp;&nbsp;<button class="btn btn-danger close_acting" data-client_type="org"  type="button">Cancel</button></div>
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
 <div class="director_table"> 
<h3 class="box-title">OTHERS</h3> 


<div class="twobox">
<div class="twobox_01">
<div class="form-group">
<label for="exampleInputPassword1">AML Checks Done</label>
<input type="checkbox" name="aml_checks" value="1" />
</div>
</div>

<!-- <div class="twobox_02">
<div class="form-group">
<label for="exampleInputPassword1">Acting?</label>
<input type="checkbox" name="acting" value="1" />
</div>
</div>

<div class="twobox_03">
<div class="form-group">
<label for="exampleInputPassword1">Tax Return Required</label>
<input type="checkbox" name="tax_ret_req" value="1" />
</div>
</div> -->

<div class="clearfix"></div>
</div>


<!-- <div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Responsible Staff</label>
<select class="form-control" name="resp_staff" id="resp_staff">
  <option value="">None</option>
  @if(!empty($responsible_staff))
    @foreach($responsible_staff as $key=>$staff_row)
      <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
    @endforeach
  @endif

</select>
</div>
</div>
<div class="clearfix"></div> -->

    <div class="service_t"><h3 class="box-title">Services</h3></div>
      <div class="add_edit">
        <a href="#" class="add_to_list" data-toggle="modal" data-target="#services-modal"> Add/Edit list</a>
      </div>
      <div class="clearfix"></div>

      <div class="form-group">
      <table width="100%" id="myServTable" class="myServTable">
        @if( isset($old_services) && count($old_services)>0 )
          @foreach($old_services as $key=>$service_row)
        <tr>
          <td align="center" width="40%"><span class="custom_chk"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" checked /><label><strong>{{ $service_row->service_name }}</strong></label></span></td>
          <td widht="30%"></td>
          <td width="30%"></td>
        </tr>
          @endforeach
        @endif

        @if( isset($new_services) && count($new_services)>0 )
          @foreach($new_services as $key=>$service_row)
          <tr id="hide_service_tr_{{ $service_row->service_id }}">
            <td align="center" width="40%"><span class="custom_chk"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" {{ (isset($client_details['other_services']) && in_array($service_row->service_id, unserialize($client_details['other_services'])))?"checked":"" }} /><label><strong>{{ $service_row->service_name }}</strong></label></span></td>
            <td width="30%"><a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a></td>
            <td align="left" widht="30%">
              <!-- <select class="form-control" name="staff_id" id="staff_id">
                <option value="">None</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                    <option value="{{ $staff_row->user_id }}">{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
                    @endforeach
                  @endif
                </select> -->
            </td>
          </tr>
          @endforeach
        @endif
        
        
      </table>
      </div>

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
        <input type="text" name="{{ strtolower($row_fields->field_name) }}" class="form-control">
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "2")
        <textarea  name="{{ strtolower($row_fields->field_name) }}" rows="3" cols="39"></textarea>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "3")
        <input type="checkbox"  name="{{ strtolower($row_fields->field_name) }}" />
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == 4)
        <select class="form-control"  name="{{ strtolower($row_fields->field_name) }}" >
          @if(!empty($row_fields->select_option) && count($row_fields->select_option) > 0)
            @foreach($row_fields->select_option as $key=>$value)
              <option value="{{ $value }}">{{ $value }}</option>
            @endforeach
          @endif
        </select>
      @elseif(!empty($row_fields->field_type) && $row_fields->field_type == "5")   
        <input type="text" class="form-control user_added_date"  name="{{ strtolower($row_fields->field_name) }}">
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
            <input type="text" name="{{ strtolower($row_fields['field_name']) }}" class="form-control">
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "2")
            <textarea  name="{{ strtolower($row_fields['field_name']) }}" rows="3" cols="39"></textarea>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "3")
            <input type="checkbox"  name="{{ strtolower($row_fields['field_name']) }}" />
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == 4)
            <select class="form-control"  name="{{ strtolower($row_fields['field_name']) }}" >
              @if(!empty($row_fields['select_option']) && count($row_fields['select_option']) > 0)
                @foreach($row_fields['select_option'] as $key=>$value)
                  <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
              @endif
            </select>
          @elseif(!empty($row_fields['field_type']) && $row_fields['field_type'] == "5")   
            <input type="text" class="form-control user_added_date"  name="{{ strtolower($row_fields['field_name']) }}">
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
                </div>
       

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
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW FIELD</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/individual/save-userdefined-field', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="ind" />
    <input type="hidden" name="back_url" value="add_ind" />
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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- Relationship Add To List Modal Start-->
<!-- <div class="modal fade" id="add_to_list-modal" tabindex="-1" role="dialog" aria-hidden="true">
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

@stop