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

@if($page_open == 1)
 <div >
    @include('jobs/pdfincludes/first_tab')
  </div>
@endif


@if($page_open != 1 && $page_open != 3)
  <div class="tab-content">
    @include('jobs/pdfincludes/second_tab')
  </div>

@endif

@if($page_open == 3)
 <div >
    @include('jobs/pdfincludes/third_tab')
  </div>
  @endif