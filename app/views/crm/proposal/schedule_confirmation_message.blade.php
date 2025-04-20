<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
        	  <div class="alert alert-<?php echo ($message==TRUE)?"success":"danger"; ?>" style="padding-bottom:20px;">
        	  <?php 

        	  		if($message==TRUE):
        	  ?>
        			<h2 align="center">Thank you for accepting this proposal.</h2>
        			<h3 align="center" style="margin:0px;">We will contact you soon.</h3>
        		<?php else:?>
        			<h2 align="center" style="font-size:22px;">Sorry, schedule has already been saved for this proposal</h2>
        		<?php 
        			endif;
        		?>

        	  </div>
     
        </div>
        <!-- .row -->
      </div>
      <!-- col-md-8 col-md-offset-2 -->
 </div>
 <!-- container col-md-12 -->
