@extends('layouts.layout')

@section('mycssfile')

<!-- google search -->
<link rel="stylesheet" href="{{ URL :: asset('css/address_search.css') }}" />
<!-- google search -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/sites/practice_details.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/upload_script.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/proposal_settings.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    //$(":file").filestyle({input: false});
</script>

<!-- google search -->
<script src="{{ URL :: asset('js/address_search.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc7HTLVvrPyl_cJQGPIb1GuWwq0cTC4MY&libraries=places&callback=initAutocomplete" async defer></script>
<!-- google search -->
@stop

@section('content')

<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
    <section class="sidebar">
      @include('layouts.inner_leftside')
    </section>
  </aside>

  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side {{ $right_class }}">
      <!-- Content Header (Page header) -->
      <!-- <section class="content-header">
          <h1>
              MY PRACTICE MANAGER
              <small>CLIENT NAME Limited</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Practice Details</li>
          </ol>
      </section> -->
      @include('layouts.below_header')

      <!-- Main content -->

<section class="content">
<div class="show_loader"></div>
  <div class="row">
    <div class="top_bts">
      <form method="post" action="{{url()}}/colorextract/upload.php" id="CrmLogoForm" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="{{ $user_id or '0' }}">
        <input type="hidden" name="group_id" value="{{ $group_id or '0' }}">
        <input type="hidden" name="added_from" id="added_from" value="practice">
        <ul>
        <!-- <li><button type="button" class="btn btn-info" onClick="window.print()"><i class="fa fa-print"></i> Print</button></li> -->
        <li>
          <a class="btn btn-success" href="/download/downloadPdf"><i class="fa fa-download"></i> Generate PDF</a>
        </li>


        <!--

        <li><a class="btn btn-primary" href="/downloadExel"><i class="fa fa fa-file-text-o"></i> Excel</a></li> -->
        <!-- <li><a href="javascript:void(0)" id="del_prc_dtls" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</a></li>

        <li><button class="btn btn-warning" type="submit" name="edit" id="edit"><i class="fa fa-edit"></i> Edit</button></li> -->

          <li style="margin-left: 300px;">
            <input type="file" name="imgFile" id="imgFile">
            <!-- <span class="btn btn-default btn-file p_details">
              Browse <input type="file" name="imgFile" id="imgFile">
            </span> -->
          </li>
          <!-- <li>
            <button type="button" id="UploadProcess">Upload</button>
          </li> -->

          <li class="LogoActionLi">
            @if(isset($practice_details->practice_logo) && $practice_details->practice_logo != "")
              @if(file_exists("colorextract/images/".$practice_details->practice_logo))
              <!-- 
                <img src="/colorextract/images/{{ $practice_details->practice_logo }}" class="browse_img" width="150" />
              -->
              
                <button type="button" title="Delete Logo?" id="delete_practice_logo" data-logo_name="{{ $practice_details->practice_logo }}">Delete Logo</button>
              @endif
            @else
              <button type="button" title="Upload Logo?" id="UploadProcess">Upload</button>
            @endif
          </li>

        <!-- <li>
          @if(isset($practice_details->practice_logo) && $practice_details->practice_logo != "")
            @if(file_exists("practice_logo/".$practice_details->practice_logo))
              <button class="btn btn-danger" data-practice_id="{{ $practice_details->practice_id }}" data-logo_name="{{ $practice_details->practice_logo }}" title="Delete Logo?" type="button" id="delete_practice_logo">Delete</button>
            @endif
          @endif
        </li> -->

        <div class="clearfix"></div>
        </ul>
      </form> 
    </div>
  </div>

<!-- Image upload error show -->
<div id="error_image_type" style="margin-left: 525px;margin-bottom: 10px;color: red;"></div>
<!-- Image upload error show -->

{{ Form::open(array('url' => '/insertPracticeDetails', 'files' => true, 'id' => 'uploadimage')) }}
<input type="hidden" name="practice_id" id="practice_id" value="{{ $practice_details->practice_id or ''}}">
<input type="hidden" name="reg_address_id" value="{{ $practice_address['reg_address_id'] or ''}}">
<input type="hidden" name="phy_address_id" value="{{ $practice_address['phy_address_id'] or ''}}">
<input type="hidden" name="hidd_practice_logo" id="hidd_practice_logo" value="{{ $practice_details->practice_logo or ''}}">

