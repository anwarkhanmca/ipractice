<!-- BEGIN STYLE CUSTOMIZER -->
<!-- <div class="color-panel hidden-sm">
  <div class="color-mode-icons icon-color"></div>
  <div class="color-mode-icons icon-color-close"></div>
  <div class="color-mode">
    <p>THEME COLOR</p>
    <ul class="inline">
      <li class="color-red current color-default" data-style="red"></li>
      <li class="color-blue" data-style="blue"></li>
      <li class="color-green" data-style="green"></li>
      <li class="color-orange" data-style="orange"></li>
      <li class="color-gray" data-style="gray"></li>
      <li class="color-turquoise" data-style="turquoise"></li>
    </ul>
  </div>
</div> -->
<!-- END BEGIN STYLE CUSTOMIZER --> 

<!-- BEGIN TOP BAR -->
<div class="pre-header">
  <div class="container">
    <div class="row">
        <!-- BEGIN TOP BAR LEFT PART -->
        <div class="col-md-6 col-sm-6 additional-shop-info">
            <ul class="list-unstyled list-inline">
                <li><i class="fa fa-phone"></i><span><?= $this->lang->line('mobile1');?></span></li>
                <li><i class="fa fa-envelope-o"></i><span>info@baitulhikmah.in</span></li>
            </ul>
        </div>
        <!-- END TOP BAR LEFT PART -->
        <!-- BEGIN TOP BAR MENU -->
        <div class="col-md-6 col-sm-6 additional-nav">
          <ul class="social-footer list-unstyled list-inline pull-right">
          <!-- <li><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
          <li><a href="#"><i class="fa fa-skype"></i></a></li> -->
          <li>
            <select onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/'+this.value;">
              <option value="english" <?php if($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>>English</option>
              <option value="bengali" <?php if($this->session->userdata('site_lang') == 'bengali') echo 'selected="selected"'; ?>>Bengali</option>  
              </select>
          </li>
        </ul> 
            <!-- <ul class="list-unstyled list-inline pull-right">
                <li><a href="page-login.html">Log In</a></li>
                <li><a href="page-reg-page.html">Registration</a></li>
            </ul> -->
        </div>
        <!-- END TOP BAR MENU -->
    </div>
  </div>        
</div>
<!-- END TOP BAR -->
<?php 
$uri = $this->uri->segment(1);
?>
<div class="header">
  <div class="container">
    <a class="site-logo" href="<?= base_url();?>"><?= $this->lang->line('site_name');?></a>

    <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

    <!-- BEGIN NAVIGATION -->
    <div class="header-navigation pull-right font-transform-inherit">
      <ul>
        <li class="<?=($uri=='')?'active':''?>">
          <a href="<?=base_url();?>"><?= $this->lang->line('home_menu');?></a>
        </li>
        <li class="<?=($uri=="about")?'active':''?>">
          <a href="<?=base_url();?>about"><?= $this->lang->line('about_menu');?></a>
        </li>
        <li class="dropdown <?=($uri=="gallery" || $uri=='video' || $uri=='audio')?'active':''?>">
          <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="javascript:void(0)"><?= $this->lang->line('gallery_menu');?></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url();?>gallery"><?= $this->lang->line('photo');?></a></li>
            <li><a href="<?=base_url();?>video"><?= $this->lang->line('video');?></a></li>
            <li><a href="<?=base_url();?>audio"><?= $this->lang->line('audio');?></a></li>
          </ul>
        </li>
        <!-- <li class="<?=($this->uri->segment(1)=="gallery")?'active':''?>">
          <a href="<?=base_url();?>gallery"><?= $this->lang->line('gallery_menu');?></a>
        </li> -->
        <li class="<?=($uri=="contact")?'active':''?>">
          <a href="<?=base_url();?>contact"><?= $this->lang->line('contact_menu');?></a>
        </li>

        <!-- BEGIN TOP SEARCH -->
        <li class="menu-search">
          <span class="sep"></span>
          <i class="fa fa-search search-btn"></i>
          <div class="search-box">
            <form action="#">
              <div class="input-group">
                <input type="text" placeholder="<?= $this->lang->line('search');?>" class="form-control">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><?= $this->lang->line('search');?></button>
                </span>
              </div>
            </form>
          </div> 
        </li>
        <!-- END TOP SEARCH -->
      </ul>
    </div>
    <!-- END NAVIGATION -->
  </div>
</div