@extends('layouts.layout') @section('mycssfile')

@stop
@section('myjsfile') 
<script src="{{ URL :: asset('js/invited_client.js') }}" type="text/javascript"></script>

<script>

$(document).ready(function() {
	$("#deadlinesday").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
			// let it happen, don't do anything
		}else {
			if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
				event.preventDefault();
			}	
		}
	});
});
</script>


@stop
 
  @section('content')
 <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @include('layouts/inner_leftside')

                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')
	
		<!-- Main content -->
		<section class="content">
        
        
			<div class="practice_mid">
				<div class="row icon_section">
					<div class="left_section">
                    
						<ul>
							<li class="hvr-grow" style="margin-right:100px;">
								<a href="/client/edit-ind-client/{{ $client_id or "" }}/{{ base64_encode('client_portal') }}">
								<div class="circle_icons_inner">
								<div class="circle_icon"> <img alt="" src="img/dashboard_circle.png"> </div>
								<p class="c_tagline2">MY DETAILS</p>
								<div class="clearfix"></div>
								</div></a>
							</li>
							<li class="hvr-grow" style="margin-right:100px;">
								<a href="client-portal/files">
								<div class="circle_icons_inner">
								<div class="circle_icon"> <img alt="" src="img/dashboard_circle.png"> </div>
								<p class="c_tagline2">FILE SHARE</p>
								<div class="clearfix"></div>
								</div></a>
							</li>
							<li class="hvr-grow">
								<a href="/tsxreturninfromation/{{$client_id}}/{{ base64_encode('client_portal') }}/1/0">
								<div class="circle_icons_inner">
								<div class="circle_icon"> <img alt="" src="img/dashboard_circle.png"> </div>
								<p class="c_tagline">SUBMIT TAX RETURN<br>
								INFORMATION</p>
								<div class="clearfix"></div>
								</div></a>
							</li>
							<!-- <li class="hvr-grow">
								<a href="javascript:void(0)">
								<div class="circle_icons_inner">
								<div class="circle_icon"> <img alt="" src="img/dashboard_circle.png"> </div>
								<p class="c_tagline">MANAGE<br>
								BILLINGS/RENEWALS</p>
								<div class="clearfix"></div>
								</div></a>
							</li> -->
						</ul>
                        
					</div>
				</div>
				<!--<div class="col-xs-12">
					<div class="col-xs-9" style="padding:0; width:100%; margin-left: 500px">
						<h2>
							DEADLINES
						</h2>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="col-xs-2" style="padding:0;">
						<strong style="font-size: 16px;">
							Deadlines Due in : 60 days 
                            
<a href="#"  data-toggle="modal" data-target="#deadlines-modal"  class="edit_icon"><img alt="" src="img/edit_icon.png"></a> 
                            
                        </strong>
					</div>

					<div class="col-xs-2" style="padding-left:20px; width: 167px;">
						<strong style="font-size: 16px;">
							Share Reminders <a href="#"  data-toggle="modal" data-target="#sharereminders-modal"  class="edit_icon"><img alt="" src="img/edit_icon.png"></a>
						</strong>
					</div>

					<div class="col-xs-2" style="padding:0;">
						<strong style="font-size: 16px; margin-left: 20px;" >
							Stop Reminders <input type="checkbox">
						</strong>
					</div>

					<div class="col-xs-6">
						<div class="next_prev_btn">
							<ul>
								<li>
									<a href="javascript:void(0)">Next</a>
								</li>
								<li>
									|
								</li>
								<li>
									<a href="javascript:void(0)">Previous</a>
								</li>
							</ul>
						</div>
						<div class="clearfix">
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="slide_content">
						<ul>
							<li>
								<p>
									Vat
									<br>
									Period
									<br>
									Amount
									<br>
									Due Date
									<br>
									Payment Ref
									<br>
									How to Play
								</p>
								<a href="javascript:void(0)"><img src="img/cross_icon.png" class="cross_icon" /></a>
							</li>
							<li>
								<p>
									Vat
									<br>
									Period
									<br>
									Amount
									<br>
									Due Date
									<br>
									Payment Ref
									<br>
									How to Play
								</p>
								<a href="javascript:void(0)"><img src="img/cross_icon.png" class="cross_icon" /></a>
							</li>
							<li>
								<p>
									Vat
									<br>
									Period
									<br>
									Amount
									<br>
									Due Date
									<br>
									Payment Ref
									<br>
									How to Play
								</p>
								<a href="javascript:void(0)"><img src="img/cross_icon.png" class="cross_icon" /></a>
							</li>
							<li>
								<p>
									Vat
									<br>
									Period
									<br>
									Amount
									<br>
									Due Date
									<br>
									Payment Ref
									<br>
									How to Play
								</p>
								<a href="javascript:void(0)"><img src="img/cross_icon.png" class="cross_icon" /></a>
							</li>
						</ul>
					</div>
				</div>-->
				<div class="col-xs-12">
					<table width="70%" border="0" class="business_table" align="center">
						<tr>
						<td width="26%">&nbsp;</td>
							<td width="14%"><strong>Select Business</strong></td>
							<td width="34%">
								<select class="form-control" id="getClientDetails">
									<option value="">-- Please Select --</option>
									@if(!empty($relation_list) && count($relation_list) > 0)
							          @foreach($relation_list as $key=>$list)
							            <option value="{{ $list['client_id'] }}">{{ $list['client_name'] }}</option>
									  @endforeach
							        @endif
								</select>
							</td>
							<!-- <td width="3%" align="center">
								<a href="#"><img src="img/edit_icon.png" /></a>
							</td>
							<td width="7%">
								<button class="btn btn-success">
									Save
								</button>
							</td>
							<td width="2%">
								&nbsp;
							</td> -->
							<td width="6%">
								
							</td>
							<td width="20%">
								<!-- <a href="/organisation/add-client" class="btn btn-info">Add New Business</a> -->
								<button type="button" id="view_edit_company" data-type="{{ base64_encode('client_portal') }}" class="btn btn-info">View/Edit Company</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="clearfix">
				</div>
				<!--vat section-->
				<div class="col-xs-12">
					<div class="vat_maincon">
						<div class="vat_section show_client_details">
							<!-- Show details here-->
						</div>
					</div>
				</div>
				<!--end vat section-->
				<div class="clearfix">
				</div>
			</div>
		</section>
		<!-- /.content -->
	</aside>
	<!-- /.right-side -->
