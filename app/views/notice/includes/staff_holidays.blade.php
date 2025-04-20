<div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="notice_board">
            <div class="notice_board_topcon">
              <div class="notice_top_left"></div>
              <div class="notice_top_mid"></div>
              <div class="notice_top_right"></div>
              <div class="clearfix"></div>
            </div>

                        
<div class="notice_midbg"> 
<span class="board_title"> </span>
<div class="col-xs-12 holidays_border" >
<!--start calendar section -->
<div class="calendar_sec">





 
          

                <div class="col-xs-12 event_box">
                    <table width="100%">
                        <tr>
                            <td width="8%">
                                <strong>Search Events</strong>
                            </td>
                            <td width="10%" align="center">
                                <select class="form-control newdropdown" id="search_staff_id">
                                    <option value="">-- Select Staff --</option>
                                    @if(!empty($staff_details))
                                        @foreach($staff_details as $key=>$staff_row)
                                            <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td width="3%">&nbsp;</td>
                            <td width="10%">
                                <input type="text" class="newdropdown" name="holiday_start" id="holiday_start" placeholder="Start Date">
                            </td>
                            <td width="3%" align="center">To</td>
                            <td width="10%">
                                <input type="text" class="newdropdown" name="holiday_end" id="holiday_end" placeholder="End Date">
                            </td>
                            <td width="3%">&nbsp;</td>
                            <td align="left">
                                <button type="button" class="btn btn-default" id="search_display" style="padding:3px 8px;"><span class="requ_t">Display</span></button><!--search_display-->
                            </td>
                        </tr>
                    </table>
                    <!-- <h4>Calendar Key :</h4> -->
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-10">
                    <div class="events_cont">
                        <div class="events_head">EVENTS</div>
                        <div class="search_date"></div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="staff_listing_con" id="search_data">

                        <!-- <ul>
                            <li>
                                <div class="ann_leave pull-left"></div> 
                                <div class="text">Annual leave</div><br>
                                <div class="font_size"><strong>Date: </strong>Sunday, February 13, 2016</div>
                                <div class="font_size"><strong>Times: </strong>Full Day, Half Day-PM</div>
                                <div class="font_size"><strong>Notes: </strong>Sunday, February 13, 2016</div>
                            </li>
                        </ul> -->
                    </div>
                    <div class="clearfix"></div>
                </div>
            
                <div class="col-xs-12 m_top">
                    <h5>Calender Key:</h5>
                </div>

                <div class="col-xs-12">
                    <table>
                        <tr>
                            @if(isset($holiday_types) && count($holiday_types) >0)
                                @foreach($holiday_types as $key=>$value)
                                <td>
                                    <div class="leave_box pull-left" style="background:#{{ $value['color'] or "" }};"></div> 
                                    <span class="text">{{ $value['name'] or "" }}</span>
                                </td>
                                @endforeach
                            @endif
                            <td>
                                <div class="leave_box pull-left" style="background:#228B22;"></div> 
                                <span class="text">Cpd & Courses</span>
                            </td>
                        </tr>
                    </table>
                </div>





  <!-- Full calender section start -->
  <!-- <div id="miniMonthCalendarContainer">
    <div id="monthManagement" class="mar_left">
      <input type="button" id="prevYear" name="prevYear" value="&laquo;" title="Previous year" />
      <input type="button" id="prevMonth" name="prevMonth" value="&lt;" title="Previous month" />
      <span id="currentMonth"></span>
      <input type="button" id="nextMonth" name="prevMonth" value="&gt;" title="Next month" />
      <input type="button" id="nextYear" name="nextYear" value="&raquo;" title="Next year" />
    </div>
  <div class="table_t"><strong>STAFF NAME</strong></div>
  <div class="cal_table">
    <table id="miniMonthCalendar">
    </table>
  </div>
  <div class="clearfix"></div>
  
  
  </div>  -->

<!--   <table width="100%" border="1" cellspacing="0" cellpadding="0">
@if(isset($staff_details) && count($staff_details) >0)
	@foreach($staff_details as $key=>$users)
  <tr>
	    <td style="width:11%"><strong>{{ $users['fname'].' '.$users['lname']}}</strong></td>
	    <td style="width:3%"></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td style="width:3%"></td>
	    <td style="width:3%"></td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	@endforeach
@endif
</table> -->
  <!-- Full calender section end -->
	<!-- <div class="table_base">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="3%"><div class="a_leave"></div></td>
	    <td width="8%">Annual leave</td>
	    <td width="3%"><div class="light_blue"></div></td>
	    <td width="14%">Maternity/Paternity leave</td>
	    <td width="3%"><div class="national_holi"></div></td>
	    <td width="10%">National Holidays</td>
	    <td width="3%"><div class="silkness"></div></td>
	    <td width="6%">Sickness</td>
	    <td width="2%"><div class="course2"></div></td>
	    <td width="48%">Courses</td>
	  </tr>
	</table>
	
	</div> -->


</div>
<!--end calendar section-->
</div>
<div class="clearfix"></div>
</div>
         




    <div class="notice_board_topcon">
    <div class="notice_bottom_left"></div>
    <div class="notice_bottom_mid"></div>
    <div class="notice_bottom_right"></div>
    <div class="clearfix"></div>
    </div>
    </div>
    
    </div>
   
  </div>
</div>
</div>