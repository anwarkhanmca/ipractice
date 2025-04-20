<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW FIELD</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/individual/save-userdefined-field', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org" />
    <input type="hidden" name="back_url" value="add_org" />
    <input type="hidden" name="added_from" id="added_from" value="editclient">
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputPassword1">Select Section</label>
          <select class="form-control show_subsec" name="step_id" id="step_id" data-client_type="org">
            @if( isset($steps) && count($steps) >0 )
              @foreach($steps as $key=>$step_row)
                @if($step_row->step_id != '4' && $step_row->status == "old")
                  <option value="{{ $step_row->step_id }}">{{ ($step_row->step_id == 1)?"BUSINESS INFORMATION":$step_row->title }}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Subsection Name</label>
          <select class="form-control subsec_change" name="substep_id" id="substep_id">
            <option value="">-- Select sub section --</option>
            @if( isset($substep) && count($substep) >0 )
              @foreach($substep as $key=>$step_row)
                <option value="{{ $step_row->step_id }}">{{ $step_row->title }}</option>
              @endforeach
            @endif
            <option value="new">Add new ...</option>
          </select>
        </div>
        <div class="input-group show_new_div" style="display:none;">
            <input type="text" class="form-control" name="subsec_name" id="subsec_name">
           <span class="input-group-addon"> <a href="javascript:void(0)" class="add_subsec_name" data-client_type="org">Save<!-- <i class="fa fa-plus"></i> --></a></span>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Field Name</label>
          <input type="text" id="field_name" name="field_name" class="form-control">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Field Type</label>
          <select class="form-control user_field_type" name="field_type" id="field_type">
            @if(!empty($field_types))
              @foreach($field_types as $key=>$field_row)
                <option value="{{ $field_row->field_type_id }}">{{ $field_row->field_type_name }}</option>
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group" style="display:none;" id="show_select_option">
          <label for="exampleInputPassword1">Options</label>
          <textarea name="select_option" cols="40" rows="3"></textarea>
          Give options width ',' separator
        </div>
        
        <div class="modal-footer1 clearfix">
          <div class="email_btns1">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info pull-left save_text" name="save">Save</button>
          </div>
        </div>
      </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- add/edit list -->
<div class="modal fade" id="addcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-business-type', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" id="client_type" value="org">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="org_name" name="org_name" placeholder="Business Type" class="txtlft form-control">
        <button type="button" class="btn btn-info pull-left save_t" data-client_type="org" id="add_business_type" name="save">Add</button>
        <div class="clearfix"></div>
      </div>
      
      <div id="append_bussiness_type">
      @if( isset($old_org_types) && count($old_org_types) >0 )
        @foreach($old_org_types as $key=>$old_org_row)
        <div class="pop_list form-group">
          {{ $old_org_row->name }}
        </div>
        @endforeach
      @endif

      @if( isset($new_org_types) && count($new_org_types) >0 )
        @foreach($new_org_types as $key=>$new_org_row)
        <div class="pop_list form-group" id="hide_div_{{ $new_org_row->organisation_id }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_org_name" data-field_id="{{ $new_org_row->organisation_id }}"><img src="/img/cross.png" width="12"></a>
          {{ $new_org_row->name }}
        </div>
        @endforeach
      @endif
      </div>
      
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_business_type" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- Vat Scheme Modal -->
<div class="modal fade" id="vatScheme-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="vat_scheme_name" id="vat_scheme_name" placeholder="Vat Scheme" class="form-control txtlft">
        <button type="button" class="btn btn-info pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Add</button>
        <div class="clearfix"></div>
      </div>
      
      <div id="append_vat_scheme">
        @if( isset($old_vat_schemes) && count($old_vat_schemes) )
          @foreach($old_vat_schemes as $key=>$scheme_row)
            <div class="form-group pop_list">
              {{ $scheme_row->vat_scheme_name }}
            </div>
          @endforeach
        @endif

        @if( isset($new_vat_schemes) && count($new_vat_schemes) )
          @foreach($new_vat_schemes as $key=>$scheme_row)
            <div class="form-group" id="hide_vat_div_{{ $scheme_row->vat_scheme_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_vat_scheme" data-field_id="{{ $scheme_row->vat_scheme_id }}"><img src="/img/cross.png" width="12"></a>
              {{ $scheme_row->vat_scheme_name }}
            </div>
          @endforeach
        @endif
      </div>
     
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- Services Modal Start-->
<div class="modal fade" id="services-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-services', 'id'=>'field_form')) }}
    <div class="modal-body">
    <div class="loader_show"></div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="service_name" id="service_name" placeholder="Service Name" class="form-control txtlft">
        <button type="button" class="btn btn-info pull-left save_t" id="save_services" name="save">Add</button>
        <div class="clearfix"></div>
      </div>

      <div id="append_services">
      @if( isset($old_services) && count($old_services)>0 )
        @foreach($old_services as $key=>$service_row)
          <div class="form-group pop_list">{{ $service_row->service_name }}</div>
        @endforeach
      @endif
      @if( isset($new_services) && count($new_services)>0 )
        @foreach($new_services as $key=>$service_row)
          <div class="pop_list form-group" id="hide_service_div_{{ $service_row->service_id }}">
            <a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a>
            {{ $service_row->service_name }}
          </div>
        @endforeach
      @endif
      </div>
     
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" id="save_services" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Services Modal End-->


<!-- Add Subsec Modal Start-->
<div class="modal fade" id="addsubsec-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-services', 'id'=>'field_form')) }}
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="service_name" placeholder="Service Name" class="form-control">
      </div>

      @if(!empty($services))
        @foreach($services as $key=>$service_row)
          <div class="form-group">
            <a href="javascript:void(0)" title="Delete Field ?" class="delete_services" data-field_id="{{ $service_row->service_id }}"><img src="/img/cross.png" width="12"></a>
            <label for="{{ $service_row->service_id }}">{{ $service_row->service_name }}</label>
          </div>
        @endforeach
      @endif
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="submit" class="btn btn-info pull-left save_t" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Add Subsec Modal End-->


<!-- Relationship Add To List Modal Start-->
<div class="modal fade" id="add_to_list-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:404px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to Relationships</h4>
        <div class="clearfix"></div>
      </div>
    <input type="hidden" id="non_rel_client_id" value="">
    <input type="hidden" id="addOtherEntity" value="">
    
      <div class="modal-body">
        <div id="add_to_msg_div" style="text-align: center; color: #00acd6"></div>
        <div class="form-group" style="width:70%">
          <label for="name">Entity Type</label>
          <select class="form-control" name="add_to_type" id="add_to_type">
            <option value="ind">Individual</option>
            <option value="org">Organisation</option>
          </select>
        </div>

        <div class="form-group" style="width:70%">
            <label for="name">Relationship Type</label>
        <select class="form-control" name="officer_rel__type_id" id="officer_rel__type_id">
            @if(!empty($rel_types))
              @foreach($rel_types as $key=>$rel_row)
              <option value="{{ $rel_row->relation_type_id }}">{{ $rel_row->relation_type }}</option>
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group" id="add_to_client_text">

          <div class="clearfix"></div>
          <div class="n_box18_18">
          <label for="exampleInputPassword1">Title</label>
            <select class="form-control select_title" id="add_to_title" name="add_to_title">
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                  <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="n_box27_27">
            <label for="exampleInputPassword1">First Name</label>
            <input type="text" id="add_to_fname" name="add_to_fname" value="" class="form-control toUpperCase">
          </div>
          <div class="n_box22_22">
            <label for="exampleInputPassword1">Middle Name</label>
            <input type="text" id="add_to_mname" name="add_to_mname" value="" class="form-control toUpperCase">
          </div>
          <div class="n_box27_27">
            <label for="exampleInputPassword1">Last Name</label>
            <input type="text" id="add_to_lname" name="add_to_lname" value="" class="form-control toUpperCase">
          </div>
          <div class="clearfix"></div>
          </div>

        <div class="form-group" style="width:70%; display:none;" id="add_to_business">
          <label for="name">Business Name</label>
          <input class="form-control toUpperCase" type="text" name="add_to_name" id="add_to_name">
        </div>
       
        <div class="modal-footer1 clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-info pull-left save_t relation_add_client" id="add_to_save" name="save">Save</button>
            <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Relationship Add To List Modal End-->

