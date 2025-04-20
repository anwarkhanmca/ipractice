
<style>
.page-break {
    page-break-after: always;
}
.footer { position: fixed; bottom: 5px; border-bottom: 2px solid #00ACD6; padding-bottom: -20px; font-size:14px;  }
.divider {color:#ccc; padding: 0 10px 0 10px ;}

</style>



<!--
<div style="border-top: #00ACD6 solid 30px; "></div>
<div style="height: 200px;"></div>
<h2 style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $details->CompanyName or "" }}</h2>

<div style="height: 15px;"></div>
<h1 style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "CLIENT OVERVIEW"}}</h1>




<div style="height: 220px;"></div>
<div style="border-top: #00ACD6 solid 30px; "></div>
 -->


<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td style="border-top: #00ACD6 solid 30px; ">&nbsp;</td>
</tr>
<tr>

 <!-- <td style="height: 220px;">&nbsp;</td> -->


@if(strlen($details->CompanyName) > 20)
<td style="height: 220px;">&nbsp;</td>
@else

<td style="height: 240px;">&nbsp;</td>
@endif




<!--
<td style="height: 270px;">&nbsp;</td> -->
</tr>
<tr>
<td style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $details->CompanyName  or "" }}</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "STATUTORY INFORMATION"}}</td>
</tr>
<tr>

@if(strlen($details->CompanyName) > 20)
<td style="height: 220px;">&nbsp;</td>
@else
<td style="height: 260px;">&nbsp;</td>
@endif
</tr>

<tr>
<td style="border-top: #00ACD6 solid 30px; position: fixed; bottom:0; ">&nbsp;</td>
</tr>
</table>
 
