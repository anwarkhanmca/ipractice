

<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

    <div class="navbar-header" style="background-color: #3c8dbc">
      
      <button type="button" class="navbar-toggle" data-target="#site-navbar-collapse" data-toggle="collapse" aria-expanded="true" style="color: #358FE4">
        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
      </button>
      
      <div class="navbar-brand navbar-brand-center" >
        <a href="https://i-practice.co.uk/dashboard"><img class="navbar-brand-logo" src="https://i-practice.co.uk/img/logo.png" style="height: 49px; margin-top: -15px;"></a> 
      </div>

      
    </div>

    <div style="position: absolute; z-index: 1; left: 44%; margin-top: 9px; font-size: 29px; color: #fff; font-weight: 400;">
      {{Session::get('pname') or ' '}}

    </div>
    <div class="navbar-container container-fluid" style="background: #3c8dbc">
      <!-- Navbar Collapse -->
      <div class="navbar-collapse navbar-collapse-toolbar collapse in" id="site-navbar-collapse" aria-expanded="true">
        <!-- Navbar Toolbar -->
        
        <!-- End Navbar Toolbar -->

        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          
          <li class="dropdown">
            <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="slide-bottom" role="button">
              <span style="color: #fff"><i class="icon wb-user" aria-hidden="true"></i>&nbsp;&nbsp;<b>{{(isset(Auth::user()->fname)) ? Auth::user()->fname : ''}} {{(isset(Auth::user()->lname)) ? Auth::user()->lname : ''}}</b></span>
              <!-- <span class="avatar avatar-online">
                <img src="./assets/portraits/5.jpg" alt="...">
                <i></i>
              </span> -->
            </a>
            <ul class="dropdown-menu" role="menu">
              <li role="presentation">
                <a href="https://i-practice.co.uk/dashboard" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Dashboard</a>
              </li>
              <li class="divider" role="presentation"></li>
              <li role="presentation">
                <a href="{{url('/auth/logout')}}" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
              </li>
            </ul>
          </li>
          
          
          
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->

      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon wb-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search" data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
 
</nav>
