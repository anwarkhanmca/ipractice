<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="27%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="26%">
									<strong>
										Date :
									</strong>
								</td>
								<td width="74%">
									{{$cdate or ""}}
								</td>
							</tr>
							<tr>
								<td>
									<strong>
										Time :
									</strong>
								</td>
								<td>
									{{$ctime or ""}}
								</td>
							</tr>
						</table>
					</td>
					<td width="38%" style="font-size:20px; text-align:center; font-weight:bold; text-decoration:underline;">
					
                    	{{ "Closed Task" }}
                      
                        
					</td>
					<td width="35%">
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
	</tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <input type="hidden" id="client_type" value="org"> 
        <thead>
            <tr role="row">
             
              <!--  <td width="5%"> Action</td> -->
                                     
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                   
                    
                    
                                      
            </tr>
        </thead>
 <tbody role="alert" aria-live="polite" aria-relevant="all">
              
              @if(!empty($closetask_report))
								  @foreach($closetask_report as $key=>$staff_row)
              
              <tr>
             
             
                <td align="left">
                
                {{ $staff_row['taskdate'] or ""  }} &nbsp;{{ $staff_row['task_time'] or "" }}
                
                
                </td>
                <td align="left">
                <a href="#" id="tasknamed" data-taskid= "{{ $staff_row['todolistnewtasks_id'] }}">{{ $staff_row['taskname'] or "" }}</a>
                </td> 
                <td align="left"><a href="#">{{ $staff_row['client_detail']['field_value'] or "" }}</a></td>
                <td align="left">{{ $staff_row['staff_detail']['fname'] }} {{ $staff_row['staff_detail']['lname'] }}</td>
                
                 
              </tr>
              
              	@endforeach
					@endif
              
              

            </tbody>
      </table>
