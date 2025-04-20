@extends('layouts.layout')

@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->

<link rel="stylesheet" href="{{ URL :: asset('css/address_search.css') }}" />

<!-- select search-->
<link href="{{ URL :: asset('css/select2.min.css') }}" rel="stylesheet" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script>
$(document).ready(function(){
    $("#incorporation_date").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#made_up_date").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#next_ret_due").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#last_acc_madeup_date").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#next_acc_due").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#next_made_up_to").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#app_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });

    $("#effective_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });

    $(".user_added_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
    
})
</script>

<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>

<!-- google search -->
<script src="{{ URL :: asset('js/address_search.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc7HTLVvrPyl_cJQGPIb1GuWwq0cTC4MY&libraries=places&callback=initAutocomplete" async defer></script>
<!-- google search -->

<!-- select search-->
<script src="{{ URL :: asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".putBusinessName").select2({
    placeholder: "None"
  });
})
</script>
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
    {{ Form::open(array('url' => '/organisation/insert-client-details', 'files' => true)) }}
    <input name="client_id" id="client_id" type="hidden" value="new">
    <section class="content">
      <div class="row">
        <div class="top_bts">
          <ul>
            <!-- <li>
              <a href="/import-from-ch/{{ base64_encode('org_list') }}" class="btn btn-info">IMPORT FROM CH</a>
            </li>
            <li>
              <button class="btn btn-success">IMPORT FROM CSV</button>
            </li>
            <li>
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
          <li class="active" id="tab_1"><a class="open_header" data-id="1" href="javascript:void(0)">BUSINESS INFORMATION</a></li>
          <li id="tab_2"><a class="open_header" data-id="2" href="javascript:void(0)">TAX INFORMATION</a></li>
          <li id="tab_3"><a class="open_header" data-id="3" href="javascript:void(0)">CONTACT INFORMATION</a></li>
          <li id="tab_4"><a class="open_header" data-id="4" href="javascript:void(0)">RELATIONSHIPS</a></li>
          <li id="tab_5"><a class="open_header" data-id="5" href="javascript:void(0)">SERVICES</a></li>
          @if(isset($user_type) && $user_type != "C")
          <li><a href="#" class="btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field</a></li>
          @endif
          

        </ul>

        
              <div class="tab-content">
                <div id="step1" class="tab-pane active">
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

<!-- <div class="twobox">
  @if(isset($user_type) && $user_type != "C")
  <div class="twobox_1">
    <div class="small_box">
        <div class="form-group">
          <label for="exampleInputPassword1">Client Code</label>
          <input type="text" id="client_code" name="client_code" class="form-control toUpperCase">
        </div>
    </div>
  </div>
  @endif
  <div class="twobox_2">
    <div class="form-group">
      <label for="exampleInputPassword1">Business Type</label>
      @if(isset($user_type) && $user_type != "C")
      <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"> Add/Edit list</a>
      @endif
      <select class="form-control" name="business_type" id="business_type">
        @if( isset($old_org_types) && count($old_org_types) >0 )
          @foreach($old_org_types as $key=>$old_org_row)
          <option value="{{ $old_org_row->organisation_id }}">{{ $old_org_row->name }}</option>
          @endforeach
        @endif

        @if( isset($new_org_types) && count($new_org_types) >0 )
          @foreach($new_org_types as $key=>$new_org_row)
          <option value="{{ $new_org_row->organisation_id }}">{{ $new_org_row->name }}</option>
          @endforeach
        @endif
       
      </select>
    </div>
  </div>
  <div class="clearfix"></div>
</div> -->


              <div class="form-group">
                @if(isset($user_type) && $user_type != "C")
                <div class="client_code">
                  <label for="exampleInputPassword1">Client Code</label>
                  <div class="clearfix"></div>
                  <input type="text" id="client_code" name="client_code" class="form-control toUpperCase" style="width:120px">
                </div>
                @endif
                <div class="business_type">
                  <label for="exampleInputPassword1">Business Type
                  @if(isset($user_type) && $user_type != "C")
                    <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
                  @endif
                  </label>
                  <!-- <label for="exampleInputPassword1">Business Type</label>
                  @if(isset($user_type) && $user_type != "C")
                  <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"> Add/Edit list</a>
                  @endif -->
                  <select class="form-control select_business_types" name="business_type" id="business_type">
                    @if( isset($old_org_types) && count($old_org_types) >0 )
                      @foreach($old_org_types as $key=>$old_org_row)
                      <option value="{{ $old_org_row->organisation_id }}">{{ $old_org_row->name }}</option>
                      @endforeach
                    @endif

                    @if( isset($new_org_types) && count($new_org_types) >0 )
                      @foreach($new_org_types as $key=>$new_org_row)
                      <option value="{{ $new_org_row->organisation_id }}">{{ $new_org_row->name }}</option>
                      @endforeach
                    @endif
                   
                  </select>
                </div>
                @if(isset($user_type) && $user_type != "C")
                <!-- <div class="n_box1">
                  <label for="exampleInputPassword1">Display in CH Data</label>
                    <div class="form-group chk_gap">
                      <input type="checkbox" id="display_in_ch" name="display_in_ch" value="Y" class="form-control" checked="checked">
                    </div>
                </div> -->
                @endif
                <div class="clearfix"></div>
              </div>



                            
              <div class="form-group">
                <label for="exampleInputPassword1">Business Name</label>
                <input type="text" id="business_name" name="business_name" class="form-control toUpperCase">
              </div>

              <div class="twobox">
                <div class="threebox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Registration Number</label>

                    <input type="text" id="registration_number" name="registration_number" class="form-control">

                  </div>
                </div>
                <div class="threebox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Incorporation Date</label>
                    <input type="text" id="incorporation_date" name="incorporation_date" class="form-control">
                  </div>
                </div>

            <div class="threebox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Registered In</label>
                <select class="form-control" name="registered_in" id="registered_in">
                  <option value="">None</option>
                 @if(!empty($reg_address))
                    @foreach($reg_address as $key=>$reg_row)
                    <option value="{{ $reg_row->reg_id }}">{{ $reg_row->reg_name }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
                              <div class="clearfix"></div>
                            </div>

                            <!-- <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Registered In</label>
                                  <input type="text" id="" class="form-control">
                                </div>
                              </div>
                              
                              <div class="clearfix"></div>
                            </div>
                             -->

                            
        <div class="form-group">
          <label for="exampleInputPassword1">Business Description</label>
          <select class="form-control putBusinessName" name="business_desc" id="business_desc">
          <option value="">None</option>
          @if(isset($business) && count($business)>0)
            @foreach($business as $key=>$b)
            <option value="{{ $b['code'] }}">{{ $b['description'] }}</option>
            @endforeach
          @endif
        </select>
                            </div>

                            <!-- <h3 class="box-title">Annual Returns</h3> -->

                            <div class="form-group">
                              <label for="exampleInputPassword1">Confirmation Statement</label>
                              <input type="checkbox" name="ann_ret_check" id="ann_ret_check" value="1" />
                            </div>


      <div id="show_ann_ret" style="display:none;">
        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Made up Date</label>
              <input type="text" id="made_up_date" name="made_up_date" class="form-control">
            </div>
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Next Return Due</label>
              <input type="text" id="next_ret_due" name="next_ret_due" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">CH Authentication Code</label>

              <input type="text" id="ch_auth_code" name="ch_auth_code" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
          




</div>
        <div class="form-group">
          <label for="exampleInputPassword1">Year End Accounts</label>
          <input type="checkbox" name="yearend_acc_check" id="yearend_acc_check" value="1" />
        </div>






      <div id="show_year_end" style="display:none;">
        <div class="twobox">
          <div class="twobox_1">
            <label for="exampleInputPassword1">Accounting Ref Date</label> 
            <div class="clearfix"></div>
            <div class="accountbox1">
            <div class="form-group">
              <select class="form-control" id="acc_ref_day" name="acc_ref_day">
                @for($i = 1; $i<=31;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>
          </div>

          <div class="accountbox2">
            <div class="form-group">

               <select id='' class="form-control" >
                    <option value=''>--Select Month--</option>
                    <option value='1'>Janaury</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
    </select> 
            </div>
          </div>
            <div class="clearfix"></div>
          </div>

           <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Last Account Made Up Date</label>
              <input type="text" id="last_acc_madeup_date" name="last_acc_madeup_date" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="next_made_up_to">Next Account Made Up Date</label>
              <input type="text" id="next_made_up_to" name="next_made_up_to" class="form-control">
            </div>
          </div>

          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Next Account Due</label>
              <input type="text" id="next_acc_due" name="next_acc_due" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>





          
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
        <!-- <button class="btn btn-info back" data-id="1" type="button">Prev</button> -->
        
        <button type="submit" class="btn btn-danger">Save</button>
        <button class="btn btn-info open" data-id="2" type="button">Next</button>
      </div>
      <div class="clearfix"></div>

    </div>
  </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->


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
                            <h3 class="box-title">TAX INFORMATION</h3>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Registered for Vat</label>
                              <input type="checkbox" name="reg_for_vat" id="reg_for_vat" value="1" />
                            </div>
                            <div class="registered_vat" id="show_reg_for_vat" style="display:none">
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Effective Date of Registration</label>
                                  <input type="text" id="effective_date" name="effective_date" class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Vat Number</label>
                                  <input type="text" id="vat_number" name="vat_number" class="form-control">
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Vat Scheme</label>
                                  
                                  <a href="#" class="add_to_list" data-toggle="modal" data-target="#vatScheme-modal"> Add/Edit list</a>
                                  <select class="form-control" name="vat_scheme_type" id="vat_scheme_type">
                                    <option value="">None</option>
                                    @if( isset($old_vat_schemes) && count($old_vat_schemes)>0 )
                                      @foreach($old_vat_schemes as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->vat_scheme_id }}">{{ $scheme_row->vat_scheme_name }}</option>
                                      @endforeach
                                    @endif
                                    @if( isset($new_vat_schemes) && count($new_vat_schemes)>0 )
                                      @foreach($new_vat_schemes as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->vat_scheme_id }}">{{ $scheme_row->vat_scheme_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select>
                                </div>
                              </div>
                              <div class="add_client_chk">
                                <div class="add_ch1">
                                  <div class="form-group">
                                  
                                 
                                
                                    <label for="exampleInputPassword1">Cash</label>
                                    <input type="radio" name="vat_scheme" value="cash" />
                                  </div>
                                </div>
                                <div class="add_ch2">
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Accrual</label>
                                    <input type="radio" name="vat_scheme" value="accrual" checked />
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Return Frequency</label>
                                  <select class="form-control frequency_change" name="ret_frequency" id="ret_frequency">
                                    <option>Choose One</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                  </select>
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Vat Stagger</label>
                                  <select class="form-control" name="vat_stagger" id="vat_stagger">
                                    <option>Choose One</option>
                                    <option value="Jan-April-Jul-Oct">Jan-April-Jul-Oct</option>
                                    <option value="Feb-May-Aug-Nov">Feb-May-Aug-Nov</option>
                                    <option value="Mar-Jun-Sept-Dec">Mar-Jun-Sept-Dec</option>
                                  </select>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>

                            
                      </div>
                            

                            <div class="form-group">
                              <label for="exampleInputPassword1">EC Sales List</label>
                                <input type="checkbox" name="ec_scale_list" id="ec_scale_list"/>
                            </div>

                            <div class="twobox" style="display:none;" id="ecsl_hide_div">
                              <div style="float:left; width:25%;"><input type="radio" name="ecsl_freq" value="quarterly" checked> Quarterly</div>
                              <div style="float:left; width:25%;"><input type="radio" name="ecsl_freq" value="monthly"> Monthly</div>
                              <div style="float:left;"><input type="radio" name="ecsl_freq" value="annually"> Annually</div>
                              <div class="clearfix"></div>
                            </div>


                            <div class="form-group">
                              <label for="exampleInputPassword1">Tax</label>
                               <input type="checkbox" id="tax_div" name="tax_div" value="1" >
                            </div>
                          
                          <div id="show_tax_div" style="display:none;"> 

                            <!--<div class="tax_utr_drop">
                              <div class="form-group">
                                <label for="exampleInputPassword1">Tax Type</label>

                                <select class="form-control org_tax_reference" name="tax_reference_type" id="tax_reference_type">
                                  <option value="N">None</option>
                                  <option value="I">Income Tax</option>
                                  <option value="C">Corporation Tax</option>
                                </select>

                              </div>
                            </div>-->
