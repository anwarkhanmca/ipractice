@if(isset($v['services']) && count($v['services']) > 0)
  @foreach($v['services'] as $k=>$vs)
    <div class="actvHead">
        <div class="actvTitle">{{$vs['service_name'] or ''}}</div>
        <div class="actvPnd">&pound;</div>
        <div class="right">{{ !empty($vs['fees'])?number_format($vs['fees'],2):'0.00'}}</div>
    </div>

    <?php $option2 = $option3 = 0;?>

    <div class="actsubcont">
        <div class="actsubcontTl">This service includes :-</div>
        <ul class="actsubsub">
        @if(isset($vs['activities']) && count($vs['activities'])>0)
          @foreach($vs['activities'] as $k=>$vsa)
            @if($vsa['activity_option'] == 1)
                <li>
                    <div class="actsubimg"><img src="/img/black_right.png"></div>
                    <div class="lileft">{{$vsa['name'] or ''}}</div>
                    <div class="liright">
                        @if($vsa['is_show_fees'] != 'Y')
                            {{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}
                        @endif
                    </div>
                </li>
            @endif
            <?php 
                if($vsa['activity_option'] == 2)$option2 = 2;
                if($vsa['activity_option'] == 3)$option3 = 3;
            ?>
          @endforeach
        @endif
        </ul>
    </div>


    @if($option2 == 2)
        <div class="actsubcont">
            <div class="actsubcontTl">Disbursement & Recharges :-</div>
            <ul class="actsubsub">
            @if(isset($vs['activities']) && count($vs['activities'])>0)
              @foreach($vs['activities'] as $k=>$vsa)
                @if($vsa['activity_option'] == 2)
                    <li>
                        <div class="actsubimg"><img src="/img/black_right.png"></div>
                        <div class="lileft">{{$vsa['name'] or ''}}</div>
                        <div class="liright">
                        @if($vsa['is_show_fees'] != 'Y')
                            {{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}
                        @endif
                        </div>
                    </li>
                @endif
            @endforeach
            @endif
            </ul>
        </div>
    @endif

    @if($option3 == 3)
    <div class="actsubcont">
        <div class="actsubcontTl">Optional Services :-</div>
        <ul class="actsubsub">
        @if(isset($vs['activities']) && count($vs['activities'])>0)
          @foreach($vs['activities'] as $k=>$vsa)
            @if($vsa['activity_option'] == 3)
            <li>
                <div class="actsubimg"><img src="/img/black_right.png"></div>
                <div class="lileft">{{$vsa['name'] or ''}}</div>
                <div class="liright">{{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}</div>
            </li>
            <?php $optional_total += str_replace(',', '', $vsa['fees']);?>
            @endif
        @endforeach
        @endif
        </ul>
    </div>
    @endif

  @endforeach
@endif