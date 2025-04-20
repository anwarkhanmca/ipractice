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
					
                        
                    
                    	{{ "Booked Courses " }}
                    
                        
                        
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
                                      <td width="15%" align="left"><strong>Courses Date</strong></td>
                                      <td width="15%" align="left"><strong>Duration</strong></td>
                                      <td width="16%" align="left"><strong>Courses Name</strong></td>
                                      <td width="16%" align="left"><strong>Attendees</strong></td>
                                    <!--  <td width="5%" align="center"><strong>Attachments</strong></td> -->
                                      
            </tr>
        </thead>
 <tbody> 
                                              
                                                   
                        @if(!empty($course_report))
						  @foreach($course_report as $key=>$staff_row)
                                   
                                   
                                    <tr>
                                     <!-- <td><a href="javascript:void(0)" id="delcourses" class="" data-id="{{ $staff_row['cpd_id'] or "" }}" ><img src="/img/cross.png"></a></td> -->
                                      <td align="left"><!--<input type="text" placeholder="dd/mm/yy">
                                        AM - HALF DAY</td> -->
                                        
                                    <div id="edit_calender_" class="edit_cal">
                      
                     &nbsp; {{ $staff_row['created'] or ""}}
                      
                      
                      <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="" data-tab=""></span>
                      
                </div>
                                  
                                        <td align="left"> {{ $staff_row['course_duration'] or ""}}</td>
                                          
                                        
                                      <td align="left"><!--<a href="#" id="coursename" data-courseid= "{{ $staff_row['cpd_id'] }}">{{ $staff_row['course_name'] or ""}}</a>-->&nbsp; {{ $staff_row['course_name'] or ""}}</td>
                                      <td align="left">
                                     &nbsp; {{ $staff_row['user_name']['fname'] or " "}}  {{ $staff_row['user_name']['lname'] }}
                   
                                      
                                         
                                      </td>
                                      
                                   <!--                                
                <td align="left">
              
              
                        
                        @if ( (isset($staff_row['add_file'])) && (!empty($staff_row['add_file'])) )
                        <img src="/img/attachment.png" width="15">
                        @endif
                 </td> -->
                          </tr>
                                    
                                  
                                  @endforeach  
                                       @endif
                                  </tbody>
      </table>