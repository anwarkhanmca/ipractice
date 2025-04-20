<div class="main">
  <div class="container">
    <ul class="breadcrumb">
        <li><a href="<?=base_url();?>"><?= $this->lang->line('home_menu');?></a></li>
        <li class="active"><?= $title;?></li>
    </ul>
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
      <!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">
        <div class="content-page">
          <div class="row margin-bottom-30">
            <!-- BEGIN INFO BLOCK -->               
            <div class="col-md-12">
              <h2 class="no-top-space"><?= $this->lang->line('about_menu');?></h2>
              <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi.</p> 
              <p>Idest laborum et dolorum fuga. Et harum quidem rerum et quas molestias excepturi sint occaecati facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus.</p>

            </div>
            <!-- END INFO BLOCK -->   

         <div class="row front-team">
            <ul class="list-unstyled">
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="assets/images/pirbaba.jpg">
                  <h3>
                    <strong><?= $this->lang->line('pirbaba');?></strong> 
                    <small>Baba Sayed Sah Bajle Nure Alam Mia Pak Kutub Ul Akhtab Alkaderi Ul Chisti Rahmatullah Alai.</small>
                  </h3>
                </div>
              </li>

              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="assets/images/lemon.jpg">
                  <h3>
                    <strong><?= $this->lang->line('lemon_syed');?></strong> 
                    <small>Chief Executive Officer / CEO</small>
                  </h3>
                </div>
              </li>
              
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="assets/images/sanwar.jpg" height="260" width="260">
                  <h3>
                    <strong><?= $this->lang->line('sanwar_khan');?></strong> 
                    <small>Operation Manager</small>
                  </h3>
                </div>
              </li>
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="assets/images/anwar.jpg">
                  <h3>
                    <strong><?= $this->lang->line('anwar_khan');?></strong> 
                    <small>Developer of this website</small>
                  </h3>
                </div>
              </li>
            </ul>            
          </div>

        </div>
      </div>
      <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
  </div>
</div>