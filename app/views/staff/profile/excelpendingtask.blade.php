
  <table>  
    
    <tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                
                <td colspan="3" height="30px" align="center">
                
                 <h1 style="color:blue">{{ "Pending Task-" }}
        
                        @if($tab_no == "1")
                       {{"Due Today"}}</h1>
                      @endif
                      @if($tab_no == "2")
                       {{"Due in 7 Days"}}</h1>
                      @endif
                      @if($tab_no == "3")
                        {{"Due in 30 Days"}}</h1>
                      @endif
                      @if($tab_no == "4")
                        {{"Due in 3 Months"}}</h1>
                      @endif
                      @if($tab_no == "5")
                        {{"Due in 6 Months"}}</h1>
                      @endif
                        @if($tab_no == "6")
                        {{"Due After 6 Months"}}</h1>
                      @endif</td>
                
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
            @if(isset($task_report) && count($task_report) >0)
							@foreach($task_report as $key=>$staff_row)
                @if($staff_row['showin_tab'] == $tab_no)
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
              @endif
            @endforeach
				  @endif
              
              

            </tbody>
      </table>
