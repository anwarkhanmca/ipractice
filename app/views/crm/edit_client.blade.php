@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!-- Date picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/jquery-ui.css') }}" />
<!-- Date picker script -->

<!-- Time picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/timepicki.css') }}" />
<!-- Time picker script -->

<!-- Add To Calender Start -->
<link href="{{ URL :: asset('css/atc-style-blue.css') }}" rel="stylesheet" type="text/css">
<!-- Add To Calender End -->      
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/crm_renewals.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL :: asset('js/crm.js') }}" type="text/javascript"></script> -->
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>
<!-- Date picker script -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script> 
<!-- Time picker script -->
<script src="{{ URL :: asset('js/jquery.price_format.2.0.js') }}" type="text/javascript"></script>

<!-- proposal js -->
<script src="{{ URL :: asset('js/proposal.js') }}" type="text/javascript"></script>
<!-- chart js -->
<script src="{{ URL :: asset('js/chartjs/Chart.min.js') }}"></script>
<!-- summernote js -->
<script src="{{ URL :: asset('js/summernote.js') }}"></script>
<!-- choosen js -->
<script src="{{ URL :: asset('js/chosen.js') }}"></script>

<!-- Add to Calender -->
<script type="text/javascript">(function () {
  if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
  if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
      var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
      s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
      //s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
      s.src = '/js/atc.min.js';
      var h = d[g]('body')[0];h.appendChild(s); }})();
</script>

<!-- page script -->
<script type="text/javascript">
$(".addto_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100" });
$(".task_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100" });
$('#calender_time').timepicki({
  show_meridian:false,
  //min_hour_value:0,
  max_hour_value:23,
  //step_size_minutes:15,
  //overflow_minutes:true,
  increase_direction:'up'
  //disable_keyboard_mobile: true
});

$('#task_time').timepicki({
  show_meridian:false,
  max_hour_value:23,
  increase_direction:'up'
});

  $("#close_date").datepicker({dateFormat:'dd-mm-yy',changeMonth:true,changeYear: true});
  $("#date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
  $("#engagement_date_txt").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
  $("#startdate_txt").datepicker({dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});

  $('#quoted_value').priceFormat({
      prefix: ''
  });
  $('#annual_revenue').priceFormat({
      prefix: ''
  });
  $('.amountformat').priceFormat({
      prefix: '',
      //centsSeparator: '.',
      //thousandsSeparator: ',',
    //  centsLimit: '',
  });
  $('#billing_amount_txt').priceFormat({
      prefix: ''
  });
</script>

<script src="{{ URL :: asset('js/jtablejs/renewals.js') }}" type="text/javascript"></script>

<!-- Editor -->
<script src="{{ URL :: asset('classy-editor/js/jquery.classyedit.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL :: asset('classy-editor/css/jquery.classyedit.css') }}" />

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
                <section class="content">
                
                <div class="row">
        <div class="practice_hed">
        <div class="top_bts">
          <ul>
            <li style="float:left;">
            
          
            <a href="/pdfdwonload/{{ $details['client_id'] }}/{{ $encoded_type }}/{{ base64_encode($tab_no) }}" class="btn btn-success" style=""><i class="fa fa-download"></i> Generate PDF</a>
           
          <!--     <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> 
            </li> 
            <li>
              <p style="margin: 4px 0 0 350px;font-size: 18px; font-weight: bold;color:#00acd6">  
                @if(isset($details['type']) && $details['type'] == "org")
                  <a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a>
                @else
                  <a href="/client/edit-ind-client/{{ $details['client_id'] }}/{{ base64_encode('ind_client') }}" target="_blank">{{ $details['client_name'] or "" }}</a>
                @endif
              </p>
              </li>
            <li style="margin: 6px 375px 0 -43px">
              <span class="social_icon"> 
                @if(isset($details['type']) && $details['type'] == "org")
                  <a href="https://twitter.com/search?q=one+direction&src=typd" target="_blank"><img src="/img/tw.png" /></a> 
                  <a href="https://www.facebook.com/public?query=fname+secondname+thirdname&type=pages" target="_blank"><img src="/img/fb.png" /></a> 
                  <a href="http://www.linkedin.com/company/fname-secondname-thirdname" target="_blank"><img src="/img/link.png" /></a>
                @else
                  <a href="https://twitter.com/search?q=one+direction&src=typd" target="_blank"><img src="/img/tw.png" /></a> 
                  <a href="https://www.facebook.com/public/secondname-fname" target="_blank"><img src="/img/fb.png" /></a>
                  <a href="https://www.linkedin.com/pub/dir/?first=alexander&last=rosse&search=Search" target="_blank"><img src="/img/link.png" /></a>
                @endif
                
              </span>
            </li>
            <!-- <li>
              <a href="javascript: history.back(1)" class="btn btn-danger">Cancel</a>
            </li>
            <li>
              <a href="javascript:void(0)" class="btn btn-info">Save/Edit</a>
            </li> -->
            <li>
              <p style="margin:0px 0 0 425px;"><a href="javascript:void(0)" class="btn btn-info" style="font-size: 18px; font-weight: bold;">{{ $initial_badge or "" }}</a></p>
            </li>
            <li>
              
              @if(isset($details['type']) && $details['type'] == 'ind')
                <a href="/client/edit-ind-client/{{$details['client_id']}}/{{base64_encode('ind_client')}}" target="_blank"><p style="margin: 6px 0 0 0;font-size:18px; font-weight:bold;color:#00acd6">{{ $client_name or ""}}</p></a>
              @else
                <a href="/client/edit-org-client/{{$details['client_id']}}/{{base64_encode('org_client')}}" target="_blank"><p style="margin: 6px 0 0 0;font-size:18px; font-weight:bold;color:#00acd6">{{ $client_name or ""}}</p></a>
              @endif
              
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>

        <div id="message_div"><!-- Loader image show while sync data --></div>
      </div>

      

      </div>
                
                
                
<input type="hidden" id="client_id" name="client_id" value="{{ $details['client_id'] }}">
<input type="hidden" id="status_id" name="status_id" value="{{ $status_id or "" }}">
    <div class="tabarea">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs nav-tabsbg">
          <li class="{{ ($tab_no == 1)?'active':'' }}"><a href="{{ $goto_url }}/{{ $details['client_id'] }}/{{ $encoded_type }}/{{ base64_encode('1') }}">BASIC INFORMATION</a></li>
          <!-- <li class=""><a data-toggle="tab" href="#tab_2">CONTACT INFORMATION</a></li> -->
          <li class="{{ ($tab_no == 2)?'active':'' }}"><a href="{{ $goto_url }}/{{ $details['client_id'] }}/{{ $encoded_type }}/{{ base64_encode('2') }}">BILLING & FEES</a></li>

          <div class="top_tabs">
            <li><a href="javascript:void(0)" class="notes-modal" data-added_from="N" data-action="add" data-renewal_id="0">+Notes</a></li>
            <!-- <li><a data-toggle="tab" href="#tab_5">+Engagement Letter</a></li> -->
          @if($tab_no == 2)
            <!-- <li><a data-toggle="tab" href="#tab_6">+New Contact</a></li> -->
          @endif
            <li><a href="javascript:void(0)" class="newtask-modal" data-task_action="add" data-task_id="0">+New Task</a></li>
            <li><a href="javascript:void(0)" data-type="{{ $details['type'] or "" }}" data-leads_id="0" data-lead_status="OPEN" data-open_from="CD_NEW" class="cd_opportunity-modal">+New Opportunity</a></li>
            <!-- <li><a data-toggle="tab" href="#tab_9">+New Quotes and Contracts</a></li> -->
            <li><a href="/crm/createProposal">+ Proposals</a></li>
            <li><a href="javascript:void(0)" data-added_from="L" class="notes-modal" data-action="add" data-renewal_id="0">+Log a Call</a></li>
          </div>
        </ul>
<div class="tab-content">
  <div id="tab_1" class="tab-pane {{ ($tab_no == 1)?'active':'' }}">
    <!--table area-->
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <h3 class="box-title">Account Detail</h3>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_table">
              <tr>
                <td width="11%"><strong>Client Type</strong></td>
                <td width="39%">{{ (isset($details['type']) && $details['type'] == 'org')?$details['business_type']:'Individual' }}</td>
                @if(isset($details['type']) && $details['type'] == "org")
                  <td width="11%"><strong>Website</strong></td>
                  <td width="39%">
                    @if(isset($details['corres_cont_website']) && $details['corres_cont_website'] != '')
                      {{ $details['corres_cont_website'] }}
                    @else
                    <!-- <a href="javascript:void(0)">Add..</a> -->
                    @endif
                  </td>
                @else
                  <td width="11%">&nbsp;</td>
                  <td width="39%">&nbsp;</td>
                @endif
              </tr>

              <tr>
                <td><strong>Engagement Date</strong></td>
                <td>
                  @if(isset($details['crm_leads_id']) && $details['crm_leads_id'] != "0")
                    {{ date('d-m-Y', strtotime($details['created'])) }}
                  @else
                    <div id="add_engagement_date_div">
                      @if(isset($acc_details['engagement_date']) && $acc_details['engagement_date'] != "")
                        <a href="javascript:void(0)" class="add_new_div" data-data_type="engagement_date" data-acc_id="{{ $acc_details['acc_id'] }}">{{ $acc_details['engagement_date'] }}</a>
                      @else
                        <a href="javascript:void(0)" class="add_new_div" data-data_type="engagement_date" data-acc_id="0">Add..</a>
                      @endif
                      </div>
                      <div id="engagement_date_div" style="display:none;">
                        <input type="text" class="form-control bottom_margin" id="engagement_date_txt">
                        <a href="javascript:void(0)" class="btn btn-info crm_but save_acc_details" data-data_type="engagement_date">Save</a>
                        <a href="javascript:void(0)" class="btn btn-danger crm_but add_new_div" data-data_type="engagement_date">Cancel</a>
                      </div>
                  @endif

                </td>
                <td><strong>Twitter Username</strong></td>
                <td>

                  <div id="add_twitter_div">
                  @if(isset($acc_details['twitter']) && $acc_details['twitter'] != "")
                    <a href="javascript:void(0)" class="add_new_div" data-data_type="twitter" data-acc_id="{{ $acc_details['acc_id'] }}">{{ $acc_details['twitter'] }}</a>
                  @else
                    <a href="javascript:void(0)" class="add_new_div" data-data_type="twitter" data-acc_id="0">Add..</a>
                  @endif
                  </div>
                  <div id="twitter_div" style="display:none;">
                    <input type="text" class="form-control bottom_margin" id="twitter_txt">
                    <a href="javascript:void(0)" class="btn btn-info crm_but save_acc_details" data-data_type="twitter">Save</a>
                    <a href="javascript:void(0)" class="btn btn-danger crm_but add_new_div" data-data_type="twitter">Cancel</a>
                  </div>

                </td>
              </tr>

            @if(isset($details['type']) && $details['type'] == "org")
              <tr>
                <td><strong>Contact Person</strong></td>
                <td>
                  <select class="form-control newdropdown select_acc_details" style="width:34.3%;height:30px;" data-data_type="contact_id" data-from='main' data-type="{{ $details['type'] or "" }}">
                    @if(isset($contact_persons) && count($contact_persons)>0)
                      @foreach($contact_persons as $key=>$contact_row)
                      <option value="{{ $contact_row['client_id'] or "" }}_{{ $contact_row['address_type'] or "" }}" {{ (isset($acc_details['contact_id']) && $acc_details['contact_id'] == $contact_row['client_id']."_".$contact_row['address_type'])?"selected":"" }}>{{ $contact_row['contact_name'] or "" }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
                <!-- <td><strong>Industry</strong></td>
                <td>
                  <select class="form-control newdropdown bottom_margin select_acc_details" id="form_industry" name="form_industry" data-data_type="industry_id" style="width:34.5%; height: 30px;">
                    <option value="0">-- None --</option>
                    @if(isset($industry_lists) && count($industry_lists) >0)
                      @foreach($industry_lists as $key=>$industry_row)
                        <option value="{{ $industry_row['industry_id'] }}" {{ (isset($acc_details['industry_id']) && $acc_details['industry_id'] == $industry_row['industry_id'])?"selected":"" }}>{{ $industry_row['industry_name'] }}</option>
                      @endforeach
                    @endif
                  </select>
                </td> -->
                <td><strong>Fax</strong></td>
                <td>
                  <div id="add_fax_div">
                    @if(isset($acc_details['fax']) && $acc_details['fax'] != "")
                    <a href="javascript:void(0)" class="add_new_div" data-data_type="fax" data-acc_id="{{ $acc_details['acc_id'] }}">{{ $acc_details['fax'] }}</a>
                  @else
                    <a href="javascript:void(0)" class="add_new_div" data-data_type="fax" data-acc_id="0">Add..</a>
                  @endif
                  </div>
                  <div id="fax_div" style="display:none;">
                    <input type="text" class="form-control bottom_margin" id="fax_txt">
                    <a href="javascript:void(0)" class="btn btn-info crm_but save_acc_details" data-data_type="fax">Save</a>
                    <a href="javascript:void(0)" class="btn btn-danger crm_but add_new_div" data-data_type="fax">Cancel</a>
                  </div>
                </td>
              </tr>
            @endif

              <tr>
                <td><strong>Email Address</strong></td>
                <td><span id="main_email">
                  @if(isset($details['type']) && $details['type'] == 'org')
                    {{ $details['corres_cont_email'] or "" }}
                  @else
                    {{ $details['res_email'] or "" }}
                  @endif
                  </span>
                </td>

                <td><strong>Phone</strong></td>
                <td><span id="main_phone">
                  @if(isset($details['type']) && $details['type'] == 'org')
                    {{ $details['corres_cont_mobile'] or "" }}
                  @else
                    {{ $details['res_telephone'] or "" }}
                  @endif
                </span>
                </td>
              </tr>

            
              <tr>
                @if(isset($details['type']) && $details['type'] == "org")
                <td><strong>Description</strong></td>
                <td cols="3">{{ $business_desc or "" }}</td>
                @endif
                <!-- <td><strong>Fax</strong></td>
                <td><a href="javascript:void(0)">Add..</a></td> -->
                <td><strong>Lead Source</strong></td>
                <td>
                  <select class="form-control newdropdown bottom_margin select_acc_details" id="form_lead_source" name="form_lead_source" data-data_type="lead_source_id" style="width:34.5%;">
                  <option value="0">-- None --</option>
                  @if(isset($old_lead_sources) && count($old_lead_sources) >0)
                    @foreach($old_lead_sources as $key=>$lead_row)
                      <option value="{{ $lead_row['source_id'] }}" {{ (isset($acc_details['lead_source_id']) && $acc_details['lead_source_id'] == $lead_row['source_id'])?"selected":"" }}>{{ $lead_row['source_name'] }}</option>
                    @endforeach
                  @endif
                  @if(isset($new_lead_sources) && count($new_lead_sources) >0)
                    @foreach($new_lead_sources as $key=>$lead_row)
                      <option value="{{ $lead_row['source_id'] }}" {{ (isset($acc_details['lead_source_id']) && $acc_details['lead_source_id'] == $lead_row['source_id'])?"selected":"" }}>{{ $lead_row['source_name'] }}</option>
                    @endforeach
                  @endif
                </select>
                </td>
              </tr>
            
              <!-- <tr>
                <td><strong>Description</strong></td>
                <td cols="3"><input type="text" class="bottom_margin" name="business_desc" id="business_desc" style="width:162%; padding-left: 4px;" value="{{ $details['business_desc'] or "" }}"></td>
                
              </tr> -->
            </table>
            <div class="basic_info_relationship">
              <ul>
                <li>
                  <p class="table_h">Relationships</p>
                  <table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
                    <tr>
                      <td width="40%"><strong>Name</strong></td>
                      <td width="40%" align="left"><strong>Relationship Type</strong></td>
                    
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
                        <td width="40%" align="left">{{ $relation_row['relation_type'] }}</td>
                      
                      </tr>
                    @endforeach
                  @endif

                  </table>
                </li>
                <li>
                  <p class="table_h">Additional Information</p>
                  <table align="center" border="0" cellspacing="0" cellpadding="0" class="" style="margin:5px auto; width:99%;">
                    <tr>
                      <td width="10%"><strong>VAT NO.</strong></td>
                      <td width="40%">{{ $details['vat_number'] or "" }}</td>
                      <td width="10%"><strong>Bank Name</strong></td>
                      <td width="40%">{{ $details['bank_name'] or "" }}</td>
                    </tr>
                    <tr>
                      <td><strong>Tax Reference</strong></td>
                      <td>{{ $details['tax_reference'] or "" }}</td>
                      <td><strong>Sort Code</strong></td>
                      <td>{{ $details['bank_short_code'] or "" }}</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><strong>Account Number</strong></td>
                      <td>{{ $details['bank_acc_no'] or "" }}</td>
                    </tr>
                  </table>
                </li>
                <li>
                 
                  <table  border="0" cellspacing="0" cellpadding="0" style=" width:100%;">
                    <tr>
                  
                      <td valign="top">
                       <table  border="0" cellspacing="0" cellpadding="0" class="" >
                    <tr>
                      <td class="table_h">Contact and Address Information</td>
                      <td width="10%">&nbsp;</td>
                      <td class="table_h">None &nbsp;</td>
                      <td><input type="radio" name="cont_address" class="cont_radio" value="none" checked /></td>
                      <td width="5%">&nbsp;</td>
                    @if(isset($details['type']) && $details['type'] == "org")
                      <td class="table_h">Same as Trading Address &nbsp;</td>
                      <td><input type="radio" name="cont_address" class="cont_radio" value="trad" data-type="{{ $details['type'] or "" }}" {{ (isset($details['crm_contact_type']) && $details['crm_contact_type'] == 'trad')?'checked':'' }} /></td>
                      <td width="5%">&nbsp;</td>
                      <td class="table_h">Correspondence Address</td>
                      <td>&nbsp;<input type="radio" name="cont_address" class="cont_radio" value="corres" data-type="{{ $details['type'] or "" }}" {{ (isset($details['crm_contact_type']) && $details['crm_contact_type'] == 'corres')?'checked':'' }} /></td>
                      <td width="5%">&nbsp;</td>
                      <td class="table_h">Registered Office Address</td>
                      <td class="table_h">&nbsp;<input type="radio" name="cont_address" class="cont_radio" value="reg" data-type="{{ $details['type'] or "" }}" {{ (isset($details['crm_contact_type']) && $details['crm_contact_type'] == 'reg')?'checked':'' }} /></td>
                    @else
                      <td class="table_h">Same as Service address &nbsp;</td>
                      <td><input type="radio" name="cont_address" class="cont_radio" value="serv" data-type="{{ $details['type'] or "" }}" {{ (isset($details['crm_contact_type']) && $details['crm_contact_type'] == 'serv')?'checked':'' }} /></td>
                      <td width="5%">&nbsp;</td>
                      <td class="table_h">Residential Address</td>
                      <td>&nbsp;<input type="radio" name="cont_address" class="cont_radio" value="res" data-type="{{ $details['type'] or "" }}" {{ (isset($details['crm_contact_type']) && $details['crm_contact_type'] == 'res')?'checked':'' }} /></td>
                    @endif
                    </tr>
                  </table>

                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>


                    <tr>
                      <td valign="top">
                      <table  border="0" cellspacing="0" cellpadding="0" style="width:100%" >
                    <tr>
                      <td width="18%" class="table_h">Billing address</td>
                      <td>
                        <span id="bill_address">
                          @if(isset($details['crm_contact_type']) && ($details['crm_contact_type'] == "" || $details['crm_contact_type'] == 'none'))
                            @if(isset($billing_address) && $billing_address == "")
                              <a href="javascript:void(0)" data-billing_id="0" class="open_billing_form">Add..</a>
                            @else
                              <a href="javascript:void(0)" data-billing_id="1" class="open_billing_form">{{ $billing_address or "" }}</a>
                            @endif
                          @else
                            {{ $billing_address or "" }}
                          @endif
                        </span>
                      </td>
                      <!-- <td><input type="text" name="address1" id="address1" class="td_gap bottom_margin" style="width:320px;" /></td>
                      <td><input type="text" name="address2" id="address2" class="td_gap bottom_margin" /></td>
                      <td><input type="text" name="city" id="city" class="td_gap bottom_margin" /></td>
                      <td><input type="text" name="county" id="county" class="td_gap bottom_margin" /></td>
                      <td>
                        <select class="form-control td_gap bottom_margin" style="width:180px; padding-top: 4px;" name="country" id="country">
                        @if(!empty($countries))
                          @foreach($countries as $key=>$country_row)
                          @if(!empty($country_row['country_code']) && $country_row['country_code'] == "GB")
                            <option value="{{ $country_row['country_id'] }}">{{ $country_row['country_name'] }}</option>
                          @endif
                          @endforeach
                        @endif
                        @if(!empty($countries))
                          @foreach($countries as $key=>$country_row)
                          @if(!empty($country_row['country_code']) && $country_row['country_code'] != "GB")
                            <option value="{{ $country_row['country_id'] }}">{{ $country_row['country_name'] }}</option>
                          @endif
                          @endforeach
                        @endif
                        </select>
                      </td>
                      <td><input type="text" name="postcode" id="postcode" class="td_gap bottom_margin" style="width:75px;" /></td> -->

                    </tr>
                  </table>
                </td>
                      
                    </tr>
                     <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </li>
                <!-- <li>
                  <p class="table_h">Opportunities</p>
                  <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                    <tr>
                      <td width="5%" align="center"><strong>Action</strong></td>
                      <td width="10%"><strong>Date</strong></td>
                      <td width="10%"><strong>Notes</strong></td>
                      <td width="20%"><strong>Stage</strong></td>
                      <td width="30%"><strong>Contact Name</strong></td>
                      <td width="15%"><strong>Amount</strong></td>
                      <td width="10%"><strong>Close Code</strong></td>
                    </tr>
                    @if(isset($opportunities) && count($opportunities) >0)
                      @foreach($opportunities as $key=>$value)
                      <tr>
                        <td align="center"><a href="javascript:void(0)" class="delete_opportunity" data-leads_id="{{ $value['leads_id'] or '0' }}" data-client_id="{{ $details['client_id'] }}"><img src="/img/cross.png" height="15"></a></td>
                        <td>{{ $value['date'] or "" }}</td>
                        <td><a href="javascript:void(0)" class="notes_btn opportunity_notes-modal" data-notes="{{ $value['notes'] or "" }}"><span>Notes</span></a></td>
                        <td>{{ $value['tab_name'] or "" }}</td>
                        <td>
                          @if(isset($value['client_type']) && $value['client_type'] == 'org')
                          <a href="javascript:void(0)" class="cd_opportunity-modal" data-type="org" data-leads_id="{{ $value['leads_id'] or '0' }}" data-lead_status="{{ $value['lead_status'] }}" data-open_from="CD">{{ $value['contact_title'] or "" }} {{ $value['contact_fname'] or "" }} {{ $value['contact_lname'] or "" }}</a>
                          @else
                          <a href="javascript:void(0)" class="cd_opportunity-modal" data-type="ind" data-leads_id="{{ $value['leads_id'] or '0' }}" data-lead_status="{{ $value['lead_status'] }}" data-open_from="CD">{{ $value['prospect_title'] or "" }} {{ $value['prospect_fname'] or "" }} {{ $value['prospect_lname'] or "" }}</a>
                          @endif
                        </td>
                        <td>${{ $value['quoted_value'] or "" }}</td>
                        <td>{{ (isset($value['close_date']) && $value['close_date'] != "0000-00-00")?date("d-m-Y",strtotime($value['close_date'])):"" }}</td>
                      </tr>
                      @endforeach
                    @endif
                  </table>
                </li> -->

                <li>
                  <p class="table_h">Task and Events</p>
                  <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                    <tr>
                      <td width="5%" align="center"><strong>Action</strong></td>
                      <td width="60%"><strong>Task Name</strong></td>
                      <td width="35%"><strong>Task Date</strong></td>
                    </tr>
                    <tr>
                      @if(isset($crm_tasks) && count($crm_tasks) >0)
                      @foreach($crm_tasks as $key=>$value)
                        <tr>
                          <td align="center"><a href="javascript:void(0)" class="delete_tasks" data-task_id="{{ $value['task_id'] }}"><img src="/img/cross.png" height="15"></a></td>
                          <td>{{ $value['task_name'] or "" }}</td>
                          <td>
                            <div id="edit_calender_{{ $value['task_id'] }}" class="edit_cal">
                              <a href="javascript:void(0)" id="date_view_{{ $value['task_id'] }}" />{{ (isset($value['task_date']) && $value['task_date'] != "")?$value['task_date']:"" }} {{ (isset($value['task_time']) && $value['task_time'] != "")?date("H:i",strtotime($value['task_time'])):"" }}</a>
                              <span class="glyphicon glyphicon-chevron-down addcalarrow" data-task_id="{{ $value['task_id'] or "" }}"></span>
                              <div class="cont_add_to_date open_dropdown_{{ $value['task_id'] }}" style="display:none;">
                              <ul> 

                              <li class="addto_cal_li"><a href="javascript:void(0)" class="newtask-modal" data-task_action="edit" data-task_id="{{ $value['task_id'] or "" }}">Add/Edit Start Date</a></li>
                              <li class="addto_cal_li">
                                <span id="view_calender_{{ $value['task_id'] }}" class="addtocalendar atc-style-blue">
                                  <var class="atc_event">
                                  <var class="atc_date_start">{{ (isset($value['task_date']) && $value['task_date'] != "")?$value['task_date']:"" }} {{ (isset($value['task_time']) && $value['task_time'] != "")?date("H:i",strtotime($value['task_time'])):"" }}</var>
                                  <var class="atc_date_end">{{ (isset($value['task_date']) && $value['task_date'] != "")?date("Y-m-d",strtotime($value['task_date'])):'' }} {{ (isset($value['task_time']) && $value['task_time'] != "")?date("H:i:s", strtotime('+1 hour', strtotime($value['task_time'])) ):"" }}</var>
                                  <var class="atc_timezone">Europe/London</var>
                                  <var class="atc_title">{{$title}} - {{$details['business_name'] or ""}}</var>
                                  <var class="atc_description">{{$title}} - {{$details['business_name'] or ""}}</var>
                                  <var class="atc_location">Office</var>
                                  <var class="atc_organizer">{{ $admin_name }}</var>
                                  <var class="atc_organizer_email">{{ $logged_email }}</var>
                                  </var>
                                </span>
                              </li>
                            </ul>
                            </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                    </tr>
                  </table>
                </li>

                <li>
                  <p class="table_h">Activity History - Email, Call & Notes</p>
                  <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;" id="activity_table">
                    <tr>
                      <td width="5%" align="center"><strong>Action</strong></td>
                      <td width="20%"><strong>Date &Time</strong></td>
                      <td width="25%"><strong>User Name</strong></td>
                      <td width="20%"><strong>Title</strong></td>
                      <td width="30%"><strong>Type</strong></td>
                    </tr>
                    @if(isset($crm_renewals) && count($crm_renewals) >0)
                      @foreach($crm_renewals as $key=>$value)
                        <tr id="act_{{ $value['renewal_id'] }}">
                          <td align="center"><a href="javascript:void(0)" class="delete_renewal_notes" data-renewal_id="{{ $value['renewal_id'] }}"><img src="/img/cross.png" height="15"></a></td>
                          <td>{{ $value['date'] or "" }} {{ $value['time'] or "" }}</td>
                          <td>{{ $value['user_name'] or "" }}</td>
                          <td>{{ $value['title'] or "" }}</td>
                          <td>
                          @if(isset($value['added_from']) && $value['added_from']=='N')
                            <a href="javascript:void(0)" class="notes_btn notes-modal" data-renewal_id="{{ $value['renewal_id'] }}" data-action="edit" data-added_from="{{ $value['added_from'] }}"><span style="">Notes</span></a>
                          @else
                            <a href="javascript:void(0)" class="notes_btn notes-modal" data-renewal_id="{{ $value['renewal_id'] }}" data-action="edit" data-added_from="{{ $value['added_from'] }}"><span style="">Call</span></a>
                          @endif
                          </td>
                        </tr>
                      @endforeach
                    @endif
                    
                  </table>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end table-->
  </div>
  <!-- /.tab-pane -->
  <!-- <div id="tab_2" class="tab-pane">
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
        <div class="row">
          <div class="col-xs-12"> Second tab </div>
        </div>
      </div>
    </div>
  </div> -->
      <div id="tab_2" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
        <!--table area-->
        <div class="box-body table-responsive">
          <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
            <div class="row">
              <div class="col-xs-6"></div>
              <div class="col-xs-6"></div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 20px;">
                  <tr>
                    <td width="8%"><strong>Payment Method</strong></td>
                    <td width="15%">
                      <div class="pay_method">
                        <select class="form-control newdropdown change_payment" data-client_id="{{ $details['client_id'] or '' }}" data-data_type="payment_method">
                          <option value="0" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '0')?'selected':''}}>None</option>
                          <option value="1" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '1')?'selected':''}}>Direct Debit</option>
                          <option value="2" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '2')?'selected':''}}>Invoice Basis</option>
                          <option value="3" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '3')?'selected':''}}>Standing Order</option>
                          <option value="4" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '4')?'selected':''}}>Other</option>
                        </select>
                      </div>
                    </td>
                    <td width="6%"><strong>Billing Cycle</strong></td>
                    <td width="15%">
                      <div class="pay_method">
                        <select class="form-control newdropdown change_payment" data-client_id="{{ $details['client_id'] or '' }}" data-data_type="billing_cycle">
                          <option value="0" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '0')?'selected':''}}>None</option>
                          <option value="1" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '1')?'selected':''}}>Weekly</option>
                          <option value="2" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '2')?'selected':''}}>Monthly</option>
                          <option value="3" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '3')?'selected':''}}>Yearly</option>
                          <option value="4" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '4')?'selected':''}}>Adhoc</option>
                        </select>
                      </div>
                    </td>
                    <td width="56%"><strong>Direct Debit Status</strong></td>
                  </tr>
                </table>
                <div class="basic_info_relationship">
                  <ul>
                    <li>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15%"><p class="table_h">Recurring Contracts</p></td>
                          <td width="78%">&nbsp;</td>
                        </tr>
                      </table>
                      
                      <div class="row bottom_space">
                        <div class="col-xs-6">
                          <div class="dataTables_length" id="example2_length">
                            
                          </div>
                        </div>
                        <div class="col-xs-6">
                          <div id="example2_filter" class="dataTables_filter">
                            <form>
                              <input type="text" name="recurringText" id="recurringText" placeholder="Search" class="tableSearch" />
                              <button type="submit" id="LoadrecurringButton" style="display: none;">Search</button>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div id="recurringContracts"></div>

                    </li>

                    <li>
                    <p class="table_h">Non Recurring Contracts</p>
                    <div class="row bottom_space">
                        <div class="col-xs-6">
                          <div class="dataTables_length" id="example2_length">
                            
                          </div>
                        </div>
                        <div class="col-xs-6">
                          <div id="example2_filter" class="dataTables_filter">
                            <form>
                              <input type="text" name="nonRecurringText" id="nonRecurringText" placeholder="Search" class="tableSearch" />
                              <button type="submit" id="LoadNonRecurringButton" style="display: none;">Search</button>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div id="nonRecurringContracts"></div>
                    </li>
                    <!-- <li>
                      <p class="table_h">Quotes</p>
                      <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                        <tr>
                          <td align="center" width="5%"><strong>Action</strong></td>
                          <td align="left"><strong>Quote Name</strong></td>
                          <td align="left"><strong>Status</strong></td>
                          <td align="right"><strong>Amount</strong></td>
                        </tr>

                        <tr>
                          <td align="center"><a href="javascript:void(0)" class="" ><img src="/img/cross.png" height="15"></a></td>
                          <td align="left">Test</td>
                          <td align="left">Test</td>
                          <td align="right">$123,020.50</td>
                        </tr>
                      </table>
                    </li> -->
                    <li>
                      <p class="table_h">Services</p>
                      <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">

                        @if(isset($services) && count($services) >0)
                          @foreach($services as $key=>$service_row)
                          <tr>
                            <td align="left">{{ $service_row['service_name'] }}</td>
                          </tr>
                          @endforeach
                        @else
                          <tr>
                            <td align="left">No records to display</td>
                          </tr>
                        @endif
                        
                        
                      </table>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end table-->
      </div>
      <!-- /.tab-pane -->
    </div>
  </div>
</div>

   
                
  
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        

    

<!-- Notes modal start -->
<div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <!-- <input type="hidden" id="notes_client_id" name="notes_client_id"> -->
        <input type="hidden" id="renewal_id" name="renewal_id">
        <input type="hidden" id="action" name="action">
        <table>
          <tr>
            <td align="left" width="20%"><strong>Title : </strong></td>
            <td align="left"><input type="text" name="notes_title" id="notes_title" class="form-control" style="width:200px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="2">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%"><strong>Notes : </strong></td>
            <td align="left"><textarea cols="56" rows="4" id="new_notes" name="new_notes" class="form-control"></textarea></td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>&nbsp;
              <a href="javascript:void(0)" class="btn btn-info save_notes" data-client_id="{{ $details['client_id'] }}" data-added_from="N">Save</a>
            </td>
          </tr>
        </table>
      </div>
    
    </div>
  </div>
</div>        
<!-- Notes modal End -->

<!-- Log a Call modal start -->
<div class="modal fade" id="logacall-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">LOG A CALL</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="log_renewal_id" name="log_renewal_id">
        <input type="hidden" id="log_action" name="log_action">
        <table>
          <tbody>
            <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Title : </strong></td>
            <td align="left"><input id="logacall_title" name="logacall_title" class="form-control" style="width:180px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Date : </strong></td>
            <td align="left"><input id="calender_date" name="calender_date" class="form-control addto_date" style="width:180px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Time : </strong></td>
            <td align="left"><input id="calender_time" name="calender_time" class="form-control" style="width:180px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Notes : </strong></td>
            <td align="left"><textarea cols="56" rows="4" id="log_notes" name="log_notes" class="form-control"></textarea></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" colspan="2" width="5%"></td>
            <td align="right"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> &nbsp;<button type="button" class="btn btn-info save_notes" data-client_id="{{ $details['client_id'] }}" data-added_from="L">Save</button></td>
          </tr>
        </tbody></table>
      </div>
    
    </div>
  </div>
</div>        
<!-- Log a Call modal End -->

<!-- New Task modal start -->
<div class="modal fade" id="newtask-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NEW TASK</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <!-- <input type="hidden" id="notes_client_id" name="notes_client_id"> -->
        <input type="hidden" id="task_id" name="task_id">
        <input type="hidden" id="task_action" name="task_action">
        <table>
          <tbody>
            <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left" width="20%"><strong>Task Name : </strong></td>
            <td align="left"><input id="task_name" name="task_name" class="form-control"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left" width="20%"><strong>Task Date : </strong></td>
            <td align="left"><input id="task_date" name="task_date" class="form-control task_date"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left" width="20%"><strong>Task Time : </strong></td>
            <td align="left"><input id="task_time" name="task_time" class="form-control"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" colspan="2" width="20%"></td>
            <td align="right"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> &nbsp;<button type="button" class="btn btn-info save_new_task" data-client_id="{{ $details['client_id'] }}">Save</button></td>
          </tr>
        </tbody></table>
      </div>
    
    </div>
  </div>
</div>        
<!-- New Task modal End -->

<!-- Opportunuty Notes modal start -->
<div class="modal fade" id="opportunity_notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" id="opp_notes_content">
        
      </div>
    
    </div>
  </div>
</div>        
<!-- Opportunuty Notes modal End -->
     
<!-- Send Template modal start -->
<div class="modal fade" id="open_form-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">NEW OPPORTUNITY</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/renewals/save-opportunity-data')) }}
      <input type="hidden" name="saved_from" value="CD">
      <input type="hidden" name="client_id" value="{{ $details['client_id'] }}">
      <input type="hidden" name="tab_no" value="{{ $encoded_tab_no }}">
      <input type="hidden" name="encoded_type" value="{{ $encoded_type }}">
      <input type="hidden" name="type" id="type" value="">
      <input type="hidden" name="leads_id" id="leads_id" value="">
      <input type="hidden" name="business_type" id="business_type" value="{{ $details['business_type_id'] or '0' }}">
      <div class="modal-body">
        <div class="form-group" style="margin:0;">
           <div class="n_box12">
              <div class="form-group">
                <label for="exampleInputPassword1">Date</label>
                <input type="text" id="date" name="date" value="{{ date('d-m-Y') }}" class="form-control">
              </div>
            
            </div>
            <div class="n_box11">
              <div class="form-group">
                <label for="deal_certainty">Probabilty</label>
                <input type="text" id="deal_certainty" name="deal_certainty" value="100" class="form-control box_60" maxlength="3"><span style="margin-top: 7px; float:left;">%</span>
              </div>
            </div>

          <div class="f_namebox2">
            <label for="exampleInputPassword1">Deal Owner</label>
              <select class="form-control" name="deal_owner" id="deal_owner">
                <option value="">-- None --</option>
                @if(isset($staff_details) && count($staff_details) >0)
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                  @endforeach
                @endif
             </select>
          </div>
          <div class="f_namebox3">
            <div class="form-group" style="width:85%; display:none;" id="org_cont_prsn">
              <label for="exampleInputPassword1">Contact Person</label>
              <select class="form-control newdropdown contact_person" style="height:35px;" name="contact_person" id="contact_person" data-from='pop' data-type="{{ $details['type'] or "" }}">
                @if(isset($contact_persons) && count($contact_persons)>0)
                  @foreach($contact_persons as $key=>$contact_row)
                  <option value="{{ $contact_row['client_id'] or "" }}_{{ $contact_row['address_type'] or "" }}">{{ $contact_row['contact_name'] or "" }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <!-- <label for="exampleInputPassword1">Attach Opportunity to Existing Client</label>
            <select class="form-control" name="existing_client" id="existing_client">
              <option value="0">-- None --</option>
              
             </select> -->
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox" id="org_name_div">
          <!-- <div class="twobox_1">
            <div class="form-group" style="width:57%" id="org_bsn_typ">
              <label for="exampleInputPassword1">Business Type <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"> Add/Edit list</a></label>
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
          
            
            
          </div> -->
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Prospect Name</label>
              <input type="text" class="form-control" name="prospect_name" id="prospect_name">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="contact_name_div">
          <label for="exampleInputPassword1">Contact Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="contact_title" name="contact_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="contact_fname" name="contact_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="contact_lname" name="contact_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="prospect_name_div">
          <label for="exampleInputPassword1">Prospect Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="prospect_title" name="prospect_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="prospect_fname" name="prospect_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="prospect_lname" name="prospect_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" id="email" name="email" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Amount</label>
                <input type="text" id="quoted_value" name="quoted_value" class="form-control money" >
              
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Lead Source <a href="javascript:void(0)" class="lead_source-modal"> <i class="fa fa-cog fa-fw settings_icon"></i></a></label>
                <select class="form-control select_title" id="lead_source" name="lead_source">
                  <option value="0">-- None --</option>
                  @if(isset($old_lead_sources) && count($old_lead_sources) >0)
                    @foreach($old_lead_sources as $key=>$lead_row)
                      <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                    @endforeach
                  @endif
                  @if(isset($new_lead_sources) && count($new_lead_sources) >0)
                    @foreach($new_lead_sources as $key=>$lead_row)
                      <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                    @endforeach
                  @endif
                </select>
              </div> 
          </div>

          <div class="twobox_2" id="industry_div">
            <div class="form-group">
              <label for="exampleInputPassword1">Industry</label>
              <select class="form-control select_title" id="industry" name="industry">
                <option value="0">-- None --</option>
                @if(isset($industry_lists) && count($industry_lists) >0)
                  @foreach($industry_lists as $key=>$industry_row)
                    <option value="{{ $industry_row['industry_id'] }}">{{ $industry_row['industry_name'] }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
  <div id="not_exists_div">
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Annual Revenue</label>
                <input type="text" id="annual_revenue" name="annual_revenue" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Website</label>
              <input type="text" id="website" name="website" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Street</label>
                <input type="text" id="street" name="street" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">City</label>
                <input type="text" id="city" name="city" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">County</label>
                <input type="text" id="county" name="county" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Postal Code</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Country</label>
              <select class="form-control" name="country_id" id="country_id">
                <option value="">-- Select Country --</option>
              @if(!empty($countries))
                @foreach($countries as $key=>$country_row)
                @if(!empty($country_row['country_code']) && $country_row['country_code'] == "GB")
                  <option value="{{ $country_row['country_id'] }}">{{ $country_row['country_name'] }}</option>
                @endif
                @endforeach
              @endif
              @if(!empty($countries))
                @foreach($countries as $key=>$country_row)
                @if(!empty($country_row['country_code']) && $country_row['country_code'] != "GB")
                  <option value="{{ $country_row['country_id'] }}">{{ $country_row['country_name'] }}</option>
                @endif
                @endforeach
              @endif
              </select>
            </div> 
          </div>
          
          <div class="clearfix"></div>
        </div>
        
      </div>
        <div class="form-group" style="width:98%;">
          <label for="exampleInputPassword1">Notes</label>
          <textarea class="form-control" rows="4" name="notes" id="notes"></textarea>
        </div>

        <div class="clearfix"></div>
      </div>
      
      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="submit" id="save_oppor_button" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
      {{ Form::close() }}
    
  </div>
  </div>
</div>
<!-- Send Template modal end -->

<!-- Send Template modal start -->
<div class="modal fade" id="billing-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">BILLING ADDRESS</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/renewals/save-billing-data')) }}
      <input type="hidden" name="client_id" value="{{ $details['client_id'] }}">
      <input type="hidden" name="tab_no" value="{{ $encoded_tab_no }}">
      <input type="hidden" name="encoded_type" value="{{ $encoded_type }}">
      <input type="hidden" name="type" id="type" value="{{ $details['type'] }}">
      <input type="hidden" name="billing_id" id="billing_id" value="">
      
      <div class="modal-body">
        <div class="form-group" style="width:98%;">
            <label for="exampleInputPassword1">Address 1</label>
            <input type="text" class="form-control" name="bill_addr1" id="bill_addr1">
          <div class="clearfix"></div>
        </div>

        <div class="form-group" style="width:98%;">
            <label for="exampleInputPassword1">Address 2</label>
            <input type="text" class="form-control" name="bill_addr2" id="bill_addr2">
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">City</label>
                <input type="text" id="bill_city" name="bill_city" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">County</label>
                <input type="text" id="bill_county" name="bill_county" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Country</label>
                <select class="form-control" name="bill_country" id="bill_country">
                @if(!empty($countries))
                  @foreach($countries as $key=>$country_row)
                  @if(!empty($country_row['country_code']) && $country_row['country_code'] == "GB")
                    <option value="{{ $country_row['country_id'] }}">{{ $country_row['country_name'] }}</option>
                  @endif
                  @endforeach
                @endif
                @if(!empty($countries))
                  @foreach($countries as $key=>$country_row)
                  @if(!empty($country_row['country_code']) && $country_row['country_code'] != "GB")
                    <option value="{{ $country_row['country_id'] }}">{{ $country_row['country_name'] }}</option>
                  @endif
                  @endforeach
                @endif
              </select>
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Postcode</label>
                <input type="text" id="bill_postcode" name="bill_postcode" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>



        
        <div class="clearfix"></div>
      </div>
      
      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="submit" id="save_oppor_button" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
      {{ Form::close() }}
    
  </div>
  </div>
</div>
<!-- Send Template modal end -->

@include("home.include.services_modal")
@include("crm.modal.lead_source")

@include("crm.proposal.modal.modal")

@stop