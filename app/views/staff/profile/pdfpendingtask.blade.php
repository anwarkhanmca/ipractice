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
					
                    	{{ "Pending Task-" }}
                        @if($tab_no == "1")
                        {{"Due Today"}}
                      @endif
                      @if($tab_no == "2")
                        {{"Due in 7 Days"}}
                      @endif
                      @if($tab_no == "3")
                        {{"Due in 30 Days"}}
                      @endif
                      @if($tab_no == "4")
                        {{"Due in 3 Months"}}
                      @endif
                      @if($tab_no == "5")
                        {{"Due in 6 Months"}}
                      @endif
                        @if($tab_no == "6")
                        {{"Due After 6 Months"}}
                      @endif
                      
                        
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



@if ($page_open != 2)
      <div id="" class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                
                  <tr role="row">
                   
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left" width="10%">Status</td>
                    
                  </tr>
                

            
            @if(isset($task_report) && count($task_report) >0)
							@foreach($task_report as $key=>$staff_row)
                            
                @if($staff_row['showin_tab'] == $tab_no)
                
                
                <tr style="background-color: ;">
                 
                
                  <td align="left">
                    {{ (isset($staff_row['taskdate']) && $staff_row['taskdate'] != "")?date("d-m-Y", strtotime($staff_row['taskdate']) ):"" }} {{ (isset($staff_row['task_time']) && $staff_row['task_time'] != "")?date('H:i', strtotime($staff_row['task_time'])):"00:00" }}
                </td>
                
                <td align="left" >
                @if($staff_row['urgent'] == "Yes")
               {{ $staff_row['taskname'] or "" }}
                @else
                  @if(isset($staff_row['task_type']) && $staff_row['task_type'] == 'todo')
                  {{ $staff_row['taskname'] or "" }}
                  @else
                    {{ $staff_row['taskname'] or "" }}
                  @endif
                @endif
                </td> 
                
                <td align="left"><a href="#">{{ $staff_row['client_name'] or "" }}</a></td>
                <td align="left">{{ $staff_row['staff_name'] or "" }}</td>
                
                
                <td align="left">
                  @if(isset($staff_row['task_type']) && $staff_row['task_type'] == 'todo')
                
                @if(isset($staff_row['status']) && $staff_row['status'] == "not_started")
                Not Started
                @endif
                @if(isset($staff_row['status']) && $staff_row['status'] == "in_progress")
                In Progress
                @endif
                @if(isset($staff_row['status']) && $staff_row['status'] == "done")
               Done
                @endif
                @if(isset($staff_row['status']) && $staff_row['status'] == "close")
                Close
                @endif
                  @else
                    {{ $staff_row['status'] }}
                  @endif
                </td>
                
               
              
              </tr>
              @endif
            @endforeach
				  @endif
              
              

            
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                  
                @endif