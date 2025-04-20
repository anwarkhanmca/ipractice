<style>
.page-break {
page-break-after: always;
}
.footer { position: fixed; bottom: 5px; border-bottom: 2px solid #00ACD6; padding-bottom: -25px; font-size:14px;  }
.divider {color:#ccc; padding: 0 10px 0 10px ;}
.hmrc { position: fixed;  }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td style="border-top: #00ACD6 solid 30px; ">&nbsp;</td>
	</tr>
	<tr>
		
		
		<td style="height: 240px;">&nbsp;</td>
	
		
	</tr>
	<tr>
		<td style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{$details['business_name'] or ""}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "CLIENT DETAILS"}}</td>
	</tr>
	<tr>
	
		<td style="height: 240px;">&nbsp;</td>
	
		
	</tr>
	<tr>
		<td style="border-top: #00ACD6 solid 30px; position: fixed; bottom:0; ">&nbsp;</td>
	</tr>
</table>
<div class="clearfix"></div>




 
    <div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>BASIC INFORMATION</strong></p>

    
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
    <tr>
			<td width="25%"style="color: #00ACD6; font-size: 15px;">
				<strong>
			Account Detail1
				</strong>
			</td>
			<td width="75%">
			&nbsp;
			</td>
		</tr>
		<tr> 
			<td width="25%">
				<strong>
				Client Type
				</strong>
			</td>
			<td width="75%">
			{{ (isset($details['type']) && $details['type'] == 'org')?$details['business_type']:'Individual' }}
			</td>
		</tr>

       <tr>
               
              
                @if(isset($details['type']) && $details['type'] == "org")
                  <td width="25%"><strong>Website</strong></td>
                  <td width="75%">
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
			<td width="25%">
				
				<strong>Engagement Date</strong>
				
			</td>
			<td width="75%">
			  @if(isset($details['crm_leads_id']) && $details['crm_leads_id'] != "0")
                    {{ date('d-m-Y', strtotime($details['created'])) }}
                  @else
                    
                      @if(isset($acc_details['engagement_date']) && $acc_details['engagement_date'] != "")
                       {{ $acc_details['engagement_date'] }}
                      @else
                       
                      @endif
                     
                     
                  @endif
			</td>
		</tr>
        
	<tr>
			<td width="25%">
				
				<strong>Twitter Username</strong>
				
			</td>
			<td width="75%">
			  @if(isset($acc_details['twitter']) && $acc_details['twitter'] != "")
                    {{ $acc_details['twitter'] }}
                  @else
                  
                  @endif
                 
			</td>
		</tr>
		
         @if(isset($details['type']) && $details['type'] == "org")
             
        	<tr>
			<td width="25%">
				
				<strong>Contact Person</strong>
				
			</td>
			<td width="75%">
            
              
                    @if(isset($contact_persons) && count($contact_persons)>0)
                      @foreach($contact_persons as $key=>$contact_row)
                      {{ $contact_row['contact_name'] or "" }}
                      @endforeach
                    @endif
                   
			</td>
		</tr>
        
        <tr>
			<td width="25%">
				
				<strong>Industry</strong>
				
			</td>
			<td>
                  <select class="form-control newdropdown bottom_margin select_acc_details" id="form_industry" name="form_industry" data-data_type="industry_id" style="width:34.5%; height: 30px;">
                    <option value="0">-- None --</option>
                    @if(isset($industry_lists) && count($industry_lists) >0)
                      @foreach($industry_lists as $key=>$industry_row)
                        <option value="{{ $industry_row['industry_id'] }}" {{ (isset($acc_details['industry_id']) && $acc_details['industry_id'] == $industry_row['industry_id'])?"selected":"" }}>{{ $industry_row['industry_name'] }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
		</tr>
		 @endif
        
        
        <tr>
			<td width="25%">
				
				<strong>Email Address</strong>
				
			</td>
			<td width="75%">
            
              
                      @if(isset($details['type']) && $details['type'] == 'org')
                    {{ $details['corres_cont_email'] or "" }}
                  @else
                    {{ $details['res_email'] or "" }}
                  @endif
                   
			</td>
		</tr>
  
  <tr>
			<td width="25%">
				
				<strong>Lead Source</strong>
				
			</td>
			<td width="75%">
            
              
                       <select class="form-control" id="" name="form_lead_source"  style="">
                  
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
  
             
             
                    
	
          
          
          <tr>
			<td width="25%">
				<strong>
				Fax
				</strong>
			</td>
			<td width="75%">
				@if(isset($acc_details['fax']) && $acc_details['fax'] != "")
                    {{ $acc_details['fax'] or "" }}
                 
                  @endif
			</td>
		</tr>
          
             
             <tr>
			<td width="25%">
				<strong>
				Phone
				</strong>
			</td>
			<td width="75%">
				 @if(isset($details['type']) && $details['type'] == 'org')
                    {{ $details['corres_cont_mobile'] or "" }}
                  @else
                    {{ $details['res_telephone'] or "" }}
                  @endif
			</td>
		</tr>
        
        
             
             @if(isset($details['type']) && $details['type'] == "org")
             
              <tr>
			<td width="25%">
				<strong>
				Description
				</strong>
			</td>
			<td width="75%">
				{{ $details['business_desc'] or "" }}
			</td>
		</tr>
              
            @endif
        
                
		<tr>
			<td width="25%">
				<strong>
				&nbsp;
				</strong>
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
        
        
        
        
        
        
       
                
                 
                 
                  
               
             
	</table>

</div>
      <div class="page-break"></div>
      <div class="footer">{{ "CLIENT DETAILS"}}  <span class="divider">| </span>{{$details['business_name'] or ""}}  <span class="divider">| </span> {{$today or ""}} {{$time or ""}}
</div>  

      
      
      
      
      
      
      
      
      <div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Relation Ship</strong></p>

      
      
      
      
      
      
      
      <table>
      
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
                           {{ $relation_row['name'] or "" }}
                          @endif

                        </td>
                        <td width="40%" align="left">{{ $relation_row['relation_type'] }}</td>
                      
                      </tr>
                    @endforeach
                  @endif

                                
      </table>
      
      </div>
         
      
      <div>
      <div class="page-break"></div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Additional Information and Contact Information</strong></p>

        
      <table>
      
       
       
                <tr>
			<td width="25%">
				<strong>
				VAT NO.
				</strong>
			</td>
			<td width="75%">
		{{ $details['vat_number'] or "" }}
			</td>
		</tr>
        
                <tr>
			<td width="25%">
				<strong>
				Bank Name
				</strong>
			</td>
			<td width="75%">{{ $details['bank_name'] or "" }}
		
			</td>
		</tr>
               
                  <tr>
			<td width="25%">
				<strong>
				Tax Reference
				</strong>
			</td>
			<td width="75%">{{ $details['tax_reference'] or "" }}
		
			</td>
		</tr>
        <tr>
			<td width="25%">
				<strong>
				Sort Code
				</strong>
			</td>
			<td width="75%">{{ $details['bank_short_code'] or "" }}
		
			</td>
		</tr>
        <tr>
			<td width="25%">
				<strong>
				Account Number
				</strong>
			</td>
			<td width="75%">{{ $details['bank_acc_no'] or "" }}
		
			</td>
		</tr>
                   
           
           
           
           
            <table  border="0" cellspacing="0" cellpadding="0" style=" width:100%;">
                    <tr>
                  
                      <td valign="top">
                       <table  border="0" cellspacing="0" cellpadding="0" class="" >
                    <tr>
                      <td class="table_h"><strong>Contact and Address Information&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                     @if($details['crm_contact_type'] == 'none')
                      <td class="table_h">&nbsp;&nbsp;&nbsp;&nbsp;None</td>
                      @endif
                    @if(isset($details['type']) && $details['type'] == "org")
                    @if($details['crm_contact_type'] == 'trad')
                      <td class="table_h">Same as Trading Address &nbsp;</td>
                      @endif
                     @if($details['crm_contact_type'] == 'corres')
                      <td class="table_h">Correspondence Address &nbsp;</td>
                      @endif
                      @if($details['crm_contact_type'] == 'reg')
                      <td class="table_h">Registered Office Address &nbsp;</td>
                      @endif
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
                      <td width="18%" class="table_h"><strong>Billing address</strong></td>
                      <td>
                        <span id="bill_address">
                          @if(isset($details['crm_contact_type']) && ($details['crm_contact_type'] == "" || $details['crm_contact_type'] == 'none'))
                            @if(isset($billing_address) && $billing_address == "")
                             None
                            @else
                            {{ $billing_address or "" }}
                            @endif
                          @else
                            {{ $billing_address or "" }}
                          @endif
                        </span>
                      </td>
                      
                    </tr>
                  </table>
                </td>
                      
                    </tr>
                     <tr>
                      <td>&nbsp;</td>
                    </tr>
                    
                  </table>       
                  
      </table>
      
      </div>
 <div class="page-break"></div>
 

<div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>BILLING & FEES</strong></p>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
    <tr>
			<td width="25%"style="color: #00ACD6; font-size: 15px;">
				<strong>
			Payment Method/Contract Renewal
				</strong>
			</td>
			<td width="75%">
			&nbsp;
			</td>
		</tr>
	
                 <tr>
			<td width="25%">
				<strong>
			Payment Method
				</strong>
			</td>
			<td width="75%">
		
        @if(isset($acc_details['payment_method']) && $acc_details['payment_method']== '0')
                       None
                       @endif
                       
                       @if(isset($acc_details['payment_method'])&& $acc_details['payment_method'] == '1')
                       Direct Debit
                       @endif
                       @if(isset($acc_details['payment_method']) && $acc_details['payment_method']== '2')
                       Invoice
                       @endif
                      @if(isset($acc_details['payment_method']) && $acc_details['payment_method']== '3')
                       Standing Order
                       @endif
                        @if(isset($acc_details['payment_method']) && $acc_details['payment_method']== '4')
                       Other
                       @endif
                       
                     
			</td>
		</tr>
	 <tr>
			<td width="25%">
				<strong>
			Billing Cycle
				</strong>
			</td>
			<td width="75%">
		
 
                       
                      @if(isset( $acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '0')
                       None
                       @endif
                       
                       @if(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '1')
                       Weekly
                       @endif
                       @if(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '2')
                       Monthly
                       @endif
                       @if(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '3')
                       Yearly
                       @endif
                        @if(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '4')
                       Adhoc
                       @endif
                          
                     
			</td>
		</tr>
             <tr>
			<td width="25%">
				<strong>
			Contract Duration
				</strong>
			</td>
			<td width="75%">
		Yearly
                                
            	</td>
		</tr>
             
             <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                        <tr>
                          
                          <td align="left"><strong>Start Date</strong></td>
                          <td align="left"><strong>Renewal Date</strong></td>
                          <td align="center" width="30%"><strong>Amount</strong></td>
                         
                        </tr>

                        <tr>
                         
                          <td align="left">
                            <div id="add_startdate_div" style="display: block;">
                              @if(isset($acc_details['startdate']) && $acc_details['startdate'] != '')
                               {{ $acc_details['startdate'] }}
                              
                              @endif
                            </div>
                           
                          </td>
                          <td align="left"><div id="ren_date_div">{{ (isset($acc_details['startdate']) && $acc_details['startdate'] != "")?date("d-m-Y", strtotime('+365 days', strtotime($acc_details['startdate'])) ):"" }}</div></td>
                          <td align="center">
                            @if(isset($acc_details['billing_amount']) && $acc_details['billing_amount'] != '')
                                {{ $acc_details['billing_amount'] }}
                             
                              @endif
        
                          </td>
                          
                        </tr>

                      @if(isset($rnl_history) && count($rnl_history) >0)
                        @foreach($rnl_history as $row_hist)
                        <tr>
                         
                          <td align="left">{{ $row_hist['start_date'] or "" }}</td>
                          <td align="left">{{ $row_hist['end_date'] or "" }}</td>
                          <td align="center">{{ $row_hist['amount'] or "" }}</td>
                         
                        </tr>
                        @endforeach
                      @endif

                      </table>
           	</table>

</div>
      <div class="page-break"></div>
      <div class="footer">{{ "CLIENT DETAILS"}}  <span class="divider">| </span>{{$details['business_name'] or ""}}  <span class="divider">| </span> {{$today or ""}} {{$time or ""}}
</div>  
 <div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Opportunities</strong></p>

        
             <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                    <tr>
                     
                      <td width="10%"><strong>Date</strong></td>
                      
                      <td width="20%"><strong>Stage</strong></td>
                      <td width="30%"><strong>Contact Name</strong></td>
                      <td width="15%"><strong>Amount</strong></td>
                      <td width="10%"><strong>Close Date</strong></td>
                    </tr>
                    @if(isset($opportunities) && count($opportunities) >0)
                      @foreach($opportunities as $key=>$value)
                      <tr>
                      
                        <td>{{ $value['date'] or "" }}</td>
                       
                        <td>{{ $value['tab_name'] or "" }}</td>
                        <td>
                          @if(isset($value['client_type']) && $value['client_type'] == 'org')
                         {{ $value['contact_title'] or "" }} {{ $value['contact_fname'] or "" }} {{ $value['contact_lname'] or "" }}
                          @else
                         {{ $value['prospect_title'] or "" }} {{ $value['prospect_fname'] or "" }} {{ $value['prospect_lname'] or "" }}
                          @endif
                        </td>
                        <td>${{ $value['quoted_value'] or "" }}</td>
                        <td>{{ (isset($value['close_date']) && $value['close_date'] != "0000-00-00")?date("d-m-Y",strtotime($value['close_date'])):"" }}</td>
                      </tr>
                      @endforeach
                    @endif
                  </table>

</div>
 <div class="page-break"></div>
 <div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Quotes</strong></p>

            <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                        <tr>
                          
                          <td align="left"><strong>Quote Name</strong></td>
                          <td align="left"><strong>Status</strong></td>
                          <td align="right"><strong>Amount</strong></td>
                        </tr>

                        
                      </table> 

</div>
 <div class="page-break"></div>
 <div>
 <p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Services</strong></p>
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
              
</div>
 <div class="page-break"></div>