<div class="practice_mid">

<div class="row box_border row_cont">
 <div class="col_left col_left_new">
<div class="col-xs-12">
 <div class="col-lg-6">   
 <!-- <h2 class="res_t p_details">Practice Details</h2> -->
 </div>
  <!-- <div class="col-lg-6">  
    <div class="browse_cont">
      <span class="btn btn-default btn-file p_details">
        Browse <input type="file" name="practice_logo" id="practice_logo">
      </span>
      <div class="image_preview">
        @if(isset($practice_details->practice_logo) && $practice_details->practice_logo != "")
          @if(file_exists("practice_logo/".$practice_details->practice_logo))
            <img src="practice_logo/{{ $practice_details->practice_logo }}" class="browse_img" width="150" />
            <button class="btn btn-danger" data-practice_id="{{ $practice_details->practice_id }}" data-logo_name="{{ $practice_details->practice_logo }}" title="Delete Logo?" type="button" id="delete_practice_logo">Delete</button>
          @endif
        @endif
      </div>
    </div>
</div> -->
<div class="clearfix"></div>
<!--<input type="file" name="practice_logo" id="practice_logo">-->
</div>
 </div>


<div class="col_right">
 <div class="setting_con">
  <!--   <a href="/settings-dashboard" class="btn btn-success btn-lg"><i class="fa fa-cog fa-fw"></i>Settings</a> -->

</div>

<div class="save_con">

<button class="btn btn-primary" type="submit" name="save" id="save">Save</button>
<!--
<button class="btn btn-info" type="reset" name="cancel" id="cancel">Cancel</button> -->
</div>

 </div>
 <div class="clearfix"></div>
</div>

<div class="row b_gap">
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label for="display_name">Display Name</label>
<input type="text" placeholder="Display Name" value="{{ $practice_details->display_name or '' }}" id="display_name" name="display_name" class="form-control">
</div>
</div>
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label for="legal_name">Legal/Trading Name</label>
<input type="text" placeholder="Legal/Trading Name" value="{{ $practice_details->legal_name or '' }}" id="legal_name" name="legal_name" class="form-control">
</div>
</div>
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label for="registration_no">Registration Number</label>
<input type="text" placeholder="Registration Number" value="{{ (isset($practice_details->registration_no) && $practice_details->registration_no != 0)?$practice_details->registration_no:'' }}" id="registration_no" name="registration_no" class="form-control">
</div>
</div>
<div class="col-lg-3 col-xs-12">
<div class="form-group">
<label>Organisation Type</label>
<select class="form-control" name="organisation_type_id" id="organisation_type_id">
    <option value="">--Select Organization Type--</option>
@if(!empty($org_types))
    @foreach($org_types as $key=>$org_row)
    <option value="{{ $org_row->organisation_id }}" {{ (isset($practice_details->organisation_type_id) && ($practice_details->organisation_type_id == $org_row->organisation_id))?'selected':'' }}>{{ $org_row->name }}</option>
    @endforeach
@endif
</select>
</div>
</div>
<div class="clearfix"></div>
</div>

</div>

<div class="practice_mid2">
<div class="row row_cont">

<div class="col-xs-12 col-xs-4">
    <div class="col_m2">
<span><strong>COMPANIES’ HOUSE LOGIN</strong></span>
<h3 class="box-title"><!-- Sign in details--></h3> 
    <div class="form-group">
        <label for="exampleInputEmail1">User Name</label>
        <input type="text" placeholder="User Name" id="ch_email" name="ch_email" class="form-control" value="{{ (isset($ch_logins['email']) && $ch_logins['email'] != '')?$ch_logins['email']:'' }}">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="text" placeholder="Password" id="ch_pass" name="ch_pass" class="form-control" value="{{ (isset($ch_logins['password']) && $ch_logins['password'] != '')?$ch_logins['password']:'' }}">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Presenter ID</label>
        <input type="text" placeholder="Enter Presenter ID" id="presenter_id" name="presenter_id" class="form-control" value="{{ (isset($ch_logins['presenter_id']) && $ch_logins['presenter_id'] != '')?$ch_logins['presenter_id']:'' }}">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Presenter Authentication codes</label>
        <input type="text" placeholder="Enter Presenter Authentication codes" id="auth_code" name="auth_code" class="form-control" value="{{ (isset($ch_logins['auth_code']) && $ch_logins['auth_code'] != '')?$ch_logins['auth_code']:'' }}">
    </div>

    </div>
