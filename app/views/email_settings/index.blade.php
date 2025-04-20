@extends('layouts.layout')

@section('myjsfile')
<!--<script src="http://cdn.ckeditor.com/4.5.2/standard-all/ckeditor.js"></script>-->
    <script type="text/javascript" src="js/email_settings.js"></script>
@stop

@section('content')

<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
           <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    @include('layouts.inner_leftside')
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
            <!-- Content Header (Page header) -->
            @include('layouts.below_header')

    <!-- Main content -->
    <section class="content">
      

      <div class="practice_mid">

        <div class="row box_border6 row_cont">
          <div class="col-xs-12 col-xs-6 p_left">
            <!-- <h2 class="res_t">Email Templates</h2> -->
          </div>
          <div class="col-xs-12 col-xs-6">
            <div class="setting_con">
             <!-- <a href="/settings-dashboard" class="btn btn-success btn-lg"><i class="fa fa-cog fa-fw"></i>Settings</a> -->
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
    @if(Session::has('success'))
      <p style="color:#00a65a; font-size:15px;">{{ Session::get('success') }}</p>
    @endif

    @if(Session::has('error'))
      <p style="color:red; font-size:15px;">{{ Session::get('error') }}</p>
    @endif
    
    <div id="msg"></div>

    

          <div class="tabarea">

            <div class="row">
        <div class="top_bts">
          <ul>
            
            <li>
              <a class="btn btn-block btn-success" data-toggle="modal" data-target="#compose-modal" style="width:124px;">
                <i class="fa fa-plus"></i> Add template</a>
            </li>

            <li>
              <button class="btn btn-info">UPLOAD LETTERHEAD</button>
            </li>
            
            <div class="clearfix"></div>
          </ul>
        </div>
        <div id="message_div" style="margin-left: 700px;"><!-- Loader image show while sync data --></div>
        
      </div>
            
            
            <!-- /.box-header -->
            <div class="box-body table-responsive">
             <!-- <p>Choose the user's level of access to this organisation's accounts:</p>-->
              <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                
                <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
                  <thead>
                    <tr role="row">
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Type</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Attachment</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Action</th>
                     </tr>
                  </thead>
                  <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(!empty($email_templates))
                    @foreach($email_templates as $key=>$email_tmpl_row)
                      <tr>
                        <td align="left">{{ $email_tmpl_row->template_type_name }}</td>
                        <td align="left">{{ $email_tmpl_row->name }}</td>
                        <td align="left">
                          @if(!empty($email_tmpl_row->file) && file_exists( "uploads/emailTemplates/".$email_tmpl_row->file ) )
                          <a href="uploads/emailTemplates/{{ $email_tmpl_row->file }}"><img src="img/attachment.png" width="20" /></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-eml_tmpl_id="{{ $email_tmpl_row->email_template_id }}" data-file="{{ $email_tmpl_row->file }}" class="deleteTemplateFile"><img src="img/cross.png" width="12" /></a>
                          @endif
                        </td>
                        <td align="left">
                          <a data-toggle="modal" class="openModal" data-template_id="{{ $email_tmpl_row->email_template_id }}" onclick="openModal('{{ $email_tmpl_row->email_template_id }}')">
                            Edit </a>
                        </td>
                        <td align="left"><a href="javascript:void(0)" data-eml_tmpl_id="{{ $email_tmpl_row->email_template_id }}" class="deleteTemplate"><img src="img/cross.png" /></a></td>
                      </tr>
                    @endforeach
                    @endif
                    
                                       
                  </tbody>
                </table>
                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="clearfix"></div>
          
  
      </div>
    </section>
    <!-- /.content -->
  </aside>
            <!-- /.right-side -->
        
  </div>

        <!-- ./wrapper --> 


