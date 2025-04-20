@extends('layouts.layout')

@section('mycssfile')
<link rel="stylesheet" href="{{ URL :: asset('css/tab.css') }}" />
<link rel="stylesheet" href="{{ URL :: asset('css/tabModule.css') }}" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/tabModule.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
     tabModule.init();

     $('.open_edit_drop').click(function(){
        var no = $(this).data('no');
        $('.open_dropdown_'+no).toggle();
     });
  });

</script>
@stop

@section('content')
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

      <div class="row">
      <!--tab area-->
      <div class="col-xs-12"> 
        <div class="tab_topcon">
          <div class="top_bts">
            <ul style="padding:0;">
              <li>
                
               <!-- <button type="button" class="btn btn-success" id="{{$chnumber}}"><i class="fa fa-download"></i> GENERATE PDF</button> -->
             
              <a href="/chadtadetailspdf/{{$chnumber}}" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a>
              </li>
              <!-- <li>
                <button class="btn btn-info">WEBCHECK</button>
              </li> -->
              <!-- <li>
                <a href="/chdata/index" class="btn btn-warning">BACK</a>
              </li> -->
              <!-- <li>
                <a href="/chdata/autologin/{{ $details->CompanyNumber or "" }}/{{ $client_data['ch_auth_code'] or "" }}" class="btn btn-info" target="_blank">Autologin</a>
              </li> -->
              <li>
                <p style="margin: 10px 0 0 400px;font-size: 18px; font-weight: bold;color:#00acd6">{{ $details->CompanyName or "" }}</p>
              </li>
              <div class="clearfix"></div>
            </ul>
          </div>
          <div class="top_search_con">
            <table width="100%" border="0">
              <tr>
                <td>COMPANIES HOUSE : </td>
                <td>&nbsp;</td>
                <td>
                <!-- <a href="/chdata/autologin/{{ $details->CompanyNumber or "" }}/{{ $client_data['ch_auth_code'] or '123456' }}" class="btn btn-info" target="_blank">AUTOLOGIN</a> -->
                <a href="javascript:void(0)" class="btn btn-info autologin_single" data-company_no="{{ $details->CompanyNumber or "" }}" data-authcode="{{ $client_data['ch_auth_code'] or '123456' }}">AUTOLOGIN</a>
                </td>
              </tr>
            </table>
          </div>
          <div class="clearfix"></div>
        </div> 

        <div class="demo">
          <div class="tab tab-vert">
            <ul class="tab-legend">
              <li class="active tab_menu1">Overview</li>
              <li>Officers</li>
              <li>Statement of Capital</li>
              <li>Filing History</li>
              <li>Charges</li>
              <li>Insolvency</li>
            </ul>

