<!-- <span style="float: left; padding-right: 10px; padding-top: 7px;">Dashboard</span>
<span style="float:left;">
  <select id="crmdashboard" name="" class="form-control" style="width: 250px;">
    <option value="existingclient">Live Clients Metrics Dashboard</option>
    <option value="salesperformancedashboard">Sales Performance Dashboard</option>
  </select>
</span> -->
<div class="row">
  <div class="col-xs-12 col-xs-1" style="padding-top: 7px;">
    Dashboard
  </div>

  <div class="col-xs-12 col-xs-3" style="margin-bottom: 10px">
    <select id="crmdashboard" name="" class="form-control" style="width: 250px;">
      <option value="live">Live Clients Metrics Dashboard</option>
      <option value="sales">Sales Performance Dashboard</option>
    </select>
  </div>
  <div class="clearfix"></div>
</div>

<div class="row">
  <div class="col-xs-12">
    <?php //include(public_path().'/chartphp/lowest_fees.php'); ?>
    <iframe src="<?php echo url();?>/chartphp/demos/basic/bar-stacked.php" frameborder="0" height="2300" width="100%" id="dashboard_frame"></iframe>
    <!-- <iframe src="http://mpm.com/chartphp/" width="100%" height="500px"></iframe> -->
  </div>

  <!-- <div class="col-xs-12 col-xs-6">
    
  </div> -->
  <div class="clearfix"></div>
</div>
                             
<!-- <div id="salesimg" style="padding-top:10px;"><img src="/img/img_2.png" /></div> -->