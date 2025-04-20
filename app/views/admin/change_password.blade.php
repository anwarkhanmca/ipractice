@extends('layouts.layout')

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    @include('layouts/inner_leftside')
                    
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

                
  {{ Form::open(array('url' => '/new-pass', 'files' => true)) }} 
  <section class="content">
     
     <div class="practice_mid">
     <div class="col-xs-12 col-xs-6">
     <div class="col_m2">
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                 @if ( $errors->count() > 0 )
                    <ul>
                        @foreach( $errors->all() as $message )
                          <li style="color: red ;">{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
                              <div id="message" style="color: red;font-size: 15px;">{{ Session::get('message') }} </div> 
                              <div id="message_su" style="color: green ;font-size: 15px;">{{ Session::get('message_su') }}</div> 
                              
               
                                  <label for="exampleInputPassword1">Old password</label>
                                  <input type="text" id="old_password" name="old_password" class="form-control">
                                </div>
                              </div>
                              <div class="twobox_2">
                                
                              </div>
                              <div class="clearfix"></div>
                            </div>
                            
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">New Password</label>
                                  <input type="text" id="new_password" name="new_password" class="form-control">
                                </div>
                              </div>
                             
                              <div class="clearfix"></div>
                            </div>
                            <div class="twobox">
                              <div class="twobox_1">
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Confirm Password.</label>
                                  <input type="text" id="conform_password" name="conform_password" class="form-control">
                               
                               
                                </div>
                              </div>
                              
                              
                              
                              
                              <div class="clearfix"></div>
                            </div>
                            <div class="add_client_btn">
                            
                             <button type="submit" class="btn btn-primary">save</button>
                             
                               </a>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                         
	</div>  <div class="clearfix"></div>    
     </div>
     
   
     
    </section>
                {{ Form::close() }}

                <!-- Main content -->

                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop