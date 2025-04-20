<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
        
<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                
                <td colspan="3" height="30px" align="center"><p style="font-size: 18; text-decoration:underline; font-weight:bold;">
                
                 @if($page_open == 1)
                        ANNUAL RETURNS - CLIENT DETAILS
                    @endif
                    @if($page_open != 1 && $page_open != 3)
                        ANNUAL RETURNS - TASK MANAGEMENT
                        
                        @if($page_open == 21)
                        (All)
                        @endif
                        
                        @if($page_open == 22)
                        (Not Started)
                        @endif
                        
                        @if($page_open == 23)
                        (Information Requested)
                        @endif
                        
                        @if($page_open == 24)
                        (Information Received)
                        @endif
                        
                        @if($page_open == 25)
                        (In- progress)
                        @endif
                        
                        @if($page_open == 26)
                        (Drafted)
                        @endif
                        
                        @if($page_open == 27)
                        (Firm Review)
                        @endif
                        
                        @if($page_open == 28)
                        (Client Review)
                        @endif
                        
                        @if($page_open == 29)
                        (Finals Sent)
                        @endif
                        
                        
                    @endif
                   
                    @if($page_open == 3)
                        COMPLETED TASKS
                    @endif
                 </p></td>
                
                <td>&nbsp;</td>
</tr>

<tr>

                <td><h5>Time:		{{$ctime or ""}}</h5></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
<tr>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
</table>
@if($page_open == 1)
<div>
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <thead>
        <tr role="row">
          <th width="8%">D0I</th>
          <th>CRN</th>
          <th width="15%">BUSINESS NAME</th>
          <th>YEAR END</th>
          <th>AUTHEN CODE</th>
          <th>LAST RETURN DATE</th>
          <th>NEXT RETURN DUE ON</th>
          <th>COUNT DOWN</th>
        </tr>
      </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          <tr class="even">
            <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="center">{{ $details['registration_number'] or "" }}</td>
            <td align="left">{{ $details['business_name'] or "" }}</td>
            <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
            <td align="center">{{ $details['ch_auth_code'] or "" }}</td>
            <td align="center">{{ isset($details['made_up_date'])?date("d-m-Y", strtotime($details['made_up_date'])):"" }}</td>
            <td align="center">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
            <td align="center">
              @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
                <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
              @else
                 {{ $details['deadret_count'] or "" }}
              @endif
            </td>
            
            
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>

  </div>
@endif
@if($page_open != 1 && $page_open != 3)
<div>
    
  <div class="tab-content">
@if($page_open == 21 )
  <div>
    
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <thead>
        <tr role="row">
         
          <th width="10%">DOI</th>
          <th width="20%">BUSINESS NAME</th>
          <th width="10%">AUTHEN CODE</th>
          <th width="10%">NEXT RETURN DUE ON</th>
          <th width="10%">DAYS</th>
          <th width="12%">JOB START DATE </th>
          
          
          
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
          
            <tr id="data_tr_{{ $details['client_id'] }}_21">
              
              <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
              <!-- <td align="left">{{ $details['business_type'] or "" }}</td> -->
              <td align="left">{{ $details['business_name'] or "" }}</td>
              <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
              <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
              <td align="left">
                @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
                  <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
                @else
                   {{ $details['deadret_count'] or "" }}
                @endif
              </td>
              <td align="center">
                {{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}
                
              </td> 
             
              
              
            </tr>
          @endif 
        @endforeach
      @endif
        
      </tbody>
    </table>
    </div>
        @endif 
        @if($page_open == 22 ) 
    <div>
       <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
       <thead>
        <tr role="row">
          
          <th width="8%">DOI</th>
          <th width="20%">BUSINESS NAME</th>
          <th width="10%">AUTHEN CODE</th>
          <th width="10%">NEXT RETURN DUE ON</th>
          <th width="10%">COUNT DOWN</th>
          
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
            @if(!isset($details['job_status'][$service_id]['status_id']))
            <tr id="data_tr_{{ $details['client_id'] }}_22">
              
              <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
              <!-- <td align="left">{{ $details['business_type'] or "" }}</td> -->
              <td align="left">{{ $details['business_name'] or "" }}</td>
              <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
              <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
              <td align="left">
                @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
                  <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
                @else
                   {{ $details['deadret_count'] or "" }}
                @endif
              </td>
              
             
              
              
            </tr>
            @endif
          @endif 
        @endforeach
      @endif
        
      </tbody>
    </table>  
    </div>
     @endif
    @for($k=3; $k <= 9;$k++) 
    @if($page_open == '2'.$k)                         
    <div>
       <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
        <thead>
        <tr role="row">
          
          <th width="10%">DOI</th>
          <th width="20%">BUSINESS NAME</th>
          <th width="10%">AUTHEN CODE</th>
          <th width="10%">NEXT RETURN DUE ON</th>
          <th width="10%">COUNT DOWN</th>
          
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
              @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $k)
              <tr id="data_tr_{{ $details['client_id'] }}_2{{ $k }}">
                
                <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
                <td align="left">{{ $details['business_name'] or "" }}</td>
                <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
                <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
                <td align="left">
                  @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
                    <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
                  @else
                     {{ $details['deadret_count'] or "" }}
                  @endif
                </td>
                  
              </tr>
              @endif
            @endif
        @endforeach
      @endif
        
      </tbody>
    </table> 
    </div>
    @endif
    @endfor   
    @if($page_open == '210')
    <div>
      <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <thead>
        <tr role="row">
          
          <th width="10%">DOI</th>
          <th width="20%">BUSINESS NAME</th>
          <th width="10%">AUTHEN CODE</th>
          <th width="10%">NEXT RETURN DUE ON</th>
          <th width="10%">COUNT DOWN</th>
         
          
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
            @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == 10)
            <tr id="data_tr_{{ $details['client_id'] }}_210">
              <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
              <td align="left">{{ $details['business_name'] or "" }}</td>
              <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
              <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
              <td align="left">
                @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
                  <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
                @else
                   {{ $details['deadret_count'] or "" }}
                @endif
              </td>
                
            </tr>
            @endif
          @endif
        @endforeach
      @endif   
      </tbody>
    </table>
    </div>
   @endif
  </div>
  </div>
@endif

@if($page_open == '3')
<div>
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <thead>
        <tr role="row">
          <th width="10%">CRN</th>
          <th width="20%">BUSINESS NAME</th>
          <th width="15%">LAST RETURN DATE</th>
          <th width="10%">FILING DATE</th>
        </tr>
      </thead>      
        <tbody role="alert" aria-live="polite" aria-relevant="all">
        <?php $i = 1;?>
        @if(isset($completed_task) && count($completed_task) >0)
          @foreach($completed_task as $key=>$details)
            <tr id="data_tr_{{ $details['completed_tasks']['task_id'] }}">
              <td align="left">{{ $details['registration_number'] or "" }}</td>
              <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}">{{ $details['business_name'] or "" }}</a></td>
              <td align="center">
                {{ isset($details['completed_tasks']['last_return_date'])?$details['completed_tasks']['last_return_date']:"" }}
              </td>
              <td align="center" width="12%">
                {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
              </td>
            </tr>
            <?php $i++;?>
          @endforeach
        @endif
      </tbody>  
    </table>
  </div>
  @endif