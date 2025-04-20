<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
        
<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                
                <td colspan="3" height="30px" align="center"><p style="font-size: 18; text-decoration:underline; font-weight:bold;">
                
                 @if($page_open == 1)
                        @if($service_id == 2)
                            {{"ECSL- CLIENT DETAILS"}}
                        @endif
                        @if($service_id == 3)
                            {{"STATUTORY ACCOUNTS - CLIENT DETAILS"}}
                        @endif
                        @if($service_id == 4)
                            {{"BOOKKEEPING - CLIENT DETAILS"}}
                        @endif
                         @if($service_id == 5)
                            {{"CORPORATION - CLIENT DETAILS"}}
                        @endif
                         @if($service_id == 7)
                        {{"INCOME TAX RETURNS - CLIENT DETAILS"}}
                        @endif
                    @endif
                    
                    @if($page_open != 1 && $page_open != 3)
                        @if($service_id == 2)
                            {{"ECSL- TASK MANAGEMENT"}}
                        @endif
                        @if($service_id == 3)
                        {{"STATUTORY ACCOUNTS - TASK MANAGEMENT"}}
                        @endif
                        @if($service_id == 4)
                        {{"BOOKKEEPING - TASK MANAGEMENT"}}
                        @endif
                        @if($service_id == 5)
                        {{"CORPORATION - TASK MANAGEMENT"}}
                        @endif
                        @if($service_id == 7)
                        {{"INCOME TAX RETURNS - TASK MANAGEMENT"}}
                        @endif
                    @endif
                        
                        @if($page_open == 21)
                        (All)
                        @endif
                        
                        @if($page_open == 22)
                        (Not Started)
                        @endif
                        
                        @if($page_open == 23)
                        (Information Requested)
                        @endif
                        
                        @if($page_open == 24)
                        (Information Received)
                        @endif
                        
                        @if($page_open == 25)
                        (In- progress)
                        @endif
                        
                        @if($page_open == 26)
                        (Drafted)
                        @endif
                        
                        @if($page_open == 27)
                        (Firm Review)
                        @endif
                        
                        @if($page_open == 28)
                        (Client Review)
                        @endif
                        
                        @if($page_open == 29)
                        (Finals Sent)
                        @endif
                        
                        @if($page_open == 3)
                        COMPLETED TASKS
                        @endif
                    
                 </p></td>
                
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


@if($page_open == 1)

    @include('jobs/excelincludes/first_tab')

@endif



@if($page_open != 1 && $page_open != 3)
 
    @include('jobs/excelincludes/second_tab')


@endif

@if($page_open == 3)

    @include('jobs/excelincludes/third_tab')
  
  @endif
</table>