<div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Tax District</label>
              
               <select class="form-control" name="tax_office_id" id="tax_office_id">
                <option value="">-- Select  --</option>
                  @if(!empty($taxallofficeaddress))
                    @foreach($taxallofficeaddress as $key=>$office_row)
                      
                        <option value="{{ $office_row['office_type'] }},{{ $office_row['office_id'] }}">{{ $office_row['office_name'] }}</option>
                      
                    @endforeach
                  @endif 
                    
                </select>
            </div>
          </div>
          <div class="twobox_2" id="show_other_office" style="display:none;">
            <div class="form-group">
              <label for="exampleInputPassword1">Other Address</label>
              <select class="form-control" name="other_office_id" id="other_office_id">
                <option value="">-- Select Address --</option>
                  @if(!empty($tax_office))
                    @foreach($tax_office as $key=>$office_row)
                      @if($office_row->parent_id != 0)
                        <option value="{{ $office_row->office_id }}">{{ $office_row->office_name }}</option>
                      @endif
                    @endforeach
                  @endif
                    
                </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        
        
        
        
        <div class="twobox">
        <label for="exampleInputPassword1">Tax Reference(UTR)</label>
         <div class="clearfix"></div>
            <div class="twobox_1" style="width: 15%;">
              <div class="form-group">
                <input type="text" id="utrsamllbox" name="utrsamllbox" class="form-control">
              </div>
            </div>
            <span class="slash">/</span>
            <div class="twobox_2">
              
                              <div class="form-group">
                                
                                <input type="text" id="tax_reference" name="tax_reference" class="form-control">
                              </div>
                             
            </div>
            </div>
            <div class="clearfix"></div>
            
            
                           
                           
                                              
                                                       

                            

        

          <div class="form-group">
            <label for="exampleInputPassword1">Postal Address</label>
            <textarea id="tax_address" name="tax_address" class="form-control" rows="3">{{ $tax_office_by_id->address  or "" }}</textarea>
          </div>

          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Post Code</label>
                <input type="text" id="tax_zipcode" name="tax_zipcode" class="form-control">
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Telephone</label>
                <input type="text" id="tax_telephone" name="tax_telephone" class="form-control">
              </div>
            </div>
            </div>
            <div class="clearfix"></div>
          </div>
      

                            
          <div class="form-group">
            <label for="exampleInputPassword1">PAYE Registered</label>
            <input type="checkbox" class="org_tax_payee_address" id="paye_reg" name="paye_reg" value="1" />
          </div>
                        
                        
                        
                        <div id="show_paye_reg" style="display:none;">    
                            <div class="form-group">
                              <label for="exampleInputPassword1">CIS Registered</label>
                              <input type="checkbox" name="cis_registered" name="cis_registered" />
                            </div>

                            
                            
                            
                            <div class="twobox">
                              <div class="twobox_1">
                              <label for="exampleInputPassword1">Account Office Reference</label>
                              <div class="clearfix"></div>
                              
                                <div class="form-group">
                         <div class="twobox_1" style="width: 15%;"><input type="text" id="samllaccofcref" name="samllaccofcref" class="form-control"></div>
                         <span class="slash_p">P</span>
                         <div style="float:left; width:70%;"><input type="text" id="acc_office_ref" name="acc_office_ref" class="form-control"></div>
                           
                                </div>
                              </div>
                              
                              
                              
                              <div class="twobox_2">
                              <label for="exampleInputPassword1">PAYE Reference</label>
                              <div class="clearfix"></div>
                              
                                <div class="form-group">
                         <div class="twobox_1" style="width: 15%;"><input type="text" id="samllpayeref" name="samllpayeref" class="form-control"></div>
                         <span class="slash">/</span>
                         <div style="float:left; width:70%;"><input type="text" id="paye_reference" name="paye_reference" class="form-control"></div>
                           
                                </div>
                              </div>
                              
                              
                           
                              <div class="clearfix"></div>
                            </div>
                            

                            <div class="form-group">
                              <label for="exampleInputPassword1">Employer Office</label>
                              <textarea class="form-control" cols="30" rows="3" id="employer_office" name="employer_office"></textarea>
                            </div>

                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Post Code</label>
                                  <input type="text" name="employer_postcode" id="employer_postcode" class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Telephone</label>
                                  <input type="text" id="employer_telephone" name="employer_telephone" class="form-control">
                                </div>
                              </div>

                            </div>
                            <div class="clearfix"></div>

                          </div>

                           <div class="form-group">
                            <label for="exampleInputPassword1">HMRC Log-in Details</label>
                            <textarea class="form-control" cols="30" rows="3" id="hmrc_login_details" name="hmrc_login_details"></textarea>
                          </div>
                          <div class="clearfix"></div>



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
  <button class="btn btn-info back"data-id="1" type="button">Prev</button>
  <button class="btn btn-danger" type="submit">Save</button>
  <button class="btn btn-info open"data-id="3" type="button">Next</button>
  
  
