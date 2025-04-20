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
    <section class="content">
      <div class="row">
        <div class="top_bts">
          <ul>
            <li>
              <button class="btn btn-info">IMPORT FROM CH</button>
            </li>
            <li>
              <button class="btn btn-success">IMPORT FROM CSV</button>
            </li>
            <li>
              <button class="btn btn-primary">REQUEST FROM CLIENT</button>
            </li>
            <li>
              <button class="btn btn-danger">REQUEST FROM OLD ACCOUNTANT</button>
            </li>
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
                
                              <input type="text" id="client_code" name="client_code" class="form-control toUpperCase">

                            </div>
                          </div>
                        </div>
                        <div class="twobox_2">
                        
                        
                        
                <div class="form-group">
                  <label for="exampleInputPassword1">Business Type</label>
                   <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"> Add/Edit list</a>
                      
                    <select class="form-control" name="business_type" id="business_type">
                     @if(!empty($org_types))
                        @foreach($org_types as $key=>$org_row)
                        <option value="{{ $org_row->organisation_id }}">{{ $org_row->name }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
              </div>
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
                              <input type="text" id="business_desc" name="business_desc" class="form-control">
                            </div>

                            <!-- <h3 class="box-title">Annual Returns</h3> -->

                            <div class="form-group">
                              <label for="exampleInputPassword1">Annual Returns</label>
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

              <select class="form-control" name="acc_ref_month" id="acc_ref_month">

                <option value="JAN">JAN</option>
                <option value="FEB">FEB</option>
                <option value="MAR">MAR</option>
                <option value="APR">APR</option>
                <option value="MAY">MAY</option>
                <option value="JUN">JUN</option>
                <option value="JUL">JUL</option>
                <option value="AUG">AUG</option>
                <option value="SEPT">SEPT</option>
                <option value="OCT">OCT</option>
                <option value="NOV">NOV</option>
                <option value="DEC">DEC</option>            
                
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
              <label for="exampleInputPassword1">Next Account Due</label>
              <input type="text" id="next_acc_due" name="next_acc_due" class="form-control">
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
      <label for="exampleInputPassword1">{{ ucwords($row_fields->field_name) }} 
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
        <input type="date"  name="{{ strtolower($row_fields->field_name) }}">
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
            <input type="date"  name="{{ strtolower($row_fields['field_name']) }}">
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
          <!-- <button class="btn btn-success" type="button">Save</button> -->
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
                                    @if(!empty($vat_schemes))
                                      @foreach($vat_schemes as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->vat_scheme_id }}">{{ $scheme_row->vat_scheme_name }}</option>
                                      @endforeach
                                    @endif
                                  <!--  <option value="11">Others - specify</option> -->

                                    
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
                            <div class="form-group">
                              <label for="exampleInputPassword1">Tax</label>
                               <input type="checkbox" id="tax_div" name="tax_div" value="1" >
                            </div>
                          
                          <div id="show_tax_div" style="display:none;"> 
                            <div class="tax_utr_con">
                            <div class="tax_utr">
                            <div class="form-group">
                              <label for="exampleInputPassword1">Tax Reference(UTR)</label>
                              <input type="text" id="tax_reference" name="tax_reference" class="form-control">
                            </div>
                            </div>

                            </div>


                            
          <div class="tax_utr_drop">
          <div class="form-group">
            <label for="exampleInputPassword1">Tax Type</label>

            <select class="form-control org_tax_reference" name="tax_reference_type" id="tax_reference_type">
              <option value="N">None</option>
              <option value="I">Income Tax</option>
              <option value="C">Corporation Tax</option>
            </select>

          </div>
          </div>
          <div class="clearfix"></div>
                            
                                                       

                            

        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Tax District</label>
               <select class="form-control" name="tax_office_id" id="tax_office_id">
                  <!-- @if(!empty($tax_office))
                    @foreach($tax_office as $key=>$office_row)
                      @if($office_row->parent_id == 0)
                        <option value="{{ $office_row->office_id }}">{{ $office_row->office_name }}</option>
                      @endif
                    @endforeach
                  @endif -->
                    <option value="">-- Select Address --</option>
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
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Account Office Reference</label>
                                  <input type="text" id="acc_office_ref" name="acc_office_ref" class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                <div class="form-group">

                                  <label for="exampleInputPassword1">PAYE Reference</label>
                                  <input type="text" id="paye_reference" name="paye_reference" class="form-control">

                                </div>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">PAYE District</label>
                                  <input type="text" id="paye_district" name="paye_district" class="form-control">
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



<!-- This portion is for user created field -->
@if(!empty($steps_fields_users) && count($steps_fields_users) > 0)
  @foreach($steps_fields_users as $row_fields)
    @if(!empty($row_fields->step_id) && $row_fields->step_id == "2")
      <div class="form-group">
      <div class="twobox_2">
      <label for="exampleInputPassword1">{{ ucwords($row_fields->field_name) }} 
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
        <input type="date"  name="{{ strtolower($row_fields->field_name) }}">
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
            <input type="date"  name="{{ strtolower($row_fields['field_name']) }}">
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
  <!-- <button class="btn btn-success" type="button">Save</button> -->
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
                <input type="checkbox" class="cont_all_addr" value="trad" name="cont_trad_addr" />
              </div>
                            
            <div class="address_type" id="show_trad_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="trad_name_check" value="trad_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_trad_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="trad_cont_name" name="trad_cont_name" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="trad_cont_tele_code" name="trad_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="trad_cont_telephone" name="trad_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="trad_cont_mobile_code" name="trad_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="trad_cont_mobile" name="trad_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="trad_cont_skype" name="trad_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="trad_cont_addr_line1" name="trad_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="trad_cont_addr_line2" name="trad_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="trad_cont_city" name="trad_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="trad_cont_county" name="trad_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="trad_cont_postcode" name="trad_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="trad_cont_country" name="trad_cont_country">
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
              </div>
            </div>
                            
                            

            <div class="form-group">
              <label for="exampleInputPassword1">Registered Office Address</label>
              <input type="checkbox" class="cont_all_addr" value="reg" name="cont_reg_addr" />
            </div>

            <div class="address_type" id="show_reg_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="reg_name_check" value="reg_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_reg_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="reg_cont_name" name="reg_cont_name" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="reg_cont_tele_code" name="reg_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="reg_cont_telephone" name="reg_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="reg_cont_mobile_code" name="reg_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="reg_cont_mobile" name="reg_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="reg_cont_skype" name="reg_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="reg_cont_addr_line1" name="reg_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="reg_cont_addr_line2" name="reg_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="reg_cont_city" name="reg_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="reg_cont_county" name="reg_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="reg_cont_postcode" name="reg_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="reg_cont_country" name="reg_cont_country">
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
              </div>
            </div>
            
            
            
            <div class="form-group">
              <label for="exampleInputPassword1">Correspondence Address</label>
              <input type="checkbox" class="cont_all_addr" name="cont_corres_addr" value="corres" />
            </div>

            <div class="address_type" id="show_corres_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="corres_name_check" value="corres_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_corres_cont" style="display:none;">
              <div class="form-group">
                <!-- <label for="exampleInputPassword1">Address Line1</label> -->
                <input type="text" id="corres_name" name="corres_cont_name" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="corres_cont_tele_code" name="corres_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="corres_cont_telephone" name="corres_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="corres_cont_mobile_code" name="corres_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="corres_cont_mobile" name="corres_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="corres_cont_skype" name="corres_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="corres_cont_addr_line1" name="corres_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="corres_cont_addr_line2" name="corres_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="corres_cont_city" name="corres_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="corres_cont_county" name="corres_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="corres_cont_postcode" name="corres_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="corres_cont_country" name="corres_cont_country">
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
              </div>
            </div>
            
            <div class="form-group">
              <label for="exampleInputPassword1">Banker</label>
              <input type="checkbox" class="cont_all_addr" name="cont_banker_addr" value="banker" />
            </div>

            <div class="address_type" id="show_banker_office_addr">
              <div class="form-group">
                <label for="exampleInputPassword1">Contact Name</label>
                <input type="checkbox" class="cont_name_check" name="banker_name_check" value="banker_cont" />
              </div>

              <!-- Contact address expand start-->
            <div id="show_banker_cont" style="display:none;">
              <div class="form-group">
                <input type="text" id="banker_cont_name" name="banker_cont_name" class="form-control">
              </div>
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="banker_cont_tele_code" name="banker_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="banker_cont_telephone" name="banker_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="banker_cont_mobile_code" name="banker_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="banker_cont_mobile" name="banker_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="banker_cont_skype" name="banker_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="banker_cont_addr_line1" name="banker_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="banker_cont_addr_line2" name="banker_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="banker_cont_city" name="banker_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="banker_cont_county" name="banker_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="banker_cont_postcode" name="banker_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="banker_cont_country" name="banker_cont_country">
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
              </div>
            </div>
            
             <!-- <div class="form-group">
                  <label for="exampleInputPassword1">Trading Address</label>
                  <input type="checkbox"  name="cont_trad_addr" id="cont_trad_addr" value="4"/>
                </div> -->
                
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
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="oldacc_cont_tele_code" name="oldacc_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="oldacc_cont_telephone" name="oldacc_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="oldacc_cont_mobile_code" name="oldacc_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="oldacc_cont_mobile" name="oldacc_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="oldacc_cont_skype" name="oldacc_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="oldacc_cont_addr_line1" name="oldacc_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="oldacc_cont_addr_line2" name="oldacc_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="oldacc_cont_city" name="oldacc_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="oldacc_cont_county" name="oldacc_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="oldacc_cont_postcode" name="oldacc_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="oldacc_cont_country" name="oldacc_cont_country">
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
              </div>
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
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="auditors_cont_tele_code" name="auditors_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="auditors_cont_telephone" name="auditors_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="auditors_cont_mobile_code" name="auditors_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="auditors_cont_mobile" name="auditors_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="auditors_cont_skype" name="auditors_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="auditors_cont_addr_line1" name="auditors_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="auditors_cont_addr_line2" name="auditors_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="auditors_cont_city" name="auditors_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="auditors_cont_county" name="auditors_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="auditors_cont_postcode" name="auditors_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="auditors_cont_country" name="auditors_cont_country">
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
              </div>
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
              <div class="form-group">
                <div class="n_box01">
                  <label for="exampleInputPassword1">Country Code</label>
                  <input type="text" id="solicitors_cont_tele_code" name="solicitors_cont_tele_code" class="form-control">
                </div>

                <div class="telbox">
                  <label for="exampleInputPassword1">Telephone</label>
                    <input type="text" id="solicitors_cont_telephone" name="solicitors_cont_telephone" class="form-control"></div>
                  <div class="clearfix"></div>
                </div>

                <div class="form-group">
                  <div class="n_box01">
                    <label for="exampleInputPassword1">Country Code</label>
                    <input type="text" id="solicitors_cont_mobile_code" name="solicitors_cont_mobile_code" class="form-control">
                  </div>
                  <div class="telbox">
                  <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" id="solicitors_cont_mobile" name="solicitors_cont_mobile" class="form-control"></div>
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Skype</label>
                  <input type="text" id="solicitors_cont_skype" name="solicitors_cont_skype" class="form-control">
                </div>
            </div>
              <!-- Contact address expand end-->


              <div class="form-group">
                <label for="exampleInputPassword1">Select or Add</label>
                 <select class="form-control get_oldcont_address" id="get_oldcont_address" data-type="cont">
                  <option value="">-- Select Address --</option>
                    @if(!empty($cont_address))
                      @foreach($cont_address as $key=>$address_row)
                        @if( (isset($address_row['client_id']) && $address_row['client_id'] != "") && (isset($address_row['cont_addr_line1']) && $address_row['cont_addr_line1'] != ""))
                          <option value="{{ $address_row['client_id'] or '' }}">{{ $address_row['cont_addr_line1'] or "" }}, {{ $address_row['cont_addr_line2'] or "" }}</option>
                        @endif
                      @endforeach
                    @endif 
                  </select>
              </div>
                            
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line1</label>
                <input type="text" id="solicitors_cont_addr_line1" name="solicitors_cont_addr_line1" class="form-control toUpperCase">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Address Line2</label>
                <input type="text" id="solicitors_cont_addr_line2" name="solicitors_cont_addr_line2" class="form-control toUpperCase">
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">City/Town</label>
                    <input type="text" id="solicitors_cont_city" name="solicitors_cont_city" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">County</label>
                    <input type="text" id="solicitors_cont_county" name="solicitors_cont_county" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="twobox">
                <div class="twobox_1">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Postcode</label>
                    <input type="text" id="solicitors_cont_postcode" name="solicitors_cont_postcode" class="form-control toUpperCase">
                  </div>
                </div>
                <div class="twobox_2">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Country</label>
                    <select class="form-control" id="solicitors_cont_country" name="solicitors_cont_country">
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
      <label for="exampleInputPassword1">{{ ucwords($row_fields->field_name) }} 
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
        <input type="date"  name="{{ strtolower($row_fields->field_name) }}">
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
            <input type="date"  name="{{ strtolower($row_fields['field_name']) }}">
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
<!-- <button class="btn btn-success" type="button">Save</button> -->
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
    <td width="30%" align="center"><strong>Appointment Date</strong></td>
    <td width="30%" align="center"><strong>Relationship Type</strong></td>
    <td width="15%" align="center"><strong>Action</strong></td>
    
  </tr>

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
<!-- <button class="btn btn-success" type="button">Save</button> -->
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
                                  <input type="text" id="bank_name" name="bank_name" class="form-control">
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
                            
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Marketing Source</label>
                                  <input type="text" id="bank_mark_source" name="bank_mark_source" class="form-control">
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
        <option value=""></option>
          @if(!empty($services))
            @foreach($services as $key=>$service_row)
              <option value="{{ $service_row->service_id }}">{{ $service_row->service_name }}</option>
            @endforeach
          @endif
            
        </select>
    </div>

    <div class="service">
      <select class="form-control" name="staff_id" id="staff_id">
        <option value="">None</option>
          @if(!empty($staff_details))
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
      <label for="exampleInputPassword1">{{ ucwords($row_fields->field_name) }} 
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
        <input type="date"  name="{{ strtolower($row_fields->field_name) }}">
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
            <input type="date"  name="{{ strtolower($row_fields['field_name']) }}">
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
            @if( isset($steps) && count($steps) >0 )
              @foreach($steps as $key=>$step_row)
                @if($step_row->status == "new" && $step_row->parent_id == 1)
                  <option value="{{ $step_row->step_id }}">{{ $step_row->title }}</option>
                @endif
              @endforeach
            @endif
            <option value="new">Add new ...</option>
          </select>
        </div>
        <div class="input-group show_new_div" style="display:none;">
            <input type="text" class="form-control" name="subsec_name" id="subsec_name">
           <span class="input-group-addon"> <a href="javascript:void(0)" class="add_subsec_name" data-client_type="org"><i class="fa fa-plus"></i></a></span>
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
      
      @if(!empty($org_types))
        @foreach($org_types as $key=>$org_row)
        <div class="form-group">
        <a href="javascript:void(0)" title="Delete Field ?" class="delete_org_name" data-field_id="{{ $org_row->organisation_id }}"><img src="/img/cross.png" width="12"></a>
        <label for="{{ $org_row->name }}">{{ $org_row->name }}</label>
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
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="vat_scheme_name" placeholder="Vat Scheme" class="form-control">
      </div>

      @if(!empty($vat_schemes))
        @foreach($vat_schemes as $key=>$scheme_row)
          <div class="form-group">
            <a href="javascript:void(0)" title="Delete Field ?" class="delete_vat_scheme" data-field_id="{{ $scheme_row->vat_scheme_id }}"><img src="/img/cross.png" width="12"></a>
            <label for="{{ $scheme_row->vat_scheme_name }}">{{ $scheme_row->vat_scheme_name }}</label>
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
        <input type="text" name="service_name" placeholder="Service Name" class="form-control">
      </div>

      @if(!empty($services))
        @foreach($services as $key=>$service_row)
          <div class="form-group">
            <a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a>
            <label for="{{ $service_row->service_id }}">{{ $service_row->service_name }}</label>
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

      @if(!empty($services))
        @foreach($services as $key=>$service_row)
          <div class="form-group">
            <a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a>
            <label for="{{ $service_row->service_id }}">{{ $service_row->service_name }}</label>
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