<table>  
    
    <tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                
                <td colspan="3" height="30px" align="center">
                
                 <h1 style="color:blue">	{{ "Individual Clients List Allocation" }}</h1>
                     </td>
                
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
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      
      <thead>
        <tr role="row">
          
          <th width="10%">Type</th>
          <th width="20%">BUSINESS NAME</th>
          
          <th width="15%">STAFF NAME</th>
          <th width="15%">STAFF NAME</th>
          <th width="15%">STAFF NAME</th>
          <th width="15%">STAFF NAME</th>
          <th width="15%">STAFF NAME</th>
        </tr>
      </thead>

     
        @if(isset($ind_client_details) && count($ind_client_details) >0)
          @foreach($ind_client_details as $key=>$details)
            
              <tr class="even" id="client_{{ $details['client_id'] }}">
               
           
                <td align="left">{{ $details['client_name'] or "" }}</td>
                <td><span class="custom_chk"><input type='checkbox' class="checkbox applicable_Checkbox" name="applicable_checkbox[]" value="{{ $details['client_id'] or "" }}" id="applicable_checkbox{{ $details['client_id'] }}" {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?"checked":"" }} />
                <!--
                <label for="applicable_checkbox{{ $details['client_id'] }}"></label>
                -->
                </span></td>
                @for($i=1; $i <=5; $i++)
                <td align="left">
                  <select class="form-control save_manual_user" data-client_id="{{ $details['client_id'] }}" data-column="{{ $i }}" name="ind_staff_id{{ $i }}" id="{{ $details['client_id'] }}_ind_staff_id{{ $i }}" {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?"":"disabled" }} >
                    <option value="">None</option>
                    @if(!empty($staff_details))
                      @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ $staff_row->user_id }}" {{ (isset( $details['allocation'][$service_id]['staff_id'.$i] ) && ($details['allocation'][$service_id]['staff_id'.$i] == $staff_row->user_id) && isset( $details['allocation'][$service_id]['service_id'] ) && ($details['allocation'][$service_id]['service_id'] == $service_id))?"selected":""}} >{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
                @endfor
              </tr>
            
          @endforeach
        @endif
     
    </table>
    
    