<!-- By PK -->

@extends('layouts.layout')

@section('myjsfile')
	<script src="{{URL :: asset('js/placeholders.js')}}"></script>
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
              <a class="btn btn-block btn-success" id="add_placeholder" data-toggle="modal" data-target="#compose-modal" style="width:124px;">
                <i class="fa fa-plus"></i> Add Placeholder</a>
            </li>
			
			<li>
              <a class="btn btn-block btn-success" href="{{url('placeholders/sync')}}" style="width:124px;">
              <i class="fa fa-refresh"></i> Synchronize</a>
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
						<th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Module</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Table</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Field</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Actions</th>
                     </tr>
                  </thead>
                  <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(!empty($placeholders))
                    @foreach($placeholders as $key=>$placeholder)
                      <tr>
						<td align="left">{{ $placeholder->id }}</td>
						<td align="left">{{ $placeholder->module }}</td>
						<td align="left">{{ $placeholder->table }}</td>
						<td align="left">{{ $placeholder->field }}</td>
						<td align="left">
							<a data-toggle="modal" class="edit_placeholder" data-url="{{url('placeholder')}}/{{$placeholder->id}}" data-placeholder_id="{{ $placeholder->id }}">
                            	Edit
							</a>
                        </td>
                        <td align="left">
							<a href="{{url('placeholder/delete')}}/{{$placeholder->id}}" data-placeholder_id="{{ $placeholder->id }}" class="do-with-ajax">
								<img src="{{url('img/cross.png')}}" />
							</a>
						</td>
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
{{ Form::open(array('url' => '/placeholder/add', 'files' => true)) }}
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Placeholder Details</h4>
        <div class="clearfix"></div>
      </div>
<!--    <form action="{{url('/email/template/add')}}" method="POST">-->
      <div class="modal-body">
		  <input type="hidden" name="placeholder_id" id="placeholder_id" value="">
		  <input type="hidden" name="baseurl" id="baseurl" value="{{url()}}">
        <div class="form-group">
          <div class="input_box_g">
            <label for="">Module</label>
            <input type="text" class="form-control" name="module" id="module" placeholder="Module Name">
          </div>
                                
          <div class="input_dropdown">
			  <label>Table</label>
              <select class="form-control" name="table_name" id="table_name" >
                <option>Select Table</option>
               
                @if(!empty($tables))
					@foreach($tables as $key=>$table)
						<option value="{{ $table->Tables_in_mpmsdb }}" >{{ $table->Tables_in_mpmsdb }}</option>
					@endforeach
                @endif
				
              </select>
          </div>
          <div class="clearfix"></div>      
        </div>

        <div class="form-group">
            <div class="">
			  <label>Field</label>
              <select class="form-control" name="field_name" id="field_name" required>
                <option>Select field</option>
               
                @if(!empty($fields))
					@foreach($fields as $key=>$field)
						<option value="{{ $field->name }}" >{{ $field->name }}</option>
					@endforeach
                @endif
				  
              </select>
          </div>
          <div class="clearfix"></div>     
        </div>
		
      </div>
      <div class="modal-footer clearfix">
        <div class="email_btns2">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" name="save" id="save" class="btn btn-primary pull-left save_t">Save</button>
        </div>
      </div>
   <!-- </form> -->
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
{{ Form :: close() }}

@stop



