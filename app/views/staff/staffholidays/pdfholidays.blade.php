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
					
                        
                    @if($page_open==1)
                    {{"AWATING APPROVAL"}}
                    @endif
                        
                        @if($page_open==2)
                    {{"APPROVED"}}
                    @endif
                    @if($page_open==3)
                    {{"DECLINED"}}
                    @endif
                    @if($page_open==4)
                    {{"ARCHIVE"}}
                    @endif
                    @if($page_open==5)
                    {{"HOLIDAY PLANNER"}}
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


@if($page_open==1)


<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
        
       
        <th align="center" width="15%">Staff Name</th>
        <th align="left">Time Off Type <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
         <th align="center" width="8%">Date</th>
         <th align="left" style="" >Duration</th> 
        <th align="center" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        
      </tr>
    </thead>





    <tbody role="alert" aria-live="polite" aria-relevant="all">
    
    
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
    
                  <tr>
                   
                  
                    <th align="center">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</th>
                   
                    <td align="left">{{$staff['requesttype'] or ""}}</td>
                    <td align="center">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="text" value="{{$staff['state'] or ""}}" >
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                  </tr>
            @endforeach
        @endif
      
    </tbody>

  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
       
        <th align="left">Time Off Type</th>
         <th align="center" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="center" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->state == "Awaiting Approval" || $prof->state == "Request Withdrawn")
                  <tr>
                    
                   
                   
                    <td align="left">{{$prof->requesttype or ""}}</td>
                      <td align="center">{{$prof->date or ""}}</td>
                   <td align="left" style="">{{$prof->duration or ""}}</td> 
                    <td align="center">
                     <input type="text" value="{{$prof->state or ""}}">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                   
                  </tr>
                   @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>

@endif


@if($page_open==2)
<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
      
       
        <th align="center" width="15%">Staff Name</th>
        <th align="left">Time Off Type <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
          <th align="left" width="8%">Date</th>
         <th align="left" style="" >Duration</th> 
        <th align="center" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
       
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
    
                  <tr>
                    
                     
                    <th align="center">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</th>
                    <td align="left">{{$staff['requesttype'] or ""}}</td>
                    <td align="center">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="text" value="{{$staff['state'] or ""}}{{"!"}}">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                   
                   
                   
                    
                  </tr>
            @endforeach
        @endif
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
        
        <th align="left">Time Off Type</th>
        <th align="center" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="center" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
      
      </tr>
    </thead>

   <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->state == "Approved" && $prof->archive == "unarchive")
                  <tr>
                    
                    
                   
                    <td align="left">{{$prof->requesttype or ""}}</td>
                     <td align="center">{{$prof->date or ""}}</td>
                   <td align="left" style="">{{$prof->duration or ""}}</td> 
                    <td align="center">
                     <input type="text" value="{{$prof->state or ""}}{{"!"}}" >
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                   
                  </tr>
                  @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>

@endif

@if($page_open==3)
<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
       
        <th align="left" width="15%">Staff Name</th>
        <th align="left">Time Off Type <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
        <th align="center" width="8%">Date</th>
         <th align="center" style="" >Duration</th> 
        <th align="left" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
             @if( $staff['archive'] == "unarchive")
                  <tr>
                    
                    <th align="center">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</th>
                    <td align="left">{{$staff['requesttype'] or ""}}</td>
                    <td align="left">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="button" value="{{$staff['state'] or ""}}" class="declined_btn">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                   
                   
                  </tr>
                  @endif
            @endforeach
        @endif
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
       
        <th align="left">Time Off Type</th>
         <th align="left" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="left" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="left" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="left">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->state == "Declined" &&  $prof->archive == "unarchive")
                  <tr>
                   
                    <td align="left">{{$prof->requesttype or ""}}</td>
                     <td align="left">{{$prof->date or ""}}</td>
                   <td align="left" style="">{{$prof->duration or ""}}</td> 
                    <td align="left">
                     <input type="text" value="{{$prof->state or ""}}">
                    </td>
                 
                   
                    
                  </tr>
                  @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>

@endif



@if($page_open==4)
<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
            @if($staff_type == "staff")
    <thead>
      <tr role="row">
      
        
        <th align="left" width="15%">Staff Name</th>
        <th align="left">Time Off Type <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
        <th align="center" width="8%">Date</th>
         <th align="center" style="" >Duration</th> 
        <th align="left" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
       
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
             
             @if($staff['archive'] == "archive")
             
                  <tr>
                   
                    <th align="center">
                    
                    {{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}
                    
                    <!--
                    <a href="/my-details/{{ $staff['staff_detail']['user_id'] }}/{{ base64_encode('staff') }}">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</a> -->
                    
                    
                    
                    </th>
                    <td align="left">{{$staff['requesttype'] or ""}}</td>
                    <td align="left">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="text" value="{{$staff['state'] or ""}}">
                     
                     
                      
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                   
                  </tr>
                  @endif
            @endforeach
        @endif
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
       
        <th align="left">Time Off Type</th>
         <th align="left" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="left" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
       
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->archive == "archive")
                  <tr>
                <td align="left">{{$prof->requesttype or ""}}</td>
                <td align="left">{{$prof->date or ""}}</td>
                <td align="left" style="">{{$prof->duration or ""}}</td> 
                <td align="left">
                    <input type="text" value="{{$prof->state or ""}}">
                      
                     
                </td>
                <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
               
                  </tr>
                  @endif
            @endforeach
        @endif
     

    </tbody>
  @endif         
</table>

@endif