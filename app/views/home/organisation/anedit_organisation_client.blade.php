@extends('layouts.layout')

@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
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
    $("#app_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });

    $("#effective_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });

    $(".user_added_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });

    
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
    <input name="client_id" type="hidden" value="{{ $client_details['client_id'] or "" }}">
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
          <li id="tab_4"><a class="open_header" data-id="4" href="javascript:void(0)">RELATIONSHIP</a></li>
          <li id="tab_5"><a class="open_header" data-id="5" href="javascript:void(0)">OTHERS</a></li>
          <li><a href="#" class="btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field</a></li>
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

                      <div class="twobox">
                        <div class="twobox_1">
                          <div class="small_box">
                            <div class="form-group">
                              <label for="exampleInputPassword1">Client Code</label>
                
                              <input type="text" id="client_code" name="client_code" value="{{ $client_details['client_code'] or "" }}" class="form-control toUpperCase">

                            </div>
                          </div>
                        </div>
                        <div class="twobox_2">
                        
                        
                        
                <div class="form-group">
                  <label for="exampleInputPassword1">Business Type</label>
                   <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"> Add/Edit list</a>
                      
                    <select class="form-control" name="business_type" id="business_type">
                      @if( isset($old_org_types) && count($old_org_types) >0 )
                        @foreach($old_org_types as $key=>$old_org_row)
                        <option value="{{ $old_org_row->organisation_id }}" {{ (isset($client_details['business_type']) && $client_details['business_type'] == $old_org_row->organisation_id)?"selected":"" }}>{{ $old_org_row->name }}</option>
                        @endforeach
                      @endif

                      @if( isset($new_org_types) && count($new_org_types) >0 )
                        @foreach($new_org_types as $key=>$new_org_row)
                        <option value="{{ $new_org_row->organisation_id }}" {{ (isset($client_details['business_type']) && $client_details['business_type'] == $new_org_row->organisation_id)?"selected":"" }}>{{ $new_org_row->name }}</option>
                        @endforeach
                      @endif
                     
                    </select>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>


                            
          <div class="form-group">
            <label for="exampleInputPassword1">Business Name</label>
            <input type="text" id="business_name" name="business_name" value="{{ $client_details['business_name'] or "" }}" class="form-control toUpperCase">
          </div>

          <div class="twobox">
            <div class="threebox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Registration Number</label>

                <input type="text" id="registration_number" name="registration_number" value="{{ $client_details['registration_number'] or "" }}" class="form-control">

              </div>
            </div>
            <div class="threebox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Incorporation Date</label>
                <input type="text" id="incorporation_date" name="incorporation_date" value="{{ isset($client_details['incorporation_date'])?date("d-m-Y", strtotime($client_details['incorporation_date'])):"" }}" class="form-control">
              </div>
            </div>

            <div class="threebox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Registered In</label>
                <select class="form-control" name="registered_in" id="registered_in">
                  <option value="">NONE</option>
                 @if(isset($reg_address) && count($reg_address)>0)
                    @foreach($reg_address as $key=>$reg_row)
                    <option value="{{ $reg_row->reg_id }}" {{ (isset($client_details['registered_in']) && $client_details['registered_in'] == $reg_row->reg_id)?"selected":""}}>{{ $reg_row->reg_name }}</option>
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
        <input type="text" id="business_desc" name="business_desc" value="{{ $client_details['business_desc'] or "" }}" class="form-control">
      </div>

                            <!-- <h3 class="box-title">Annual Returns</h3> -->

      <div class="form-group">
        <label for="exampleInputPassword1">Annual Returns</label>
        <input type="checkbox" name="ann_ret_check" id="ann_ret_check" {{ (isset($client_details['ann_ret_check']) && $client_details['ann_ret_check'] == 1)?"checked":""}} value="1" />
      </div>


      <div id="show_ann_ret" style="display: {{ (isset($client_details['ann_ret_check']) && $client_details['ann_ret_check'] == 1)?'block':'none'}};">
        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Made up Date</label>
              <input type="text" id="made_up_date" name="made_up_date" value="{{ isset($client_details['made_up_date'])?date('d-m-Y', strtotime($client_details['made_up_date'])):'' }}" class="form-control">
            </div>
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Next Return Due</label>
              <input type="text" id="next_ret_due" name="next_ret_due"  value="{{ isset($client_details['next_ret_due'])?date('d-m-Y', strtotime($client_details['next_ret_due'])):'' }}" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">CH Authentication Code</label>

              <input type="text" id="ch_auth_code" name="ch_auth_code" value="{{ $client_details['ch_auth_code'] or '' }}" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
          




</div>


        <div class="form-group">
          <label for="exampleInputPassword1">Year End Accounts</label>
          <input type="checkbox" name="yearend_acc_check" id="yearend_acc_check" {{ (isset($client_details['yearend_acc_check']) && $client_details['yearend_acc_check'] == 1)?"checked":""}} value="1" />
        </div>






      <div id="show_year_end" style='display: {{ (isset($client_details['yearend_acc_check']) && $client_details['yearend_acc_check'] == 1)?"block":"none"}};'>
        <div class="twobox">
          <div class="twobox_1">
            <label for="exampleInputPassword1">Accounting Ref Date</label> 
            <div class="clearfix"></div>
            <div class="accountbox1">
            <div class="form-group">
              <select class="form-control" id="acc_ref_day" name="acc_ref_day">
                @for($i = 1; $i<=31;$i++)
                <option value="{{ $i }}" {{ (isset($client_details['acc_ref_day']) && $client_details['acc_ref_day'] == $i)?"selected":""}}>{{ $i }}</option>
                @endfor
              </select>
            </div>
          </div>

          <div class="accountbox2">
            <div class="form-group">

        <select class="form-control" name="acc_ref_month" id="acc_ref_month">
          @foreach($months as $key=>$row)
            <option value="{{ $key }}" {{ (isset($client_details['acc_ref_month']) && $client_details['acc_ref_month'] == $key)?"selected":""}}>{{ $row }}</option>
          @endforeach       
                
              </select>
            </div>
          </div>
            <div class="clearfix"></div>
          </div>

           <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Last Account Made Up Date</label>
              <input type="text" id="last_acc_madeup_date" name="last_acc_madeup_date" value='{{ isset($client_details['last_acc_madeup_date'])?date("d-m-Y", strtotime($client_details['last_acc_madeup_date'])):"" }}' class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Next Account Due</label>
              <input type="text" id="next_acc_due" name="next_acc_due" value='{{ isset($client_details['next_acc_due'])?date("d-m-Y", strtotime($client_details['next_acc_due'])):"" }}' class="form-control">
            </div>
          </div>

          <!-- <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Next Account Due</label>
              <input type="text" id="" class="form-control">
            </div>
          </div> -->
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
          <button class="btn btn-info open" data-id="2" type="button">Next</button>
          <button class="btn btn-success" type="submit">Save</button>
          <button class="btn btn-danger back" data-id="1" type="button">Cancel</button>
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
                              <input type="checkbox" name="reg_for_vat" id="reg_for_vat" {{ (isset($client_details['reg_for_vat']) && $client_details['reg_for_vat'] == 1)?"checked":""}} value="1" />
                            </div>
                            
                            <div class="registered_vat" id="show_reg_for_vat" style="display: {{ (isset($client_details['reg_for_vat']) && $client_details['reg_for_vat'] == 1)?'block':'none' }};">
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Effective Date of Registration</label>
                                  <input type="text" id="effective_date" name="effective_date" value="{{ isset($client_details['effective_date'])?date('d-m-Y', strtotime($client_details['effective_date'])):'' }}" class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Vat Number</label>
                                  <input type="text" id="vat_number" name="vat_number" value="{{ $client_details['vat_number'] or '' }}" class="form-control">
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
                                        <option value="{{ $scheme_row->vat_scheme_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->vat_scheme_id)?"selected":"" }}>{{ $scheme_row->vat_scheme_name }}</option>
                                      @endforeach
                                    @endif
                                    @if( isset($new_vat_schemes) && count($new_vat_schemes)>0 )
                                      @foreach($new_vat_schemes as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->vat_scheme_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->vat_scheme_id)?"selected":"" }}>{{ $scheme_row->vat_scheme_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select>
                                </div>
                              </div>
                              <div class="add_client_chk">
                                <div class="add_ch1">
                                  <div class="form-group">
                                  
                                 
                                
                                    <label for="exampleInputPassword1">Cash</label>
                                    <input type="radio" name="vat_scheme" value="cash"  {{ (isset($client_details['vat_scheme']) && $client_details['vat_scheme'] == "cash")?"checked":""}}  />
                                  </div>
                                </div>
                                <div class="add_ch2">
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Accrual</label>
                                    <input type="radio" name="vat_scheme" value="accrual" {{ (isset($client_details['vat_scheme']) && $client_details['vat_scheme'] == "accrual")?"checked":""}}  />
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
                                    
                                    <option value="quarterly" {{ (isset($client_details['ret_frequency']) && $client_details['ret_frequency'] == "quarterly")?"selected":""}}>Quarterly</option>
                                    <option value="monthly"{{ (isset($client_details['ret_frequency']) && $client_details['ret_frequency'] == "monthly")?"selected":""}}> Monthly</option>
                                    <option value="yearly" {{ (isset($client_details['ret_frequency']) && $client_details['ret_frequency'] == "yearly")?"selected":""}}> Yearly</option>
                                    
                                  </select>
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Vat Stagger</label>
                                  <select class="form-control" name="vat_stagger" id="vat_stagger">
                                    <option>Choose One</option>
                                    
                                     <option value="monthly"{{ (isset($client_details['vat_stagger']) && $client_details['vat_stagger'] == "monthly")?"selected":""}}> Monthly</option>
                                    
                                  </select>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="exampleInputPassword1">EC Sales List</label>
                                <input type="checkbox" name="ec_scale_list" id="ec_scale_list" {{ (isset($client_details['ec_scale_list']) && $client_details['ec_scale_list'] == "on" )?"checked":""}} value="on" />

                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Tax</label>
                               <input type="checkbox" id="tax_div" name="tax_div" {{ (isset($client_details['tax_div']) && $client_details['tax_div'] == 1)?"checked":""}}  value="1" >
                            </div>
                          
                          <div id="show_tax_div" style="display:{{ (isset($client_details['tax_div']) && $client_details['tax_div'] == 1)?'block':'none'}};"> 
                            <div class="tax_utr_con">
                            <div class="tax_utr">
                            <div class="form-group">
                              <label for="exampleInputPassword1">Tax Reference(UTR)</label>
                              <input type="text" id="tax_reference" name="tax_reference"  value="{{ $client_details['tax_reference'] or '' }}" class="form-control">
                            </div>
                            </div>

                            </div>


                            
          <div class="tax_utr_drop">
          <div class="form-group">
            <label for="exampleInputPassword1">Tax Type</label>

            <select class="form-control org_tax_reference" name="tax_reference_type" id="tax_reference_type">
              <option value="N" {{ (isset($client_details['tax_reference_type']) && $client_details['tax_reference_type'] == "N")?"selected":""}}>None</option>
              <option value="I"{{ (isset($client_details['tax_reference_type']) && $client_details['tax_reference_type'] == "I")?"selected":""}}>Income Tax</option>
              <option value="C"{{ (isset($client_details['tax_reference_type']) && $client_details['tax_reference_type'] == "C")?"selected":""}}>Corporation Tax</option>
            </select>

          </div>
          </div>
          <div class="clearfix"></div>
                            
                                                       

                            

        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Tax District</label>
               <select class="form-control" name="tax_office_id" id="tax_office_id" >
                  <!-- @if(!empty($tax_office))
                    @foreach($tax_office as $key=>$office_row)
                      @if($office_row->parent_id == 0)
                        <option value="{{ $office_row->office_id }}">{{ $office_row->office_name }}</option>
                      @endif
                    @endforeach
                  @endif -->
                    <option value="">-- Select AddresS --</option>
                    @if(isset($tax_office) && count($tax_office) >0)
                    @foreach($tax_office as $key=>$office_row)
                      @if($office_row->parent_id == 0)
                        <option value="{{ $office_row->office_id }}" {{ (isset($client_details['tax_office_id']) && $client_details['tax_office_id'] == $office_row->office_id)?"selected":""}} >{{ $office_row->office_name }}</option>
                      @endif
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
                        <option value="{{ $office_row->office_id }}" {{ (isset($client_details['tax_office_id']) && $client_details['tax_office_id'] == $office_row->office_id)?"selected":""}}>     {{ $office_row->office_name }}</option>
                      @endif
                    @endforeach
                  @endif
                    
                </select>
                
                
                
                
                <!--
                
                
                     
                    <select class="form-control" id="trad_cont_country" name="trad_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['trad_cont_country']) && $client_details['trad_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}"  {{ (isset($client_details['trad_cont_country']) && $client_details['trad_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                
                -->
                
                
                
                
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Postal Address</label>
            <textarea id="tax_address" name="tax_address" class="form-control" rows="3">{{ $client_details['tax_address'] or "" }} </textarea>
          </div>

          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Post Code</label>
                <input type="text" id="tax_zipcode" name="tax_zipcode" value="{{ $client_details['tax_zipcode'] or "" }}" class="form-control">
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Telephone</label>
                <input type="text" id="tax_telephone" name="tax_telephone" value="{{ $client_details['tax_telephone'] or "" }}" class="form-control">
              </div>
            </div>
            </div>
            <div class="clearfix"></div>
          </div>
      

                            
          <div class="form-group">
            <label for="exampleInputPassword1">PAYE Registered</label>
            <input type="checkbox" class="org_tax_payee_address" id="paye_reg" name="paye_reg" {{ (isset($client_details['paye_reg']) && $client_details['paye_reg'] == 1)?"checked":""}}   value="1" />
          </div>
                        
                        
                        
                        <div id="show_paye_reg" style="display:{{ (isset($client_details['paye_reg']) && $client_details['paye_reg'] == 1)?"block":"none"}};">    
                            <div class="form-group">
                              <label for="exampleInputPassword1">CIS Registered</label>
                              <input type="checkbox" name="cis_registered" name="cis_registered" {{ (isset($client_details['cis_registered']) && $client_details['cis_registered'] == "on" )?"checked":""}}   />
                            </div>

                            
                            
                            
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Account Office Reference</label>
                                  <input type="text" id="acc_office_ref" name="acc_office_ref" value="{{ $client_details['acc_office_ref'] or "" }}"  class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">

                                  <label for="exampleInputPassword1">PAYE Reference</label>
                                  <input type="text" id="paye_reference" name="paye_reference" value="{{ $client_details['paye_reference'] or "" }}" class="form-control">

                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">PAYE District</label>
                                  <input type="text" id="paye_district" name="paye_district" value="{{ $client_details['paye_district'] or "" }}" class="form-control">
                                </div>
                              </div>
                              <!-- <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Employer Office</label>
                              
                                  <input type="text" id="employer_office" name="employer_office" class="form-control">
                              
                                 
                                </div>
                              </div> -->
                              <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputPassword1">Employer Office</label>
                              <textarea class="form-control" cols="30" rows="3" id="employer_office" name="employer_office">{{ $client_details['employer_office'] or "" }}</textarea>
                            </div>

                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Post Code</label>
                                  <input type="text" name="employer_postcode" id="employer_postcode" value="{{ $client_details['employer_postcode'] or "" }}" class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Telephone</label>
                                  <input type="text" id="employer_telephone" name="employer_telephone" value="{{ $client_details['employer_telephone'] or "" }}" class="form-control">
                                </div>
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
  <button class="btn btn-info open"data-id="3" type="button">Next</button>
  <button class="btn btn-success" type="submit">Save</button>
  <button class="btn btn-danger back"data-id="1" type="button">Cancel</button>
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




           





              <div class="form-group">
                <label for="exampleInputPassword1">Trading Address</label>
                <input type="checkbox" class="cont_all_addr" value="trad" {{ (isset($client_details['cont_trad_addr']) && $client_details['cont_trad_addr'] == "trad")?"checked":""}} name="cont_trad_addr" />
              </div>
                       
                             
                            
            <div class="address_type" id="show_trad_office_addr" style="display: {{ (isset($client_details['cont_trad_addr']) && $client_details['cont_trad_addr'] == 'trad')?'block':'none' }};"> 
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="trad_name_check" value="trad_cont"  {{ (isset($client_details['trad_name_check']) && $client_details['trad_name_check'] == "trad_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_trad_cont" style="display: {{ (isset($client_details['trad_name_check']) && $client_details['trad_name_check'] == 'trad_cont')?'block':'none'}};">
              <div class="form-group">
                <input type="text" id="trad_cont_name" name="trad_cont_name" value="{{ $client_details['trad_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="trad_cont_tele_code" name="trad_cont_tele_code" value="{{ $client_details['trad_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="trad_cont_telephone" name="trad_cont_telephone" value="{{ $client_details['trad_cont_telephone'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="trad_cont_mobile_code" name="trad_cont_mobile_code" value="{{ $client_details['trad_cont_mobile_code'] or "" }}" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="trad_cont_mobile" name="trad_cont_mobile" value="{{ $client_details['trad_cont_mobile'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="trad_cont_email" name="trad_cont_email" value="{{ $client_details['trad_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="trad_cont_website" name="trad_cont_website" value="{{ $client_details['trad_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="trad_cont_skype" name="trad_cont_skype" value="{{ $client_details['trad_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="trad">
                  <option value="">-- Select Address --</option>
                  
                  
                  
                  
                  
                  @if(isset($cont_address) && count($cont_address) >0)
                    @foreach($cont_address as $key=>$address_row)
                        @if (isset($address_row['trad_cont_addr_line1']) && $address_row['trad_cont_addr_line1'] !="")
                            <option value="{{ $address_row['client_id'] }}"> {{ $address_row['trad_cont_addr_line1'] }}</option>
                       @endif
                    @endforeach
                 @endif
                  
                  
                  
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="trad_cont_addr_line1" name="trad_cont_addr_line1" value="{{ $client_details['trad_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="trad_cont_addr_line2" name="trad_cont_addr_line2"  value="{{ $client_details['trad_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="trad_cont_city" name="trad_cont_city" value="{{ $client_details['trad_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="trad_cont_county" name="trad_cont_county" value="{{ $client_details['trad_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="trad_cont_postcode" name="trad_cont_postcode" value="{{ $client_details['trad_cont_postcode'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                 
                  <div class="form-group">
                    
                    
                    
                    
                    <label for="exampleInputPassword1">Country</label>
                    
                    
                         
                    <select class="form-control" id="trad_cont_country" name="trad_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['trad_cont_country']) && $client_details['trad_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}"  {{ (isset($client_details['trad_cont_country']) && $client_details['trad_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  
                  
                  
                  
                  
                  </div>
                  
                  
                  
                  
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
                            
                            

            <div class="form-group">
              <label for="exampleInputPassword1">Registered Office Address</label>
              <input type="checkbox" class="cont_all_addr" value="reg" name="cont_reg_addr" {{ (isset($client_details['cont_reg_addr']) && $client_details['cont_reg_addr'] == "reg")?"checked":""}}  />
            </div>

            <div class="address_type" id="show_reg_office_addr" style="display: {{ (isset($client_details['cont_reg_addr']) && $client_details['cont_reg_addr'] == 'reg')?'block':'none'}};">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="reg_name_check" value="reg_cont" {{ (isset($client_details['reg_name_check']) && $client_details['reg_name_check'] == "reg_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_reg_cont" style="display: {{ (isset($client_details['reg_name_check']) && $client_details['reg_name_check'] == "reg_cont")?"block":"none"}};">
              <div class="form-group">
                <input type="text" id="reg_cont_name" name="reg_cont_name" value="{{ $client_details['reg_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="reg_cont_tele_code" name="reg_cont_tele_code" value="{{ $client_details['reg_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="reg_cont_telephone" name="reg_cont_telephone" value="{{ $client_details['reg_cont_telephone'] or "" }}"  class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="reg_cont_mobile_code" name="reg_cont_mobile_code" value="{{ $client_details['reg_cont_mobile_code'] or "" }}"  class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="reg_cont_mobile" name="reg_cont_mobile" value="{{ $client_details['reg_cont_name'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="reg_cont_email" name="reg_cont_email" value="{{ $client_details['reg_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="reg_cont_website" name="reg_cont_website" value="{{ $client_details['reg_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="reg_cont_skype" name="reg_cont_skype" value="{{ $client_details['reg_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="reg">
                  <option value="">-- Select Address --</option>
                      
                      @if(!empty($cont_address))
                        @foreach($cont_address as $key=>$address_row)
                            @if (isset($address_row['reg_cont_addr_line1']) && $address_row['reg_cont_addr_line1'] !="")
                                <option value="{{ $address_row['client_id'] }}"> {{ $address_row['reg_cont_addr_line1'] }}</option>
                           @endif
                        @endforeach
                 @endif
                      
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="reg_cont_addr_line1" name="reg_cont_addr_line1" value="{{ $client_details['reg_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="reg_cont_addr_line2" name="reg_cont_addr_line2" value="{{ $client_details['reg_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="reg_cont_city" name="reg_cont_city" value="{{ $client_details['reg_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="reg_cont_county" name="reg_cont_county" value="{{ $client_details['reg_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="reg_cont_postcode" name="reg_cont_postcode" value="{{ $client_details['reg_cont_postcode'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    
                    
                    
                    <select class="form-control" id="reg_cont_country" name="reg_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['reg_cont_country']) && $client_details['reg_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['reg_cont_country']) && $client_details['reg_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
            
            
            <div class="form-group">
              <label for="exampleInputPassword1">Correspondence Address</label>
              <input type="checkbox" class="cont_all_addr" name="cont_corres_addr" value="corres" {{ (isset($client_details['cont_corres_addr']) && $client_details['cont_corres_addr'] == "corres")?"checked":""}} />
            </div>

            <div class="address_type" id="show_corres_office_addr" style="display: {{ (isset($client_details['cont_corres_addr']) && $client_details['cont_corres_addr'] == "corres")?"block":"none"}};">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="corres_name_check" value="corres_cont"  {{ (isset($client_details['corres_name_check']) && $client_details['corres_name_check'] == "corres_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_corres_cont" style="display: {{ (isset($client_details['corres_name_check']) && $client_details['corres_name_check'] == "corres_cont")?"block":"none"}};">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="corres_name" name="corres_cont_name" value="{{ $client_details['corres_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="corres_cont_tele_code" name="corres_cont_tele_code" value="{{ $client_details['corres_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="corres_cont_telephone" name="corres_cont_telephone"  value="{{ $client_details['corres_cont_telephone'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="corres_cont_mobile_code" name="corres_cont_mobile_code" value="{{ $client_details['corres_cont_mobile_code'] or "" }}" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="corres_cont_mobile" name="corres_cont_mobile" value="{{ $client_details['corres_cont_mobile'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="corres_cont_email" name="corres_cont_email" value="{{ $client_details['corres_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="corres_cont_website" name="corres_cont_website" value="{{ $client_details['corres_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="corres_cont_skype" name="corres_cont_skype" value="{{ $client_details['corres_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="corres">
                  <option value="">-- Select Address --</option>
                      @if(!empty($cont_address))
                        @foreach($cont_address as $key=>$address_row)
                            @if (isset($address_row['corres_cont_addr_line1']) && $address_row['corres_cont_addr_line1'] !="")
                                <option value="{{ $address_row['client_id'] }}"> {{ $address_row['corres_cont_addr_line1'] }}</option>
                           @endif
                        @endforeach
                    @endif
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="corres_cont_addr_line1" name="corres_cont_addr_line1" value="{{ $client_details['corres_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="corres_cont_addr_line2" name="corres_cont_addr_line2" value="{{ $client_details['corres_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="corres_cont_city" name="corres_cont_city" value="{{ $client_details['corres_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="corres_cont_county" name="corres_cont_county" value="{{ $client_details['corres_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="corres_cont_postcode" name="corres_cont_postcode" value="{{ $client_details['corres_cont_postcode'] or "" }}"  class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="corres_cont_country" name="corres_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['corres_cont_country']) && $client_details['corres_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['corres_cont_country']) && $client_details['corres_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Banker</label>
              <input type="checkbox" class="cont_all_addr" name="cont_banker_addr"  value="banker" {{ (isset($client_details['cont_banker_addr']) && $client_details['cont_banker_addr'] == "banker")?"checked":""}} />
            </div>

            <div class="address_type" id="show_banker_office_addr" style="display: {{ (isset($client_details['cont_banker_addr']) && $client_details['cont_banker_addr'] == "banker")?"block":"none"}};">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="banker_name_check"  value="banker_cont" {{ (isset($client_details['banker_name_check']) && $client_details['banker_name_check'] == "banker_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_banker_cont" style="display: {{ (isset($client_details['banker_name_check']) && $client_details['banker_name_check'] == "banker_cont")?"block":"none"}};">
              <div class="form-group">
                <input type="text" id="banker_cont_name" name="banker_cont_name" value="{{ $client_details['banker_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="banker_cont_tele_code" name="banker_cont_tele_code" value="{{ $client_details['banker_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="banker_cont_telephone" name="banker_cont_telephone" value="{{ $client_details['banker_cont_telephone'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="banker_cont_mobile_code" name="banker_cont_mobile_code" value="{{ $client_details['banker_cont_mobile_code'] or "" }}" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="banker_cont_mobile" name="banker_cont_mobile" value="{{ $client_details['banker_cont_mobile'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="banker_cont_email" name="banker_cont_email" value="{{ $client_details['banker_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="banker_cont_website" name="banker_cont_website" value="{{ $client_details['banker_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="banker_cont_skype" name="banker_cont_skype" value="{{ $client_details['banker_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="banker">
                  <option value="">-- Select Address --</option>
                       @if(!empty($cont_address))
                        @foreach($cont_address as $key=>$address_row)
                            @if (isset($address_row['banker_cont_addr_line1']) && $address_row['banker_cont_addr_line1'] !="")
                                <option value="{{ $address_row['client_id'] }}"> {{ $address_row['banker_cont_addr_line1'] }}</option>
                           @endif
                        @endforeach
                    @endif
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="banker_cont_addr_line1" name="banker_cont_addr_line1" value="{{ $client_details['banker_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="banker_cont_addr_line2" name="banker_cont_addr_line2" value="{{ $client_details['banker_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="banker_cont_city" name="banker_cont_city" value="{{ $client_details['banker_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="banker_cont_county" name="banker_cont_county" value="{{ $client_details['banker_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="banker_cont_postcode" name="banker_cont_postcode" value="{{ $client_details['banker_cont_postcode'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="banker_cont_country" name="banker_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['banker_cont_country']) && $client_details['banker_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['banker_cont_country']) && $client_details['banker_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
             <!-- <div class="form-group">
                  <label for="exampleInputPassword1">Trading Address</label>
                  <input type="checkbox"  name="cont_trad_addr" id="cont_trad_addr" value="4"/>
                </div> -->
                
            <div class="form-group">
              <label for="exampleInputPassword1">Old Accountants</label>
              <input type="checkbox" class="cont_all_addr" name="cont_oldacc_addr" value="oldacc" {{ (isset($client_details['cont_oldacc_addr']) && $client_details['cont_oldacc_addr'] == "oldacc")?"checked":""}} />
            </div>

            <div class="address_type" id="show_oldacc_office_addr" style="display: {{ (isset($client_details['cont_oldacc_addr']) && $client_details['cont_oldacc_addr'] == "oldacc")?"block":"none"}};">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="oldacc_name_check" value="oldacc_cont" {{ (isset($client_details['oldacc_name_check']) && $client_details['oldacc_name_check'] == "oldacc_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_oldacc_cont" style="display: {{ (isset($client_details['oldacc_name_check']) && $client_details['oldacc_name_check'] == "oldacc_cont")?"block":"none"}};">
              <div class="form-group">
                <input type="text" id="banker_cont_name" name="oldacc_cont_name" value="{{ $client_details['oldacc_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="oldacc_cont_tele_code" name="oldacc_cont_tele_code"  value="{{ $client_details['oldacc_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="oldacc_cont_telephone" name="oldacc_cont_telephone" value="{{ $client_details['oldacc_cont_telephone'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="oldacc_cont_mobile_code" name="oldacc_cont_mobile_code" value="{{ $client_details['oldacc_cont_mobile_code'] or "" }}" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="oldacc_cont_mobile" name="oldacc_cont_mobile" value="{{ $client_details['oldacc_cont_mobile'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="oldacc_cont_email" name="oldacc_cont_email" value="{{ $client_details['oldacc_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="oldacc_cont_website" name="oldacc_cont_website" value="{{ $client_details['oldacc_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="oldacc_cont_skype" name="oldacc_cont_skype" value="{{ $client_details['oldacc_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="oldacc">
                  <option value="">-- Select Address --</option>
                      @if(!empty($cont_address))
                        @foreach($cont_address as $key=>$address_row)
                            @if (isset($address_row['oldacc_cont_addr_line1']) && $address_row['oldacc_cont_addr_line1'] !="")
                                <option value="{{ $address_row['client_id'] }}"> {{ $address_row['oldacc_cont_addr_line1'] }}</option>
                           @endif
                        @endforeach
                    @endif
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="oldacc_cont_addr_line1" name="oldacc_cont_addr_line1" value="{{ $client_details['oldacc_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="oldacc_cont_addr_line2" name="oldacc_cont_addr_line2" value="{{ $client_details['oldacc_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="oldacc_cont_city" name="oldacc_cont_city" value="{{ $client_details['oldacc_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="oldacc_cont_county" name="oldacc_cont_county" value="{{ $client_details['oldacc_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="oldacc_cont_postcode" name="oldacc_cont_postcode" value="{{ $client_details['oldacc_cont_postcode'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="oldacc_cont_country" name="oldacc_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['oldacc_cont_country']) && $client_details['oldacc_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['oldacc_cont_country']) && $client_details['oldacc_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Auditors</label>
              <input type="checkbox" class="cont_all_addr" name="cont_auditors_addr" value="auditors" {{ (isset($client_details['cont_auditors_addr']) && $client_details['cont_auditors_addr'] == "auditors")?"checked":""}} />
            </div>

            <div class="address_type" id="show_auditors_office_addr" style="display: {{ (isset($client_details['cont_auditors_addr']) && $client_details['cont_auditors_addr'] == "auditors")?"block":"none"}};">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="auditors_name_check" value="auditors_cont" {{ (isset($client_details['auditors_name_check']) && $client_details['auditors_name_check'] == "auditors_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_auditors_cont" style="display: {{ (isset($client_details['auditors_name_check']) && $client_details['auditors_name_check'] == "auditors_cont")?"block":"none"}};">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="auditors_cont_name" name="auditors_cont_name" value="{{ $client_details['auditors_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="auditors_cont_tele_code" name="auditors_cont_tele_code" value="{{ $client_details['auditors_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="auditors_cont_telephone" name="auditors_cont_telephone" value="{{ $client_details['auditors_cont_telephone'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="auditors_cont_mobile_code" name="auditors_cont_mobile_code" value="{{ $client_details['auditors_cont_mobile_code'] or "" }}" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="auditors_cont_mobile" name="auditors_cont_mobile" value="{{ $client_details['auditors_cont_mobile'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="auditors_cont_email" name="auditors_cont_email" value="{{ $client_details['auditors_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="auditors_cont_website" name="auditors_cont_website" value="{{ $client_details['auditors_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="auditors_cont_skype" name="auditors_cont_skype" value="{{ $client_details['auditors_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="auditors">
                  <option value="">-- Select Address --</option>
                       @if(!empty($cont_address))
                        @foreach($cont_address as $key=>$address_row)
                            @if (isset($address_row['auditors_cont_addr_line1']) && $address_row['auditors_cont_addr_line1'] !="")
                                <option value="{{ $address_row['client_id'] }}"> {{ $address_row['auditors_cont_addr_line1'] }}</option>
                           @endif
                        @endforeach
                    @endif
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="auditors_cont_addr_line1" name="auditors_cont_addr_line1" value="{{ $client_details['auditors_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="auditors_cont_addr_line2" name="auditors_cont_addr_line2" value="{{ $client_details['auditors_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="auditors_cont_city" name="auditors_cont_city" value="{{ $client_details['auditors_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="auditors_cont_county" name="auditors_cont_county" value="{{ $client_details['auditors_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="auditors_cont_postcode" name="auditors_cont_postcode" value="{{ $client_details['auditors_cont_postcode'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="auditors_cont_country" name="auditors_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['auditors_cont_country']) && $client_details['auditors_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['auditors_cont_country']) && $client_details['auditors_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Solicitors</label>
              <input type="checkbox" class="cont_all_addr" name="cont_solicitors_addr" value="solicitors" {{ (isset($client_details['cont_solicitors_addr']) && $client_details['cont_solicitors_addr'] == "solicitors")?"checked":""}} />
            </div>

            <div class="address_type" id="show_solicitors_office_addr" style="display: {{ (isset($client_details['cont_solicitors_addr']) && $client_details['cont_solicitors_addr'] == "solicitors")?"block":"none"}};">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="solicitors_name_check" value="solicitors_cont" {{ (isset($client_details['solicitors_name_check']) && $client_details['solicitors_name_check'] == "solicitors_cont")?"checked":""}} />
              </div>

              <!-- Contact address expand start-->
            <div id="show_solicitors_cont" style="display: {{ (isset($client_details['solicitors_name_check']) && $client_details['solicitors_name_check'] == "solicitors_cont")?"block":"none"}};">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="solicitors_cont_name" name="solicitors_cont_name" value="{{ $client_details['solicitors_cont_name'] or "" }}" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="solicitors_cont_tele_code" name="solicitors_cont_tele_code" value="{{ $client_details['solicitors_cont_tele_code'] or "" }}" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="solicitors_cont_telephone" name="solicitors_cont_telephone" value="{{ $client_details['solicitors_cont_telephone'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="solicitors_cont_mobile_code" name="solicitors_cont_mobile_code" value="{{ $client_details['solicitors_cont_mobile_code'] or "" }}" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="solicitors_cont_mobile" name="solicitors_cont_mobile" value="{{ $client_details['solicitors_cont_mobile'] or "" }}" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="text" id="solicitors_cont_email" name="solicitors_cont_email" value="{{ $client_details['solicitors_cont_email'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Website</label>
                  <input type="text" id="solicitors_cont_website" name="solicitors_cont_website" value="{{ $client_details['solicitors_cont_website'] or "" }}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="solicitors_cont_skype" name="solicitors_cont_skype" value="{{ $client_details['solicitors_cont_skype'] or "" }}" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_orgoldcont_address" id="get_orgoldcont_address" data-type="solicitors">
                  <option value="">-- Select Address --</option>
                       @if(!empty($cont_address))
                        @foreach($cont_address as $key=>$address_row)
                            @if (isset($address_row['solicitors_cont_addr_line1']) && $address_row['solicitors_cont_addr_line1'] !="")
                                <option value="{{ $address_row['client_id'] }}"> {{ $address_row['solicitors_cont_addr_line1'] }}</option>
                           @endif
                        @endforeach
                    @endif
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="solicitors_cont_addr_line1" name="solicitors_cont_addr_line1" value="{{ $client_details['solicitors_cont_addr_line1'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="solicitors_cont_addr_line2" name="solicitors_cont_addr_line2" value="{{ $client_details['solicitors_cont_addr_line2'] or "" }}" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="solicitors_cont_city" name="solicitors_cont_city" value="{{ $client_details['solicitors_cont_city'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="solicitors_cont_county" name="solicitors_cont_county" value="{{ $client_details['solicitors_cont_county'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="solicitors_cont_postcode" name="solicitors_cont_postcode" value="{{ $client_details['solicitors_cont_postcode'] or "" }}" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="solicitors_cont_country" name="solicitors_cont_country">
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['solicitors_cont_country']) && $client_details['solicitors_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif
                      @if(!empty($countries))
                        @foreach($countries as $key=>$country_row)
                        @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                          <option value="{{ $country_row->country_id }}" {{ (isset($client_details['solicitors_cont_country']) && $client_details['solicitors_cont_country'] == $country_row->country_id)?"selected":""}}>{{ $country_row->country_name }}</option>
                        @endif
                        @endforeach
                      @endif   
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
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
  <button class="btn btn-info open" data-id="4" type="button">Next</button>
  <button class="btn btn-success" type="submit">Save</button>
  <button class="btn btn-danger back" data-id="2" type="button">Cancel</button>
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
<h3 class="box-title">RELATIONSHIP</h3> 
<div class="top_bts">
<ul style="padding: 0;">  
<li>
<div class="form-group">
  <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> New Relationship</a>
</div>
</li>
<li>
<div class="form-group">
  <a href="/organisation/add-client" target="_blank" class="btn btn-info"><i class="fa fa-plus"></i> New Client-Organ</a>
</div>
</li>
<li>
<div class="form-group">
  <a href="/individual/add-client"target="_blank" class="btn btn-info"><i class="fa fa-plus"></i> New Client-Inv</a>
</div>
</li>
</ul>  
</div> 

<div class="box-body table-responsive">
<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
<input type="hidden" id="app_hidd_array" name="app_hidd_array" value="">
<input type="hidden" id="search_client_type" name="search_client_type" value="ind">
<input type="hidden" id="rel_client_id" name="rel_client_id" value="">
<table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
  <tr>
    <td width="25%"><strong>Name</strong></td>
    <td width="26%" align="center"><strong>Appointment Date</strong></td>
    <td width="26%" align="center"><strong>Relationship Type</strong></td>
    <td width="10%" align="center"><strong>Acting</strong></td>
    <td width="13%" align="center"><strong>Action</strong></td>
    
  </tr>

  @if(isset($relationship) && count($relationship) >0 )
    @foreach($relationship as $key=>$relation_row)
      <tr id="database_tr{{ $relation_row['client_relationship_id'] }}">
        <td width="25%">{{ $relation_row['name'] or "" }}</td>
        <td width="26%" align="center">{{ $relation_row['appointment_date'] }}</td>
        <td width="26%" align="center">{{ $relation_row['relation_type'] }}</td>
        <td width="10%" align="center"><input type="checkbox" class="rel_acting" name="rel_acting[]" id="rel_acting_{{ $relation_row['appointment_with'] }}" {{ (isset($relation_row['acting']) && $relation_row['acting'] == "Y")?"checked":"" }} value="{{ $relation_row['appointment_with'] }}"  data-edit_index="{{ $relation_row['client_relationship_id'] }}" data-officer_id="{{ $relation_row['appointment_with'] }}" /></td>
        <td width="13%" align="center">
          <a href="javascript:void(0)" class="edit_database_rel" data-edit_index="{{ $relation_row['client_relationship_id'] }}" data-officer_id="{{ $relation_row['appointment_with'] }}"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete_database_rel" data-delete_index="{{ $relation_row['client_relationship_id'] }}"><i class="fa fa-trash-o fa-fw"></i></a>
        </td>
      </tr>
    @endforeach
  @endif

  </table>





  <div class="contain_tab4" id="new_relationship" style="display:none;">
    <div class="contain_search">
      <input type="text" placeholder="Search..." class="form-control all_relclient_search" id="relname" name="relname">
      <div class="search_value show_search_client" id="show_search_client"></div>
    </div>

    <div class="contain_date"><input type="text" id="app_date" name="app_date" class="form-control"></div>

    <div class="contain_type">
      <select class="form-control" name="rel_type_id" id="rel_type_id">
          @if(!empty($rel_types))
            @foreach($rel_types as $key=>$rel_row)
            <option value="{{ $rel_row->relation_type_id }}">{{ $rel_row->relation_type }}</option>
            @endforeach
          @endif
        </select>
    </div>
    
    <div class="contain_action"><button class="btn btn-success" data-client_type="org" onClick="saveRelationship()" type="button">Add</button></div>
  </div>
    


</div>
</div>

<div class="add_client_btn">
  <button class="btn btn-info open" data-id="5" type="button">Next</button>
  <button class="btn btn-success" type="submit">Save</button>
  <button class="btn btn-danger back" data-id="3" type="button">Cancel</button>
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
                            <h3 class="box-title">OTHERS</h3>
                            <h4 class="box-title">Bank Details</h4>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Bank Name</label>
                                  <input type="text" id="bank_name" name="bank_name" value="{{ $client_details['bank_name'] or "" }}" class="form-control">
                                </div>
                              </div>
                              <!-- <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Sort Code</label>
                                  <input type="text" id="bank_short_code" name="bank_short_code" class="form-control">
                                </div>
                              </div> -->
                              <div class="clearfix"></div>
                            </div>

                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Sort Code</label>
                                  <input type="text" id="bank_short_code" name="bank_short_code" value="{{ $client_details['bank_short_code'] or "" }}" class="form-control">
                                  
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Account Number</label>
                                  <input type="text" id="bank_acc_no" name="bank_acc_no" value="{{ $client_details['bank_acc_no'] or "" }}" class="form-control">
                                  
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Marketing Source</label>
                                  <input type="text" id="bank_mark_source" name="bank_mark_source" value="{{ $client_details['bank_mark_source'] or "" }}" class="form-control">
                                </div>
                              </div>
                              
                              <div class="clearfix"></div>
                            </div>

                            <div class="director_table">
                            <div class="service_t">
                              <h3 class="box-title">Services</h3></div>
                              
                              <div class="add_edit">
                              <a href="#" class="add_to_list" data-toggle="modal" data-target="#services-modal"> Add/Edit list</a>
                              </div>
                              <div class="clearfix"></div>
                              <div class="form-group">
                                <a href="javascript:void(0)" class="btn btn-info" onClick="show_org_other_div()">Allocate Service to staff</a>
                              </div>
                              <div class="box-body table-responsive">
                                <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                                  <div class="row">
                                    <div class="col-xs-6"></div>
                                    <div class="col-xs-6"></div>
                                  </div>
  <table width="100%" class="table table-bordered table-hover dataTable" id="myServTable">
  <input type="hidden" id="serv_hidd_array" name="serv_hidd_array" value="">
    <tr>
      <td align="center"><strong>Service</strong></td>
      <td align="center"><strong>Staff</strong></td>
      <td align="center"><strong>Action</strong></td>
    </tr>
    
    
    
    
    
    
    
    
    
    
    
  </table>



<div class="contain_tab4" id="add_services_div" style="display:none;">
    <div class="services_search">
      <select class="form-control" name="service_id" id="service_id">
        <option value="">None</option>
          @if( isset($old_services) && count($old_services)>0 )
            @foreach($old_services as $key=>$service_row)
              <option value="{{ $service_row->service_id }}">{{ $service_row->service_name }}</option>
            @endforeach
          @endif
          @if( isset($new_services) && count($new_services)>0 )
            @foreach($new_services as $key=>$service_row)
              <option value="{{ $service_row->service_id }}">{{ $service_row->service_name }}</option>
            @endforeach
          @endif
            
        </select>
    </div>

    <div class="service">
      <select class="form-control" name="staff_id" id="staff_id">
        <option value="">None</option>
          @if(isset($staff_details) && count($staff_details) >0)
            @foreach($staff_details as $key=>$staff_row)
            <option value="{{ $staff_row->user_id }}">{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
            @endforeach
          @endif
        </select>
      
    </div>
    
    <div class="contain_action"><button class="btn btn-success" onClick="saveServices()" type="button">Add</button></div>
  </div>



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
<!-- <button class="btn btn-info">Next</button> -->
<button class="btn btn-success save" type="submit">Save</button>
<button class="btn btn-danger back" data-id="4" type="button">Cancel</button>
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
    <input type="hidden" name="client_type" value="org" />
    <input type="hidden" name="back_url" value="edit_org" />
    <input type="hidden" name="client_id" value="{{ $client_details['client_id'] }}">
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputPassword1">Select Section</label>
          <select class="form-control show_subsec" name="step_id" id="step_id" data-client_type="org">
            @if( isset($steps) && count($steps) >0 )
              @foreach($steps as $key=>$step_row)
                @if($step_row->step_id != '4' && $step_row->status == "old")
                  <option value="{{ $step_row->step_id }}">{{ ($step_row->step_id == 1)?"BUSINESS INFORMATION":$step_row->title }}</option>
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
              @foreach($substep as $key=>$step_row)
                <option value="{{ $step_row->step_id }}">{{ $step_row->title }}</option>
              @endforeach
            @endif
            <option value="new">Add new ...</option>
          </select>
        </div>
        <div class="input-group show_new_div" style="display:none;">
            <input type="text" class="form-control" name="subsec_name" id="subsec_name">
           <span class="input-group-addon"> <a href="javascript:void(0)" class="add_subsec_name" data-client_type="org">Save</a></span>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Field Name</label>
          <input type="text" id="field_name" name="field_name" class="form-control">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Field Type</label>
          <select class="form-control user_field_type" name="field_type" id="field_type">
            @if( isset($field_types) && count($field_types)>0 )
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


<!-- add/edit list -->
<div class="modal fade" id="addcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-business-type', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">

    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="org_name" name="org_name" placeholder="Business Type" class="form-control">
      </div>
      
      <div id="append_bussiness_type">
      @if( isset($old_org_types) && count($old_org_types) >0 )
        @foreach($old_org_types as $key=>$old_org_row)
        <div class="form-group">
          <label for="{{ $old_org_row->name }}">{{ $old_org_row->name }}</label>
        </div>
        @endforeach
      @endif

      @if( isset($new_org_types) && count($new_org_types) >0 )
        @foreach($new_org_types as $key=>$new_org_row)
        <div class="form-group" id="hide_div_{{ $new_org_row->organisation_id }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="delete_org_name" data-field_id="{{ $new_org_row->organisation_id }}"><img src="/img/cross.png" width="12"></a>
          <label for="{{ $new_org_row->name }}">{{ $new_org_row->name }}</label>
        </div>
        @endforeach
      @endif
      </div>
      
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_business_type" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- Vat Scheme Modal -->
<div class="modal fade" id="vatScheme-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" name="added_from" id="added_from" value="client">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="vat_scheme_name" id="vat_scheme_name" placeholder="Vat Scheme" class="form-control">
      </div>

      <div id="append_vat_scheme">
        @if( isset($old_vat_schemes) && count($old_vat_schemes) )
          @foreach($old_vat_schemes as $key=>$scheme_row)
            <div class="form-group">
              <label for="{{ $scheme_row->vat_scheme_name }}">{{ $scheme_row->vat_scheme_name }}</label>
            </div>
          @endforeach
        @endif

        @if( isset($new_vat_schemes) && count($new_vat_schemes) )
          @foreach($new_vat_schemes as $key=>$scheme_row)
            <div class="form-group" id="hide_vat_div_{{ $scheme_row->vat_scheme_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="delete_vat_scheme" data-field_id="{{ $scheme_row->vat_scheme_id }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $scheme_row->vat_scheme_name }}">{{ $scheme_row->vat_scheme_name }}</label>
            </div>
          @endforeach
        @endif
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- Services Modal Start-->
<div class="modal fade" id="services-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-services', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="service_name" id="service_name" placeholder="Service Name" class="form-control">
      </div>

      <div id="append_services">
      @if( isset($old_services) && count($old_services)>0 )
        @foreach($old_services as $key=>$service_row)
          <div class="form-group">
            <label for="{{ $service_row->service_id or "" }}">{{ $service_row->service_name or "" }}</label>
          </div>
        @endforeach
      @endif
      @if( isset($new_services) && count($new_services)>0 )
        @foreach($new_services as $key=>$service_row)
          <div class="form-group" id="hide_service_div_{{ $service_row->service_id }}">
            <a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id or "" }}"><img src="/img/cross.png" width="12"></a>
            <label for="{{ $service_row->service_id or "" }}">{{ $service_row->service_name or "" }}</label>
          </div>
        @endforeach
      @endif
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" id="save_services" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Services Modal End-->


<!-- Add Subsec Modal Start-->
<div class="modal fade" id="addsubsec-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-services', 'id'=>'field_form')) }}
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="service_name" placeholder="Service Name" class="form-control">
      </div>

      @if(isset($services) && count($services)>0)
        @foreach($services as $key=>$service_row)
          <div class="form-group">
            <a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id or "" }}"><img src="/img/cross.png" width="12"></a>
            <label for="{{ $service_row->service_id }}">{{ $service_row->service_name or "" }}</label>
          </div>
        @endforeach
      @endif
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="submit" class="btn btn-primary pull-left save_t" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Add Subsec Modal End-->









@stop