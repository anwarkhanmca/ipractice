@extends('layouts.layout')


@section('mycssfile')


<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script>
var Table1, Table2, Table3;

$(function() {

  Table1 = $('#example1').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true,
        //"aLengthMenu": [[90], [90]],
        //"iDisplayLength": 90,
        
  

      "aoColumns":[
            {"bSortable": false}
            /*{"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}*/
        ]

    });
    
    
    
  //Table1.fnSort( [ [2,'asc'] ] );

 

   
  

});
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
        <div class="practice_mid"> 
        <form>
          
          <div class="tabarea">
            <div class="row">
                        <div class="col-xs-12 ser_con">
                     <div class="service_t">SERVICES</div>
                       <table width="100%" cellspacing="0" cellpadding="0" class="table table-bordered th_con m_gap2" id="example1" aria-describedby="example1_info">
  <tr>
    <td>   
    <a href="https://online.hmrc.gov.uk/shortforms/form/CWF1ST" target="_blank" class="registration_btn">Self Assesment and National Insurance Contributions Registration</a>
    </td>
  </tr>
  <tr>
    <td>
    <a href="https://online.hmrc.gov.uk/shortforms/form/SA1" target="_blank" class="registration_btn">Registering for Self Assessment and getting a tax return</a>
    </td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/EMPREG_Ltd1-2" target="_blank" class="registration_btn">Register as an employer - Limited Company with up to 2 directors</a></td>
  </tr>
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/PAYENICoC" target="_blank" class="registration_btn">Notification of a change in personal details</a></td>
  </tr>
   
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/SA401" target="_blank" class="registration_btn">Registering a partner for S A and Class 2 National Insurance contributions</a></td>
  </tr>
 
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/NIStatement" target="_blank" class="registration_btn">Request for statement of National Insurance account</a></td>
  </tr>
  
  <!-- <tr>
    <td><a href="https://www.hmrc.gov.uk/pensionschemes/ip14online.htm" target="_blank" class="registration_btn">Application for protection of your lifetime allowance - individual protection 2014</a></td>
  </tr> -->
  
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/EMPREG_Sole" target="_blank" class="registration_btn">Register as an employer - Sole trader</a></td>
  </tr>
  
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/tc689
" target="_blank" class="registration_btn">Tax credits and Child Benefit authority for an intermediary to act on behalf of a customer</a></td>
  </tr>
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/PT_CertOfRes" target="_blank" class="registration_btn">Request for Certificate of Residence in the UK</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CeaseTrading" target="_blank" class="registration_btn">Stopping self-employment</a></td>
  </tr>
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/P2" target="_blank" class="registration_btn">PAYE Coding Notice query</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/EXBENoRtn" target="_blank" class="registration_btn">PAYE - no return of Class 1A National Insurance contributions due</a></td>
  </tr>
  	<!-- <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/P11DX" target="_blank" class="registration_btn">Application to HMRC for dispensation for expenses and benefits reporting form P11DX</a></td>
  </tr> -->
<tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CBO_General" target="_blank" class="registration_btn">Child Benefit Office - General Enquiry
</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CNR_SA_SEF" target="_blank" class="registration_btn">Self-Assessment - Non-Resident Individual
</a></td>
  </tr>
 <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/OSHVAT?dept-name=&sub-dept-name=&location=47&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">Question About An Online Service
</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CNR_NIC_SEF" target="_blank" class="registration_btn">National Insurance Contributions - Individuals abroad
</a></td>
  </tr>

<tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/AAMIssue?dept" target="_blank" class="registration_btn">Agents' Issue Resolution Service</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/TEH_IRF" target="_blank" class="registration_btn">Tax Evasion Hotline - Information report form</a></td>
  </tr>
<tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/DPU_SAR" target="_blank" class="registration_btn">Data Protection Subject Access Request Form</a></td>
  </tr>

<tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CAR_IHT_Pre_Ref?dept-name=CAR&sub-dept-name=IHT&location=38&origin=http://www.hmrc.gov.uk/cto/online" target="_blank" class="registration_btn">HMRC Inheritance Tax (IHT) Reference Request</a></td>
  </tr>
  
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/EESignUp" target="_blank" class="registration_btn">Sign up for HMRC help and support emails</a></td>
  </tr>
   
  
   <!-- <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/HICBCDisc" target="_blank" class="registration_btn">High Income Child Benefit charge - request for information</a></td>
  </tr>
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/DMB_SMP2_ShPP" target="_blank" class="registration_btn">Apply for an advance of     Statutory Maternity Pay (SMP)</a></td>
  </tr> -->
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/OSHVATEDR?dept-name=&sub-dept-name=&location=47&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">Effective Date Of Registration (EDR) Requests</a></td>
  </tr>
  
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CHYChaEnq" target="_blank" class="registration_btn">Charities and VAT - Enquiry form for Charities</a></td>
  </tr>
  
 <!-- <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/IP2014?dept-name=&sub-dept-name=&location=36&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">Application for protection of your lifetime allowance - individual protection 2014</a></td>
  </tr>  -->
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CH193?dept-name=&sub-dept-name=&location=43&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">Children looked-after by a local authority or Care Trust for eight weeks or more - CH193</a></td>
  </tr> 
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CBOptOut?dept-name=&sub-dept-name=&location=43&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">High Income Child Benefit charge request not to receive Child Benefit payments</a></td>
  </tr> 
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CBOptIn?dept-name=&sub-dept-name=&location=43&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">High Income Child Benefit charge request to receive Child Benefit payments</a></td>
  </tr> 
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/HICBCDisc?dept-name=&sub-dept-name=&location=43&origin=http://www.hmrc.gov.uk" target="_blank" class="registration_btn">High Income Child Benefit charge - request for information</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/TCCF?dept-name&sub-dept-name&location=43&origin=http%3A%2F%2Fwww.hmrc.gov.uk" target="_blank" class="registration_btn">Order a tax credits claim form</a></td>
  </tr>
  <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CBOCH297e" target="_blank" class="registration_btn">Tell Child Benefit about your child staying in non-advanced education or approved training</a></td>
  </tr>
   <tr>
    <td><a href="https://online.hmrc.gov.uk/shortforms/form/CH193?dept-name=&sub-dept-name=&location=43&origin=http://www.hmrc.gov.uk
" target="_blank" class="registration_btn">Children looked-after by a local authority or Care Trust for eight weeks or more - CH193</a></td>
  </tr>
  

</table> 
<!-- <a href="#" class="refer_t">Refer to the excel book - book 1 stracture email</a> -->
                        </div>
                    	
                      </div>
          </div>
        </form>
        
      </div>
</aside>



@stop