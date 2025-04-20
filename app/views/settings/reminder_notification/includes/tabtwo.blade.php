<div class="col_m2">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
      <li class="{{ ($page_open == 21)?'active':'' }}"><a href="{{ $goto_url }}/21">CLIENT</a></li>
      <li class="{{ ($page_open == 22)?'active':'' }}"><a href="{{ $goto_url }}/22">STAFF</a></li>
    </ul>
    <div class="tab-content">
      <div id="tab_21" class="tab-pane {{ ($page_open == '21')?'active':'' }}">
        <table class="table table-bordered table-hover dataTable " id="example21" width="100%">
            <thead>
              <tr>
                <th width="3%"><input type="checkbox" class="CheckallCheckbox"></th>
                <th><strong>Section</strong></th>
                <th align="left" colspan="2" width="25%"><strong>Email Template</strong></th>
              </tr>
            </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($details['services']) && count($details['services']) >0)
              @foreach($details['services'] as $key=>$client_row)
                <tr>
                  <td><input type="checkbox" class="CheckallCheckbox"></td>
                  <td>{{ $client_row['service_name'] or '' }}</td>
                  <td width="6%">
                      <select class="form-control newdropdown">
                          <option value="off">OFF</option>
                          <option value="on">ON</option>
                      </select>
                  </td>
                  <td><a href="javascript:void(0)">Edit Email Template</a></td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
        
      <div id="tab_22" class="tab-pane {{ ($page_open == 22)?'active':'' }}">
        <table class="table table-bordered table-hover dataTable " id="example22" width="100%">
            <thead>
              <tr>
                <th width="3%"><input type="checkbox" class="CheckallCheckbox"></th>
                <th><strong>Tasks</strong></th>
                <th align="left" colspan="2" width="25%"><strong>Staff Name</strong></th>
              </tr>
            </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
              
            @if(isset($details['services']) && count($details['services']) >0)
              @foreach($details['services'] as $key=>$client_row)
                <tr>
                  <td><input type="checkbox" class="CheckallCheckbox"></td>
                  <td>{{ $client_row['service_name'] or '' }}</td>
                  <td width="10%">
                      <select class="form-control newdropdown">
                          <option value="off">OFF</option>
                          <option value="on">ON</option>
                      </select>
                  </td>
                  <td>
                      <select class="form-control newdropdown" data-service_id="{{ $client_row['service_id'] or '' }}">
                          <option value="on">-- Select --</option>
                          @if(isset($details['users']) && count($details['users']) >0)
                            @foreach($details['users'] as $key=>$client_row)
                              <option value="{{ $client_row['user_id'] or '' }}">{{ $client_row['fname'] or '' }} {{ $client_row['lname'] or '' }}</option>
                            @endforeach
                          @endif
                      </select>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
      
      <!-- /.tab-pane -->
    </div>
  </div>
  <!--end sub tab-->
</div>
