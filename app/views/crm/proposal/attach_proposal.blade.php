<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="row"  style="margin-top: 10px;">
            <div class="panel panel-primary" style="border-color: #0866C6">
                <div class="panel-heading" style="color: #fff; background-color: #0866C6; border-color: #0866C6;">
                    <h3 class="panel-title">{{ $page_title }} - Select Attachments</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => '/crm/saveProposalAttachment', 'class'=>'form-horizontal')) }}
                    <div class="row col-md-12" style="padding-left:20px;">
                        @if($attachments)
                        @foreach($attachments as $attachment)
                        <div class="attachment-item">
                            <div  class="attachment-item-title">
                                <label class="proposal-attach-label"><input type="checkbox" name="files[]" value="{{ $attachment->id }}" <?php echo ( isset($attached_files) && in_array($attachment->id, $attached_files)) ? "checked='checked'":"";?> > {{ $attachment->title }}</label>
                            </div>
                            <div class="img-holder">
                                <a href="#" class="attach_proposal_previewr" data-atid="{{ $attachment->id }}"><img src="{{ url('public/img/preview_images/pdffile.jpg') }}"/> </a>
                            </div>

                        </div>
                        <!--                          attachment-item-->
                        @endforeach
                        @endif
                    </div>
                    <!--                      col-md-12-->
                    <div class="row col-md-12">
                        <input type="hidden" name="proposal_id" value="{{ $proposal_id }}"/>
                        <input type="hidden" name="page_title" value="{{ $page_title }}"/>
                        @if(isset($copy_proposal_id))
                            <input type="hidden" name="copy_proposal_id" value="{{ $copy_proposal_id }}"/>
                        @endif

                        <div class="col-md-8">
                            <button type="submit" class="btn btn-sm btn-primary proposal-button" style="background-color: #0866C6">Next</button>
                            @if(isset($copy_proposal_id))
                                <a href="{{ url('crm/copyAdditionalNote/'.$proposal_id.'/'.$copy_proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="background-color: #0866C6">Skip</a>
                            @else
                                <a href="{{ url('crm/'.(($page_title == 'Edit Proposal') ? 'editAdditionalNote' : 'additionalNote') . '/'.$proposal_id) }}" class="btn btn-sm btn-primary proposal-button" style="background-color: #0866C6">Skip</a>
                            @endif
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
<div class="modal fade" id="attach_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Preview Attachment</h4>
      </div>
      <div class="modal-body">
        <iframe src="#" id="attachmentFile" style="width:100%;height:400px;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>