<div class="clearfix"></div>


 <div class="page-break"></div>
 <div class="footer">{{ "STATUTORY INFORMATION"}}  <span class="divider">| </span>{{ $details->CompanyName or "" }}<span class="divider">| </span> {{$today or ""}} {{$time or ""}}
    </div>
 
 
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>OVERVIEW</strong></p>
  <div>
         
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
          
          <tr>
            <td width="40%" class="td_color"><strong>Company Name</strong></td>
            <td width="60%">{{ $details->CompanyName or "" }}</td>
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
            <td>{{ $client_data['ch_auth_code'] or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Company Category</strong></td>
            <td>{{ $details->CompanyCategory or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Company Status</strong></td>
            <td>{{ $details->CompanyStatus or "" }}</td>
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
            <td>{{ $details->Accounts->AccountRefDay or "" }}/{{ $details->Accounts->AccountRefMonth or "" }}</td>
          </tr>
          <tr>
            <td class="td_color"><strong>Last Accounts made Up Date</strong></td>
            <td>{{ $details->Accounts->LastMadeUpDate or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Next Accounts Due</strong></td>
            <td>{{ $details->Accounts->NextDueDate or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Last Return Made Up To</strong></td>
            <td>{{ $details->Returns->LastMadeUpDate or "" }}</td>
          </tr>
            <tr>
            <td class="td_color"><strong>Next Return Due</strong></td>
            <td>{{ $details->Returns->NextDueDate or "" }}</td>
          </tr>
          
        </table>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px; padding-top: 10px;">
            <tr class="td_color">
              <td align="left"><strong>	<font color="#00ACD6">REGISTERED OFFICE</font></strong></td>
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










 <div class="page-break"></div>
 
 
 
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>OFFICERS</strong></p>
  <div>
         <!--
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
         
            <tr class="td_color">
              <td align="left" class="sub_header"><strong>Name</strong></td>
              <td align="left" class="sub_header"><strong>Appointment Date</strong></td>
              <td align="left" class="sub_header"><strong>Role</strong></td>
            </tr>

          @if(isset($officers) && count($officers)>0)
            @foreach($officers as $key=>$field_row)
              @if(!isset($field_row->resigned_on))
              <tr>
                <td align="left">{{ ucwords($field_row->name) }}</td>
                <td align="left">{{ isset($field_row->appointed_on)?date("d F Y", strtotime($field_row->appointed_on)):"" }}</td>
                <td align="left">{{ ucwords(str_replace("-", " ", $field_row->officer_role)) }}</td>
              </tr>
              @endif
            @endforeach
          @endif
           
        </table>
        -->
         
        
        
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px; padding-top: 20px;">
         
          <tr class="td_color">
            <td width="13%" class="sub_header"> <strong>Name</strong></td>
            <td width="13%" class="sub_header"><strong>DOB</strong></td>
            <td width="8%" class="sub_header"><strong>Nationality</strong></td>
            <td width="13%" class="sub_header"><strong>Occupation</strong></td>
            <td width="8%" class="sub_header"> <strong>Country</strong></td>
            <td width="13%" class="sub_header"><strong>Officer Role</strong></td>
            <td width="13%" class="sub_header"><strong>Appointed on</strong></td>
             <td width="13%" class="sub_header"><strong>Address</strong></td>
             
          </tr>
          
          
           @if(isset($offdetails) && count($offdetails)>0)
                @foreach($offdetails as $key=>$field_row)
                 @if(!isset($field_row->resigned_on))
               
                <tr>
               <td width="13%" class="sub_header">{{ ucwords($field_row['name']) }}</td>
               
            <td width="13%" class="sub_header">{{ $field_row['dobmonth'] or "" }} {{"," }}{{ $field_row['dobyear'] or "" }}</td>
            
            <td width="8%" class="sub_header"> {{$field_row['nationality'] or ""}}</td>
            
            <td width="13%" class="sub_header">{{ ucwords(str_replace("-", " ", $field_row['ocu'])) }}</td>
            <td width="8%" class="sub_header">{{$field_row['country'] or ""}}</td>
            
            <td width="13%" class="sub_header">{{ ucwords(str_replace("-", " ", $field_row['offrole'])) }}</td>
            <td width="13%" class="sub_header">{{ isset($field_row['appointed'])?date("d F Y", strtotime($field_row['appointed'])):"" }} </td>
             <td width="20%" class="sub_header">
             
             
             @if(!empty($field_row['address']->address_line_1 ))
             {{ $field_row['address']->address_line_1 or "" }}{{", " }}
             @endif
             
              @if(!empty( $field_row['address']->address_line_2))
             {{ $field_row['address']->address_line_2 or "" }}{{", " }}
             @endif
             
               @if(!empty($field_row['address']->premises))
              {{ $field_row['address']->premises or "" }}{{", " }}
             @endif
             
              @if(!empty($field_row['address']->locality ))
              {{ $field_row['address']->locality or "" }}{{", " }}
             @endif
                 
                 
                 @if(!empty($field_row['address']->postal_code ))
              {{ $field_row['address']->postal_code or "" }}{{", " }}
             @endif                      
                                       
                       
                         @if(!empty($field_row['address']->country ))
              {{ $field_row['address']->country or "" }}{{", " }}
             @endif                 
                                       
               </td>
                </tr>
                 @endif
                @endforeach
          
          @endif
          
          <!--
           @if(isset($officers) && count($officers)>0)
            @foreach($officers as $key=>$field_row)
              @if(!isset($field_row->resigned_on))
                 <tr>
               <td width="13%" class="sub_header">{{ ucwords($field_row->name) }}</td>
            <td width="13%" class="sub_header">{{ $field_row->date_of_birth->month or "" }}{{ $field_row->date_of_birth->year or "" }}</td>
            <td width="8%" class="sub_header"> {{$field_row->nationality or ""}}</td>
            <td width="13%" class="sub_header">{{ ucwords(str_replace("-", " ", $field_row->officer_role)) }}</td>
            <td width="8%" class="sub_header">{{$field_row->country_of_residence or ""}}</td>
            <td width="13%" class="sub_header">{{ ucwords(str_replace("-", " ", $field_row->officer_role)) }}</td>
            <td width="13%" class="sub_header">{{ isset($field_row->appointed_on)?date("d F Y", strtotime($field_row->appointed_on)):"" }} </td>
            <td width="20%" class="sub_header">{{ $field_row->address->address_line_1 or "" }}{{ $field_row->address->address_line_2 or "" }}{{ $field_row->address->premises or "" }}{{ $field_row->address->locality or "" }}{{ $field_row->address->postal_code or "" }}{{ $field_row->address->country or "" }}</td>
                </tr>
              @endif
            @endforeach
          @endif
            -->
          
          
          
          
          
          
          
          
          
          
          

             
      
        </table>
        
        
                
</div>





 <div class="page-break"></div>

 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>STATEMENT OF CAPITAL</strong></p>
  <div>
         
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
         
          <tr class="td_color">
            <td class="sub_header"> <strong>Type</strong></td>
            <td width="15%" class="sub_header"><strong>Date</strong></td>
            <td class="sub_header"><strong>Share Capital</strong></td>
            <td class="sub_header"><strong>Category</strong></td>
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
</div>




 <div class="page-break"></div>

 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>COMPANY FILING HISTORY LIST</strong></p>
  <div>
         
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
           
          <tr class="td_color">
            <td class="sub_header" width="20%"  ><strong>Type</strong></td>
            <td width="20%" class="sub_header"><strong>Date</strong></td>
            <td width="40%" class="sub_header"><strong>Description</strong></td>
             <td width="20%" class="sub_header">View/Download</td>
            
          </tr>

        @if(!empty($filling_history))
          @foreach($filling_history as $key=>$field_row)
            <tr>
              <td width="20%" >{{ $field_row->type or "" }}</td>
              <td width="20%" >{{ $field_row->date or "" }}</td>
              <td width="40%" align="left">{{ ucwords(str_replace("-", " ", $field_row->description)) }}</td>
               <td width="20%"><a href="https://beta.companieshouse.gov.uk/company/{{ $details->CompanyNumber or "" }}/filing-history/{{ $field_row->transaction_id or "" }}/document?format=pdf&download=0" target="_blank">View PDF</a></td>
            </tr>
          @endforeach
        @endif

           <!-- <tr>
            <td colspan="3">&nbsp;</td>
             </tr> -->
        </table>
          
        
</div>




 <div class="page-break"></div>

 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CHARGES</strong></p>
  <div>
         
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
           
        
          <tr>
            <td colspan="4" align="left" class="charge_tr"><strong>Charge Registered</strong></td>
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
 
 
 
 
 <div class="page-break"></div>

 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>INSOLVENCY</strong></p>
  <div>
         
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
           <tr class="td_color">
          
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