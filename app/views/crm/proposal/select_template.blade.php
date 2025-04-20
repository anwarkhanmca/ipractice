<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="row" style="margin-top: 10px;">
            <div class="panel panel-primary" style="border-color: #0866C6">
                <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                    <h3 class="panel-title">{{ $page_title }} - Select Template</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => '/crm/proposalPreview')) }}
                    <div class="row col-md-12" style="padding-left:20px;">

                        <div class="attachment-item" style="margin-left:5px;">
                            <div  class="attachment-item-title">
                                <label class="proposal-template-label"><input type="radio" name="template" <?php 
                                if($proposal_info->proposal_template!=""){
                                    echo ($proposal_info->proposal_template==1)? "checked='checked'":"";
                                }else{
                                    echo "checked='checked'";
                                }
                                ?> value="1"> Basic</label>
                            
                            </div>
                            <div class="img-holder">
                                <a class="fancybox" rel="group" href="{{ url('public/img/preview_images/preview_proposal.png') }}"><img src="{{ url('public/img/preview_images/preview_proposal.png') }}"/> </a>
                            </div>

                        </div>
                        <!--                          attachment-item-->
                        <div class="attachment-item">
                            <div  class=" attachment-item-title">
                                <label class="proposal-template-label"><input type="radio" <?php echo ($proposal_info->proposal_template==2)? "checked='checked'":"";?> name="template" value="2"> Standard</label>
                            </div>
                            <div class="img-holder">
                                <a  class="fancybox" rel="group" href="{{ url('public/img/preview_images/proposal_preview_standard.png') }}"><img src="{{ url('public/img/preview_images/proposal_preview_standard.png') }}"/> </a>
                            </div>

                        </div>
                        <!--                          attachment-item-->
                        <div class="attachment-item">
                            <div  class=" attachment-item-title">
                                <label class="proposal-template-label"><input type="radio" <?php echo ($proposal_info->proposal_template==3)? "checked='checked'":"";?> name="template" value="3"> Corporate</label>
                            </div>
                            <div class="img-holder">
                                <a class="fancybox" rel="group" href="{{ url('public/img/preview_images/preview_proposal_corporate.png') }}">
                                    <img src="{{ url('public/img/preview_images/preview_proposal_corporate.png') }}"/>
                                </a>
                            </div>

                        </div>
                        <!--                          attachment-item-->


                    </div>
                    <!--                      col-md-12-->
                    <div class="row col-md-12" style="margin-top:10px;">
                        <input type="hidden" name="proposal_id" value="{{ $proposal_id }}"/>
                        <input type="hidden" name="page_title" value="{{ $page_title }}"/>
                        <div class="col-md-8">

                            <button type="submit" class="btn btn-sm btn-primary proposal-button" style="background-color: #0866C6">Next</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
<!--                panel-body-->
            </div>
        </div>
        <!--        .row-->
    </div>
    <!--    col-md-8 col-md-offset-2-->
</div>