<!-- Officers Details Modal Start-->
<div class="modal fade" id="officers_details-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div> -->
      </div>

    <div class="modal-body">
      <table width="100%" border="1" bordercolor="60aad2" class="officer_table">
          <tr class="td_color">
            <td align="center" colspan="4"><span class="table_tead_t">OFFICERS</span></td>
          </tr>
          <tr class="td_color">
            <td align="center" class="sub_header">Name</td>
            <td align="center" class="sub_header">Role</td>
            <td align="center" class="sub_header">Appointment Date</td>
            <td align="center" width="20%" class="sub_header">Add to Relationships</td>
          </tr>

        <!-- @if(isset($relationship) && count($relationship) >0 )
            @foreach($relationship as $key=>$relation_row)
              <tr id="database_tr{{ $relation_row['client_relationship_id'] }}">
                <td width="40%">{{ $relation_row['name'] or "" }}</td>
                <td width="40%" align="center">{{ $relation_row['relation_type'] }}</td>
                
                <td width="20%" align="center">
                    <div class="officer_selectbox">
                        <span>+ Add</span>
                        <div class="small_icon" data-id="{{ $relation_row['client_relationship_id'] }}"></div>
                        <div class="clr"></div>
                        <div class="select_toggle" id="status{{ $relation_row['client_relationship_id'] }}">
                          <ul>
                            <li data-value="org"><a href="{{ $relation_row['link'] }}" target="_blank">NEW CLIENT</a></li>
                            <li data-value="non"><a href="javascript:void(0)" data-relation_id="{{ $relation_row['client_relationship_id'] }}" class="officer_addto_relation">NON - CLIENT</a></li>
                          </ul>
                        </div>
                    </div>
                </td>
              </tr>
            @endforeach
        @endif -->
        </table>
    </div>

  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Officers Details Modal End-->


<!-- Relationship Client Modal Start-->
<div class="modal fade" id="relation_client-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:30%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">Related Organisations</h3>
        <div class="clearfix"></div>
      </div>

    <div class="modal-body" style="padding-top: 0px;">
      @if(isset($relation_list) && count($relation_list) >0 )
        @foreach($relation_list as $key=>$relation_row)
          <p><input type="checkbox" class="user_client_relation" data-related_company_id="{{ $relation_row['related_company_id'] or "" }}" name="other_related_client[]" {{ (isset($relation_row['status']) && $relation_row['status'] == "A")?"checked":"" }} value="{{ $relation_row['client_id'] or "" }}">&nbsp;<strong>{{ $relation_row['client_name'] or "" }}</strong></p>
        @endforeach
      @endif
    </div>

  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Relationship Client Modal End-->

<!-- View Share Holders Details Modal Start-->
<div class="modal fade" id="view_shareholders-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:45%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div> -->
      </div>

    <div class="modal-body">
      <table width="100%" border="1" bordercolor="60aad2" class="shareholder_table">
          <tr class="td_color">
            <td align="center" colspan="3"><span class="table_tead_t">View Shareholders</span></td>
          </tr>
          <tr class="td_color">
            <td align="center" class="sub_header">Date</td>
            <td align="center" class="sub_header">Category</td>
            <td align="center" width="20%" class="sub_header">View/Download</td>
          </tr>

        </table>
    </div>

  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- View Share Holders Details Modal End-->

<!-- Activity History Start -->
<div class="modal fade" id="activity_history-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1150px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align: center;"></h4>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body">
        <div class="row">
          
        </div>
        <div class="row">
          <div class="col-xs-12">
              <div class="row bottom_space">
                <div class="col-xs-7" style="text-align: right;font-size: 20px; padding-right: 40px">
                  Activity History
                </div>
                <div class="col-xs-5">
                  <div class="dataTables_filter">
                    <form>
                      <input type="text" name="actHstrySearchText" id="actHstrySearchText" placeholder="Search" class="tableSearch" />
                      <!-- <button type="submit" id="actHstrySearchButton" style="display:none;">Search</button> -->
                    </form>
                  </div>
                </div>
              </div>
              <div id="actHstryTable"></div>
          </div>
        </div>
      
      </div>
    </div>
  </div>
</div>
<!-- Activity History End -->

<!-- Notes modal start -->
<div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <!-- <input type="hidden" id="notes_client_id" name="notes_client_id"> -->
        <input type="hidden" id="renewal_id" name="renewal_id">
        <input type="hidden" id="action" name="action">
        <table style="width: 100%">
          <tr>
            <td align="left" width="20%"><strong>Title : </strong></td>
            <td align="left"><input type="text" name="notes_title" id="notes_title" class="form-control" style="width:200px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="2">&nbsp;</td>
          </tr>

          <tr>
            <td align="left"><strong>Notes : </strong></td>
            <td align="left"><textarea cols="56" rows="4" id="new_notes" name="new_notes" class="form-control"></textarea></td>
          </tr>
          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>&nbsp;
              <a href="javascript:void(0)" class="btn btn-info save_notes" data-client_id="{{ $client_details['client_id'] or "" }}" data-added_from="N">Save</a>
            </td>
          </tr>
        </table>
      </div>
    
    </div>
  </div>