</div>
 
<div class="col-xs-12 col-xs-4">
 <div class="col_m2">
<span><strong>HMRC LOGIN DETAILS</strong></span>
<h3 class="box-title"><!-- Sign in details --></h3>
<div class="form-group">
<label for="exampleInputEmail1">User Name</label>
<input type="text" placeholder="User Name" name="hmrcusername" value="{{$practice_details->hmrcusername or ''}}" id="exampleInputEmail1" class="form-control">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Password</label>
<input type="text" placeholder="Password" name="hmrcpass" value="{{$practice_details->hmrcpass or ''}}" id="exampleInputPassword1" class="form-control">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Gateway Agent Identifier</label>
<input type="text" placeholder="Gateway Agent Identifier" name="gatewayagentidentifier" value="{{$practice_details->gatewayagentidentifier or ''}}" id="exampleInputEmail1" class="form-control">
</div>

</div>
 </div>
 
 <div class="col-xs-12 col-xs-4">
  <div class="col_m2">
<span><strong>AGENT IDS</strong></span>
<h3 class="box-title"><!-- Sign in details --></h3>
<div class="agent_left">
<div class="form-group">
<label for="exampleInputEmail1">Paye</label>
<input type="text" placeholder="Paye" name="agentpaye" value="{{$practice_details->agentpaye or ''}}" id="exampleInputEmail1" class="form-control">
</div>
<div class="form-group">
<label for="exampleInputPassword1">SA</label>
<input type="text" placeholder="SA" name="agentsa" value="{{$practice_details->agentsa or ''}}" id="exampleInputPassword1" class="form-control">
</div>
<!--
<div class="form-group">
<label for="exampleInputPassword1">VAT</label>
<input type="text" placeholder="Vat" id="exampleInputPassword1" class="form-control">
</div> -->
 </div>
 
 <div class="agent_right">
<div class="form-group">
<label for="exampleInputEmail1">CT</label>
<input type="text" placeholder="CT" name="agentct" value="{{$practice_details->agentct or ''}}" id="exampleInputEmail1" class="form-control">
</div>

 </div>
 
 <div class="clearfix"></div>
 
 </div>
 </div>
 
 </div>

</div>

<div class="practice_mid2">
<div class="row row_cont">

 <h2>Contact Details</h2>
<div class="col-xs-12 col-xs-4">
 <div class="col_m1">
<h3 class="box-title">Registered Office Address</h3>
<div class="form-group">
<label for="reg_attention">Attention</label>
<input type="text" placeholder="Attention" value="{{ $practice_address['reg_attention'] or '' }}" id="reg_attention" name="reg_attention" class="form-control">
</div>
<!-- <div class="form-group">
<label for="reg_street_address">Street Address or PO Box</label>
<textarea placeholder="Street Address or PO Box" id="reg_street_address" name="reg_street_address" rows="3" class="form-control">{{ $practice_address['reg_street_address'] or ''}}</textarea>
</div> -->
<div class="form-group" style="margin-bottom: 0px;">
  <label for="address1">Address Line 1</label>
</div>

<div class="form-group" id="locationField">
  <label for="address1">Address Line 1</label>
  <input type="text" class="form-control address_search" id="address1" name="address1" value="{{ $practice_address['reg_address1'] or ''}}" placeholder="Enter your address" onfocus="geolocate()" autocomplete="off">

<!--   <input type="text" class="form-control address_search" name="address1" id="address1" placeholder="Enter your address" onfocus="geolocate()" autocomplete="off"> -->
</div>
<div class="form-group">
  <label for="address2">Address Line 2</label>
  <input type="text" id="address2" name="address2" class="form-control" value="{{ $practice_address['reg_address2'] or ''}}">
