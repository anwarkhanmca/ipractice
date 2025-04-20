
<section class="content-header">
    <div class="col-4">
        <h1>{{ $heading or "" }}</h1>
    </div>
    <div class="col-4 logo_con big_image">{{ $practice_logo or "" }}
        <!-- <a href="/practice-details" id="image_preview">
            {{ $practice_logo or "" }}
        </a> -->
    </div>
    @if(isset($user_type) && $user_type != "A")
    <div class="home_right">
        
        @if(isset($title) && $title == "Dashboard")
            <div class="left_section" style="float: left; width: auto; margin-right: 10px;">
                <ul>
                    <li class="hvr-grow" style="width: auto; height: auto; margin: 0">
                      <a href="/hmrc/taxrates">
                        <div class="circle_icons_inner">
                          <span class="c_tagline2" style="padding: 0px; line-height: 14px; font-size: 15px; text-transform: none;">Tax Cards</span>
                          <div class="clearfix"></div>
                        </div>
                      </a>
                    </li>
                </ul>
            </div>
        @endif
        
        <ol class="breadcrumb " style="float: left;">
            <li><a href="{{ $dashboard_url }}"><i class="fa fa-home"></i> Dashboard</a></li>
            @if(isset($previous_page))
            <li>{{ $previous_page }}</li>
            @endif
            @if(isset($sub_url))
            <li>{{ $sub_url }}</li>
            @endif

            @if(isset($title) && $title != "Dashboard")
            {{ '<li class="active">'.ucwords(strtolower($title)).'</li>' }}
            @endif
            
        </ol>
    </div>
    @endif
    <div class="clearfix"></div>
</section>