</div>
                             <div class="clearfix"></div>
                          </div>
                        </div>
                        <div class="col-xs-12 col-xs-6">
                          
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                  
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
              <h3 class="box-title">CONTACT INFORMATION</h3>

              <!-- <div class="form-group">
                <table width="100%">
                  <tr>
                    <td width="48%">
                      <select class="form-control viewContactsList" name="org_contacts" id="org_contacts">
                        <option value="">-- View Contact --</option>
                        
                      </select>
                    </td>
                    <td width="2%"></td>
                    <td width="10%"><button type="button" class="btn btn-default btn-sm open" data-id="4">ADD OFFICERS</button></td>
                    <td width="15%"><button type="button" class="btn btn-default btn-sm " data-contact_id="0" data-added_from="edit_org">ADD OTHER CONTACTS</button></td>
                    <td width="25%">
                      <div style="float: left;padding: 3px; border:1px solid #ddd;">
                        <a href="javascript:void(0)" class="" data-added_from="edit_org">Edit</a> | 
                        <a href="javascript:void(0)" class="" data-delete_from="edit_org">Delete</a> | <a href="javascript:void(0)" class="" data-copy_from="edit_org">View</a>
                      </div>
                    </td>
                  </tr>
                </table>
              </div> -->

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example">Mobile</label>
                    <input type="text" id="contactmobile" name="contactmobile" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example">Organisation Email</label>
                    <input type="text" id="contactemail" name="contactemail" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Organisation Website</label>
                    <input type="text" id="contactwebsite" name="contactwebsite" value="{{ $client_details['contactwebsite'] or "" }}" class="form-control">
                   <div class="clearfix"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="contacttelephone" name="contacttelephone" class="form-control ">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Organisation Fax</label>
                    <input type="text" id="contactfax" name="contactfax" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>


              <div class="form-group">
                <label for="exampleInputPassword1">Trading Address</label>
                <input type="checkbox" class="cont_all_addr" value="trad" name="cont_trad_addr" />
              </div>
                            
            <div class="address_type" id="show_trad_office_addr">
              <!-- <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="trad_name_check" value="trad_cont" />
              </div> -->

              <!-- Contact address expand start-->
            <div id="show_trad_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="trad_cont_name" name="trad_cont_name" class="form-control">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="trad_cont_telephone" name="trad_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="trad_cont_mobile" name="trad_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="trad_cont_email" name="trad_cont_email" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="trad_cont_website" name="trad_cont_website" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="trad">New</a> | <a javascript:void(0) class="editAddress" data-address_type="trad">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="trad">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="trad">View</a></label>
                <select class="form-control get_orgoldcont_address" id="trad_address" data-type="trad">
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
                <input type="text" id="trad_cont_addr_line1" name="trad_cont_addr_line1" class="form-control toUpperCase" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="trad_cont_addr_line2" name="trad_cont_addr_line2" class="form-control toUpperCase" readonly>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="trad_cont_city" name="trad_cont_city" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="trad_cont_county" name="trad_cont_county" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="trad_cont_postcode" name="trad_cont_postcode" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="trad_cont_country" name="trad_cont_country" readonly>
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
            </div>
                            
                            

            <div class="form-group">
              <label for="exampleInputPassword1">Registered Office Address</label>
              <input type="checkbox" class="cont_all_addr" value="reg" name="cont_reg_addr" />
            </div>

            <div class="address_type" id="show_reg_office_addr">
              <!-- <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="reg_name_check" value="reg_cont" />
              </div> -->

              <!-- Contact address expand start-->
            <div id="show_reg_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="reg_cont_name" name="reg_cont_name" class="form-control">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="reg_cont_telephone" name="reg_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" id="reg_cont_mobile" name="reg_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="reg_cont_email" name="reg_cont_email" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="reg_cont_website" name="reg_cont_website" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="reg">New</a> | <a javascript:void(0) class="editAddress" data-address_type="reg">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="reg">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="reg">View</a></label>
                <select class="form-control get_orgoldcont_address" id="reg_address" data-type="reg">
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
                <input type="text" id="reg_cont_addr_line1" name="reg_cont_addr_line1" class="form-control toUpperCase" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="reg_cont_addr_line2" name="reg_cont_addr_line2" class="form-control toUpperCase" readonly>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="reg_cont_city" name="reg_cont_city" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="reg_cont_county" name="reg_cont_county" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="reg_cont_postcode" name="reg_cont_postcode" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="reg_cont_country" name="reg_cont_country" readonly>
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
            </div>
            
            
            
            <div class="form-group">
              <label for="exampleInputPassword1">Correspondence Address</label>
              <input type="checkbox" class="cont_all_addr" name="cont_corres_addr" value="corres" />
            </div>

            <div class="address_type" id="show_corres_office_addr">
              <!-- <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="corres_name_check" value="corres_cont" />
              </div> -->

              <!-- Contact address expand start-->
            <div id="show_corres_cont" style="display:none;">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="corres_cont_name" name="corres_cont_name" class="form-control">
              </div>

              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="corres_cont_telephone" name="corres_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" id="corres_cont_mobile" name="corres_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="corres_cont_email" name="corres_cont_email" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="corres_cont_website" name="corres_cont_website" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="corres">New</a> | <a javascript:void(0) class="editAddress" data-address_type="corres">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="corres">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="corres">View</a></label>
                <select class="form-control get_orgoldcont_address" id="corres_address" data-type="corres">
                  <option value="">-- Select Address --</option>
                  @if(isset($cont_address) && count($cont_address)>0)
                    @foreach($cont_address as $key=>$address_row)
                      <option value="{{ $address_row['address_id'] }}">{{ $address_row['fullAddress'] }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
                            
              
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Bankers</label>
              <input type="checkbox" class="cont_all_addr" name="cont_banker_addr" value="banker" />
            </div>
                
                
                
                
            <div class="address_type" id="show_banker_office_addr">
             <div class="form-group">
                                  <label for="exampleInputPassword1">Bank Name</label>
                                  <input type="text" id="bank_name" name="bank_name" class="form-control">
                                </div>
             <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Sort Code</label>
                                  <input type="text" id="bank_short_code" name="bank_short_code" class="form-control">
                                  
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Account Number</label>
                                  <input type="text" id="bank_acc_no" name="bank_acc_no" class="form-control">
                                  
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
              <div class="form-group">
                            
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="banker_name_check" value="banker_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_banker_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="banker_cont_name" name="banker_cont_name" class="form-control">
              </div>

              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="banker_cont_telephone" name="banker_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" id="banker_cont_mobile" name="banker_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="banker_cont_email" name="banker_cont_email" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="banker_cont_website" name="banker_cont_website" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->

              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="banker">New</a> | <a javascript:void(0) class="editAddress" data-address_type="banker">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="banker">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="banker">View</a></label>
                <select class="form-control get_orgoldcont_address" id="banker_address" data-type="banker">
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
                <input type="text" id="banker_cont_addr_line1" name="banker_cont_addr_line1" class="form-control toUpperCase" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="banker_cont_addr_line2" name="banker_cont_addr_line2" class="form-control toUpperCase" readonly>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="banker_cont_city" name="banker_cont_city" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="banker_cont_county" name="banker_cont_county" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="banker_cont_postcode" name="banker_cont_postcode" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="banker_cont_country" name="banker_cont_country" readonly>
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

                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="banker_cont_website" name="banker_cont_website" class="form-control">
                </div>
                <div class="clearfix"></div>
              </div> -->
            </div>
          
                
            <div class="form-group">
              <label for="exampleInputPassword1">Old Accountants</label>
              <input type="checkbox" class="cont_all_addr" name="cont_oldacc_addr" value="oldacc" />
            </div>

            <div class="address_type" id="show_oldacc_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="oldacc_name_check" value="oldacc_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_oldacc_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="banker_cont_name" name="oldacc_cont_name" class="form-control">
              </div>

              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="oldacc_cont_telephone" name="oldacc_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" id="oldacc_cont_mobile" name="oldacc_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="oldacc_cont_email" name="oldacc_cont_email" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="oldacc_cont_website" name="oldacc_cont_website" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="oldacc">New</a> | <a javascript:void(0) class="editAddress" data-address_type="oldacc">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="oldacc">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="oldacc">View</a></label>
                <select class="form-control get_orgoldcont_address" id="oldacc_address" data-type="oldacc">
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
                <input type="text" id="oldacc_cont_addr_line1" name="oldacc_cont_addr_line1" class="form-control toUpperCase" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="oldacc_cont_addr_line2" name="oldacc_cont_addr_line2" class="form-control toUpperCase" readonly>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="oldacc_cont_city" name="oldacc_cont_city" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="oldacc_cont_county" name="oldacc_cont_county" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="oldacc_cont_postcode" name="oldacc_cont_postcode" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="oldacc_cont_country" name="oldacc_cont_country" readonly>
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

                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="oldacc_cont_website" name="oldacc_cont_website" class="form-control">
                </div>
                <div class="clearfix"></div>
              </div> -->
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Auditors</label>
              <input type="checkbox" class="cont_all_addr" name="cont_auditors_addr" value="auditors" />
            </div>

            <div class="address_type" id="show_auditors_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="auditors_name_check" value="auditors_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_auditors_cont" style="display:none;">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="auditors_cont_name" name="auditors_cont_name" class="form-control">
              </div>

              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="auditors_cont_telephone" name="auditors_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" id="auditors_cont_mobile" name="auditors_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="auditors_cont_email" name="auditors_cont_email" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="auditors_cont_website" name="auditors_cont_website" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="auditors">New</a> | <a javascript:void(0) class="editAddress" data-address_type="auditors">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="auditors">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="auditors">View</a></label>
                <select class="form-control get_orgoldcont_address" id="auditors_address" data-type="auditors">
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
                <input type="text" id="auditors_cont_addr_line1" name="auditors_cont_addr_line1" class="form-control toUpperCase" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="auditors_cont_addr_line2" name="auditors_cont_addr_line2" class="form-control toUpperCase" readonly>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="auditors_cont_city" name="auditors_cont_city" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="auditors_cont_county" name="auditors_cont_county" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="auditors_cont_postcode" name="auditors_cont_postcode" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="auditors_cont_country" name="auditors_cont_country" readonly>
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

                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="auditors_cont_website" name="auditors_cont_website" class="form-control">
                </div>
                <div class="clearfix"></div>
              </div> -->
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Solicitors</label>
              <input type="checkbox" class="cont_all_addr" name="cont_solicitors_addr" value="solicitors" />
            </div>

            <div class="address_type" id="show_solicitors_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="solicitors_name_check" value="solicitors_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_solicitors_cont" style="display:none;">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="solicitors_cont_name" name="solicitors_cont_name" class="form-control">
              </div>

              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="solicitors_cont_telephone" name="solicitors_cont_telephone" class="form-control">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" id="solicitors_cont_mobile" name="solicitors_cont_mobile" class="form-control">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" id="solicitors_cont_email" name="solicitors_cont_email" class="form-control">
              </div>
                
              <div class="form-group">
                <label for="exampleInputPassword1">Website</label>
                <input type="text" id="solicitors_cont_website" name="solicitors_cont_website" class="form-control">
              </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="solicitors">New</a> | <a javascript:void(0) class="editAddress" data-address_type="solicitors">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="solicitors">Delete</a> | <a javascript:void(0) class="copyAddress" data-address_type="solicitors">View</a></label>
                <select class="form-control get_orgoldcont_address" id="solicitors_address" data-type="solicitors">
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
                <input type="text" id="solicitors_cont_addr_line1" name="solicitors_cont_addr_line1" class="form-control toUpperCase" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="solicitors_cont_addr_line2" name="solicitors_cont_addr_line2" class="form-control toUpperCase" readonly>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="solicitors_cont_city" name="solicitors_cont_city" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="solicitors_cont_county" name="solicitors_cont_county" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="solicitors_cont_postcode" name="solicitors_cont_postcode" class="form-control toUpperCase" readonly>
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="solicitors_cont_country" name="solicitors_cont_country" readonly>
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

                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="solicitors_cont_website" name="solicitors_cont_website" class="form-control">
                </div>
                <div class="clearfix"></div>
              </div> -->
            </div>
            
            <!-- <div class="form-group">
              <label for="exampleInputPassword1">Others</label>
              <input type="checkbox" name="cont_others_addr" id="cont_others_addr" value="8" />
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Notes</label>
             <textarea rows="3" name="notes" id="notes" class="form-control"></textarea>
            </div> -->


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
                        <div class="col-xs-12 col-xs-6"> </div>
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



  <!-- <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> New Relationship</a> -->
  <!-- <select name="add_new_entity" id="add_new_entity" class="add_new_entity">
    <option value="">ADD NEW ENTITY</option>
    <option value="non">NON - CLIENT</option>
    <option value="org">CLIENT - ORG</option>
    <option value="ind">CLIENT - IND</option>
  </select> -->

<div style="width:100%;">
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

<div style="float: left; margin: 4px 0 0 5px;"><button type="button" class="btn btn-default btn-sm imported_officers">VIEW/ADD IMPORTED OFFICERS</button></div>

</div>
<!-- <li>
<div class="form-group">
  <a href="/organisation/add-client" target="_blank" class="btn btn-info"><i class="fa fa-plus"></i> New Client-Organ</a>
</div>
</li>
<li>
<div class="form-group">
  <a href="/individual/add-client"target="_blank" class="btn btn-info"><i class="fa fa-plus"></i> New Client-Inv</a>
</div>
</li> -->
<!-- <li>
<div class="form-group">
  <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_to_list-modal">ADD TO LIST</a>
</div>
</li> -->

 


<div class="box-body table-responsive">
  <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
  <input type="hidden" id="app_hidd_array" name="app_hidd_array" value="">
  <input type="hidden" id="search_client_type" name="search_client_type" value="ind">
  <!-- <input type="hidden" id="rel_client_id" name="rel_client_id" value=""> -->
  <table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
    <tr>
      <td width="40%"><strong>Name</strong></td>
      <td width="40%" align="center"><strong>Relationship Type</strong></td>
      <!-- <td width="10%" align="center"><strong>Acting</strong></td> -->
      <td width="20%" align="center"><strong>Action</strong></td>
    </tr>

  </table>

    <div class="contain_tab4" id="new_relationship" style="display:none;">
      <div class="contain_search" id="client_dropdown">
        <!-- <input type="text" placeholder="Search..." class="form-control all_relclient_search" id="relname" name="relname">
        <div class="search_value show_search_client" id="show_search_client"></div> -->
        <select class="form-control" name="rel_client_id" id="rel_client_id">
            <!-- @if(isset($allClients) && count($allClients)>0)
              @foreach($allClients as $key=>$client_row)
              <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
              @endforeach
            @endif -->
          </select>
      </div>

      <!-- <div class="contain_date"><input type="text" id="app_date" name="app_date" class="form-control"></div> -->

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


<div style="margin-top: 10px;">
  <button type="button"  onClick="show_div()" class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>
  <!-- <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> Add new line</a> -->
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
                           <!-- <h3 class="box-title">OTHERS</h3>
                            <h4 class="box-title">Bank Details</h4>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Bank Name</label>
                                  <input type="text" id="bank_name" name="bank_name" class="form-control">
                                </div>
                              </div> -->
                              <!-- <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Sort Code</label>
                                  <input type="text" id="bank_short_code" name="bank_short_code" class="form-control">
                                </div>
                              </div> 
                              <div class="clearfix"></div>
                            </div>-->

                           <!-- <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Sort Code</label>
                                  <input type="text" id="bank_short_code" name="bank_short_code" class="form-control">
                                  
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Account Number</label>
                                  <input type="text" id="bank_acc_no" name="bank_acc_no" class="form-control">
                                  
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
-->
<!--
  @if(isset($user_type) && $user_type != "C")                      
      <div class="twobox">
        <div class="twobox_1">
          <div class="form-group">
            <label for="exampleInputPassword1">Marketing Source</label>
            <input type="text" id="bank_mark_source" name="bank_mark_source" class="form-control">
          </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
  @endif
-->
      <div class="other_table">
  @if(isset($user_type) && $user_type != "C")
    <div class="row">
      <div class="col-md-2"><h3 class="box-title">Services</h3></div>
      <div class="add_edit col-md-3">
        <a href="#" class="add_to_list" data-toggle="modal" data-target="#services-modal"> Add/Edit list</a>
      </div>
    </div>
      <div class="clearfix"></div>

      <div class="form-group">
      <table width="100%" id="myServTable" class="myServTable">
        @if( isset($old_services) && count($old_services)>0 )
          @foreach($old_services as $key=>$service_row)
          <tr>
            <td align="center" width="40%"><span class="custom_chk chk_fixed"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" /><label><strong>{{ $service_row->service_name }}</strong></label></span></td>
          </tr>
          @endforeach
        @endif
        @if( isset($new_services) && count($new_services)>0 )
          @foreach($new_services as $key=>$service_row)
          <tr id="hide_service_tr_{{ $service_row->service_id }}">
            <td align="center" width="40%"><span class="custom_chk chk_fixed"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" /><label><strong>{{ $service_row->service_name }}</strong></label></span></td>
            <!-- <td width="30%"><a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a></td>
            <td align="left" widht="30%">
              <select class="form-control" name="staff_id" id="staff_id">
                <option value="">None</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                    <option value="{{ $staff_row->user_id }}">{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
                    @endforeach
                  @endif
                </select>
            </td> -->
          </tr>
          @endforeach
        @endif
        
        
      </table>
      </div>
      
    @endif


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
                        <div class="col-xs-12 col-xs-6">
                          
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <!-- /.tab-pane -->
              </div>
            </div>
          </div>
        
      </div>
    </section>

    {{ Form::close() }}

                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->




@include("home.include.client_modal_page")



@stop
