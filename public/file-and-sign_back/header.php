<style>
.nav-tabs-custom > .nav-tabs > li:first-of-type {
	margin-left:5px;
}
.nav-tabs-custom > .nav-tabs > li:first-of-type a{
	cursor:pointer;
}
</style>
<header class="headermain">
	<div class="logo_controlar">
		<a href="/dashboard"><img src="images/logo.png"></a>
	</div>
<?php
$session = FileAndSign::get_session();
$user_id = $session['id'];
$group_id = $session['group_id'];
//$user_id 	= $_SESSION['admin_details']['id'];
//$group_id 	= $_SESSION['admin_details']['group_id'];
$sql = "SELECT * FROM practice_details WHERE user_id IN(SELECT user_id FROM users WHERE group_id='".$group_id."')";
//echo $sql;die;
$query = mysql_query($sql) or die(mysql_error());
$result = mysql_fetch_assoc($query);

$sql_1 = "SELECT profile_photo FROM client_files WHERE client_id ='".$user_id."'";
//echo $sql_1;die;
$query_photo = mysql_query($sql_1) or die(mysql_error());
$result_photo = mysql_fetch_assoc($query_photo);

?>
	<div class="col_display">
		<p class="display_name"><?php echo $result['display_name'];?></p>
	</div>
	<nav class="navbar" role="navigation">
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="<?=$SITE_URL?>" class="dropdown-toggle" data-toggle="dropdown">
						<i class="glyphicon glyphicon-user"></i>
						<span><?php echo $session['fname'];?> <?php echo $session['lname'];?> <i class="caret"></i></span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header bg-light-blue">
						<?php if(isset($result_photo['profile_photo']) && $result_photo['profile_photo'] != ""){?>
		                        <img src="/uploads/profile_photo/<?php echo $result_photo['profile_photo'];?>" class="img-circle" alt="User Image" />
		                <?php }else{?>
		                        <div class="no_profile">
		                <?= strtoupper(substr($session['fname'],0,1));?><?= strtoupper(substr($session['lname'],0,1));?>
		                        </div>
		                <?php }?>
							<p>
							   <?php echo $session['fname'];?> <?php echo $session['lname'];?>
							</p>
						</li>
						
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="/staff-profile" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-left" style="margin-left: 3px;">
								<a href="/change-password" class="btn btn-default btn-flat">Edit Password</a>
							</div>
							<div class="pull-right">
								<a href="/admin-logout" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>

				<li class="dropdown messages-menu">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class=""><img src="../img/bell.png"></i>
                    <span class="label label-danger">8</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 4 messages</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                        <li>
                          <!-- start message -->
                          <a href="#">
                          <div class="pull-left"><img src="../img/avatar3.png" class="img-circle" alt="User Image"></div>
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


            <?php if(isset($session['user_type']) && $session['user_type'] != "C"){?>
            <li><a href="/settings-dashboard" style="padding:0;">
                <img src="../img/setting.png" width="24"></a></li>
            <?php }?>
            
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class=""><img src="../img/question.png"></i>
                    <!-- <span class="label label-warning">10</span> -->
                </a>
                  <ul class="dropdown-menu">
                    <li class="header">You have 10 notifications</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                        <li> <a href="#"> <i class="ion ion-ios7-people info"></i> 5 new members joined today </a> </li>
                        
                      </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                    </li>
                    <li class="footer"><a href="#">View all</a></li> 
                  </ul>
                </li>

			</ul>
		</div>
	</nav>
	<div class="clearfix"></div>    
</header>