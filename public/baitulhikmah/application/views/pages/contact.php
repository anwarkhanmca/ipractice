<div class="main">
  <div class="container">
	<ul class="breadcrumb">
	    <li><a href="<?=base_url();?>"><?= $this->lang->line('home_menu');?></a></li>
	    <li class="active"><?= $title;?></li>
	</ul>
	<div class="row margin-bottom-40">
	  <!-- BEGIN CONTENT -->
	  <div class="col-md-12">
	    <div class="content-page">
	      <div class="row">
	        <div class="col-md-12">
	          <div id="map" class="gmaps margin-bottom-40" style="height:400px;"></div>
	        </div>
	        <div class="col-md-9 col-sm-9">
	          <!-- BEGIN FORM-->
	          <form action="#" role="form">
	            <div class="form-group">
	              <label for="contacts-name"><?= $this->lang->line('name');?></label>
	              <input type="text" class="form-control" id="contacts-name">
	            </div>
	            <div class="form-group">
	              <label for="contacts-email"><?= $this->lang->line('email');?></label>
	              <input type="email" class="form-control" id="contacts-email">
	            </div>
	            <div class="form-group">
	              <label for="contacts-email"><?= $this->lang->line('subject');?></label>
	              <input type="text" class="form-control" id="contacts-subject">
	            </div>
	            <div class="form-group">
	              <label for="contacts-message"><?= $this->lang->line('message');?></label>
	              <textarea class="form-control" rows="5" id="contacts-message"></textarea>
	            </div>
	            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <?= $this->lang->line('send');?></button>
	            <button type="button" class="btn btn-default"><?= $this->lang->line('cancel');?></button>
	          </form>
	          <!-- END FORM-->
	        </div>

	        <div class="col-md-3 col-sm-3 sidebar2">
	          <h2><?= $this->lang->line('our_contacts');?></h2>
	          <address class="margin-bottom-40">
		          <?= $this->lang->line('address');?><br>
		          <abbr><?= $this->lang->line('phone');?>:</abbr> <?= $this->lang->line('mobile2');?><br>
		          <abbr><?= $this->lang->line('skype');?>:</abbr> <a href="skype:anwarkhanmca786">anwarkhanmca786</a>
		      </address>

	          <address>
	            <abbr title="Phone"><?= $this->lang->line('email');?></abbr><br>
	            <a href="mailto:info@baitulhikmah.com">info@baitulhikmah.in</a><br>
	            <a href="mailto:anwarkhanmca786@gmail.com">anwarkhanmca786@gmail.com</a>
	          </address>
	          <ul class="social-icons margin-bottom-40">
	            <li><a href="#" data-original-title="facebook" class="facebook"></a></li>
	            <li><a href="#" data-original-title="Goole Plus" class="googleplus"></a></li>
	            <li><a href="#" data-original-title="linkedin" class="linkedin"></a></li>
	          </ul>      
	        </div>
	      </div>
	    </div>
	  </div>
	  <!-- END CONTENT -->
	</div>
  </div>
</div>

<script type="text/javascript">
var map;
$(document).ready(function(){
  map = new GMaps({
	div: '#map',
    lat: 24.394570,
	lng: 88.069966,
  });
   var marker = map.addMarker({
        lat: 24.394570,
		lng: 88.069966,
        title: 'Loop, Inc.',
        infoWindow: {
            content: "<b>Nowda.</b> Mirjapur, Raghunathganj<br>West Bengal, India"
        }
    });

   marker.infoWindow.open(map, marker);
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBULVMN8kKbQ0QxgNfweG4KGb4ePE_kNtQ" type="text/javascript"></script>
<script src="assets/global/plugins/gmaps/gmaps.js" type="text/javascript"></script>