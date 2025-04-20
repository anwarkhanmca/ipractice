<?php
$user_id 	= $_SESSION['admin_details']['id'];
$group_id 	= $_SESSION['admin_details']['group_id'];
$sql = "SELECT display_name, practice_logo FROM practice_details WHERE user_id IN(SELECT user_id FROM users WHERE group_id='".$group_id."')";
//echo $sql;die;
$query = mysql_query($sql) or die(mysql_error());
$result = mysql_fetch_assoc($query);
?>
<header class="headermain">
<div class="logo_controlar">
<a href="/dashboard"><img src="../img/logo.png"></a>
</div>
<div class="col_display">
    <p class="display_name"><?php echo $result['display_name'];?></p>
</div>
<nav class="navbar" role="navigation">
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span><?php echo $_SESSION['admin_details']['fname'];?> <?php echo $_SESSION['admin_details']['lname'];?> <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                        <img src="../img/user3.jpg" class="img-circle" alt="User Image">
                        <p>
                           <?php echo $_SESSION['admin_details']['fname'];?> <?php echo $_SESSION['admin_details']['lname'];?>
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
        </ul>
    </div>
</nav>
    
<div class="clearfix"></div>    

</header>