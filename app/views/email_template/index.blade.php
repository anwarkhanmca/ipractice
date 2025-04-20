<!-- By PK -->

@extends('layouts.layout')

@section('myjsfile')
	<!--<script src="http://cdn.ckeditor.com/4.5.2/standard-all/ckeditor.js"></script>-->
	<script src="{{url('ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{url()}}/js/contact_email_templates.js"></script>
	<script src="{{ URL :: asset('js/template_type.js') }}" type="text/javascript"></script>
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
              <a class="btn btn-block btn-success" href="/email/template/add" style="width:124px;">
                <i class="fa fa-plus"></i> Add template</a>
            </li>

            <li>
              <button class="btn btn-info">UPLOAD LETTERHEAD</button>
            </li>
            
			<li>
              <a class="btn btn-block btn-success" href="{{url('/placeholders')}}" style="width:124px;">
                <i class="fa fa-code"></i> Placeholders</a>
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
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Type</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name</th>
                      <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Actions</th>
                     </tr>
                  </thead>
                  <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(!empty($templates))
                    @foreach($templates as $key=>$template)
                      <tr>
						<td align="left">{{ $template->id }}</td>
						<td align="left">{{ $template->type }}</td>
						<td align="left">{{ $template->name }}</td>
						<td align="left">
							<!--<a href="{{url('email/template/edit')}}/{{$template->id}}" data-toggle="modal" class="edit_template" data-url="{{url('email/template/getdetails/')}}/{{$template->id}}" data-template_id="{{ $template->id }}">-->
							<a href="{{url('email/template/edit')}}/{{$template->id}}" class="edit_template" data-template_id="{{ $template->id }}">
                            	Edit
							</a>
                        </td>
                        <td align="left">
							<a href="{{url('email/template/delete')}}/{{$template->id}}" data-template_id="{{ $template->id }}" class="do-with-ajax">
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

@stop