</div>        
<!-- Notes modal End -->

<!-- Activity Notes modal start -->
<div class="modal fade" id="activity_notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="loader_class"></div>
        <!-- <input type="hidden" id="notes_client_id" name="notes_client_id"> -->
        <input type="hidden" id="store_id" name="store_id" value="0">
        <table style="width: 100%">
          <tr>
            <td align="left"><strong>Notes : </strong></td>
            <td align="left"><textarea cols="56" rows="4" id="activity_notes" name="activity_notes" class="form-control"></textarea></td>
          </tr>
          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="right">
              <a href="javascript:void(0)" class="btn btn-info saveActivityNotes">Save</a>
            </td>
          </tr>
        </table>
      </div>
    
    </div>
  </div>
</div>        
<!-- Activity Notes modal End -->

<!-- Log a Call modal start -->
<div class="modal fade" id="logacall-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">LOG A CALL</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="log_renewal_id" name="log_renewal_id">
        <input type="hidden" id="log_action" name="log_action">
        <table>
          <tbody>
          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Title : </strong></td>
            <td align="left"><input id="logacall_title" name="logacall_title" class="form-control addto_date" style="width:180px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Date : </strong></td>
            <td align="left"><input id="calender_date" name="calender_date" class="form-control addto_date" style="width:180px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Time : </strong></td>
            <td align="left"><input id="calender_time" name="calender_time" class="form-control" style="width:180px;"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="5%">&nbsp;</td>
            <td align="left" width="20%"><strong>Notes : </strong></td>
            <td align="left"><textarea cols="56" rows="4" id="log_notes" name="log_notes" class="form-control"></textarea></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" colspan="2" width="5%"></td>
            <td align="right"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> &nbsp;<button type="button" class="btn btn-info save_notes" data-client_id="{{ $client_details['client_id'] or "" }}" data-added_from="L">Save</button></td>
          </tr>
        </tbody></table>
      </div>
    
    </div>
  </div>
</div>        
<!-- Log a Call modal End -->

<!-- New Address start -->
<!-- <div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add/Edit Address</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader"></div>
      <form method="post" action="/client/save-client-address" name="address_form" id="address_form">
        <input type="hidden" id="address_id" name="address_id">
        <input type="hidden" id="address_type" name="address_type">
        <input type="hidden" id="link" name="link" value="/organisation/add-client">
        <table>
          <tr>
            <td align="left" width="25%"><strong>Address Line 1 : </strong></td>
            <td align="left"><input type="text" class="form-control" name="address1" id="address1"></td>
          </tr>
          <tr>
            <td align="left" width="25%"><strong>Address Line 2 : </strong></td>
            <td align="left"><input type="text" class="form-control" name="address2" id="address2"></td>
          </tr>

          <tr>
            <td align="left" width="25%"><strong>City : </strong></td>
            <td align="left"><input type="text" class="form-control" name="address_city" id="address_city"></td>
          </tr>
          <tr>
            <td align="left" width="25%"><strong>County : </strong></td>
            <td align="left"><input type="text" class="form-control" name="address_county" id="address_county"></td>
          </tr>
          <tr>
            <td align="left" width="25%"><strong>PostCode : </strong></td>
            <td align="left"><input type="text" class="form-control" name="address_postcode" id="address_postcode"></td>
          </tr>
          <tr>
            <td align="left" width="25%"><strong>Country : </strong></td>
            <td align="left">
            <select class="form-control" id="address_country" name="address_country">
              @if(!empty($countries))
                @foreach($countries as $key=>$country_row)
                @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                  <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
                @endif
                @endforeach
              @endif
              @if(!empty($countries))
                @foreach($countries as $key=>$country_row)
                @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                  <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
                @endif
                @endforeach
              @endif 
              </select>  
            </td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>&nbsp;
              <a href="javascript:void(0)" class="btn btn-info save_new_address" >Save</a>
            </td>
          </tr>
        </table>
      </form>
      </div>
    
    </div>
  </div>
</div> -->        
<!-- New Address modal End -->



<!-- Contact Information New Contact pop up -->
@include("contacts_letters.modal")



