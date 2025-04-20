@section('mycssfile')
@stop

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Hmrc Revenue</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->

<!-- font Awesome -->

<!-- Ionicons -->

<!-- Morris chart -->

<style>
*{ margin:0; padding:0;}
body{ font-family:Arial, Helvetica, sans-serif; background:#3f3f3f; font-size:15px}
.bx tr td{ padding:3px 5px;}


.custom_wrapper{ padding:50px; margin:0 auto; width:900px; background:#fff;}
.custom_wrapper table{ border-collapse:collapse; }
.hm_img{ padding:0; margin:0; float:left;}
.hm_con{ padding:15px 0 0 3px; margin:0; color:#009991; font-size:24px; float:left; font-weight:bold;}
.lft_pan{ padding:0; margin:0; float:left; width:48%;}
.rft_pan{ padding:0; margin:0; float:right; width:48%;}
.rft_pan table tr td{ padding:5px 10px 2px 10px}
.pl_con{ padding:0 0 0 0; margin:0; }
.box1{ padding:0 0 0 0; margin:20px 0 0 0; border:#009991 solid 1px; height:150px;}
.bx{ padding:0; margin:5px 0 10px 0; border:#009991 solid 1px; border-collapse:collapse;}
td.bx-col{ border:#98d6d1 solid 1px; height:25px; font-size:15px;}
.ofcllft{ padding:0; margin:0; float:left; width:200px;}
.sa_con{ padding:0px 0px 0 0; margin:0; float:left; width:50px;}
.ofcchckbx{ padding:0; margin:3px 18px 0 0; float:left; border: #009991 solid 1px;}
.ofcbx{ padding:7px 50px; margin:0 0 0 0; border-bottom:#ccc solid 1px; float:left;}
.ofcllft_in{ padding:0; margin:0 0 5px 0; float:left;}
.grn_pan{ padding:5px; margin:0; background-color:#e3f4f2; width:420px;}
td.ind_con{ padding:0; font-style:italic;}
.sl_bx{ padding:0; margin:0; background-color:#d7e7ff; border:#8ad1cc solid 1px; width:90px;}
.maintab{ background:#e3f4f2;}
.maintab table tr td{ padding:0px;}

.txt_bx{ padding:5px 0 5px 0; margin:0; background:#fff; border:#8ad1cc solid 1px; width:97%;}
.clr_butt{ padding:6px 15px; margin:15px 0 0 150px; color:#000000; cursor:pointer; border:none; background:#bed9e2; font-weight:bold; box-shadow:1px 1px 1px 1px #8ea9b2;}
.author_tab{ padding:0; margin:40px 0 0 0;}
.author_tab table tr td{ padding:10px;}
.maintab2{background:#e3f4f2;}
.shld_con{ padding:0; font-size:23px; color:#00998e; font-weight:bold; margin:0;}
.if_con{ padding:0; margin:0; font-size:17px; font-weight:normal;}
.if_con1{ padding:0; margin:0; font-size:18px; font-weight:normal;}
.vat_con{ padding:5px 0 0 0; margin:0; font-size:17px; line-height:22px;}
.txt_bx2{ padding:1px 0 1px 0; margin:0; background:#fff; border:#6fc7c0 solid 1px; width:22px; height:26px;}
</style>

</head>



<body style="background:3f3f3f !important;">

<div class="custom_wrapper">

<table width="100%" border="0">
  <tr>
    <td>
	<span class="hm_img"><img src="img/hm_logo.jpg" alt=""></span>
	</td>
    <td>
	<span class="hm_con" style="float:right; padding-top:10px;">Authorising your agent</span>
	</td>
  </tr>
  <tr>
    <td colspan="2"><p style="border-bottom:#00998e solid 15px; margin:7px 0 12px 0;"></p></td>
  </tr>
  <tr>
    <td colspan="2">
	<span class="lft_pan">
	<p class="pl_con"><strong>Please read the notes on the back before completing this
authority.</strong>
This authority allows us to exchange and disclose
information about you with your agent and to deal with
them on matters within the responsibility of HM Revenue &
Customs (HMRC), as specified on this form. This overrides any
earlier authority given to HMRC. We will hold this authority
until you tell us that the details have changed.</p>


 <table width="100%" border="0" class="bx" align="left">
  <tr>
    <td class="bx-col"> <strong>I <span style="color:#8ad1cc"><em>( print your name )</em></span></strong></td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col"><strong> of <span style="color:#8ad1cc"><em>( name of your business, company or trust if applicable )</em></span></strong></td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col"><strong> authorise HMRC to disclose information to</strong></td>
  </tr>
  <tr>
    <td class="bx-col"><strong><span style="color:#8ad1cc"><em> ( agent's business name )</em></span></strong></td>
  </tr>
  <tr>
    <td class="bx-col"></td>
  </tr>
  <tr>
    <td class="bx-col"><strong>I agree that the nominated agent has agreed to act on my/our
behalf, and the information is correct and complete.
The authorisation is limited to the matters shown on the
right-hand side of this form.</strong></td>
  </tr>
  <tr>
    <td class="bx-col"><em><strong>Signature</strong>
see note 1 overleaf before signing </em></td>
  </tr>
  <tr>
    <td class="bx-col"><strong><em>Date</em></strong></td>
  </tr>
</table>


   <p>Give your personal details or company registered office here</p>
   
   <table width="100%" border="0" class="bx">
  <tr>
    <td class="bx-col">Address</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">Postcode</td>
  </tr>
  <tr>
    <td class="bx-col">Phone number</td>
  </tr>
</table>


<p>Give your agent's details here</p>

<table width="100%" border="0" class="bx">
  <tr>
    <td class="bx-col">Address</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">Postcode</td>
  </tr>
  <tr>
    <td class="bx-col">Phone number</td>
  </tr>
  <tr>
    <td class="bx-col">Agent codes (SA/CT/PAYE)</td>
  </tr>
  <tr>
    <td class="bx-col">&nbsp;</td>
  </tr>
  <tr>
    <td class="bx-col">Client reference</td>
  </tr>
</table>

 <p style="border-bottom: #98d6d1 solid 2px; margin:25px 0 10px 0;"></p>
 <p style="font-style:italic; padding-bottom:10px; color:#6f7175;"><strong>For official use only</strong></p>
 
  <div class="ofcllft" style="color:#6f7175;">
    <div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	
	<div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	
	<div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	
	<div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	
  </div>
  
  
  
  <div class="ofcllft" style="float:right;color:#6f7175;">
    <div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	
	<div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	
	<div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	
	<div class="ofcllft_in">
      <span><p class="sa_con">SA</p></span>
	  <span><input name="" type="checkbox" value="" class="ofcchckbx"></span>
	  <span class="ofcbx"></span>
      <div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
	
  </div>
  <div style="clear:both;"></div>
  <br>
<strong>64-8</strong>

  
  <div class="clearfix"></div>

  
   </span>
   <span class="rft_pan">
   
     <p class="pl_con"><strong>Please tick the box(es) and provide the reference(s)requested only for those matters for which you want HMRC to deal with your agent.</strong></p>
	 
<br />

   <table width="100%" border="0" bgcolor="#e3f4f2" class="maintab">
  <tr>
    <td valign="top">
	<table width="100%" border="0">
  <tr>
    <td class="ind_con"><strong>Individual*/Partnership*/Trust* Tax Affairs</strong></td>
    <td><input name="" type="checkbox" value=""></td>
    <td><select name="" class="sl_bx"><option>*select</option></select></td>	
  </tr>
  <tr><td colspan="3">*delete as appropriate (including National Insurance)</td></tr>
</table>
	</td>
  </tr>
  
  <tr>
    <td style="padding-top:5px;">
	Your National Insurance number
(individuals only)
	</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0">
  <tr>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="27"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="7">&nbsp;</td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6">&nbsp;</td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="5">&nbsp;</td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8">&nbsp;</td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="82" align="right" style="font-style:italic;">If you are
self employed
tick here</td>
    <td width="31"><input name="" type="checkbox" value=""></td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
    <td style="padding-top:15px;">
	Unique Taxpayer Reference (UTR)
(if applicable)
	</td>
  </tr>
  <tr>
    <td>
	
	  <table width="100%" border="0">
  <tr>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="22"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="21"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="22"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="21"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="22"><input name="" type="text" value="" class="txt_bx2"></td>
	<td width="21"><input name="" type="text" value="" class="txt_bx2"></td>
	<td width="20"><input name="" type="text" value="" class="txt_bx2"></td>
    
    <td width="118" align="right" style="font-style:italic;">If UTR not yet
issued tick here</td>
    <td width="33"><input name="" type="checkbox" value=""></td>
  </tr>
</table>
	

	
	</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="91%">If you are a Self Assessment taxpayer, we will send
your Statement of Account to you, but if you would
like us to send it to your agent instead, please tick here </td>
    <td width="9%"><input name="" type="checkbox" value=""></td>
  </tr>
</table>
</td>
  </tr>
     <tr>
    <td colspan="2" style="padding:0;">&nbsp; </td>
  </tr>
</table>

<br />

<table width="100%" border="0" bgcolor="#e3f4f2" class="maintab">
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="26%"><strong style="font-style:italic;">Tax credits</strong></td>
    <td width="74%"><input name="" type="checkbox" value=""></td>
  </tr>

</table>
</td>
  </tr>
  <tr>
    <td>Your National Insurance number
(only if not entered above)</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="9%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="7%">&nbsp;</td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6%">&nbsp;</td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6%">&nbsp;</td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6%">&nbsp;</td>
    <td width="10%"><input name="" type="text" value="" class="txt_bx2"></td>
  </tr>
    
</table>
</td>
  </tr>
  <tr>
    <td>If you have a joint tax credit claim and the other claimant
wants HMRC to deal with this agent, they should sign here
Name</td>
  </tr>
  <tr>
    <td><input name="" type="text" class="txt_bx"></td>
  </tr>
  <tr>
    <td>Signature</td>
  </tr>
  <tr>
    <td><textarea name="" cols="" rows="" class="txt_bx"></textarea></td>
  </tr>
  <tr>
    <td>Joint claimant's National Insurance number</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="9%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="7%">&nbsp;</td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6%">&nbsp;</td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6%">&nbsp;</td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="6%">&nbsp;</td>
    <td width="10%"><input name="" type="text" value="" class="txt_bx2"></td>
  </tr>
</table></td>
  </tr>
   <tr>
    <td colspan="2" style="padding:0;">&nbsp; </td>
  </tr>
  
</table>

  <br />

   <table width="100%" border="0" bgcolor="#e3f4f2" class="maintab">
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="32%"><strong style="font-style:italic;">Corporation Tax</strong></td>
    <td width="68%"><input name="" type="checkbox" value=""></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>Company Registration Number</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="44%"><input name="" type="text" value="" class="txt_bx2"></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>Company's Unique Taxpayer Reference</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
	<td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
	<td width="8%"><input name="" type="text" value="" class="txt_bx2"></td>
    <td width="44%"><input name="" type="text" value="" class="txt_bx2"></td>
  </tr>
</table></td>
  </tr>
   <tr>
    <td colspan="2" style="padding:0;">&nbsp; </td>
  </tr>
</table>


<br />


    <table width="100%" border="0" bgcolor="#e3f4f2" class="maintab">
  <tr>
    <td><strong>NOTE:
Do not complete this section if you are an
employee. Only tick the box if you are an employer
operating PAYE</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="46%">Employer PAYE Scheme</td>
    <td width="54%"><input name="" type="checkbox" value=""></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>Employer PAYE reference</td>
  </tr>
  <tr>
    <td><input name="" type="text" class="txt_bx"></td>
  </tr>
   <tr>
    <td colspan="2" style="padding:0;">&nbsp; </td>
  </tr>
</table>


<br />


    <table width="100%" border="0" bgcolor="#e3f4f2" class="maintab">
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td><strong>VAT</strong></td>
    <td><input name="" type="checkbox" value=""></td>
    <td>(see notes 2 and 5 overleaf)</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>VAT Registration Number</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
    <td><input name="" type="text" value="" class="txt_bx2"></td>
  </tr>
</table>
</td>
    <td>If not yet
registered
tick here</td>
    <td><input name="" type="checkbox" value=""></td>
  </tr>
  
</table>
</td>
  </tr>
   <tr>
    <td colspan="2" style="padding:0; height:6px">&nbsp; </td>
  </tr>
</table>



    <input name="" type="button" value="CLEAR FORM" class="clr_butt">

HMRC 08/11
   
   
   </span>
   <div class="clearfix"></div>
   

	</td>
    <td>&nbsp;
	
</td>
	
	
	
	
	
	
  </tr>
  
</table>








   <table width="100%" border="0" class="author_tab">
  <tr>
    <td class="shld_con" style="padding-bottom:10px;">1 Who should sign the form</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td class="if_con"><strong>If the authority is for</strong></td>
    <td class="if_con"><strong>Who signs the form</strong></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="maintab2" style="border:1px solid #a5abad; font-size:18px;">
  <tr>
    <td width="52%" class="if_con1">You, as an individual</td>
    <td width="48%" class="if_con1">You, for your personal tax affairs</td>
  </tr>
  <tr>


  </tr>
  <tr>
    <td class="if_con1">A Company</td>
    <td class="if_con1">The secretary or other responsible officer of
the company</td>
  </tr>
  <tr>

  </tr>
  <tr>
    <td class="if_con1">A Partnership</td>
    <td class="if_con">The partner responsible for the partnership's
tax affairs. It applies only to the partnership.
Individual partners need to sign a separate
authority for their own tax affairs</td>
  </tr>
  <tr>

  </tr>
  <tr>
    <td class="if_con1">A trust</td>
    <td class="if_con1">One or more of the trustees</td>
  </tr>
</table>
</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td width="52%" valign="top">
    
    <p class="shld_con">2 What this authority means</p>
    <p class="vat_con"><strong>• For matters other than VAT or tax credits</strong></p>
    <p class="vat_con">We will start sending letters and forms to your agent and
give them access to your account information online.
Sometimes we need to correspond with you as well as, or
instead of, your agent. </p>

    <p class="vat_con">For example, the latest information on what Self
Assessment (SA) forms we send automatically can be
found on our website, go to</p>

    <p class="vat_con"><strong>www.hmrc.gov.uk/sa/agentlist.htm</strong>
or phone the SA Helpdesk on
<strong>0845 9000 444</strong>
.
You will not receive your Self Assessment Statements
of Account if you authorise your agent to receive
them instead, but paying any amount due is
your responsibility. </p>

    <p class="vat_con">We do not send National Insurance statements and
requests for payment to your agent unless you have
asked us if you can defer payment.</p>

    <p class="vat_con">Companies do not receive Statements of Account.</p>
    
    <p class="vat_con">• <strong>For VAT and tax credits</strong></p>
    
    <p class="vat_con">We will continue to send correspondence to you rather
than to your agent but we can deal with your agent in
writing or by phone on specific matters. If your agent is
able to submit VAT returns online on your behalf, you will
need to authorise them to do so through our website.
For joint tax credit claims, we need both claimants to
sign this authority to enable HM Revenue & Customs to
deal with your agent.</p>

    <p class="shld_con" style="padding-top:20px;">3 How we use your information</p>
    <p class="vat_con">HM Revenue & Customs is a Data Controller under the Data
Protection Act 1998. We hold information for the purposes
specified in our notification to the Information
Commissioner, including the assessment and collection of
tax and duties, the payment of benefits and the prevention
and detection of crime, and may use this information for
any of them.</p>
    <p class="vat_con">We may get information about you from others, or we
may give information to them. If we do, it will only be
as the law permits to:</p>
    <p class="vat_con">• check the accuracy of information</p>
    
    
    
    
    </td>
    <td width="48%">
    
    <p class="vat_con">•prevent or detect crime</p>
    <p class="vat_con">• protect public funds.</p>
    <p class="vat_con">We may check information we receive about you with
what is already in our records. This can include information
provided by you, as well as by others, such as other
government departments or agencies and overseas tax
and customs authorities. We will not give information
to anyone outside HM Revenue & Customs unless the law
permits us to do so. For more information go to
<strong>www.hmrc.gov.uk</strong>
and look for
Data Protection Act
within
the
Search
facility. </p>

   <p class="shld_con" style="padding-top:20px;">4 Multiple agents</p>
   <p class="vat_con">If you have more than one agent (for example, one acting
for the PAYE scheme and another for Corporation Tax),
please sign one of these forms for each.</p>

   <p class="shld_con" style="padding-top:20px;">5 Where to send this form</p>
   <p class="vat_con">When you have completed this form please
send it to:<br /><strong>HM Revenue & Customs<br />
Central Agent Authorisation Team<br />
Longbenton<br />
Newcastle upon Tyne<br />
NE98 1ZZ</strong> </p>

    <p class="vat_con">There are some exceptions to this to help speed the
handling of your details in certain circumstances.
If this form:</p>
    <p class="vat_con">• accompanies other correspondence, send it to the
appropriate HM Revenue & Customs (HMRC) office</p>
    <p class="vat_con">• is solely for Corporation Tax affairs, send it to the
HMRC office that deals with the company </p>
    <p class="vat_con">• is for a High Net Worth or an expatriate customer,
send it to the appropriate High Net Worth Unit or
the Manchester Expat Team</p>
    <p class="vat_con">• accompanies a VAT Registration application, send
it to the appropriate VAT Registration Unit</p>
    <p class="vat_con">• has been specifically requested by an HMRC office,
send it back to that office.</p>
    </td>
  </tr>
</table>
</td>
  </tr>
  
</table>


</div>




</body>
</html>