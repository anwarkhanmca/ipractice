@extends('layouts.layout')

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                         @include('layouts.outer_leftside')
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

                
                {{ Form::open(array('url' => '/profile-update', 'files' => true)) }} 
                <section class="content">
					<div class="practice_mid">
						<div class="col-xs-12 col-xs-6">
							<div class="col_m2">
								<div class="twobox">
									<div class="twobox_1">
										<div class="form-group">
									        <label for="exampleInputPassword1">First Name</label>
				                            <input type="text" id="fname" name="fname" class="form-control" value="{{ $admin_details['fname'] or "" }}">
										</div>
									</div>
									<div class="twobox_2">
										<label for="exampleInputPassword1">Last Name</label>
										<input type="text" id="lname" name="lname" class="form-control" value="{{ $admin_details['lname'] or "" }}">
									</div>
									<div class="clearfix">
									</div>
								</div>
								<div class="twobox">
									<div class="twobox_1">
										<div class="form-group">
											<label for="exampleInputPassword1">Phone
											</label>
											<input type="text" id="phone" name="phone" class="form-control" value="{{ $admin_details['phone'] or "" }}">
										</div>
									</div>
									<div class="twobox_2">
										<label for="exampleInputPassword1">Website</label>
										<input type="text" id="website" name="website" class="form-control" value="{{ $admin_details['website'] or "" }}">
									</div>
									<div class="clearfix">
									</div>
								</div>
                                
                                <div class="twobox">
									<div class="twobox_2">
										<label for="exampleInputPassword1">Country</label>
										<select class="form-control" id="country" name="country">
                                            @if(!empty($coun))
                                              @foreach($coun as $key=>$country_row)
                                              @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                                                <option value="{{ $country_row->country_id }}" {{ ($country_row->country_id == $admin_details['country'])?'selected':''}}>{{ $country_row->country_name }}</option>
                                              @endif
                                              @endforeach
                                            @endif
                                            @if(!empty($coun))
                                              @foreach($coun as $key=>$country_row)
                                              @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                                                <option value="{{ $country_row->country_id }}" {{ ($country_row->country_id == $admin_details['country'])?'selected':''}}>{{ $country_row->country_name }}</option>
                                              @endif
                                              @endforeach
                                            @endif
                                        </select>
									</div>
									<div class="clearfix">
									</div>
								</div>
								
								<div class="add_client_btn" style="margin-right: 8px;">
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
								<div class="clearfix">
								</div>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>
				</section>
                {{ Form::close() }}

                <!-- Main content -->

                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop