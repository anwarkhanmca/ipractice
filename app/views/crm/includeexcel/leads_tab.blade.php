<table >
        
<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                <td>&nbsp;</td>
                <td colspan="2" height="30px" align="center">
                
                	{{ "CRM-LEADS" }}
                        
                
                
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
            
@if($page_open == '51')

 
  <table>
    <thead>
      <tr role="row">
        
        <th width="10%">Date</th>
        <th width="15%">Deal Owner</th>
        <th width="15%">Prospect Name</th>
        <th width="15%">Contact Name</th>
        <th width="15">Phone</th>
        <th width="15%">Lead Source</th>
        <th width="15%">Lead Status</th> 
        
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($leads['leads_details']) && count($leads['leads_details']) >0)
        @foreach($leads['leads_details'] as $key=>$leads_row)
          <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
            
            <td align="left">{{ $leads_row['date'] or "" }}</td>
            <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
            <td align="left">
              @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
              {{ $leads_row['prospect_name'] or "" }}
              @else
                {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
              @endif
            </td>
            <td align="left">
              @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
              {{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}
              @endif
              
            </td>
            <td align="center">{{ $leads_row['phone'] or "" }}</td>
           
            
            <td align="center">{{ $leads_row['source_name'] or "" }}</td>
            <td align="center">
              <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                @if(isset($leads_tabs) && count($leads_tabs) >0)
                  @foreach($leads_tabs as $key=>$tab_row)
                    @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
                      <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                      @endif
                  @endforeach
                @endif
              </select>
            </td>
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>

@endif
@if($page_open == '511')
<table  border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;" id="">
      <thead>
        <tr role="row">
          
          <th width="7%">Date</th>
          <th width="12%">Deal Owner</th>
          <th width="12%">Prospect Name</th>
          <th>Contact Name</th>
          <th width="5%">Phone</th>
          
          <th width="8%">Lead Source</th>
          <th width="9%">Lead Status </th>
         
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($leads['leads_details']) && count($leads['leads_details']) >0)
          @foreach($leads['leads_details'] as $key=>$leads_row)
            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == 511)
            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
             
              <td align="left">{{ $leads_row['date'] or "" }}</td>
              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
              <td align="left">
                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                  {{ $leads_row['prospect_name'] or "" }}
                @else
                {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
                @endif
              </td>
              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
              <td align="center">{{ $leads_row['phone'] or "" }}</td>
             
              
              <td align="center">{{ $leads_row['source_name'] or "" }}</td>
              <td align="center">
                <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                  @if(isset($leads_tabs) && count($leads_tabs) >0)
                    @foreach($leads_tabs as $key=>$tab_row)
                      @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
                        <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                        @endif
                    @endforeach
                  @endif
                </select>
              </td>
             
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
@endif
@if($page_open == '512')
<table  border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;" id="">
      <thead>
        <tr role="row">
          
          <th width="7%">Date</th>
          <th width="12%">Deal Owner</th>
          <th width="12%">Prospect Name</th>
          <th>Contact Name</th>
          <th width="5%">Phone</th>
          
          <th width="8%">Lead Source</th>
          <th width="9%">Lead Status </th>
         
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($leads['leads_details']) && count($leads['leads_details']) >0)
          @foreach($leads['leads_details'] as $key=>$leads_row)
            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == 512)
            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
             
              <td align="left">{{ $leads_row['date'] or "" }}</td>
              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
              <td align="left">
                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                 {{ $leads_row['prospect_name'] or "" }}
                @else
               {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
                @endif
              </td>
              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
              <td align="center">{{ $leads_row['phone'] or "" }}</td>
             
              
              <td align="center">{{ $leads_row['source_name'] or "" }}</td>
              <td align="center">
                <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                  @if(isset($leads_tabs) && count($leads_tabs) >0)
                    @foreach($leads_tabs as $key=>$tab_row)
                      @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
                        <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                        @endif
                    @endforeach
                  @endif
                </select>
              </td>
             
              
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
@endif
@if($page_open == '513')
<table  border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;" id="">
      <thead>
        <tr role="row">
          
          <th width="7%">Date</th>
          <th width="12%">Deal Owner</th>
          <th width="12%">Prospect Name</th>
          <th>Contact Name</th>
          <th width="5%">Phone</th>
          
          <th width="8%">Lead Source</th>
          <th width="9%">Lead Status </th>
         
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($leads['leads_details']) && count($leads['leads_details']) >0)
          @foreach($leads['leads_details'] as $key=>$leads_row)
            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == 513)
            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
             
              <td align="left">{{ $leads_row['date'] or "" }}</td>
              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
              <td align="left">
                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                  {{ $leads_row['prospect_name'] or "" }}
                @else
                  {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
                @endif
              </td>
              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
              <td align="center">{{ $leads_row['phone'] or "" }}</td>
             
              
              <td align="center">{{ $leads_row['source_name'] or "" }}</td>
              <td align="center">
                <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                  @if(isset($leads_tabs) && count($leads_tabs) >0)
                    @foreach($leads_tabs as $key=>$tab_row)
                      @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
                        <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                        @endif
                    @endforeach
                  @endif
                </select>
              </td>
             
              
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
@endif

