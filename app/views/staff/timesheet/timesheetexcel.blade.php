<div class="col-4">
        <h1 style="color:blue">{{ $title or "" }}</h1>
    </div>
<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">          
  <thead>
    <tr role="row">
    <!-- <th align="center"><input type="checkbox" id="allCheckSelect"/></th> -->
      <th align="center"><strong>Date</strong></th>
      <th align="center"><strong>Staff Name</strong></th>
      <th><strong>Client Name</strong></th>
      <th align="left"><strong>Service</strong></th>
      <th><strong>HRS</strong></th>
    </tr>
  </thead>

  <tbody role="alert" aria-live="polite" aria-relevant="all">
							
							@if(!empty($time_sheet_report))
								  @foreach($time_sheet_report as $key=>$staff_row)
								 <tr>
								<!--	<td align="center"><input type="checkbox" /></td> -->
									<td align="center">{{ $staff_row['created_date'] }}</td>
									<td align="center">{{ $staff_row['staff_detail']['fname'] }} {{ $staff_row['staff_detail']['lname'] }}</td>
									<td  align="left">{{ $staff_row['client_detail']['field_value'] }}</td>
									<td align="left">{{ $staff_row['old_vat_scheme']['vat_scheme_name'] }}</td>
									<td align="center">{{ number_format($staff_row['hrs'], 2, '.', '') }}</td>
									
								</tr>
									@endforeach
								@endif
                                  
                              
                            </tbody>
                          </table>