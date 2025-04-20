<table class="table table-bordered table-hover dataTable " id="example3" width="100%">
    <thead>
      <tr>
        <th width="3%"><input type="checkbox" class="CheckallCheckbox"></th>
        <th><strong>Staff Name</strong></th>
        <th align="left" width="10%"><strong></strong></th>
      </tr>
    </thead>
  <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    @if(isset($details['users']) && count($details['users']) >0)
      @foreach($details['users'] as $key=>$client_row)
        <tr>
          <td><input type="checkbox" class="CheckallCheckbox"></td>
          <td>{{ $client_row['fname'] or '' }} {{ $client_row['lname'] or '' }}</td>
          <td width="6%">
              <select class="form-control newdropdown">
                  <option value="off">OFF</option>
                  <option value="on">ON</option>
              </select>
          </td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>