<ul class="tab-content">
  <li> 
    <div class="col-lg-12">
       <div class="details_table">
        <!-- <table width="100%" border="1" bordercolor="60aad2">
          <tr class="td_color">
            <td colspan="2" align="center"><span class="table_tead_t">OVERVIEW</span></td>
          </tr>
          <tr>
            <td width="40%" class="td_color"><strong>Company Name</strong></td>
            <td width="60%">{{ $details->company_name or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Registration Number</strong></td>
            <td>{{ $details->company_number or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Registered in</strong></td>
            <td>{{ $client_data['registered_in'] or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Web Filing Authentication Code</strong></td>
            <td>{{ $client_data['ch_auth_code'] or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Company Category</strong></td>
            <td>{{ $details->CompanyCategory or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Company Status</strong></td>
            <td>{{ $details->company_status or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Country of Origin</strong></td>
            <td>{{ $details->jurisdiction or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Incorporation Date</strong></td>
            <td>{{ $details->IncorporationDate or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Nature of Business</strong></td>
            <td>{{ $nature_of_business or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Accounting Reference Date</strong></td>
            <td>{{ $details->accounts->accounting_reference_date->day or "" }}/{{ $details->accounts->accounting_reference_date->month or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Last Accounts made Up Date</strong></td>
            <td>{{ $details->accounts->last_accounts->made_up_to or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Next Accounts Due</strong></td>
            <td>{{ $details->next_due or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Last Return Made Up To</strong></td>
            <td>{{ $details->annual_return->last_made_up_to or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Next Return Due</strong></td>
            <td>{{ $details->annual_return->next_due or "" }}</td>
          </tr>
          
        </table> -->
        <table width="100%" border="1" bordercolor="60aad2">
          <tr class="td_color">
            <td colspan="2" align="center"><span class="table_tead_t">OVERVIEW</span></td>
          </tr>
          <tr>
            <td width="40%" class="td_color"><strong>Company Name</strong></td>
            <td width="60%">{{ $details->CompanyName or "" }}
              @if(isset($type) && $type == "ltd")
              <div class="table_right"><a href="javascript:void(0)">Edit</a>
              <span class="glyphicon glyphicon-chevron-down open_edit_drop" data-no="1"></span>
              <div class="cont_add_to_date open_dropdown_1" style="left: 650px; top: 60px;display:none;">
                <ul>
                  <li><a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=SDNM01">Same Day</a></li>
                  <li><a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=NM01">Standard</a></li>
                </ul>
              </div>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td class="td_color"><strong>Registration Number</strong></td>
            <td>{{ $details->CompanyNumber or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Registered in</strong></td>
            <td>{{ $client_data['registered_in'] or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Web Filing Authentication Code</strong></td>
            <td>{{ $client_data['ch_auth_code'] or "" }}
              <div class="table_right"><a href="javascript:void(0)" class="open_popdata" data-link="https://ewf.companieshouse.gov.uk/runpage?page=companyRegistrationDetails">Edit</a></div></td>
              <!--https://ewf.companieshouse.gov.uk/runpage?page=companyRegistrationDetails-->
          </tr>
          <tr>
            <td class="td_color"><strong>Company Category</strong></td>
            <td>{{ $details->CompanyCategory or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Company Status</strong></td>
            <td>{{ $details->CompanyStatus or "" }}<div class="table_right">
              @if(isset($type) && $type == "llp")
                <a href="javascript:void(0)" class="open_popdata" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLDS02">Edit</a>
              <!-- <a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLDS02" target="_blank">Edit</a> -->
              @else
                <a href="javascript:void(0)" class="open_popdata" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=DS02">Edit</a>
              <!-- <a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=DS02" target="_blank">Edit</a> -->
              @endif
            </div></td>
          </tr>
          <tr>
            <td class="td_color"><strong>Country of Origin</strong></td>
            <td>{{ $details->CountryOfOrigin or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Incorporation Date</strong></td>
            <td>{{ $details->IncorporationDate or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Nature of Business</strong></td>
            <td>{{ $nature_of_business or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Accounting Reference Date</strong></td>
            <td>{{ $details->Accounts->AccountRefDay or "" }}/{{ $details->Accounts->AccountRefMonth or "" }}<div class="table_right">
              @if(isset($type) && $type == "llp")
                <a href="javascript:void(0)" class="open_popdata" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLAA01">Edit</a>
                <!-- <a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLAA01" target="_blank">Edit</a> -->
              @else
                <a href="javascript:void(0)" class="open_popdata" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=AA01">Edit</a>
                <!-- <a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=AA01" target="_blank">Edit</a> -->
              @endif
            </div></td>
          </tr>
          <tr>
            <td class="td_color"><strong>Last Accounts made Up Date</strong></td>
            <td>{{ $details->Accounts->LastMadeUpDate or "" }}
              @if(isset($type) && $type == "ltd")
              <div class="table_right"><a href="javascript:void(0)">Edit</a>
              <span class="glyphicon glyphicon-chevron-down open_edit_drop" data-no="2"></span>
              <div class="cont_add_to_date open_dropdown_2" style="left: 650px; top: 408px;display:none;">
                <ul>
                  <li><a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/autopage?form=AA02Conditions">DCA</a></li>
                  <li><a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/autopage?form=AbbreviatedConditions">ABBRV</a></li>
                  <li><a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/autopage?form=MicroEntitiesConditions">MICRO</a></li>
                </ul>
              </div>
              </div>
              @endif
            </td>
          </tr>
            <tr>
            <td class="td_color"><strong>Next Accounts Due</strong></td>
            <td>{{ $details->Accounts->NextDueDate or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Last Return Made Up To</strong></td>
            <td>{{ $details->Returns->LastMadeUpDate or "" }}<div class="table_right">
              <a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/autopage?form=ARMUD">File</a>
            </div></td>
          </tr>
            <tr>
            <td class="td_color"><strong>Next Return Due</strong></td>
            <td>{{ $details->Returns->NextDueDate or "" }}</td>
          </tr>
          
        </table>

        <table width="100%" border="1" bordercolor="60aad2" class="register_top">
            <tr class="td_color">
              <td align="center">
                <div class="table_left">
                  @if(isset($type) && $type == "llp")
                    <a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLAD01">Edit</a>
                  @else
                    <a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=AD01">Edit</a>
                  @endif
                </div>
                <span class="table_tead_t">REGISTERED OFFICE</span>
                <div class="table_right">
                  @if(isset($type) && $type == "llp")
                    <a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLAD02">Add/Edit SAIL</a>
                  @else
                    <a href="javascript:void(0)" class="open_popdata open_calender_pop" data-link="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=AD02">Add/Edit SAIL</a>
                  @endif
                </div>
              </td>
            </tr>
            <tr>
              <td>
              {{ $registered_office->address_line_1 or "" }}<br>
              {{ $registered_office->address_line_2 or "" }}<br>
              {{ $registered_office->locality or "" }}<br>
              {{ $registered_office->country or "" }}<br>
              {{ $registered_office->postal_code or "" }}
              </td>
            </tr>
          </table>

      </div>
    </div>
  </li>
               
  <li> 
    <div class="col-lg-12">
     <div class="details_table">
        <div class="registered_table">
          <div class="reg_contain">
          @if(isset($type) && $type == "llp")
            <div class="first_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=LLAP01" target="_blank">Appoint an Officer</a></div>
          @else
            <div class="first_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=AP01" target="_blank">Appoint an Officer</a></div>
          @endif
            <div class="sec_cot"><a href="https://ewf.companieshouse.gov.uk/officers/1" target="_blank">Change Officer Details</a></div>
            <div class="third_cot"><a href="https://ewf.companieshouse.gov.uk/officers/1" target="_blank">Terminate Appointment</a></div>
          
          </div>
          <table width="100%" border="1" bordercolor="60aad2">
            <tr class="td_color">
              <td align="center" colspan="3"><span class="table_tead_t">OFFICERS</span></td>
            </tr>
            <tr class="td_color">
              <td align="left" class="sub_header">Name</td>
              <td align="left" class="sub_header">Appointment Date</td>
              <td align="left" class="sub_header">Role</td>
            </tr>

          @if(isset($officers) && count($officers)>0)
            @foreach($officers as $key=>$field_row)
              @if(!isset($field_row->resigned_on))
              <tr><!-- link_color get_officers-->
                <td align="left"><a href="javascript:void(0)" data-key="{{ $key }}" data-number="{{ $details->CompanyNumber }}" class="officer_link get_officers">{{ ucwords($field_row->name) }}</a></td>
                <td align="left">{{ isset($field_row->appointed_on)?date("d F Y", strtotime($field_row->appointed_on)):"" }}</td>
                <td align="left">{{ ucwords(str_replace("-", " ", $field_row->officer_role)) }}</td>
              </tr>
              @endif
            @endforeach
          @endif
            

          </table>
        </div>
      </div>
    </div>
  </li>

  <li> 
    <div class="col-lg-12">
      <div class="details_table">
        <div class="reg_contain">
          @if(isset($type) && $type == "ltd")
            <div class="table_right"><a href="https://ewf.companieshouse.gov.uk/runpage?page=formLoader&formLoader.targetFormId=SH01">Return on Allotment of Shares</a></div>
          @endif
        </div>
        <table width="100%" border="1" bordercolor="60aad2" style="text-align:center;">
          <tr class="td_color">
            <td colspan="4" align="center"><span class="table_tead_t">STATEMENT OF CAPITAL</span></td>
          </tr>
          <tr class="td_color">
            <td class="sub_header">Type</td>
            <td width="15%" class="sub_header">Date</td>
            <td class="sub_header">Share Capital</td>
            <td class="sub_header">Category</td>
          </tr>

        @if(!empty($filling_history))
          @foreach($filling_history as $key=>$field_row)
            @if(isset($field_row->associated_filings) && count($field_row->associated_filings) >0 )
              @if(isset($field_row->associated_filings[0]->category) && ($field_row->associated_filings[0]->category == 'capital' || $field_row->associated_filings[0]->category == 'annual-return' || $field_row->associated_filings[0]->category == 'incorporation') )
                <tr>
                  <td>{{ $field_row->associated_filings[0]->type or "" }}</td>
                  <td>{{ isset($field_row->associated_filings[0]->date)?date("d-m-Y", strtotime($field_row->associated_filings[0]->date)):"" }}</td>
                  <td>{{ $field_row->associated_filings[0]->description_values->capital[0]->currency or "" }} {{ $field_row->associated_filings[0]->description_values->capital[0]->figure or "" }}</td>
                  <td>{{ ucwords(str_replace("-", " ", $field_row->associated_filings[0]->category)) }}</td>
                </tr>
              @endif
            @endif
          @endforeach
        @endif

           <!-- <tr>
            <td colspan="3">&nbsp;</td>
             </tr> -->
        </table>
        <!-- <table width="100%" border="1" bordercolor="60aad2">
          <tr class="td_color">
            <td align="center"><span class="table_tead_t">SECRETARIES</span></td>
          </tr>
        @if(!empty($officers))
          @foreach($officers as $key=>$field_row)
            @if(strpos($field_row->officer_role,'secretary') !== false)
              <tr>
                <td><a href="javascript:void(0)" data-key="{{ $key }}" data-number="{{ $details->CompanyNumber }}" class="link_color get_officers">{{ $field_row->name or "" }}</a></td>
              </tr>
            @endif
          @endforeach
        @endif
        
        </table> -->
      </div>
    </div>
  </li>

  <li> 
    <div class="col-lg-12">
      <div class="details_table">
        <table width="100%" border="1" bordercolor="60aad2" style="text-align:center;">
          <tr class="td_color">
            <td colspan="4" align="center"><span class="table_tead_t">COMPANY FILING HISTORY LIST</span></td>
          </tr>
          <tr class="td_color">
            <td class="sub_header">Type</td>
            <td width="15%" class="sub_header">Date</td>
            <td class="sub_header">Description</td>
            <td class="sub_header">View/Download</td>
          </tr>

        @if(!empty($filling_history))
          @foreach($filling_history as $key=>$field_row)
            <tr>
              <td>{{ $field_row->type or "" }}</td>
              <td>{{ $field_row->date or "" }}</td>
              <td align="left">
                {{ ucwords(str_replace("-", " ", $field_row->description)) }}

                {{ (isset($field_row->description_values->made_up_date) && $field_row->description_values->made_up_date!="")?' - '. date('d-m-Y', strtotime($field_row->description_values->made_up_date)):'' }}&nbsp;

                {{ (isset($field_row->description_values->officer_name) && $field_row->description_values->officer_name!="")? $field_row->description_values->officer_name:'' }}&nbsp;

                {{ (isset($field_row->description_values->appointment_date) && $field_row->description_values->appointment_date!="")?' - '. date('d-m-Y', strtotime($field_row->description_values->appointment_date)):'' }}&nbsp;

                {{ $field_row->description_values->new_address or '' }}&nbsp;
                {{ $field_row->description_values->change_date or '' }}&nbsp;
                {{ $field_row->description_values->old_address or '' }}&nbsp;

                {{ (isset($field_row->description_values->change_date) && $field_row->description_values->change_date!="")?' - '. date('d-m-Y', strtotime($field_row->description_values->change_date)):'' }}
              </td>
              <td><a href="https://beta.companieshouse.gov.uk/company/{{ $details->CompanyNumber or "" }}/filing-history/{{ $field_row->transaction_id or "" }}/document?format=pdf&download=0" target="_blank">View PDF</a></td>
            </tr>
          @endforeach
        @endif

           <!-- <tr>
            <td colspan="3">&nbsp;</td>
             </tr> -->
        </table>
        <!-- <table width="100%" border="1" bordercolor="60aad2">
          <tr class="td_color">
            <td align="center"><span class="table_tead_t">SECRETARIES</span></td>
          </tr>
        @if(!empty($officers))
          @foreach($officers as $key=>$field_row)
            @if(strpos($field_row->officer_role,'secretary') !== false)
              <tr>
                <td><a href="javascript:void(0)" data-key="{{ $key }}" data-number="{{ $details->CompanyNumber }}" class="link_color get_officers">{{ $field_row->name or "" }}</a></td>
              </tr>
            @endif
          @endforeach
        @endif
        
        </table> -->
      </div>
    </div>
  </li>

  <li> 
    <div class="col-lg-12">
      <div class="details_table">
        <div class="reg_contain">
        @if(isset($type) && $type == "llp")
          <div class="first_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=LLMR01" target="_blank">Register a Charge</a></div>
          <div class="otr_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=LLMR02" target="_blank">Register an Acquisition</a></div>
          <div class="otr_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=LLMR04" target="_blank">Satisfy a Charge</a></div>
          <div class="otr_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=LLMR05" target="_blank">Cease or Release Property from Charge</a></div>
        @else
          <div class="first_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=MR01" target="_blank">Register a Charge</a></div>
          <div class="otr_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=MR02" target="_blank">Register an Acquisition</a></div>
          <div class="otr_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=MR04" target="_blank">Satisfy a Charge</a></div>
          <div class="otr_cot"><a href="https://ewf.companieshouse.gov.uk/runpage?page=preFiling&preFilingPage.form=MR05" target="_blank">Cease or Release Property from Charge</a></div>
        @endif
        </div>
        <table width="100%" border="1" bordercolor="60aad2" style="text-align:center;">
          <tr class="td_color">
            <td colspan="4" align="center"><span class="table_tead_t">CHARGES</span></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="charge_tr">Charge Registered</td>
          </tr>
        @if(isset($charges->items) && count($charges->items) >0)
          @foreach($charges->items as $key=>$charge_row)
          <tr>
            <td colspan="3" align="left" class="sub_header" width="70%">Charge Code : 
              <span class="normal_p">{{ $charge_row->charge_code  or "" }}</span></td>
            <td align="left" class="sub_header">Transaction filed</td>
          </tr>
          <tr>
            <td>Created <br><strong>{{ date("d F Y", strtotime($charge_row->created_on)) }}</strong></td>
            <td>Delivered <br><strong>{{ date("d F Y", strtotime($charge_row->delivered_on)) }}</strong></td>
            <td>Status <br><strong>{{ ucwords($charge_row->status) }}</strong></td>
            <td>Registration of charge(MR01)<br><a href="https://beta.companieshouse.gov.uk{{ $charge_row->transactions[0]->links->filing}}/document?format=pdf&download=0" target="_blank">View PDF</a></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="sub_header">Persons entitled : 
             <span class="normal_p">{{ $charge_row->persons_entitled[0]->name or "" }}</span></td>
          </tr>

          <tr>
            <td colspan="4" align="left" class="sub_header">Brief description <br>
              <p class="normal_p">{{ $charge_row->particulars->description or "" }}</p>
            </td>
          </tr>
          @endforeach
        @endif

        </table>
      </div>
    </div>
  </li>

  <li> 
    <div class="col-lg-12">
      <div class="details_table">
        
        <table width="100%" border="1" bordercolor="60aad2" style="text-align:center;">
          <tr class="td_color">
            <td colspan="2" align="center"><span class="table_tead_t">INSOLVENCY</span></td>
          </tr>

        @if(isset($insolvency->cases) && count($insolvency->cases) >0)
          @foreach($insolvency->cases as $key=>$insolv_row)
          <tr>
            <td colspan="2" align="left" class="charge_tr">1 Insolvency case</td>
          </tr>
          <tr>
            <td colspan="2" align="left" class="charge_tr">Case number {{ $insolv_row->number }} - {{ ucwords(str_replace("-", " ", $insolv_row->type)) }}</td>
          </tr>
          <tr>
            <td colspan="2" align="left" class="normal_p">Commencement of winding up <br>
              <strong class="charge_tr">{{ date("d F Y", strtotime($insolv_row->dates[0]->date)) }}</strong>
            </td>
          </tr>

          <tr>
            <td align="left" width="50%">Practitioner <br> <strong>{{ ucwords($insolv_row->practitioners[0]->name) }}</strong></td>
            <td align="left">Appointed on <br> <strong>{{ isset($insolv_row->practitioners[0]->appointed_on)?date("d F Y", strtotime($insolv_row->practitioners[0]->appointed_on)):"" }}</strong></td>
          </tr>

          <tr>
            <td colspan="2" align="left">{{ ucwords($insolv_row->practitioners[0]->address->address_line_1) }}, {{ ucwords($insolv_row->practitioners[0]->address->locality)}}, {{ ucwords($insolv_row->practitioners[0]->address->postal_code) }}</td>
          </tr>
        @endforeach
      @endif

        </table>
      </div>
    </div>
  </li>

</ul>
  </div>
    </div>
    </div>
   <!--end tab area-->
    
  
      </div>












      
      
    </section>


</aside><!-- /.right-side -->
            
        
<!-- popup content -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
       <div class="cross_btn1"><button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button></div>
      <div class="registered_table1 popup_align">
     
<table width="100%" border="1" bordercolor="60aad2">
  <tr class="td_color">
     <td colspan="2"><span class="table_tead_t">PERSONAL DETAILS</span></td>
    </tr>
  <tr>
    <td width="29%" class="td_color">Title :</td>
    <td width="71%">Mr.</td>
  </tr>
  <tr>
    <td class="td_color">First Name :</td>
    <td>Jude</td>
  </tr>
  <tr>
    <td class="td_color">Middle Name :</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="td_color">Last Name :</td>
    <td>LOBO</td>
  </tr>
  <tr>
    <td class="td_color">DOB :</td>
    <td>1970-10-25</td>
  </tr>
  <tr>
    <td class="td_color">Nationality :</td>
    <td>British</td>
  </tr>
  <tr>
    <td class="td_color">Occupation :</td>
    <td>it Professional</td>
  </tr>
  <tr>
    <td class="td_color">Country of residence :</td>
    <td>Gbr</td>
  </tr>
   <tr class="td_color">
     <td colspan="2"><span class="table_tead_t">SERVICE ADDRESS</span></td>
    </tr>
  <tr>
    <tr>
    <td class="td_color">Address 1 :</td>
    <td>24</td>
  </tr>
   <tr>
    <td class="td_color">Address 2 :</td>
    <td>Awefwef</td>
  </tr>
   <tr>
    <td class="td_color">Address 3 :</td>
    <td></td>
  </tr>
     <tr>
    <td class="td_color">Town :</td>
    <td></td>
  </tr>
     <tr>
    <td class="td_color">Country :</td>
    <td>Leicestershire</td>
  </tr>
     <tr>
    <td class="td_color">Post Code :</td>
    <td>LE652NR</td>
  </tr>
  <tr>
    <td class="td_color">Country :</td>
    <td>GBR</td>
  </tr>
</table>
</div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="personal_details" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="cross_btn1"><button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button></div>
      <div class="registered_table1 popup_align" id="officer_details_div"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>  


<div class="modal fade" id="chdatadetails_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">COLLECTION DATE</h4> -->
        <div class="clearfix"></div>
      </div>
      <div class="modal-body">
        <div class="show_loader"><!-- Show Loader --></div>
        <div class="form-group">
          <div style="font-size: 17px;">
            Please <a href="javascript:void(0)" class="btn btn-info autologin_single" data-company_no="{{ $details->CompanyNumber or '' }}" data-authcode="{{ $client_data['ch_auth_code'] or '123456' }}">AUTOLOGIN</a> into Companies house and <a href="javascript:void(0)" class="continue_link" target="_blank">Click here</a> to continue >>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>  



@stop