<!-- COMPOSE MESSAGE MODAL -->
{{ Form::open(array('url' => '/template/add_template', 'files' => true)) }}
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add an email template</h4>
        <div class="clearfix"></div>
      </div>
    <form action="#" method="post">
      <div class="modal-body">
        <div class="form-group">
          <div class="input_box_g">
            <label for="exampleInputEmail1">Template Name</label>
            <input type="text" class="form-control" name="add_name" id="add_name" placeholder="First Name">
          </div>
                                
          <div class="input_dropdown">
              <label>Type</label>
              <select class="form-control" name="add_template_type" id="add_template_type" onChange="getTemplate(this.value, 'add')">
                <option>Select Template Type</option>
               
                @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                
               <!-- @if(!empty($template_types))
                @foreach($template_types as $key=>$type_row)
                <option value="{{ $type_row->template_type_id }}">{{ $type_row->template_type_name }}</option>
                @endforeach
                @endif -->
              </select>
          </div>
          <div class="clearfix"></div>      
        </div>

        <div class="form-group">
            <div class="input_box_g">
              <label for="exampleInputEmail1">Message Subject</label>
              <input name="add_title" id="add_title" type="text" class="form-control" placeholder="Message Subject">
            </div>
            <div class="input_dropdown">
                <label>Insert Placeholder</label>
                <select class="form-control" id="addplaceholder">
                    <option value="option1">option 1</option>
                    <option value="option2">option 2</option>
                    <option value="option3"> option 3</option>
                    <option value="option4">option 4</option>
                    <option value="option5">option 5</option>
                </select>
            </div>
          <div class="clearfix"></div>     
        </div>

        <div class="form-group">
            <textarea name="add_message" id="add_message" class="form-control" placeholder="Message" style="height: 250px;"></textarea>
        </div>
        
      </div>
      <div class="modal-footer clearfix">
        <div class="form-group new_temp">                                
            <div class="btn btn-success btn-file">
                <i class="fa fa-paperclip"></i> Attachment
                <input type="file" name="add_file" id="add_file" />
            </div>
            <!-- <p class="help-block">Max. 32MB</p> -->
        </div>
        <div class="email_btns2">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" name="save" id="save" class="btn btn-primary pull-left save_t">Save</button>
        </div>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

</div>
{{ Form :: close() }}







<!-- Edit MESSAGE MODAL -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
  {{ Form::open(array('url' => '/template/edit-email-template', 'files' => true, 'id' => 'edit_form')) }}
<input type="hidden" name="edit_email_template_id" id="edit_email_template_id" value=""> 
<input type="hidden" name="hidd_file" id="hidd_file" value=""> 
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit an email template</h4>
        <div class="clearfix"></div>
      </div>
    <form action="#" method="post">
      <div class="modal-body">
        <div class="form-group">
          <div class="input_box_g">
            <label for="exampleInputEmail1">Template Name</label>
            <input type="text" class="form-control" id="edit_name" name="edit_name" value="">
          </div>
                                
          <div class="input_dropdown" id="type_dropdown">
              <label>Type</label>
              <select class="form-control" name="edit_template_type" id="edit_template_type" onChange="getTemplate(this.value, 'edit')">
                <option value="">Select Template Type</option>
                @if(!empty($template_types))
                @foreach($template_types as $key=>$type_row)
                <option value="{{ $type_row->template_type_id }}">{{ $type_row->template_type_name }}</option>
                @endforeach
                @endif
              </select>
          </div>
          <div class="clearfix"></div>      
        </div>

        <div class="form-group">
            <div class="input_box_g">
              <label for="exampleInputEmail1">Message Subject</label>
              <input name="edit_title" id="edit_title" type="text" class="form-control" value="">
            </div>
            <div class="input_dropdown">
                <label>Insert Placeholder</label>
                <select class="form-control" id="editplaceholder">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                </select>
            </div>
          <div class="clearfix"></div>     
        </div>

        <div class="form-group">
            <textarea name="edit_message" id="edit_message" class="form-control" style="height: 250px;"></textarea>
        </div>
      </div>
      <div class="modal-footer clearfix">
        <div class="form-group new_temp">                                
            <div class="btn btn-success btn-file">
                <i class="fa fa-paperclip"></i> Attachment
                <input type="file" name="edit_file" id="edit_file" />
            </div>
             <p class="help-block" id="edit_attach_file"></p> 
        </div>
        <div class="email_btns2">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" onclick="form_validation()" name="save" id="save" class="btn btn-primary pull-left save_t">Save</button>
        </div>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
{{ Form :: close() }}


</div>
<script src="ckeditor/ckeditor.js"></script>


@stop



