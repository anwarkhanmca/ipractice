
<?php
if(isset($practice['crm_auto_color']) && $practice['crm_auto_color'] != ''){
    $auto_color = $practice['crm_auto_color'];
}else{
    $auto_color = '#12A5F4';
}

if(isset($practice['crm_manual_color']) && $practice['crm_manual_color'] != ''){
    $manual_color = $practice['crm_manual_color'];
}else{
    $manual_color = '#12A5F4';
}

/*if(isset($practice['use_color']) && $practice['use_color'] == 'M'){
    $color = $practice['crm_manual_color'];
}else if(isset($practice['use_color']) && $practice['use_color'] == 'A'){
    $color = $practice['crm_auto_color'];
}else{
    $auto_color = '#12A5F4';
}*/

?>



<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading" style="color:#fff;background-color:#0866C6;border-color:#0866C6;">
                <div style="width: 92%; float: left;"><i class="fa fa-list tiny-icon"></i> {{$content_header or ""}}</div>

                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive" >
                    <table class="table table-bordered table-striped table-hover" id="" width="100%">
                        <tr>
                            <th width="50%">
                                <div style="float: left; border-bottom: 1px solid #ccc; width: 100%">
                                    <div class="col-xs-5">Select Corporate Colour Manually</div>
                                    <div class="col-xs-2"><input type="color" class="menuColor" id="menuColor" value="{{ $practice['crm_manual_color'] or '' }}" data-type="manual_change"></div>
                                    
                                <div class="col-xs-2 manualNotUseBtn" style="display:{{ (isset($practice['use_color']) && $practice['use_color'] == 'M')?'block':'none';}}">
                                    <a class="btn btn-default btn-file useColor" href="javascript:void(0)" data-btn_no="1" data-type="manual_notuse" data-use_color="M" title="Use this">Do not use</a>
                                </div>
                                <div class="col-xs-2 manualUseBtn" style="display:{{ (isset($practice['use_color']) && $practice['use_color'] == 'M')?'none':'block';}}">
                                    <a class="btn btn-default btn-file useColor" href="javascript:void(0)" data-btn_no="1" data-type="manual_use" data-use_color="M" title="Use this">Use this!</a>
                                </div>

                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin:15px 0 10px 0;">Logo (Optional)</div>

                                <div class="col-xs-12">  
                                <form method="post" action="{{url()}}/colorextract/upload.php" id="CrmLogoForm" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="{{ $user_id or '0' }}">
                                    <input type="hidden" name="group_id" value="{{ $group_id or '0' }}">
                                    <input type="hidden" name="added_from" id="added_from" value="branding">
                                    <div class="col-xs-10 crmlogoBox"> 
                                        <div class="col-xs-8">
                                            <input type="file" name="imgFile">
                                        </div>
                                        <div class="col-xs-4">
                                            <button type="button" id="UploadProcess">Process</button>
                                        </div>
                                    </div>
                                </form>
                                </div>

                                <div style="float: left; width: 100%; margin: 50px 0 10px 0;">
                                    <div class="col-xs-5">Colour Detected</div>
                                    <div class="col-xs-2">
                                        <input type="color" class="menuColor" id="colorAreaA" value="{{$practice['crm_auto_color'] or ''}}" data-type="auto_change">
                                    </div>
                                <div class="col-xs-2 autoNotUseBtn" style="display:{{ (isset($practice['use_color']) && $practice['use_color'] == 'A')?'block':'none';}}">
                                    <a class="btn btn-default btn-file useColor" href="javascript:void(0)" data-btn_no="1" data-type="auto_notuse" data-use_color="A" title="Do not use">Do Not Use</a>
                                </div>
                                <div class="col-xs-2 autoUseBtn" style="display:{{ ( isset($practice['use_color']) && $practice['use_color'] == 'A')?'none':'block';}}">
                                    <a class="btn btn-default btn-file useColor" href="javascript:void(0)" data-btn_no="1" data-type="auto_use" data-use_color="A" title="Use this!">Use this!</a>
                                </div>

                                </div>
                                </div>
                            @if(isset($practice['crm_branding_logo']) && $practice['crm_branding_logo'] != '')
                                @if(file_exists("colorextract/images/".$practice['crm_branding_logo']))
                                <div class="col-xs-12" style="margin-bottom: 5px; padding-left: 0px;">
                                    <div class="col-xs-3">
                                        <button class="btn btn-danger" data-logo_name="{{$practice['crm_branding_logo'] or ''}}" title="Delete Logo?" type="button" id="delete_branding_logo">Delete Logo</button>
                                    </div>
                                    <div class="col-xs-3 deleteLoader"></div>
                                </div>
                                @endif
                            @endif

                                <div class="col-xs-12">
                                    <table class="table table-bordered" width="100%" id="colorTable">
                                    <thead>
                                        <tr>
                                            <td>Image</td>
                                            <td>Percentage</td>
                                            <td style="width: 5%">Colour</td>
                                            <td style="width: 3%;">Use</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($imageColors) && count($imageColors) >0)
                                    <?php $i = 1;?>
                                        @foreach($imageColors as $k=>$v)
                                            
                                            <tr>
                                            @if($i == 1)
                                                <td rowspan='20'><img src="/colorextract/images/{{$practice['crm_branding_logo']}}" alt='test image' width='80'></td>
                                            @endif
                                                <td>{{ $v['percentage'] or '' }}</td>
                                                <td><div class="boxColor" style="background-color:#{{ $v['color_code'] or '' }}"></div></td>
                                                <td><input type="radio" class="selectRadioColor" name="colRadio" value="#{{ $v['color_code'] or '' }}" {{ ('#'.$v['color_code'] == $practice['crm_auto_color'])?'checked':'' }}></td>
                                            </tr>
                                            <?php $i++;?>
                                        @endforeach
                                    @endif
                                        <!-- <tr>
                                            <td></td>
                                            <td><div class="boxColor" style="background-color:#282424"></div></td>
                                            <td><input type="radio" class="selectRadioColor" name="colRadio" value="#282424"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><div class="boxColor" style="background-color:#f98383"></div></td>
                                            <td><input type="radio" class="selectRadioColor" name="colRadio" value="#f98383"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><div class="boxColor" style="background-color:#ff0505"></div></td>
                                            <td><input type="radio" class="selectRadioColor" name="colRadio" value="#ff0505"></td>
                                        </tr> -->
                                    </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"></div>
                            </th>
                            <th width="50%" id="viewDemoProposal">
                                @include('crm/includes/ajax_branding')
                            </th>
                        </tr>                        
                    </table>

                </div>
                <!--table-responsive-->

            </div>
            <!-- panel-body-->
        </div>
        <!-- panel-->
    </div>
    <!--col-md-12-->
</div>

<!--E47810003-->