</div>

<div class="form-group">
<label for="reg_city_id">Town/City</label>
<!-- <input type="text" placeholder="Town/City" value="{{ $practice_address['reg_city_name'] or '' }}" onKeyUp="ajaxSearchByCity(this.value, 'reg_city_id')" id="reg_city_id" name="reg_city_id" class="form-control"> 
<input type="hidden" name="hid_reg_city_id" id="hid_reg_city_id" value="{{ $practice_address['reg_city_id'] or '' }}">
<div class="drop_down_city" id="reg_city_id_div" style="display:none;">
    <ul id="reg_city_id_result"></ul>
</div>-->

<input type="text" placeholder="Town/City" name="address_city" id="address_city" value="{{ $practice_address['reg_city'] or '' }}" class="form-control">

</div>

<div class="form-group">
<label for="reg_state_id">State/Region</label>
<!-- <input type="text" placeholder="State/Region" value="{{ $practice_address['reg_state_name'] or '' }}" id="reg_state_id" name="reg_state_id" class="form-control">
<input type="hidden" name="hid_reg_state_id" id="hid_reg_state_id" value="{{ $practice_address['reg_state_id'] or '' }}"> -->
<input type="text" placeholder="State/Region" value="{{ $practice_address['reg_state'] or '' }}" id="address_county" name="address_county" class="form-control">
</div>

<div class="form-group">
<label for="reg_zip">Postal/Zip Code</label>
<input type="text" placeholder="Postal/Zip Code" value="{{ $practice_address['reg_zip'] or '' }}" id="address_postcode" name="address_postcode" class="form-control">
</div>

<div class="form-group">
  <label for="reg_country_id">Country</label>
