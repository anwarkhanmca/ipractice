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
            <div class="panel panel-primary" style="border-color: #0866C6">
              <div class="panel-heading" style="color: #fff;background-color:#0866C6; border-color: #0866C6;">
                <h3 class="panel-title"><i class="fa fa-plus-square-o tiny-icon"></i> &nbsp;{{ $form_title or ''}}</h3>
              </div>
          <div class="panel-body">
            {{ Form::open(array('url' => '/crm/attachment', 'class'=>'form-horizontal', 'files'=>true)) }}
              <div class="input-group  col-md-12 proposal-input-group">
                <div class="col-md-3">
                  <label class="proposal-label"><b>Title </b></label>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="Title" name="title" value="{{ Input::old('title') }}"/>
                    @if ($errors->has('title')) <span style="color: red">{{ $errors->first('title') }}</span> @endif
                </div>
              </div>
                    <!--input group-edns here-->
                    <div class="input-group  col-md-12 proposal-input-group">
                      <div class="col-md-3">
                        <label class="proposal-label"><b>PDF</b></label>
                      </div>
                      <div class="col-md-6">
                        <div class="input-group" style="position:relative;">
                          <input type="text" class="form-control file-focus-field" id="file_input" placeholder="No File Selected">
                            <span class="input-group-addon btn btn-primary" style="background-color:#0866C6;color:#fff;border:1px solid #069">Select</span>
                        </div>
                        <input type="file" class="form-control file-field" name="file" onchange="$('#file_input').val($(this).val());"  style="opacity:0;position:absolute;top:0;"/>
                        @if ($errors->has('file')) <span style="color: red">{{ $errors->first('file') }}</span> @endif
                      </div>
                    </div>

                    <!--input group-edns here-->
                    <div class="col-md-6 col-md-offset-3">
                      <button type="submit" class="btn btn-primary btn-sm proposal-button" style="margin-top: 5px; background-color: #0866C6;"><i class="fa fa-paper-plane tiny-icon"></i> Save </button>
                    </div>
                {{ Form::close() }}
              </div>
            </div>
            <div class="panel panel-primary">
              <div class=" panel-heading" style="color:#fff;background-color:#0866C6; border-color: #0866C6;">
                <h3 class="panel-title"><i class="fa fa-list tiny-icon"></i> &nbsp;{{ $content_header or "" }}</h3>
              </div>
            <div class="panel-body">
              <div class="show_loader"></div>
              <div class="table-responsive" >
              <table class="table table-bordered" id="attachment_table" width="100%">
              <thead>
                <tr>
                  <th width="40%"><b>Title</b></th>
                  <th><b>PDF File</b></th>
                  <th width="6%"><b>Notes</b></th>
                  <th width="6%"><b>Preview</b></th>
                  <th width="10%"><b><a href="/crm/attachment/{{($is_archive=='hide')?'show':'hide'}}">{{($is_archive=='hide')?'Show':'Hide'}} Archive</a></b></th>
                </tr>
                </thead>
                <tbody>
                @if(isset($attachments) && count($attachments) >0)
                  @foreach($attachments as $attachment)
                  <tr class="attAcH_{{$attachment['id'] }} {{($attachment['is_archive']=='Y')?'rowColor': '' }}">
                    <td>{{ $attachment['title'] or "" }}</td>
                    <td><a href="{{ url('/uploads/pdf forms/'.$attachment['file']) }}" download>{{ $attachment['file'] }}</a></td>
                    <td><a href="javascript:void(0)" class="notes_btn proposalNotes"  data-table_id="{{ $attachment['id'] }}" data-type="settings_attachment" data-name="{{$attachment['title'] or ''}}">Notes</a></td>
                    <td><a href="#" data-file="{{ $attachment['file'] }}" class="btn btn-xs btn-primary attach_file_preview" style=" background-color: #0866C6; border-color: #0866C6"><i class="fa fa-eye tiny-icon"></i> Preview</a></td>
                    <td style="text-align: center;">
                      <!-- <a href="javascript:void(0)" data-id="{{$attachment['id']}}" class="btn btn-xs btn-danger delete"  data-url="{{ url('/crm/attachment/delete/'.$attachment['id']) }}"><i class="fa fa-trash-o"></i></a> -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                          <li><a href="javascript:void(0)" data-id="{{$attachment['id']}}" class="deleteAttachment"  data-url="{{ url('/crm/attachment/delete/'.$attachment['id']) }}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                          
                          <li><a href="javascript:void(0)" id="arcAttachment_{{$attachment['id']}}" data-attachment_id="{{$attachment['id']}}" class="arcAttachment" data-update_value="{{($attachment['is_archive']=='Y')?'N':'Y'}}" data-event="{{($attachment['is_archive']=='Y')?'unarchive':'archive'}}"><i class="fa fa-edit tiny-icon"></i>{{($attachment['is_archive']=='Y')?'Un Archive':'Archive'}}</a></li>
                            
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @endforeach  
                @endif 
                </tbody>
                </table>
            </div>
          </div>
        </div>

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