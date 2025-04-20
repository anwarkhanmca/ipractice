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
    <td class="" width="25%"><a href="https://www.gov.uk/government/publications/rates-and-allowances-income-tax/income-tax-rates-and-allowances-current-and-past#personal-allowances" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">Income Tax - Personal Allowances</a></td>
    
    <td class="" width="25%"><a href="https://www.gov.uk/government/publications/rates-and-allowances-income-tax/income-tax-rates-and-allowances-current-and-past#tax-rates-and-bands"data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">Income Tax Rates and Bands</a></td>
 <td class="" width="25%"><a href="https://www.gov.uk/donating-to-charity/donating-straight-from-your-wages-or-pension" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">Income Tax Relief - Gift Aid</a></td>
 <td class="" width="25%"><a href="https://www.gov.uk/income-tax-reliefs/maintenance-payments-tax-relief" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">Income Tax Relief - Maintenance Payments</a></td>
    </tr>
  
   <tr>
    <td class="" width="25%"><a href="http://www.hmrc.gov.uk/manuals/vcmmanual/vcm10530.htm" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">Income Tax Reducers - EIS</a></td>
    
    <td class="" width="25%"><a href="http://www.hmrc.gov.uk/manuals/vcmmanual/vcm31130.htm" title="" target="_blank" class="hmrc_btn ">Income Tax Reducers - SEIS</a></td>
 <td class="" width="25%"><a href="http://webarchive.nationalarchives.gov.uk/20140109143644/http:/www.hmrc.gov.uk/guidance/vct.htm#2" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">Income Tax Reducers - VCT</a></td>
 <td class="" width="25%"><a href="" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn ">&nbsp;</a></td>
    </tr>
    
    
   <tr>
    <td><p class="hmrc_a gap_1">NATIONAL INSURANCE CONTRIBUTIONS</p></td>
    <td><p class="hmrc_a gap_1">CAPTIAL GAINS TAX</p></td>
    <td><p class="hmrc_a gap_1">PENSION PREMIUMS</p></td>
    <td><p class="hmrc_a gap_1">STAMP TAXES</p></td>
    </tr>
   <tr>
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-national-insurance-contributions/rates-and-allowances-national-insurance-contributions" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn3 ">NIC - Rates and Allowances</a></td>
    
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-capital-gains-tax/capital-gains-tax-rates-and-annual-tax-free-allowances#capital-gains-tax-rates-and-annual-tax-free-allowances" data-toggle="tooltip"  title="" target="_blank" class="hmrc_btn3 ">CGT Rates and Annual Tax-Free Allowances</a></td>
    
    <td><a href="https://www.gov.uk/tax-on-your-private-pension/pension-tax-relief" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn3 ">Pension Premiums - Rates and Allowances</a></td>
    
    <!-- <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-stamp-duty-land-tax/stamp-duty-land-tax-rates" target="_blank" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn3 ">Stamp Taxes - Rates and Thresholds</a></td> -->
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-stamp-duty-land-tax" target="_blank" data-toggle="tooltip" title="" target="_blank" class="hmrc_btn3 ">Stamp Taxes - Rates and Thresholds</a></td>
  </tr>
 <!--<tr>
    <td colspan="4"><a href="http://www.hmrc.gov.uk/tools/payinghmrc/class1anic.htm" target="_blank" data-toggle="tooltip" title="Class 1A NIC reference checker" class="hmrc_btn " style="width:24%" >Class 1A NIC Reference Checker</a></td>
  </tr>-->
 <tr>
    <td><p class="hmrc_a gap_1">KEY DATES AND DEADLINES</p></td>
    <td><p class="hmrc_a gap_1">SAVING AND INVESTMENT</p></td>
    <td><p class="hmrc_a gap_1">CHARITABLE GIVING</p></td>
    <td><p class="hmrc_a gap_1">&nbsp;</p></td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/government/uploads/system/uploads/attachment_data/file/519796/5293_AgentsTaxCal_v3_accessible.pdf" target="_blank" data-toggle="tooltip" class="hmrc_btn3 ">Key Dates & Deadlines</a></td>
    <td><a href="https://www.gov.uk/individual-savings-accounts" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">Savings & Investments - ISAs</a></td>
    <td><a href="https://www.gov.uk/donating-to-charity/gift-aid" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">Charitable Giving - Gift Aid</a></td>
    <td><a href="" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">&nbsp;</a></td>
  </tr>
  <tr>
   <td><p class="hmrc_a gap_1">CORPORATION TAX</p></td>
    <td>&nbsp;</td>
    <td><p class="hmrc_a gap_1">MILEAGE</p></td>
    <td>&nbsp;</td>
   </tr>
  <tr>
    <td id="btn_1"><a href="https://www.gov.uk/government/publications/rates-and-allowances-corporation-tax/rates-and-allowances-corporation-tax#corporation-tax-rates" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">Corporation Tax - Rates</a></td>
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-corporation-tax/rates-and-allowances-corporation-tax#ring-fence-companies" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">Corporation Tax - Ring fence companies</a></td>
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-travel-mileage-and-fuel-allowances/travel-mileage-and-fuel-rates-and-allowances" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">Mileage Allowances -Travel- mileage & fuel rates</a></td>
    <td><a href="https://www.gov.uk/government/publications/advisory-fuel-rates" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn3 ">Mileage Allowances - Advisory Fuel Rates</a></td>
  </tr>
  
  
  <tr>
  <td colspan="4" class="hmrc_a gap_1">CAPITAL ALLOWANCES</td>
   </tr>
  
  <tr>
    <td><a href="https://www.gov.uk/work-out-capital-allowances/rates-and-pools" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">CA - Rates and Pools</a></td>
    <td><a href="https://www.gov.uk/capital-allowances/annual-investment-allowance" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">CA - Annual Investment Allowance</a></td>
    <td><a href="https://www.gov.uk/capital-allowances/first-year-allowances"  target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">CA - First Year Allowances</a></td>
    <td><a href="https://www.gov.uk/capital-allowances/business-cars" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">CA - Business Cars</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">VALUE ADDED TAX </td>
   </tr>
  
  <tr>
    <td><a href="https://www.gov.uk/vat-rates" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">VAT Rates</a></td>
    <td><a href="https://www.gov.uk/vat-registration-thresholds" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">VAT Registration Thresholds</a></td>
    <td><a href="https://www.gov.uk/government/publications/vat-road-fuel-scale-charges-table"  target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">VAT Road Scale Charges </a></td>
    <td><a href="" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn ">&nbsp;</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">INHERITANCE TAX</td>
   </tr>
 <tr>
    <td><a href="https://www.gov.uk/inheritance-tax/overview" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Inheritance Rates & Thresholds</a></td>
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-inheritance-tax-thresholds/inheritance-tax-thresholds" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Inheritance Tax Thresholds - Prev years</a></td>
    <td><a href="https://www.gov.uk/government/publications/rates-and-allowances-inheritance-tax-interest-rates/rates-and-allowances-inheritance-tax-interest-rates" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Inheritance Tax interest rates</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">&nbsp;</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a gap_1">VECHILE BENEFITS</td>
  </tr>
  <tr>
  <td class="" width="50%" colspan="2"><a href="http://www.hmrc.gov.uk/manuals/eimanual/EIM24705.htm" target="_blank" data-toggle="tooltip" class="hmrc_btn2 ">Vehicle Benefits - Percentage, 2011/12 onwards</a></td>
  <td class="" width="50%" colspan="2"><a href="http://www.hmrc.gov.uk/manuals/eimanual/EIM24855.htm" target="_blank" data-toggle="tooltip" class="hmrc_btn2 ">Vehicle Benefits - Percentage, 2011/12 onwards</a></td>
    <!--<td><a href="http://www.hmrc.gov.uk/tools/sdlt/land-and-property.htm" target="_blank" data-toggle="tooltip" title="Work out how much SDLT you need to pay when buying or transferring freehold land or property" class="hmrc_btn">SDLT Freehold purchase calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/sdlt/leases.htm" target="_blank" data-toggle="tooltip" title="Work out how much SDLT you need to pay on a new lease" class="hmrc_btn">SDLT lease transation calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/sdltShipley.htm" target="_blank" data-toggle="tooltip" title="Request to pay SDLT by CHAPS" class="hmrc_btn">SDLT CHAPS request</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a">PENSIONS</td>
  </tr>-->
  <tr>
   <!-- <td><a href="http://www.hmrc.gov.uk/tools/pension-allowance/index.htm" target="_blank" data-toggle="tooltip" title="Work out if you can top up your annual tax-free pension allowance" class="hmrc_btn">Pension saving annual allowance calculators</a></td>-->
   <td class="" width="50%" colspan="2"><a href="http://www.hmrc.gov.uk/manuals/eimanual/EIM24705.htm" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn2 ">Vehicle Benefits - Percentage, 2002/03 onwards: Car	</a></td>
   
    <td><a href="http://www.hmrc.gov.uk/manuals/eimanual/EIM24400.htm" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Vehicle Benefits - Classic Cars</a></td>
    <td><a href="http://www.hmrc.gov.uk/manuals/eimanual/EIM25580.htm" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Car fuel benefit - The multiplier</a></td>
    <!--<td><a href="http://www.hmrc.gov.uk/tools/annual-allowance/calculator.htm" target="_blank" data-toggle="tooltip" title="Pension input amount calculator" class="hmrc_btn">Pension input calculator</a></td>-->
  </tr>
  <!--<tr>
  <td colspan="4" class="hmrc_a">CHILD BENEFIT AND CHILD TRUST FUND</td>
  </tr>-->
  <tr>
    <td><a href="https://www.gov.uk/expenses-and-benefits-company-vans/work-out-the-value" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Company Vans</a></td>
    <td><a href="https://www.gov.uk/expenses-and-benefits-company-vans/whats-exempt" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Company Vans - Exemptions</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">&nbsp;</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">&nbsp;</a></td>
  </tr>
   <tr>
  <td colspan="4" class="hmrc_a gap_1">SOME USEFUL RATES</td>
  </tr>
  <tr>
    <td><a href="https://www.gov.uk/state-pension" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Basic Retirement Pension</a></td>
    <td><a href="https://www.gov.uk/child-benefit-rates" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Child Benefit</a></td>
    
    <td><a href="https://www.gov.uk/employers-sick-pay/entitlement" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Statutory Sick Pay (SSP)</a></td>
    <td><a href="https://www.gov.uk/employers-maternity-pay-leave/entitlement" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Statutory Maternity Pay (SMP)</a></td>
  </tr>
<!-- <tr>
  <td colspan="4" class="hmrc_a">VAT</td>
  </tr>-->
  <tr>
    <td><a href="https://www.gov.uk/employers-adoption-pay-leave/entitlement" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Statutory Adoption Pay (SAP)</a></td>
    <td><a href="https://www.gov.uk/employers-paternity-pay-leave/entitlement" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Statutory Paternity Pay (SPP)*</a></td>
    <td><a href="https://www.gov.uk/jobseekers-allowance/what-youll-get" target="_blank" data-toggle="tooltip" title="" class="hmrc_btn">Useful Rates - Jobseeker's Allowance</a></td>
    <td><a href="https://www.gov.uk/national-minimum-wage-rates" target="_blank" title="" class="hmrc_btn">Useful Rates - National Minimum Wage</a></td>
  </tr>
  <!--<tr>
  <td colspan="4" class="hmrc_a">CORPORATE TAX</td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/ct-nil.htm" target="_blank" data-toggle="tooltip" title="Tell HMRC you have no Corporation Tax due" class="hmrc_btn">No Corporation tax due</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/cotaxCumbernauld.htm" target="_blank" data-toggle="tooltip" title="Request to pay Corporation Tax by CHAPS toHMRC Cumbernauld" class="hmrc_btn">Corporation tax Via CHAPS(Cumbernauld)</a></td>
    <td><a href="http://www.hmrc.gov.uk/payinghmrc/cotaxShipley.htm" target="_blank" data-toggle="tooltip" title="Request to pay Corporation Tax by CHAPS toHMRC Shipley" class="hmrc_btn">Corporation Tax via CHAPS(Shipley)</a></td>
    <td><a href="#" target="_blank" class="hmrc_btn">...</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a">INHERITANCE TAX AND BEREAVEMENT</td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/bereavement/index.htm" target="_blank" data-toggle="tooltip" title="Find out what to do when dealing with HMRC after someone dies" class="hmrc_btn">Bereavement guide</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/inheritancetax/interest-rate-calculator.htm" target="_blank" data-toggle="tooltip" title="Calculate how much interest is due on a payment of Inheritance Tax" class="hmrc_btn">Inheritance Tax Interest calculator</a></td>
    
    <td><a href="http://www.hmrc.gov.uk/tools/iht-reduced-rate/index.htm" target="_blank" data-toggle="tooltip" title="See if you qualify to pay a reduced rate of Inheritance Tax" class="hmrc_btn">Inheritance Tax reduced rate calculator</a></td>
    <td><a href="https://www.gov.uk/government/publications/inheritance-tax-grossing-up-calculators" target="_blank" data-toggle="tooltip" title="Work out an estate value when legacies in a will are free of tax and other assets are tax exempt" class="hmrc_btn">Inheritance Tax : grossing calculators</a></td>
  </tr>
  <tr>
  <td colspan="4" class="hmrc_a">IMPORT AND EXPORT</td>
  </tr>
  <tr>
    <td colspan="2"><a href="http://ec.europa.eu/taxation_customs/dds2/seed/seed_home.jsp?Lang=en&redirectionDate=2011080" target="_blank" data-toggle="tooltip" title="Check whether your SEED Excise ID is valid" class="hmrc_btn">System for the exchange of Excise Data(SEED)</a></td>
    <td><a href="https://www.gov.uk/classification-of-goods" data-toggle="tooltip" title="Classify your goods for import or export using the UK Trade Tariff, based on the EU TARIC (TARiff Integre Communautaire)" target="_blank" class="hmrc_btn">UK Trade Tariff tool</a></td>
    <td><a href="http://www.uk-customs-tariff.com/Login.aspx?ReturnUrl=%2fDefault.aspx" target="_blank" data-toggle="tooltip" title="All 3 volumes of the Tariff, which sets out the duties and measures that affect imports, exports and goods in transit"  class="hmrc_btn2">UK intergrated Tariff</a></td>
  </tr>
  <tr>
   <td><p class="hmrc_a">TRUSTS</p></td>
    <td><p class="hmrc_a">IR35:WORKING THROUGH AN INTERMEDIARY</p></td>
    <td><p class="hmrc_a">GAMBLING DUTIES</p></td>
    <td><p class="hmrc_a">CERTIFICATS OF TAX DEPOSIT</p></td>
  </tr>
  <tr>
    <td><a href="http://www.hmrc.gov.uk/tools/trusts/index.htm" target="_blank" data-toggle="tooltip" title="Work out a discretionary trust's available tax pool" class="hmrc_btn">Tax pool calculator</a></td>
    <td><a href="http://www.hmrc.gov.uk/ir35/ir35.xlt" data-toggle="tooltip" title="Help you calculate a deemed employment payment" target="_blank" class="hmrc_btn">Deemed payments spreadsheet</a></td>
    <td><a href="https://public-online.hmrc.gov.uk/machine-games-duty-search" target="_blank" data-toggle="tooltip" title="Search business by postcode" class="hmrc_btn">Machine Games Duty registered Business</a></td>
    <td><a href="http://www.hmrc.gov.uk/tools/certtaxdeposit/index.htm" target="_blank" data-toggle="tooltip" title="Check the level of interest due against a tax deposit you have already made under the Certificate of Tax Deposit scheme" class="hmrc_btn">Certificate of Tax Deposit Interest Calculator</a></td>
  </tr>-->
  
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