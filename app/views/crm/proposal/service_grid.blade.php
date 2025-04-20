@if($errors->has())
    <?php unset($editProduct); ?>
@endif

<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <!-- <div class="panel-heading" style="color:#fff;background-color:#0866C6;border-color:#0866C6;">
                <div style="width: 92%; float: left;"><i class="fa fa-list tiny-icon"></i> {{$content_header or ""}}</div>
                <div style="float: left;"><a href="javascript:void(0)" class="Servicepop431" data-prop_serv_id="0" data-type="P" data-action="add" style="color: #fff;">+New Service</a></div>

                <div style="float: left;"><a href="javascript:void(0)" class="Servicepop431" data-prop_serv_id="0" data-type="P" data-action="add" style="color: #fff;">+New Service</a></div>
                <div class="clearfix"></div>
            </div> -->

            <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;" id="primary_nav_wrap">
                <li class=""><a href="http://eweb.ipractice.com/crm/proposals"><i class="fa fa-list tiny-icon"></i> {{$content_header or ""}}</a></li>
                <li class=""><a href="javascript:void(0)" class="Servicepop431" data-prop_serv_id="0" data-type="P" data-action="add" style="color: #fff;">+New Service</a></li>

                <li style="float: right;">
                @if($is_archive == 'hide')
                    <a href="/crm/service/show">Show Archive</a>
                @else
                    <a href="/crm/service/hide">Hide Archive</a>
                @endif
                </li>


                </ul>

            <div class="panel-body">
                <div class="table-responsive" >
                    <div class="show_loader"></div>
                    <table class="table table-bordered table-striped table-hover" id="serviceTable">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th width="10%">Price</th>
                                <th width="10%">Tax Rate <a href="javascript:void(0)" class="tax_rate_open" data-is_archive="hide"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                <th width="35%">Activities</th>
                                <th width="7%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($ServicesTask) && count($ServicesTask) >0 )
                            @foreach($ServicesTask as $key=>$v)
                            <tr class="TaskServTablTr_{{ $v['service_id']}} {{($v['is_archive']=='Y')?'rowColor': '' }}" >
                                <td>*{{ ucwords(strtolower($v['service_name'])) }}</td>
                                <td>{{ !empty($v['price'])?number_format($v['price'], 2):'' }}</td>
                                <td>{{ (isset($v['tax_rate']) && $v['tax_rate']!='')?$v['tax_rate'].'%':'' }}</td>
                                <td>
                                    <div style="float: left;width: 10%; margin-right: 3px;"><a href="javascript:void(0)" class="activities_modal" data-type="T" data-prop_serv_id="0" data-service_id="{{ $v['service_id']}}" data-is_archive="hide"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
                                    <div style="float: left; width: 87%">
                                    <select class="form-control newdropdown">
                                        <option value="">-- Select --</option>
                                    @if(isset($v['activities']) && count($v['activities']) >0 )
                                        @foreach($v['activities'] as $key=>$a)  
                                            <option value="{{ $a['activity_id'] or '' }}">{{ $a['name'] or '' }} (£{{ $a['base_fee'] or '' }})</option>
                                        @endforeach
                                    @endif  
                                    </select>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                            <li>
                                                <a href="javascript:void(0)" data-type="T" data-prop_serv_id="0" data-service_id="{{ $v['service_id']}}" class="Servicepop431" data-action="edit"><i class="fa fa-edit tiny-icon"></i>Edit</a>
                                            </li>
                                            <li class="archiveLi_{{ $v['service_id']}}">
                                            @if(isset($v['status']) && $v['status'] == 'new' )
                                              @if($v['is_archive'] == 'N')
                                                <a href="javascript:void(0)" data-service_id="{{ $v['service_id']}}" class="deleteServicesSet" data-action="delete" data-table_name="services" data-column_name="service_id" data-update_value="Y"><i class="fa fa-trash-o tiny-icon"></i>Delete</a>
                                                
                                              @else
                                                <a href="javascript:void(0)" data-service_id="{{ $v['service_id']}}" class="deleteServicesSet" data-action="unarchive" data-table_name="services" data-column_name="service_id" data-update_value="N"><i class="fa fa-trash-o tiny-icon"></i>Un-Archive</a>
                                                
                                              @endif
                                            @endif
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            
                            @endforeach
                        @endif

                        @if(isset($ServicesProp) && count($ServicesProp) >0 )
                            @foreach($ServicesProp as $key=>$v)
                            @if(isset($v['service_id']) && $v['service_id'] =='0' )
                            <tr class="ServTablTr_{{ $v['prop_serv_id']}}">
                                <td>{{ $v['service_name'] or '' }}</td>
                                <td>{{ number_format($v['price'], 2) }}</td>
                                <td>{{ (isset($v['tax_rate']) && $v['tax_rate']!='')?$v['tax_rate'].'%':'' }}</td>
                                <td>
                                    <div style="float: left;width: 10%; margin-right: 3px;"><a href="javascript:void(0)" class="activities_modal" data-type="P" data-prop_serv_id="{{ $v['prop_serv_id']}}" data-service_id="{{ $v['service_id']}}" data-is_archive="hide"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
                                    <div style="float: left; width: 87%">
                                    <select class="form-control newdropdown">
                                        <option value="">-- Select --</option>
                                    @if(isset($v['activities']) && count($v['activities']) >0 )
                                        @foreach($v['activities'] as $key=>$a)  
                                            <option value="{{ $a['activity_id'] or '' }}">{{ $a['name'] or '' }}</option>
                                        @endforeach
                                    @endif  
                                    </select>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0)" data-type="P" data-prop_serv_id="{{ $v['prop_serv_id']}}" data-service_id="{{ $v['service_id']}}" class="Servicepop431" data-action="edit"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                            <li><a href="javascript:void(0)" class="deletePropService" data-id="{{ $v['prop_serv_id']}}" data-type="P"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        @endif
                        </tbody>
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