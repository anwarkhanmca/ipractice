<header class="headermain">
<div class="logo_controlar">
<a href="{{ $dashboard_url }}">

  
@if(isset($user_type) && $user_type != "C")
  <img src="{{ URL :: asset('img/logo.png') }}" />
@endif
</a>
</div>
<div class="col_display">
    <p class="display_name">{{ $practice_name or "" }}</p>
</div>
<nav class="navbar" role="navigation">
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>{{ $admin_name or "" }} <i class="caret"></i></span>
                </a>

                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                    @if(isset($profile_photo) && $profile_photo != "")
                        <img src="/uploads/profile_photo/{{ $profile_photo }}" class="img-circle" alt="User Image" />
                    @else
                        <div class="no_profile" style="padding-top: 15px;">
                          {{ strtoupper($short_name) }}
                        </div>
                    @endif
                        <p>
                           {{ $admin_name or "" }}
                        </p>
                    </li>
                    
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            @if(isset($user_type) && $user_type != "C")
                            <a href="/staff-profile" class="btn btn-default btn-flat" style="padding: 6px 5px;">My Dashboard</a>
                            @else
                            <a href="/client/edit-ind-client/{{ $client_id or "" }}/{{ base64_encode('client_portal') }}" class="btn btn-default btn-flat" style="padding: 6px 5px;">My Dashboard</a>
                            @endif
                        </div>
                        <div class="pull-left" style="margin-left: 3px;">
                            <a href="/change-password" class="btn btn-default btn-flat" style="padding: 6px 5px;">Edit Password</a>
                        </div>
                        <div class="pull-right">
                            <a href="/admin-logout" class="btn btn-default btn-flat" style="padding: 6px 5px;">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="dropdown notifications-menu" id="backup_clientdata">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class=""><img src="/img/bell.png"></i>
                    <span class="label label-danger unread_data_count">{{ $unread_count }}</span>
                </a>
                
                  <ul class="dropdown-menu" style="width: 340px;">
                    <li class="header">
                    <div class="left">You have <span class="unread_data_count">{{ $unread_count }}</span> notification(s)</div>
                      <div class="left"><a href="javascript:void(0)" class="open_notifications" style="color: #3c8dbc; padding-left:15px">Manage Notifications <i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
                      <div class="clearfix"></div> 
                    </li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <div class="slimScrollDiv" style="position: relative; overflow-y: scroll; height: 300px;">
                      <ul class="menu" style="overflow: hidden; width: 100%; ">
                      @if(!empty($store_datas))
                        @foreach($store_datas as $key=>$value)
                          <li id="action_not{{ $value['store_id'] }}">
                          @if($value['is_read'] == 'N')  
                            <div class="notif_icon actionNotification" data-action="new" data-store_id="{{ $value['store_id'] }}">New!</div> 
                          @else
                            <div class="notif_icon actionNotification" data-action="delete" data-store_id="{{ $value['store_id'] }}">Delete</div>
                          @endif
                            <div class="notif_text openNotification" data-store_id="{{ $value['store_id'] }}">
                          @if($value['client_type'] == 'staff')
                            Staff
                          @else
                            Client
                          @endif
                           Details Changes on {{ $value['date']}} at {{ $value['time']}}
                            <!-- Notification for {{ $value['client_name'] }} on {{ $value['date']}} at {{ $value['time']}} -->
                            </div>

                            <div class="clearfix"></div> 
                          </li>
                        @endforeach
                      @endif
                      </ul>
                      <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                    </li>
                    <!-- <li class="footer" style="margin: 0 0 10px 0;"><a href="#">View all</a></li>  -->
                  </ul>
                </li>


            


            @if(isset($user_type) && $user_type != "C")
            <li><a href="/settings-dashboard" style="padding:0;">
                <img src="/img/setting.png" width="24"></a></li>
            @endif
            
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class=""><img src="/img/question.png"></i>
                    <!-- <span class="label label-warning">10</span> -->
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 4 messages</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                        <li>
                          <!-- start message -->
                          <a href="#">
                          <div class="pull-left"><img src="/img/avatar3.png" class="img-circle" alt="User Image"></div>
                          <h4> Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small> </h4>
                          <p>Why not buy a new awesome theme?</p>
                          </a> </li>
                        <!-- end message -->
                        
                      </ul>
                      <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                    </li>
                    <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
            </li>

            <li class="dropdown report-menu">
              <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" style="padding:0; font-size: 30px;">>></a>
                <ul class="dropdown-menu">
                  <li> 
                  <a href="javascript:void(0)" style="background-color: #00c0ef; color: white; font-size: 18px;border-bottom: 1px solid white;" class="contact_form" data-msg_type="S">Suggestion Box</a>
                  </li>
                  <li><a href="javascript:void(0)" style="background-color: #00c0ef; color: white; font-size: 18px;" class="contact_form" data-msg_type="R">Report a Problem!</a></li>
                </ul>
            </li>
            
        </ul>
    </div>
</nav>
    
<div class="clearfix"></div>    

</header>