<!-- <input type="text" id="reg_country_id" value="United Kingdom" name="reg_country_id" class="form-control" disabled>
<input type="hidden" name="hid_reg_country_id" id="hid_reg_country_id" value="1"> -->
  <select class="form-control" name="address_country" id="address_country">
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
        <option value="{{ $country_row->country_id }}" {{ (isset($practice_address['reg_country_id']) && $country_row->country_id == $practice_address['reg_country_id'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
 </div>
 
 <div class="col-xs-12 col-xs-4">
 <div class="col_m1">
<h3 class="box-title t1_left">Physical Office Address</h3>
<p class="t1_right"><a href="javascript:void(0)" onClick="copyPostal()">Copy Postal</a></p>
<div class="clearfix"></div>
<div class="form-group">
<label for="phy_attention">Attention</label>
<input type="text" placeholder="Attention" value="{{ $practice_address['phy_attention'] or '' }}" id="phy_attention" name="phy_attention" class="form-control">
</div>
<!-- <div class="form-group">
<label for="phy_street_address">Street Address or PO Box</label>
<textarea placeholder="Street Address or PO Box" name="phy_street_address" id="phy_street_address" rows="3" class="form-control">{{ $practice_address['phy_street_address'] or ''}}</textarea>
</div> -->
<div class="form-group">
  <label for="phy_street_address1">Address Line 1</label>
  <input type="text" id="phy_address1" name="phy_address1" class="form-control" value="{{ $practice_address['phy_address1'] or ''}}">
</div>
<div class="form-group">
  <label for="phy_street_address2">Address Line 2</label>
  <input type="text" id="phy_address2" name="phy_address2" class="form-control" value="{{ $practice_address['phy_address2'] or ''}}">
</div>

<!-- <div class="form-group">
<label for="phy_city_id">Town/City</label>
<input type="text" placeholder="Town/City" value="{{ $practice_address['phy_city_name'] or '' }}" onKeyUp="ajaxSearchByCity(this.value, 'phy_city_id')" id="phy_city_id" name="phy_city_id" class="form-control">
<input type="hidden" name="hid_phy_city_id" id="hid_phy_city_id" value="{{ $practice_address['phy_city_id'] or '' }}">
<div class="drop_down_city" id="phy_city_id_div" style="display:none;">
    <ul id="phy_city_id_result"></ul>
</div>

</div> -->

<div class="form-group">
<label for="phy_city_id">Town/City</label>
<input type="text" placeholder="Town/City" value="{{ $practice_address['phy_city'] or '' }}" id="phy_city" name="phy_city" class="form-control">
</div>

<!-- <div class="form-group">
<label for="phy_state_id">State/Region</label>
<input type="text" placeholder="State/Region" value="{{ $practice_address['phy_state_name'] or ''}}" id="phy_state_id" name="phy_state_id" class="form-control">
<input type="hidden" name="hid_phy_state_id" id="hid_phy_state_id" value="{{ $practice_address['phy_state_id'] or '' }}">
</div> -->

<div class="form-group">
<label for="phy_state_id">State/Region</label>
<input type="text" placeholder="State/Region" value="{{ $practice_address['phy_state'] or ''}}" id="phy_state" name="phy_state" class="form-control">
</div>

<div class="form-group">
<label for="phy_zip">Postal/Zip Code</label>
<input type="text" placeholder="Postal/Zip Code" value="{{ $practice_address['phy_zip'] or '' }}" id="phy_zip" name="phy_zip" class="form-control">
</div>

<div class="form-group">
<label for="phy_country_id">Country</label>
<!-- <input type="text" value="United Kingdom" id="phy_country_id" name="phy_country_id" class="form-control" disabled>
<input type="hidden" name="hid_phy_country_id" id="hid_phy_country_id" value="1"> -->
<select class="form-control" name="phy_country_id" id="phy_country_id">
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
        <option value="{{ $country_row->country_id }}"{{ (isset($practice_address['phy_country_id']) && $country_row->country_id == $practice_address['phy_country_id'])?"selected":"" }}>{{ $country_row->country_name }}</option>
      @endif
      @endforeach
    @endif
  </select>
</div>
</div>
 </div>


 
 <div class="col-xs-12 col-xs-4">
  <div class="col_m1">
    <div class="form-group">
      <label for="tel_number">Telephone</label>
      <input type="text" placeholder="Number" value="{{ $practice_details['telephone_no'][0] or '' }}" id="tel_number" name="tel_number" class="form-control">
    </div>
    <div class="clearfix"></div> 

    <div class="form-group">
      <label for="fax_number">Fax</label>
      <input type="text" placeholder="Fax Number" value="{{ $practice_details['fax_no'][0] or '' }}" id="fax_number" name="fax_number" class="form-control">
    </div>

    <div class="clearfix"></div> 

    <div class="form-group">
      <label for="mob_number">Mobile</label>
      <input type="text" placeholder="Mobile Number" value="{{ $practice_details['mobile_no'][0] or '' }}" id="mob_number" name="mob_number" class="form-control">
    </div>

 <div class="clearfix"></div> 
 <div class="form-group">
<label for="exampleInputEmail1">Email</label>
<input type="text" placeholder="Email" name="practiceemail" value="{{ $practice_details['practiceemail'] or '' }}" id="practiceemail" class="form-control">
</div>
<div class="clearfix"></div>
 <div class="form-group">
<label for="exampleInputEmail1">Website</label>
<input type="text" placeholder="Website" name="practicewebsite" value="{{ $practice_details['practicewebsite'] or '' }}" id="practicewebsite" class="form-control">
</div>
<div class="clearfix"></div>
 <div class="form-group">
<label for="exampleInputEmail1">Skype</label>
<input type="text" placeholder="Skype" name="practiceskype" value="{{ $practice_details['practiceskype'] or '' }}" id="practiceskype" class="form-control">
</div>
 </div>
 <div class="save_con">
<!-- <button class="btn btn-warning" type="submit" name="save" id="save">Edit Physical Address</button> 
<button class="btn btn-primary" type="submit" name="save" id="save">Save</button>
<button class="btn btn-danger" type="reset" name="cancel" id="cancel">Cancel</button>-->
</div>
 </div>
 


 </div> 
 <div class="clearfix"></div> 
 </div>
{{ Form::close() }}


                </section><!-- /.content -->

            </aside><!-- /.right-side -->
        
  </div>

        <!-- ./wrapper -->     
@stop



