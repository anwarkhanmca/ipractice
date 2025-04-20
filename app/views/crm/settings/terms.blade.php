<div class="container">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            @if(Session::has('info_msg'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ Session::get('info_msg') }}
                        </div>
                    </div>
                </div>
            @endif             

        <!-- Terms and Condition start -->
        <div class="panel panel-primary">
          <div class="panel-heading" style="color:#fff;background-color:#0866C6; border-color: #0866C6;">
            <h3 class="panel-title"><i class="fa fa-list tiny-icon"></i> Terms and Conditions</h3>
          </div>
          <div class="panel-body">
          <div class="show_loader"></div>
            <div class="table-responsive" >
              <table width="100%" id="termsConditionTable">
                <tr>
                  <td width="7%">
                    <a href="javascript:void(0)" id="terms_edit" class="btn btn-info termsExists" style="width:70%;display:{{ (isset($terms) && count($terms) >0)?'block':'none' }}">Edit</a>
                    <a href="javascript:void(0)" id="terms_save" class="btn btn-success termsNotExists" style="width:70%;display:{{ (isset($terms) && count($terms) >0)?'none':'block' }}">Save</a>
                  </td>
                  <td>
                  <div class="col_m2 termsExists" id="termsExists" style="display:{{ (isset($terms) && count($terms) >0)?'block':'none' }}">
                    <div class="col-md-12" style="margin-bottom: 10px; border-bottom: 1px solid #ccc;">
                      <a href="javascript:void(0)" id="termsHeader">Updated by {{ $terms['user_name'] or '' }} On {{$terms['added_date'] or ''}}</a>
                    </div>
                    <div class="col-md-12" id="trmsDescDiv">
                      {{ $terms['description'] or '' }}
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="termsNotExists" style="display:{{ (isset($terms) && count($terms) >0)?'none':'block' }}">
                  <form method="post" action="/crm/action" id="tcFileUploadForm">
                    <textarea class="form-control" rows="4" id="terms_description" name="terms_description">{{ $terms['description'] or '' }}</textarea>
                  </form>
                  </div>
                    
                  </td>
                </tr>
              </table>
            </div>
        </div>
      </div>
        <!-- Terms and Condition end -->
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>

<!-- ///////////////////////////////////SMALL MODAL FOR MESSAGE///////////////////// -->
@include('crm/modal/attachment_preview')

<div class="modal fade modal-sm" id="message_modal-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
       <h4 id="message_modal"></h4>
      </div>
    
    </div>
  </div>
</div> 