@extends('layouts.layout')

@section('mycssfile')

<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/taxreturn.js') }}" type="text/javascript"></script>
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
  
    <input type="hidden" id="client_id" name="client_id" value="new">
    <input type="hidden" id="main_client_id" value="{{ $client_id or '0' }}">
    <input type="hidden" id="page_open" value="{{ $page_open or "" }}">
    <input type="hidden" id="encoded_page_name" value="{{ $encoded_page_name or "" }}">
    <input type="hidden" id="TAXYEAR" value="{{ $TAXYEAR or "" }}">
    <input type="hidden" id="service_id" value="7">
    <input type="hidden" id="checklist_id" value="{{ $checklist['checklist_id'] or '0' }}">

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
      
      
    <div class="tax_top_pan">
      <div class="" style="float: left;">
        <span style="float:left; padding-right: 15px; padding-top: 3px;"><strong>Select Tax Year</strong></span>
        <span style="float:left;width:157px;">
          <select class="form-control change_tax_year" id="change_tax_year">
            <option value="">-- Select Tax Year --</option>
            @if(isset($taxreturn_year) && count($taxreturn_year) >0)
              @foreach($taxreturn_year as $key=>$value)
                <option value="{{ $value or "" }}" {{ ($TAXYEAR == $value)?'selected':'' }}>{{ $value or "" }}</option>
              @endforeach
            @endif
          </select>      
        </span>
        <div class="clearfix"></div>
      </div>
     
      <span class="show_date">
        
      </span>
      <!-- <span style="float:right;">
      <button type="submit" class="btn btn-success" style="padding: 5px 25px 5px 25px;">SAVE</button>
      <button type="submit" class="btn btn-danger" style="padding: 5px 25px 5px 25px;">CLOSE</button>
      <button type="submit" class="btn btn-info" style="padding: 5px 25px 5px 25px;"> SUBMIT </button>
      
      </span> -->

        <div class="clearfix"></div>
   </div>
    <div class="practice_mid">
        

<div class="tabarea">
  
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg" id="header_ul">
        <li class="{{ ($page_open == 1)?'active':'' }}"><a href="javascript:void(0)" data-open_id="1">PERSONAL DETAILS</a></li>
        <li class="{{ ($page_open == 2)?'active':'' }}"><a href="javascript:void(0)" data-open_id="2" class="" id="non_clickable">TAX RETURN INFORMATION</a></li>
        <!-- <li class="{{ ($page_open == 2)?'active':'' }}"><a href="/tsxreturninfromation/{{$client_id}}/{{ base64_encode('client_portal') }}/2" class="avoid-clicks" id="non_clickable">TAX RETURN INFORMATION</a></li> -->
       <!-- <li class="active" id="tab_1"><a class="open_header" data-id="1" href="javascript:void(0)">PERSONAL DETAILS</a></li> 
        <li id="tab_2"><a class="open_header" data-id="2" href="javascript:void(0)">TAX RETURN INFORMATION</a></li> -->
        
        
      </ul>
      <div class="tab-content">

          
          <div id="step1" class="tab-pane {{ ($page_open == 1)?'active':'' }}" >
          
          
{{ Form::open(array('url'=>'/individual/insert-client-details', 'files' => true, 'id'=>'basicform')) }}
    <input type="hidden" name="client_id" value="{{ $client_details['client_id'] }}">
    <input type="hidden" name="client_type" value="ind">
    
    <input type="hidden"  name="page_name"  id="page_name" value="{{ $page_name }}">
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
<label for="exampleInputPassword1">Title</label>
<select class="form-control select_title" id="title" name="title">
  @if(!empty($titles))
    @foreach($titles as $key=>$title_row)
    <option value="{{ $title_row->title_name }}" {{ (isset($client_details['title']) && ($title_row->title_name == $client_details['title']))?"selected":"" }}>{{ $title_row->title_name }}</option>
    
    @endforeach
  @endif
</select>
  
  </div>
</div>

<div class="form-group">

<div class="clearfix"></div>
<div class="n_box1">

</div>
<div class="n_box2">
    <label for="exampleInputPassword1">First Name</label>
    <input type="text" id="fname" name="fname" value="{{ $client_details['fname'] or "" }}" class="form-control toUpperCase"></div>
<div class="n_box3">
    <label for="exampleInputPassword1">Middle Name</label>
    <input type="text" id="mname" name="{{ $client_details['mname'] or "" }}" class="form-control"></div>
<div class="n_box4">
    <label for="exampleInputPassword1">Last Name</label>
    <input type="text" id="lname" name="lname" value="{{ $client_details['lname'] or "" }}"  class="form-control toUpperCase"></div>
<div class="clearfix"></div>
</div>

<div class="form-group">
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
<input type="text" id="res_postcode" name="res_postcode"  value="{{ $client_details['res_postcode']  or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Country</label>
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
</div>


<div class="form-group">

<div class="n_box01">
  <label for="exampleInputPassword1">Country Code</label>
  <!-- <select class="form-control" id="serv_tele_code" name="serv_tele_code">
  <option value="44">44</option>
  </select> -->
  <input type="text" id="res_tele_code" value="44" name="res_tele_code" value="{{ $client_details['res_tele_code']  or "" }}" class="form-control" readonly />
</div>

<div class="telbox">
<label for="exampleInputPassword1">Telephone</label>
    <input type="text" id="res_telephone" name="res_telephone" value="{{ $client_details['res_telephone']  or "" }}" class="form-control"></div>
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
<input type="text" id="dob" name="dob" value="{{ (isset($client_details['dob']))?date('d-m-Y', strtotime($client_details['dob'])):"" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>
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
<label for="exampleInputPassword1">Tax Officew</label>
<input type="hidden" id="tax_reference_type" value="I">
<select class="form-control" id="tax_office_id" name="tax_office_id">
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
<textarea id="tax_address" name="tax_address" class="form-control" rows="3">{{ $client_details['tax_address'] or "" }}</textarea>

</div>


<div class="twobox">
<div class="twobox_1">
<div class="form-group">
<label for="exampleInputPassword1">Postal/Zip Code</label>
<input type="text" id="tax_zipcode" name="tax_zipcode" value="{{ $client_details['tax_zipcode'] or "" }}" class="form-control">
</div>
</div>

<div class="twobox_2">
<div class="form-group">
<label for="exampleInputPassword1">Telephone</label>
<input type="text" id="tax_telephone" name="tax_telephone" value="{{ $client_details['tax_telephone']  or "" }}" class="form-control">
</div>
</div>
<div class="clearfix"></div>
</div>



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
        {{ Form::close() }}
    </div>

<div id="step2" class="tab-pane {{ ($page_open ==2)?'active':'' }}">
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">  
        <div class="col-xs-12">
          <div class="col_m2">
            <table width="100%">
              <tr>
                <td width="35%" align="right" class="utr_table">Tax Return Information Checklist</td>
                <td width="30%">
                  <div class="" style="position: relative; width:260px !important;margin-left: 50px;">
                 <div class="j_selectbox002">
                  <span>DOWNLOAD CHECKLIST</span>
                  <div class="select_icon" id="select_icon"></div>
                  <div class="clr"></div>
                  <div class="open_toggle" style="z-index: 99;">
                    <ul id="document_list">
                    @if(isset($checklist['documents']) && count($checklist['documents']) >0)
                      @foreach($checklist['documents'] as $key=>$value)
                        <li><a href="/uploads/tax_return_doc/{{ $value['document_name'] or ""}}" download>{{ $value['document_name'] or ""}}</a></li>
                      @endforeach
                    @endif
                    </ul>
                  </div>
                </div>
                 </div>
                </td>
                <td width="25%">Stop Reminders <input type="checkbox" value="Y" {{ (isset($checklist['is_reminder']) && $checklist['is_reminder'] =='Y')?'checked':'' }} class="reminder_check" data-checklist_id="{{$checklist['checklist_id'] or '0'}}"></td>
                <td width="10%" align="right">
                  <!-- <button type="button" class="btn btn-danger">Submit Changes!</button> -->
                </td>
              </tr>
            </table>
          </div>  

          <div class="col_m2 pad_top2">  




  <div class="col-xs-4">
    <form method="post" name="mess_form" action="/ic/save-messages">
      <h3 class="no-pad blue_color" style="margin-bottom: 30px;">NOTES</h3>
      
      <div class="form-group" id="addnew_box">
        <div class="col-xs-2 no-pad">
          <button type="button" class="btn btn-info" id="open_msg_box">Add a New Note</button>
        </div>
        <div class="clearfix"></div>
      </div>

      @if(isset($checklist['messages']) && count($checklist['messages']) >0)
        @foreach($checklist['messages'] as $key=>$message)   
          <div class="form-group">
            <h3 class="blue_color">{{ $message['subject'] or "" }}</h3>
          @if(isset($message['messages']) && count($message['messages']) >0)
            @foreach($message['messages'] as $key=>$row)   
            <div class="col-xs-2 no-pad">
              <span class="input_icon">
                @if(isset($client_files['profile_photo']) && $client_files['profile_photo'] == "")
                  <img src="/img/avatar2.png" align="left" />
                @else
                  <img src="/uploads/profile_photo/{{ $client_files['profile_photo'] or "" }}" align="left" />
                @endif
              </span>
            </div>
            <div class="col-xs-10 no-pad">
              <div class="col-xs-8 pull-left no-pad">
                <p class="no-pad"><strong style="font-size: 16px;">{{ $admin_name or '' }}</strong></p>
                <p>{{ $row['message'] or "" }}</p>
              </div>
              <div class="col-xs-4 pull-right">
                <p>{{ (isset($row['created']) && $row['created'] != '0000-00-00 00:00:00')?date('M d', strtotime($row['created'])):'' }}
