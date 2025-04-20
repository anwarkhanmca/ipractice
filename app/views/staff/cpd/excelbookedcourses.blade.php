<div class="col-4">

        <h1 style="color:blue">{{ "CPD BookedCourses" }}</h1>
        <h5>Date:	{{$cdate or ""}}</h5>
<h5>Time:		{{$ctime or ""}}</h5>
    </div>
    
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <input type="hidden" id="client_type" value="org"> 
        <thead>
            <tr role="row">
             
              <!--  <td width="5%"> Action</td> -->
                                      <th><strong>Courses Date</strong></th>
                                      <th><strong>Duration</strong></th>
                                      <th><strong>Courses Name</strong></th>
                                      <th><strong>Attendees</strong></th>
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