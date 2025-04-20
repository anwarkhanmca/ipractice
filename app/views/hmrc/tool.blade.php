@extends('layouts.layout')


@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/jquery.quicksearch.js') }}" type="text/javascript"></script>
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




//var Table1, Table2, Table3;

$(function() {
        $('input#id_search').quicksearch('table#table_example tbody td');
        
        
       /* $("#id_search").on('keypress , keydown' , function(){
            var txt = $(this).val();
            
            if($("#table_example").find("tbody").find("tr").css('display') == "none") {
                $("#no_result").css('display','block');
            } else{
                $("#no_result").css('display','none');
            }
            if(txt.length == 1){
                $("#no_result").css('display','none');
            }
        })*/
    });
    /*
//$('#example1').dataTable();
 Table1 = $('#example1').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        //"aLengthMenu": [[90], [90]],
        //"iDisplayLength": 90,
        
  

      "aoColumns":[
            {"bSortable": false}
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
    
});*/
</script>

@stop

@section('content')


<div class="wrapper row-offcanvas row-offcanvas-left">
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @include('layouts/inner_leftside')

                </section>
                <!-- /.sidebar -->
            </aside>
           <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')
    <!-- Content Header (Page header) -->
    <!--<section class="content-header">
      <h1>HMRC AUTHORISATIONS</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>-->
    <!-- Main content -->
    </section>
    <!-- Main content -->
    <section class="content">



<div class="col-xs-12">
<div class="hmrc_main">
        <form>
		<div style="float: right; margin-right: 15px;"><strong class="search_t">Search</strong> &nbsp;	<input style=" padding: 3px; border: #ccc solid 1px;   width: 16em;" type="text" name="search" value="" id="id_search" placeholder="" autofocus=""></div>	
		</form>	
            
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table_example"  >
<thead>
    <th style="display: none;"></th>
    <th style="display: none;"></th>
    <th style="display: none;"></th>
    <th style="display: none;"></th>
</thead>
<tbody>
<tr>
  <td colspan="4" class="hmrc_a">INCOME TAX</td>
  </tr>
  <tr>
    <td class="" width="25%"><a href="https://www.gov.uk/check-income-tax" data-toggle="tooltip" title="Check you're paying the right amount of Income Tax" target="_blank" class="hmrc_btn ">HMRC Tax Checker</a></td>
    
    <td class="" width="25%"><a href="http://tools.hmrc.gov.uk/hmrctaxcalculator/screen/Personal+Tax+Calculator/en-GB/summary?user=guest"data-toggle="tooltip" title="Estimate how much Income Tax and National Insurance you'll need to pay this year" target="_blank" class="hmrc_btn ">HMRC Tax Calculator</a></td>
 <td class="" width="50%" colspan="2"><a href="http://www.hmrc.gov.uk/tools/r85/r85-2015.htm" target="_blank" data-toggle="tooltip" title="Check whether you can get bank or building society interest paid tax-free for the tax year 2015 to 2016" class="hmrc_btn2 ">Check if your bank or building or society can pay your interest without tax being taken off</a></td>
    </tr>
   <tr>
    <td colspan="4" class="hmrc_a gap_1">NATIONAL INSURANCE</td>
    </tr>
   <tr>
    <td><a href="https://www.gov.uk/claim-national-insurance-refund" data-toggle="tooltip" title="Apply for a refund on your National Insurance contributions" target="_blank" class="hmrc_btn ">National Insurance refund</a></td>
    
    <td><a href="https://www.gov.uk/government/collections/how-to-manually-check-your-payroll-calculations" data-toggle="tooltip"  title="Check a company directors National Insurance contributions" target="_blank" class="hmrc_btn ">Director NIC Calculator</a></td>
    
    <td><a href="https://www.gov.uk/government/collections/how-to-manually-check-your-payroll-calculations" data-toggle="tooltip" title="Calculate your employee's National Insurance contributions" target="_blank" class="hmrc_btn ">NIC Calculator</a></td>
    
    <td><a href="http://www.hmrc.gov.uk/tools/payinghmrc/currentyear.htm" target="_blank" data-toggle="tooltip" title="PAYE/NIC current year reference checker" target="_blank" class="hmrc_btn ">PAYE/NIC Current Year reference checker</a></td>
  </tr>
 <tr>
    <td colspan="4"><a href="http://www.hmrc.gov.uk/tools/payinghmrc/class1anic.htm" target="_blank" data-toggle="tooltip" title="Class 1A NIC reference checker" class="hmrc_btn " style="width:24%" >Class 1A NIC Reference Checker</a></td>
  </tr>
 <tr>
    <td><p class="hmrc_a gap_1">SELF EMPLOYED</p></td>
    <td><p class="hmrc_a gap_1">SELF ASSESSMENT</p></td>
    <td><p class="hmrc_a gap_1">EMPLOYMENT STATUS</p></td>
    <td><p class="hmrc_a gap_1">RESIDENCE</p></td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/self-assessment-ready-reckoner" target="_blank" data-toggle="tooltip" title="A tool to help you budget for your first Self Assessment tax bill if you're self-employed" class="hmrc_btn3 ">Self-employed ready reconer</a></td>
    <td><a href="http://www.hmrc.gov.uk/gds/specialist/lloyds_calculator.htm" target="_blank" data-toggle="tooltip" title="Work out adjustments under section 107 Finance Act 2000 when filing your Self Assessment tax return" class="hmrc_btn3 ">Lloyds Calculator</a></td>
    <td><a href="http://tools.hmrc.gov.uk/esi/screen/ESI/en-GB/summary?user=guest" target="_blank" data-toggle="tooltip" title="Check your employment status" class="hmrc_btn3 ">Employment Status Indicator</a></td>
    <td><a href="http://tools.hmrc.gov.uk/rift/screen/SRT+-+Combined/en-GB/summary?user=guest" target="_blank" data-toggle="tooltip" title="Check your residence status for Income Tax and Capital Gains Tax" class="hmrc_btn3 ">Tax residence indicator</a></td>
  </tr>
  <tr>
   <td colspan="4" class="hmrc_a gap_1">PAYE</td>
   </tr>
  <tr>
    <td id="btn_1"><a href="https://www.gov.uk/pay-leave-for-parents" target="_blank" data-toggle="tooltip" title="Find out if you can get maternity, paternity or shared parental leave - for employees" class="hmrc_btn ">Calculate your leave and pay when you have a child</a></td>
    <td><a href="https://www.gov.uk/government/collections/how-to-manually-check-your-payroll-calculations" target="_blank" data-toggle="tooltip" title="Check your payroll calculations" class="hmrc_btn ">Nil Payroll Calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/payeCumbernauld.htm" target="_blank" data-toggle="tooltip" title="Request form for PAYE CHAPS transfer" class="hmrc_btn ">PAYE CHAPS</a></td>
    <td><a href="https://www.gov.uk/basic-paye-tools" target="_blank" data-toggle="tooltip" title="Tools to help you run your payroll" class="hmrc_btn ">Basic PAYE Tools</a></td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/calculate-tax-on-company-cars" target="_blank" data-toggle="tooltip" title="Calculate the company car tax charge based on a car's taxable value and CO2 rating" class="hmrc_btn ">Company car calculator</a></td>
    <td><a href="https://www.gov.uk/maternity-paternity-calculator" target="_blank" data-toggle="tooltip" title="Work out your employee's maternity or paternity pay and leave" class="hmrc_btn ">Maternity and pay calculator</a></td>
    <td><a href="https://www.gov.uk/paye-online/desktop-viewer"  target="_blank" data-toggle="tooltip" title="View your employee tax codes and notices" class="hmrc_btn ">PAYE Desktop Viewer</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/stop-cumbernauld.htm" target="_blank" data-toggle="tooltip" title="Stop receiving a PAYE payment booklet" class="hmrc_btn ">Stop PAYE Payment booklet form</a></td>
  </tr>
 <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/payinghmrc/currentyear.htm" target="_blank" data-toggle="tooltip" title="PAYE/NIC current year reference checker" class="hmrc_btn">PAYE/NIC Current year reference checker</a></td>
    <td><a href="https://www.gov.uk/get-paye-forms-p45-p60" target="_blank" data-toggle="tooltip" title="Get P45s and P60s for your employees if you can't produce these using your payroll software" class="hmrc_btn">Order P45s and P60s</a></td>
    <td><a href="https://www.gov.uk/calculate-statutory-sick-pay" target="_blank" data-toggle="tooltip" title="Work out your employee's statutory sick pay" class="hmrc_btn">Statutory sick pay calculator</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">STAMP DUTY LAND TAX(SDLT)</td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/sdlt/land-and-property.htm" target="_blank" data-toggle="tooltip" title="Work out how much SDLT you need to pay when buying or transferring freehold land or property" class="hmrc_btn">SDLT Freehold purchase calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/sdlt/leases.htm" target="_blank" data-toggle="tooltip" title="Work out how much SDLT you need to pay on a new lease" class="hmrc_btn">SDLT lease transation calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/sdltShipley.htm" target="_blank" data-toggle="tooltip" title="Request to pay SDLT by CHAPS" class="hmrc_btn">SDLT CHAPS request</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">PENSIONS</td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/pension-allowance/index.htm" target="_blank" data-toggle="tooltip" title="Work out if you can top up your annual tax-free pension allowance" class="hmrc_btn">Pension saving annual allowance calculators</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/annualallowancelimit/index.htm" target="_blank" data-toggle="tooltip" title="Check if you need to pay a tax charge on your pension savings" class="hmrc_btn">Pension schemes annual all. checking tool</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/lifetimeallowance/index.htm" target="_blank" data-toggle="tooltip" title="Check if you should apply for lifetime allowance protection on your pension" class="hmrc_btn">Pension schemes lifetime all. checking tool</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/annual-allowance/calculator.htm" target="_blank" data-toggle="tooltip" title="Pension input amount calculator" class="hmrc_btn">Pension input calculator</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">CHILD BENEFIT AND CHILD TRUST FUND</td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/child-benefit-tax-calculator" target="_blank" data-toggle="tooltip" title="Check if you need to pay the High Income Child Benefit Tax Charge" class="hmrc_btn">Child Benefit Tax Calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/childtrustfundclaim/ctfaccount.htm" target="_blank" data-toggle="tooltip" title="Work out where your Child Trust Fund is held" class="hmrc_btn">Child Trust Fund Locator</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
   <tr>
  <td colspan="4" class="hmrc_a gap_1">TAX CREDITS</td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/childcare-vouchers-better-off-calculator" target="_blank" data-toggle="tooltip" title="Find out how childcare vouchers from your employer affect your tax credits" class="hmrc_btn">Child vouchers: Better of calculators</a></td>
    <td><a href="https://www.gov.uk/qualify-tax-credits" target="_blank" data-toggle="tooltip" title="Find out if you qualify for tax credits" class="hmrc_btn">Tax credits questionaire</a></td>
    
    <td><a href="https://www.gov.uk/tax-credits-calculator" target="_blank" data-toggle="tooltip" title="Estimate of how much in tax credits you could get in total" class="hmrc_btn">Tax credits calculator</a></td>
    <td><a href="https://www.gov.uk/childcare-costs-for-tax-credits" target="_blank" data-toggle="tooltip" title="Calculate your childcare costs for claiming tax credits" class="hmrc_btn">Tax credits : working out childcare cost</a></td>
  </tr>
 <tr>
  <td colspan="4" class="hmrc_a gap_1">VAT</td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/vat-payment-deadlines" target="_blank" data-toggle="tooltip" title="Work out the VAT payment deadline for your accounting period" class="hmrc_btn">VAT Payment deadline calculator</a></td>
    <td><a href="http://ec.europa.eu/taxation_customs/vies/" target="_blank" data-toggle="tooltip" title="Check a VAT number from any EU country to help you complete a EC Sales List (ESL)" class="hmrc_btn">EU VAT number validation</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/paying-vat.htm" target="_blank" data-toggle="tooltip" title="Request to pay VAT by CHAPS" class="hmrc_btn">VAT CHAPS  request</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">CORPORATE TAX</td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/ct-nil.htm" target="_blank" data-toggle="tooltip" title="Tell HMRC you have no Corporation Tax due" class="hmrc_btn">No Corporation tax due</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/cotaxCumbernauld.htm" target="_blank" data-toggle="tooltip" title="Request to pay Corporation Tax by CHAPS toHMRC Cumbernauld" class="hmrc_btn">Corporation tax Via CHAPS(Cumbernauld)</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/cotaxShipley.htm" target="_blank" data-toggle="tooltip" title="Request to pay Corporation Tax by CHAPS toHMRC Shipley" class="hmrc_btn">Corporation Tax via CHAPS(Shipley)</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">INHERITANCE TAX AND BEREAVEMENT</td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/bereavement/index.htm" target="_blank" data-toggle="tooltip" title="Find out what to do when dealing with HMRC after someone dies" class="hmrc_btn">Bereavement guide</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/inheritancetax/interest-rate-calculator.htm" target="_blank" data-toggle="tooltip" title="Calculate how much interest is due on a payment of Inheritance Tax" class="hmrc_btn">Inheritance Tax Interest calculator</a></td>
    
    <td><a href="http://www.hmrc.gov.uk/tools/iht-reduced-rate/index.htm" target="_blank" data-toggle="tooltip" title="See if you qualify to pay a reduced rate of Inheritance Tax" class="hmrc_btn">Inheritance Tax reduced rate calculator</a></td>
    <td><a href="https://www.gov.uk/government/publications/inheritance-tax-grossing-up-calculators" target="_blank" data-toggle="tooltip" title="Work out an estate value when legacies in a will are free of tax and other assets are tax exempt" class="hmrc_btn">Inheritance Tax : grossing calculators</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">IMPORT AND EXPORT</td>
  </tr>
  <tr>
    <td colspan="2"><a href="http://ec.europa.eu/taxation_customs/dds2/seed/seed_home.jsp?Lang=en&redirectionDate=2011080" target="_blank" data-toggle="tooltip" title="Check whether your SEED Excise ID is valid" class="hmrc_btn">System for the exchange of Excise Data(SEED)</a></td>
    <td><a href="https://www.gov.uk/classification-of-goods" data-toggle="tooltip" title="Classify your goods for import or export using the UK Trade Tariff, based on the EU TARIC (TARiff Integre Communautaire)" target="_blank" class="hmrc_btn">UK Trade Tariff tool</a></td>
    <td><a href="http://www.uk-customs-tariff.com/Login.aspx?ReturnUrl=%2fDefault.aspx" target="_blank" data-toggle="tooltip" title="All 3 volumes of the Tariff, which sets out the duties and measures that affect imports, exports and goods in transit"  class="hmrc_btn2">UK intergrated Tariff</a></td>
  </tr>
  <tr>
   <td><p class="hmrc_a gap_1">TRUSTS</p></td>
    <td><p class="hmrc_a gap_1">IR35:WORKING THROUGH AN INTERMEDIARY</p></td>
    <td><p class="hmrc_a gap_1">GAMBLING DUTIES</p></td>
    <td><p class="hmrc_a gap_1">CERTIFICATS OF TAX DEPOSIT</p></td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/trusts/index.htm" target="_blank" data-toggle="tooltip" title="Work out a discretionary trust's available tax pool" class="hmrc_btn3">Tax pool calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/ir35/ir35.xlt" data-toggle="tooltip" title="Help you calculate a deemed employment payment" target="_blank" class="hmrc_btn3">Deemed payments spreadsheet</a></td>
    <td><a href="https://public-online.hmrc.gov.uk/machine-games-duty-search" target="_blank" data-toggle="tooltip" title="Search business by postcode" class="hmrc_btn3">Machine Games Duty registered Business</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/certtaxdeposit/index.htm" target="_blank" data-toggle="tooltip" title="Check the level of interest due against a tax deposit you have already made under the Certificate of Tax Deposit scheme" class="hmrc_btn3">Certificate of Tax Deposit Interest Calculator</a></td>
  </tr>
  
  </tbody>
</table>

<table id="no_result" style="display: none;">
    <tbody>
        <tr>
            <td>No matching records found</td>
        </tr>
    </tbody>
</table>


<div class="clearfix"></div>

</div>
</div>
<div class="clearfix"></div>
        
    </section>
    <!-- /.content -->
  </aside></div>


@stop