<a href="javascript:void(0)" class="delete_message" data-message_id="{{ $row['message_id'] or '0' }}" style="margin-right: 20px; float:right;"><img src="/img/cross.png" height="12" /></a>
                </p>
                
              </div>
            </div>
            <div class="clearfix"></div>
          @endforeach
        @endif
          </div>
          <div class="form-group">
          <div class="col-xs-10 no-pad">
            <button type="button" class="btn btn-primary open_reply" data-message_id="{{ $message['message_id'] or "" }}">Reply</button>
          </div>
          <div class="clearfix"></div>
        </div>
          
        @endforeach
      @endif

    <div  id="msg_box" style="display:none;">
      <div class="form-group">
        <div class="col-xs-2 no-pad">
          <span class="input_icon">
            @if(isset($client_files['profile_photo']) && $client_files['profile_photo'] == "")
              <img src="/img/avatar2.png" align="top" />
            @else
              <img src="/uploads/profile_photo/{{ $client_files['profile_photo'] or '' }}" align="top"/>
            @endif
          </span>
        </div>
        <div class="col-xs-10 no-pad">
          <input type="text" name="subject" id="subject" placeholder="Subject" class="input_textbox form-control"/>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <div  id="reply_box" style="display:none;">
      <input type="hidden" id="hidd_reply_id" value="0">
      <div class="form-group">
        <div class="col-xs-2 no-pad">
          <span class="input_icon">
            @if(isset($client_files['profile_photo']) && $client_files['profile_photo'] == "")
              <img src="/img/avatar2.png" align="middle" />
            @else
              <img src="/uploads/profile_photo/{{ $client_files['profile_photo'] or "" }}" align="middle" />
            @endif
          </span>
        </div>
        <div class="col-xs-10 no-pad">
          <textarea name="" placeholder="Write a message.." name="message" id="message" class="input_textbox form-control text_area"></textarea>
          <button class="btn btn-primary input_textbox save_message" type="button">Send Message</button>
          <!-- <span class="btn btn-default pull-right input_textbox">
          <i class="glyphicon glyphicon-trash"></i></span> -->
        </div>

        <div class="clearfix"></div>
      </div>
    </div>

  <!-- <div id="reply_box" style="display:none;">
      <div class="form-group">
        <div class="col-xs-2 no-pad">
          <span class="input_icon">
            @if(isset($client_files['profile_photo']) && $client_files['profile_photo'] == "")
              <img src="/img/avatar2.png" align="middle" />
            @else
              <img src="/uploads/profile_photo/{{ $client_files['profile_photo'] or "" }}" align="middle" />
            @endif
          </span>
        </div>
        <div class="col-xs-10 no-pad">
          <textarea name="" placeholder="Write a message.." name="message" id="message" class="input_textbox form-control text_area"></textarea>
          <button class="btn btn-primary input_textbox save_message" type="button">Send Message</button>
          <span class="btn btn-default pull-right input_textbox">
          <i class="glyphicon glyphicon-trash"></i></span>
        </div>
  
        <div class="clearfix"></div>
      </div>
  </div> -->
      

    <!-- <div class="form-group">
      <div class="col-xs-2 no-pad">
        <span class="input_icon"><img src="/img/avatar2.png" align="left" /></span>
      </div>
      <div class="col-xs-10 no-pad">
        <div class="col-xs-9 pull-left no-pad">
          <p><strong>UK INVESTMENT INCOME eg Interest & Dividends</strong></p>
          <p>Hello</br></br>
            I2 Office The Pinnacle, Midsummer Boulevard, Milton Keynes, England, MK9 1BP</br></br>
            
            Thanks & Regards,</br>
            Ramjee Sharma
          </p>
        </div>
        <div class="col-xs-3 pull-right"><p>Feb 8</p></div>
      </div>
        <div class="clearfix"></div>
    </div> -->

    <!-- <div class="form-group">
      <div class="col-xs-2 no-pad">
      <span class="input_icon"><img src="/img/avatar2.png" align="middle" /></span></div>
      <div class="col-xs-10 no-pad">
        <textarea name="" placeholder="Write a message.." class="input_textbox form-control text_area"></textarea>
        <button class="btn btn-primary input_textbox" type="submit">Send Message</button>
        <span class="btn btn-default pull-right input_textbox">
        <i class="glyphicon glyphicon-trash"></i></span>
      </div>
    
      <div class="clearfix"></div>
    </div> -->

    </form>

  </div>
  <div class="col-xs-4">
       
        <div style="margin:0 auto; width:87%;">
        {{ Form::open( array('url' => '/pdfclientupload', 'files' => true, 'id'=>'clientpdfeform14', 'name'=>'clientpdfeform14')   ) }}
                <span class="btn btn-default btn-file" style="float:left; margin-right: 10px; width: 80px;"> Browse
                    <input type="file" class="staffupload_file" name="add_pdffile"  id="add_pdffile14" >
                    <input type="hidden" name="action" value="upload" />
                    <input type="hidden" name="service_id" value="7" />
                    <input type="hidden" name="tax_year" id="upload_tax_year" value="0" />
                </span>
          {{ Form :: close() }}
          <span class="pull-right">
         <div class="j_selectbox2" style="width:260px !important;">
    <span>VIEW DOCUMENT</span>
    <div class="select_icon" id="select_icon"></div>
    <div class="clr"></div>
    <div class="open_toggle">
      <ul class="doc_list">
      @if(isset($checklist['client_docs']) && count($checklist['client_docs']) >0)
        @foreach($checklist['client_docs'] as $key=>$clienttax)   
          <li data-value="non"><a href="javascript:void(0)" data-client="{{$client_id}}" data-file="{{$clienttax['file']}}" id="{{$clienttax['clienttaxpdf_id']}}" class="filename">{{$clienttax['file'] or "" }}</a><strong style="float: right;"><a href="javascript:void(0)" class="deldoc" data-delid="delid_{{$clienttax['clienttaxpdf_id']}}" ><img src="/img/cross.png"></a></strong></li>
        @endforeach
      @endif
      </ul>
    </div>
  </div>
        </span>
         <div class="clr"></div>
        </div>
       
       
           <h3 style="font-size: 18px; text-align: center">DOCUMENT VIEWER</h3>
           
           <div class="emp_box">
           
           <iframe id="clienttaxpdfviwer" width="100%" height="600px" src=""></iframe>
           </div>
       
       
       
       
       </div>



    <div class="col-xs-4">
       
       <h3 class="blue_color no-pad">PLEASE SUPPLY THE FOLLOWING MISSING INFORMATION</h3>
       
       <div class="emp_pan">
       
          <span><input type="checkbox" id="employment_income" /></span>
          <span>EMPLOYMENT INCOME</span>
            
    

          <div class="emp_pan_in" id="employment_incomebody">
          
                  <span style="float:left; margin-bottom: 10px;" data-nid="1" class="notesmodalcall">
               
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span  class="note_butt">Notes</span></a>
             
             </span>
             <div class="clr"></div>
             
             <p class="emp_con"><a href="javascript:void(0)" title="Employment">Employment</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Employment lump sums</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Share scheme</a></p>
          
          
          </div>
          
       
       </div>
       
       
       
       
       
       
       <div class="emp_pan">
       
          <span><input type="checkbox" id="self_income" /></span>
          <span>SELF EMPLOYMENT/PARTNERSHIP INCOME</span>
            
          <div class="emp_pan_in" id="self_incomebody">
       
             <span style="float:left; margin-bottom: 10px;" data-nid="2" class="notesmodalcall"> 
               
               <a href="javascript:void(0)" data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span  class="note_butt">Notes</span></a>
             
             </span>
             <div class="clr"></div>
             
             <p class="emp_con"><a href="#" title="Employment">Self-employment</a></p>
             <p class="emp_con"><a href="#" title="">Post-cessation expenses etc</a></p>
             <p class="emp_con"><a href="#" title="">Partnership</a></p>
             <p class="emp_con"><a href="#" title="">Class 4 NICs</a></p>
          
          
          </div>
          
       
       </div>
       
       
       
       
       
       
       <div class="emp_pan">
       
          <span><input type="checkbox" id="pension_income" /></span>
          <span>PENSION INCOME</span>
            
          <div class="emp_pan_in" id="pension_incomebody">
          
             <span style="float:left;margin-bottom: 10px;" data-nid="3"  class="notesmodalcall">
               
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notess</span></a>
             
             </span>
             <div class="clr"></div>
             
             <p class="emp_con"><a href="#" title="Employment">State pensions and benefits</a></p>
             <p class="emp_con"><a href="#" title="">Other UK pension etc</a></p>
            
          
          
          </div>
          
       
       </div>
       
       
       
        
       <div class="emp_pan">
        <span><input type="checkbox" id="property_income" /></span>
          <span>PROPERTY INCOME</span>
           <div class="emp_pan_in" id="property_incomebody">
              
             <span style="float:left;margin-bottom: 10px;" data-nid="4" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="#" title="Employment">Income From Property</a></p>
            
            
          </div>         
       </div>
       
       
       
       <div class="emp_pan">
        <span><input type="checkbox" id="other_income" /></span>
          <span>OTHER INCOME</span>
           <div class="emp_pan_in" id="other_incomebody">
           
             <span style="float:left;margin-bottom: 10px;" data-nid="5" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="Employment">Other Income/Losses</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="Employment">Close Company loans written off</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="Employment">Minister of religion</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="Employment">Members of Parliament etc</a></p>
            
          </div>         
       </div>
       
       
       
       
       <div class="emp_pan">
        <span><input type="checkbox" id="ukinvestment_income" /></span>
          <span>UK INVESTMENT INCOME eg Interest & Dividends</span>
           <div class="emp_pan_in" id="ukinvestment_incomebody">
           
             <span style="float:left;margin-bottom: 10px;" data-nid="6" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Interest from UK Banks etc</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Dividends from UK companies </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Other Dividends </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Stock Dividends</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Interest from gilts,accrued income etc</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Non-qualifying distributions</a></p>
            
          </div>         
       </div>
       
       
       
        <div class="emp_pan">
        <span><input type="checkbox" id="foreign_income" /></span>
          <span>FOREIGN INCOME eg Foreign savings interest & dividends</span>
           <div class="emp_pan_in" id="foreign_incomebody">
          
             <span style="float:left;margin-bottom: 10px;" data-nid="7"class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Foreign Savings Interest</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Dividends from Foreign companies </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Overseas Pensions Etc </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Income From land and property abroad </a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Foreign life assurance gains </a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Income received by person abroad</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Other overseas income and gains</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Foreign tax paid on Other income </a></p>
            
          </div>         
       </div>
       
       
       
       
         
        <div class="emp_pan">
        <span><input type="checkbox" id="trust_estates" /></span>
          <span>TRUST & ESTATES</span>
           <div class="emp_pan_in" id="trust_estatesbody">
          
             <span style="float:left;margin-bottom: 10px;" data-nid="8" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Income from a trust or settlement</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Income chargeable to settlor </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Income from UK estate </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Income From foreign estate </a></p>
             
            
          </div>         
       </div>
       
       
       <div class="emp_pan">
        <span><input type="checkbox" id="reliefs" /></span>
          <span>RELIEFS eg Gift and Payments Pensions EIS etc  </span>
           <div class="emp_pan_in" id="reliefsbody">
          
             <span style="float:left;margin-bottom: 10px;"data-nid="9" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Gift Aid Payments</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Gift to Charity </a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Pension Payments</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Override Foreign TAX Credit Relief</a></p>
             
             <p class="emp_con"><a href="javascript:void(0)" title="">Subscriptions for venture Capital Trust Shares</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Subscriptions for Shares under EIS/seed EIS </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Community Investment Tax Relief</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Qualifying Loan Interest </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Maintenance Payments</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Payments to a trade union etc. for death benefits </a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Relief Claimed on redemption of bonus shares</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Relief Claimed for later years trading losess </a></p>
             
             <p class="emp_con"><a href="javascript:void(0)" title="">Payroll Giving</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Social Investment Tax Relief</a></p>
             
             
            
          </div>         
       </div>
       
         
        <div class="emp_pan">
        <span><input type="checkbox" id="capital_gains" /></span>
          <span>CAPITAL GAINS</span>
           <div class="emp_pan_in" id="capital_gainsbody">
           
             <span style="float:left;margin-bottom: 10px;"data-nid="10" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Lloyed's underwriters</a></p>
             
             
             
            
          </div>         
       </div>
       
       
       <div class="emp_pan">
        <span><input type="checkbox" id="residence_status" /></span>
          <span>RESIDENCE STATUS</span>
           <div class="emp_pan_in" id="residence_statusbody">
           
             <span style="float:left;margin-bottom: 10px;"data-nid="11" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Residence Status</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Remittance Basis</a></p>
             
             
             
            
          </div>         
       </div>
       
       <div class="emp_pan">
        <span><input type="checkbox" id="misscellaneous" /></span>
          <span>MISCELLANEOUS</span>
           <div class="emp_pan_in" id="misscellaneousbody">
           
             <span style="float:left;margin-bottom: 10px;"data-nid="12"class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Royalties and annual payments made</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Student Loan Repayments</a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Benefit from pre-owned  assets</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Service company income</a></p>
              
                <p class="emp_con"><a href="javascript:void(0)" title="">Underpayments,overpayments and adjustment</a></p>
              <p class="emp_con"><a href="javascript:void(0)" title="">Business receipts taxed as income of earlier year</a></p>
             
             <p class="emp_con"><a href="javascript:void(0)" title="">High income Child Benefit Charge </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Pension savings tax charges </a></p>
             <p class="emp_con"><a href="javascript:void(0)" title="">Tax avoidance Schemes </a></p>
          </div>         
       </div>
       
       
       <div class="emp_pan">
        <span><input type="checkbox" id="other_information" /></span>
          <span>OTHER INFORMATION</span>
           <div class="emp_pan_in" id="other_informationbody">
           
             <span style="float:left;margin-bottom: 10px;" data-nid="13" class="notesmodalcall">
               <a href="javascript:void(0)"  data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="note_butt">Notes</span></a>
             </span>
             <div class="clr"></div>
             <p class="emp_con"><a href="javascript:void(0)" title="">Other Information</a></p>
              
          </div>         
       </div>
       
      </div> 
       
       
       
       
       
       
       
       <div class="clr"></div>
       
          






<div class="add_client_btn">
 <!-- <button class="btn btn-info back" data-id="1" type="button">Prev</button>
  <button class="btn btn-danger" type="submit">Save</button> -->
 <!-- <button class="btn btn-info open"data-id="3" type="button">Next</button> -->
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
                  
                </div>
         
        <div id="step4" class="tab-pane" style="display:none;">
                  
                </div>

        <div id="step5" class="tab-pane" style="display:none;">
                  
                </div>
       

</div>
          </div>
          



            
          </div>
        
    



      </div>
    </section>



                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


<div aria-hidden="false" role="dialog" tabindex="1" id="composenotes-modal" class="modal fade in">
  <div style="width:36%;" class="modal-dialog">
    
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button type="button" data-dismiss="modal" aria-hidden="true" class="close save_btn">x</button>
     
      <div style="width:100%;">
      <input type="hidden" name="notes" id="notesid" value="" />
             <label style="font-size: 18px;" for="f_name">Notes</label>
             
          <textarea value="" id="notess" name="notes1[]" cols="65" rows="4"></textarea>
         
          <button style=" padding:4px 20px; text-align: center; margin-top: 15px; margin-left: 240px;" data-dismiss="modal" id="" onclick="" class="btn btn-danger">Cancel</button>
          
          <button style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; " id="save_notes"  class="btn btn-primary">Save</button>   
          <div class="clr"></div>       
         </div>
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@stop