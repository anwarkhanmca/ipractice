<div class="row">
  <!--<div class="col-xs-12 col-xs-1" style="padding-top: 7px;">
    Dashboard
  </div>-->

  <div class="col-xs-12 col-xs-3" style="margin: 5px 0 15px 550px;">
    <select id="crmdashboard" class="form-control newdropdown" style="width: 262px; height: 33px; font-weight: bold">
        <option value="live">LIVE CLIENTS METRICS DASHBOARD</option>
        <option value="sales">SALES PERFORMANCE DASHBOARD</option>
    </select>
  </div>
  <div class="clearfix"></div>
</div>

<div class="row">
  <div class="col-xs-12">
      <div class="loading" id="before_show" style="display: none";>
        <div class="loading-1"></div>
        <div class="loading-2"></div>
        <div class="loading-3"></div>
        <div class="loading-4"></div>
        <div class="loading-5"></div>
        <div class="loading-6"></div>
        <div class="loading-7"></div>
        <div class="loading-8"></div>
        <div class="loading-9"></div>
        <div class="loading-10"></div>
      </div>
      
      <div id="after_show" style="display: block";>
         <iframe src="<?php echo url();?>/chartphp/demos/basic/live-dashboard.php?user_id={{ $user_id or '' }}" frameborder="0" height="2300" width="100%" id="dashboard_frame"></iframe>
      </div>

  </div>

  <!-- <div class="col-xs-12 col-xs-6">
    
  </div> -->
  <div class="clearfix"></div>

</div>
                             
<!-- <div id="salesimg" style="padding-top:10px;"><img src="/img/img_2.png" /></div> -->