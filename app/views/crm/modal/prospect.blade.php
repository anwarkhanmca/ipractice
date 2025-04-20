<div class="modal fade" id="open_form-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">NEW OPPORTUNITY</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/crm/save-leads-data', 'id'=>'saveProspectsForm')) }}
      <input type="hidden" name="saved_from" id="saved_from" value="{{ $saved_from or 'OPT' }}">
      <input type="hidden" name="encode_page_open" value="{{ $encode_page_open or '' }}">
      <input type="hidden" name="encode_owner_id" value="{{ $encode_owner_id or '' }}">
      <input type="hidden" name="type" id="type" value="">
      <input type="hidden" name="leads_id" id="leads_id" value="0">
      <input type="hidden" id="contactNameHid" value="">

      <div class="modal-body">
      <div class="show_loader"></div>
        <div class="form-group" style="margin:0;" id="row1">
          <div class="n_box12">
            <div class="form-group">
              <label for="exampleInputPassword1">Date</label>
              <input type="text" id="date" name="date" value="{{ $staff_row['date'] or '' }}" class="form-control">
            </div>
          </div>
          <div class="n_box11">
            <div class="form-group">
              <label for="deal_certainty">Probabilty</label>
              <input type="text" id="deal_certainty" name="deal_certainty" value="100" class="form-control box_60" maxlength="3"><span style="margin-top: 7px; float:left;">%</span>
            </div>
          </div>

          <div class="f_namebox2">
            <label for="exampleInputPassword1">Deal Owner</label>
              <select class="form-control" name="deal_owner" id="deal_owner">
                <option value="">-- None --</option>
                @if(isset($staff_details) && count($staff_details) >0)
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                  @endforeach
                @endif
             </select>
          </div>
          <div style="float: left; width: 36.8%">
            <label for="example">Attach Opportunity to Existing Client</label>
            <select class="form-control is_exists" name="is_exists" id="is_exists">
              <option value="N">-- No --</option>
              <option value="Y">-- Yes --</option>
             </select>
          </div>
          <div class="clearfix"></div>
        </div> 

        <div class="row" id="row3" style="display: none;">
          <div class="col-md-8">
            <div class="form-group">
              <label for="example">Client Name</label>
              <select class="form-control" name="existing_client" id="existing_client">
                <option value="">--Select --</option>
              </select>
            </div>
          </div>
          <div class="col-md-4" id="row10">
            <div class="form-group">
              <label for="exampleInputPassword1">Contact Name</label>
              <select class="form-control" name="contact_name" id="contact_name">
                <option value="">--Select --</option>
                
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>       

        <!-- <div class="twobox" id="org_name_div">
          <div class="twobox_1">
            <div class="form-group" style="width:57%" id="org_bsn_typ">
              <label for="exampleInputPassword1">Business Type <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></label>
              <select class="form-control" name="business_type" id="business_type">
                @if( isset($old_org_types) && count($old_org_types) >0 )
                  @foreach($old_org_types as $key=>$old_org_row)
                  <option value="{{ $old_org_row->organisation_id }}">{{ $old_org_row->name }}</option>
                  @endforeach
                @endif

                @if( isset($new_org_types) && count($new_org_types) >0 )
                  @foreach($new_org_types as $key=>$new_org_row)
                  <option value="{{ $new_org_row->organisation_id }}">{{ $new_org_row->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>

            <div class="form-group" style="width:57%; display:none;" id="org_cont_prsn">
              <label for="exampleInputPassword1">Contact Person</label>
              <select class="form-control" name="contact_person" id="contact_person">
                
              </select>
            </div>
            
          </div>

          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Prospect Name</label>
              <input type="text" class="form-control" name="prospect_name" id="prospect_name">
            </div>
          </div>
          <div class="clearfix"></div>
        </div> -->

        <div class="row" id="row2">
          <div class="col-md-9">
            <div class="form-group">
              <div style="width: 100%">
                <div class="cntdrop">Prospect Name</div>
                <div style="float: left; margin-left:135px;"><a href="https://beta.companieshouse.gov.uk" target="_blank">Companies house web check</a></div>
              </div>
              <input type="text" class="form-control" name="prospect_name" id="prospect_name">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" id="org_bsn_typ">
              <label for="exampleInputPassword1">Business Type <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></label>
              <select class="form-control" name="business_type" id="business_type">
                @if( isset($old_org_types) && count($old_org_types) >0 )
                  @foreach($old_org_types as $key=>$old_org_row)
                  <option value="{{$old_org_row->organisation_id}}">{{ $old_org_row->name }}</option>
                  @endforeach
                @endif

                @if( isset($new_org_types) && count($new_org_types) >0 )
                  @foreach($new_org_types as $key=>$new_org_row)
                  <option value="{{$new_org_row->organisation_id}}">{{ $new_org_row->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="row4">
          <div class="row">
            <div class="col-md-9">
              <label for="exampleInputPassword1">Opportunity Title</label>
              <input type="text" id="proposal_title" name="proposal_title" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="exampleInputPassword1">Amount</label>
              <input type="text" id="quoted_value" name="quoted_value" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="row11">
          <label for="example">Prospect Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="prospect_title" name="prospect_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="prospect_fname" name="prospect_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="prospect_lname" name="prospect_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="row12">
          <div class="row">
            <div class="col-md-3">
              <label for="example">Add Contact</label>
              <select class="form-control addContactType" id="addContact" name="addContact">
                <option value="N">New</option>
                <option value="E">Existing</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="example">Contact Type</label>
              <select class="form-control addContactType" id="contactType" name="contactType">
                <option value="A">Acting</option>
                <option value="NA">Non Acting</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="example">Position</label>
              <input type="text" id="position" name="position" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>

        <div class="form-group" id="row5">
          <div class="row">
            <div class="col-md-12">
              <label for="example">Contact Name</label>
              <select class="form-control contactPerson" name="contact_person" id="contact_person">
                <option value="">-- Select Contact --</option>
                <!-- @if( isset($clients) && count($clients) >0 )
                  @foreach($clients as $key=>$r1)
                    <option value="{{$r1['client_id']}}_R">{{ $r1['client_name'] }}</option>
                  @endforeach
                @endif
                @if( isset($contacts) && count($contacts) >0 )
                  @foreach($contacts as $key=>$r1)
                    <option value="{{$r1['contact_id']}}_C">{{ $r1['contact_name'] }}</option>
                  @endforeach
                @endif -->
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="row" id="row13">
          <div class="col-md-2">
            <div class="form-group">
              <label for="exampleInputPassword1">Contact Name</label>
              <select class="form-control select_title" id="contact_title" name="contact_title">
                <option value="">Title</option>
                @if(!empty($titles))
                  @foreach($titles as $key=>$title_row)
                  <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                  @endforeach
                @endif
              </select>
            </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="example">&nbsp;</label>
              <input type="text" id="contact_fname" name="contact_fname" class="form-control" placeholder="First Name">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="example">&nbsp;</label>
              <input type="text" id="contact_mname" name="contact_mname" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputPassword1">&nbsp;</label>
              <input type="text" id="contact_lname" name="contact_lname" class="form-control" placeholder="Last Name">
            </div> 
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="row" id="row6">
          <div class="col-md-4">
              <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" >
              </div> 
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputPassword1">Mobile</label>
              <input type="text" id="mobile" name="mobile" class="form-control" >
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="exampleInputPassword1">Email</label>
              <input type="text" id="email" name="email" class="form-control" >
            </div> 
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox" id="row7">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Lead Source <a href="javascript:void(0)" class="lead_source-modal"> <i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></label>
              <select class="form-control select_title" id="lead_source" name="lead_source">
                <option value="0">-- None --</option>
                @if(isset($old_lead_sources) && count($old_lead_sources) >0)
                  @foreach($old_lead_sources as $key=>$lead_row)
                    <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                  @endforeach
                @endif
                @if(isset($new_lead_sources) && count($new_lead_sources) >0)
                  @foreach($new_lead_sources as $key=>$lead_row)
                    <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                  @endforeach
                @endif
              </select>
            </div> 
          </div>

          <div class="twobox_2" id="row8">
            <!-- <div class="form-group">
              <label for="exampleInputPassword1">Industry</label>
              <select class="form-control select_title" id="industry" name="industry">
                <option value="0">-- None --</option>
                @if(isset($industry_lists) && count($industry_lists) >0)
                  @foreach($industry_lists as $key=>$industry_row)
                    <option value="{{ $industry_row['industry_id'] }}">{{ $industry_row['industry_name'] }}</option>
                  @endforeach
                @endif
              </select>
            </div> -->
          </div>
          <div class="clearfix"></div>
        </div>

        <div id="row9"><!-- not_exists_div-->
          <div class="twobox">
            <div class="twobox_1">
                <div class="form-group">
                  <label for="exampleInputPassword1">Annual Revenue</label>
                  <input type="text" id="annual_revenue" name="annual_revenue" class="form-control" >
                </div> 
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Website</label>
                <input type="text" id="website" name="website" class="form-control" >
              </div>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <label for="addr1">Select &nbsp; <a javascript:void(0) class="newAddress" data-address_type="res" data-page_name="{{ $page_name or '' }}">New</a> |   
            <a javascript:void(0) class="editAddress" data-address_type="res" data-page_name="{{ $page_name or '' }}">Edit</a> | <a javascript:void(0) class="deleteAddress" data-address_type="res">Delete</a> | 
            <a javascript:void(0) class="copyAddress" data-address_type="res">View</a></label>   
            <select class="form-control get_orgoldcont_address" id="res_address" name="res_address" data-type="res">
              <option value="">-- Select Address --</option>
              @if(isset($cont_address) && count($cont_address)>0)
                @foreach($cont_address as $key=>$ar)
                  <option value="{{ $ar['address_id'] }}">{{ $ar['fullAddress'] or '' }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Notes</label>
          <textarea class="form-control" rows="4" name="notes" id="notes"></textarea>
        </div>

        <div class="clearfix"></div>
      </div>
      
      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info" id="saveProspectsPop">Save</button>
        </div>
      </div>
      {{ Form::close() }}
    
  </div>
  </div>
</div>


<div class="modal fade" id="SecondPlusA-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add/Edit Contact</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'saveContactForm')) }}
      <input type="hidden" name="savedFromA" id="savedFromA" value="{{ $saved_from or '' }}">
      <input type="hidden" name="action" value="saveNewContact">
      <input type="hidden" name="secDropVal" id="secDropVal" value="">
      <input type="hidden" name="contactTypeSec" id="contactTypeSec" value="contact_name">
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="col-md-12 bottom10">
          <div class="col-md-6">
            <label for="exampleInputPassword1">Contact Type</label>
            <select class="form-control" id="cntTypeSecPlus" name="contact_type">
              <option value="1">Client Contact</option>
              <option value="2">Non - Client Officer</option>
              <option value="3">Non - Client Other</option>
            </select>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="col-md-12 bottom10">
          <div class="col-md-3">
            <label for="exampleInputPassword1">Title</label>
            <select class="form-control" id="" name="contact_title">
              <!-- <option value="">-- Title --</option> -->
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="col-md-3">
            <label for="exampleInputPassword1">First Name</label>
            <input type="text" class="form-control" name="contact_fname">
          </div>
          <div class="col-md-3">
            <label for="exampleInputPassword1">Middle Name</label>
            <input type="text" class="form-control" name="contact_mname">
          </div>
          <div class="col-md-3">
            <label for="exampleInputPassword1">Last Name</label>
            <input type="text" class="form-control" name="contact_lname">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="col-md-12 bottom10">
          <div class="col-md-6">
            <label for="exampleInputPassword1">Telephone</label>
            <input type="text" class="form-control" name="contact_telephone">
          </div>
          <div class="col-md-6">
            <label for="exampleInputPassword1">Mobile</label>
            <input type="text" class="form-control" name="contact_mobile">
          </div>
        </div>

        <div class="col-md-12 bottom10">
          <div class="col-md-12">
            <label for="exampleInputPassword1">Email</label>
            <input type="text" class="form-control" name="contact_email">
          </div>
        </div>

        <div class="col-md-12 bottom10">
          <div class="col-md-12">
            <label for="exampleInputPassword1">Company Name</label>
            <select class="form-control disable_click" id="secPlusPopCompanyName" name="company_name">
              @if(!empty($allOrgClients))
                @foreach($allOrgClients as $k=>$v)
                  <option value="{{ $v['client_id'] or '' }}">{{ $v['client_name'] or '' }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>

        <div class="col-md-12 bottom10">
          <div class="col-md-12">
            <div style="width: 100%">
              <div class="cntdrop1">Select</div>
              <div style="float: left;">
                <a href="javascript:void(0)" class="newAddress" data-address_type="other" data-page_name="proposal">New</a> | 
                <a href="javascript:void(0)" class="editAddress" data-address_type="other" data-page_name="proposal">Edit</a><!--  | 
                <a href="javascript:void(0)" class="deleteAddress" data-address_type="other">Delete</a> | <a href="javascript:void(0)" class="copyAddress" data-address_type="other">View</a> --></div>
            </div>
            <select class="form-control get_orgoldcont_address" id="other_address" name="address_id" data-type="other">
              <option value="">-- Select Address --</option>
              @if(isset($cont_address) && count($cont_address)>0)
                @foreach($cont_address as $key=>$address_row)
                  <option value="{{ $address_row['address_id'] }}" {{ (isset($client_details['trad_address']) && $client_details['trad_address'] == $address_row['address_id'])?"selected='selected'":""}}>{{ $address_row['fullAddress'] }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>

        <div class="col-md-12 bottom10">
          <div class="col-md-12">
            <label for="exampleInputPassword1">Position</label>
            <div id="posTextSecP" style="display: none;">
              <input type="text" class="form-control" name="positionText">
            </div>
            <div id="posSelectSecP">
              <select class="form-control" id="" name="positionDrop">
              <!-- <option value="">-- Select Position --</option> -->
              @if(isset($relationTypes) && count($relationTypes)>0)
                @foreach($relationTypes as $k=>$v)
                  <option value="{{ $v['relation_type_id'] or '' }}">{{ $v['relation_type'] or '' }}</option>
                @endforeach
              @endif
            </select>
            </div>
            
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      
      <div class="modal-footer" style="border-top: none; padding-top: 0;">
        <div class="col-md-12">
          <div class="col-md-12 col-md-offset-9">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2" id="saveSecPlusPop">Save</button>
          </div>
        </div>
      </div>
      {{ Form::close() }}
    
  </div>
  </div>
</div>