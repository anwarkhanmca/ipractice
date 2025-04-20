<div class="col-4">

        <h1 style="color:blue">{{ "Closed Task"  }}</h1>
        <h5>Date:	{{$cdate or ""}}</h5>
<h5>Time:		{{$ctime or ""}}</h5>
    </div>
    
<table border="1" >
      <input type="hidden" id="client_type" value="org"> 
        <thead>
            <tr role="row">
             
              <!--  <td width="5%"> Action</td> -->
                                     
                    <th >Task Date</th>
                    <th>Task Name</th>
                    <th >Client Name</th>
                    <th >Staff Name</th>
                   
                    
                    
                                      
            </tr>
        </thead>
 <tbody role="alert">
            @if(isset($closetask_report) && count($closetask_report) >0)
							@foreach($closetask_report as $key=>$staff_row)
                
                <tr>
                  
                
                  <td align="left"> {{$staff_row['taskdate'] or ""}} {{$staff_row['task_time'] or ""}}
                    
                </td>
                
                <td align="left" >
                @if($staff_row['urgent'] == "Yes")
                <a href="#" style="color: #FA5858;" class="tasknamed" data-taskid="{{ $staff_row['todolistnewtasks_id'] or "" }}">{{ $staff_row['taskname'] or "" }}</a>
                @else
                  @if(isset($staff_row['task_type']) && $staff_row['task_type'] == 'todo')
                 {{ $staff_row['taskname'] or "" }}
                  @else
                    {{ $staff_row['taskname'] or "" }}
                  @endif
                @endif
                </td> 
                
                <td ><a href="#">{{ $staff_row['client_name'] or "" }}</a></td>
                <td >{{ $staff_row['staff_name'] or "" }}</td>
                
              
               
              
              
              </tr>
              
            @endforeach
				  @endif
              
              

            </tbody>
      </table>