</div>

<div>
<div class="modal fade" id="deadlines-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:22%;">
    
    <div class="modal-content">
     
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button" style="float:right; margin-right:8px;">x</button>
      <div class="clr"></div>
      
      <div class="modal-body" style="padding: 13px;">
      
     
      <div class="pp_pan" style="padding: 0 0 10px 0; margin: 0;">
      
            <p style="border-bottom: #ccc solid 1px; padding: 0 0 3px 0; margin: 0; text-align: center;">Remind me of Deadlines Due in:</p>
            <p style="padding-top: 9px; padding-left: 13px;"><strong>Day</strong></p>
            <span><input type="text" id="deadlinesday" style="width: 50px; height: 36px;" name="remind_deadline" /></span>
            <span><input type="button" value="Save"  style="width: 80px; height: 36px;margin-left: 32px;"/></span>
            <span><input type="button" aria-hidden="true" data-dismiss="modal" value="Cancel" style="width: 80px; height: 36px;" /></span>
             
         
          <div class="clr"></div>       
         </div>
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>


<div>
<div class="modal fade" id="sharereminders-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:45%;">
    
    <div class="modal-content">
     
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button" style="float:right; margin-right:8px;">x</button>
        <div class="clr"></div>
      
      
      
      <div class="modal-body" style="padding: 13px;">
      
     
      <div style="padding: 0 0 10px 0; margin: 0;">
          
          <p style="border-bottom: #ccc solid 1px; padding: 0 0 3px 0; margin: 0;"><strong>DEADLINE REMINDERS</strong></p>
          <div class="ded_pan">
         
            <p>Please enter email addresses for deadline reminders</p>
            <input type="text" value="abel02@icloud.com" style="width:100%; margin: 5px 0 5px 0; padding: 6px 0 6px 0px; border: #ccc solid 1px;" />
            <input type="text" value="abel02@icloud.com" style="width:100%; margin: 5px 0 5px 0; padding: 6px 0 6px 0px; border: #ccc solid 1px;" />
            <input type="text" value="abel02@icloud.com" style="width:100%; margin: 5px 0 5px 0; padding: 6px 0 6px 0px; border: #ccc solid 1px;" />
            <input type="text" value="abel02@icloud.com" style="width:100%; margin: 5px 0 0 0; padding: 6px 0 6px 0px; border: #ccc solid 1px;" />
      
          </div>
          <div class="ded_pan_rgt">
          
            <p>Frequency of reminders</p>
            
            <p>
              <span><input type="radio" name="frequencyreminders" /></span>
              <span>Daily</span>
            </p>
            
            <p>
              <span><input type="radio" name="frequencyreminders"  /></span>
              <span>Weekly</span>
            </p>
          
          </div>
          <div class="clr"></div> 
        
           <span><input type="button" value="Submit"  style="width: 100px; padding: 5px 0 5px 0; margin: 20px 5px 0 0;"/></span>
            <span><input type="button" aria-hidden="true" data-dismiss="modal" value="Cancel" style="width: 100px; padding: 5px 0 5px 0; margin: 20px 0 0 0;" /></span>
        
                
         </div>
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>

@stop