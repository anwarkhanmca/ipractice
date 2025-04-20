<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="add_contact-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add/ Edit Contact</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/contacts/insert-contact-details', 'id'=>'AddContactForm')) }}
    <input type="hidden" name="tab_index" value="{{ $step_id or "" }}">
    <input type="hidden" name="encoded_type" value="{{ $encoded_type or "" }}">
    <input type="hidden" name="contact_id" id="contact_id" value="">
    <input type="hidden" name="AddedFrom" id="AddedFrom" value="">
    <input type="hidden" name="popupType" id="popupType" value="C">
    <input type="hidden" name="reference_client_id" id="reference_client_id" value="0">

    <div class="modal-body">
      <div class="show_loader"></div>
      <div class="twobox" id="fileCntctASDv">
      <div class="twobox_1">
        <div class="form-group">
          <label for="exampleInputPassword1">File Contact as</label>
          <select class="form-control" name="contact_type" id="contact_type">
            <option value="company_name">Company Name</option>
            <option value="contact_name">Contact Name</option>
          </select> 
        </div>
      </div>

      <div class="twobox_2">
        
      </div>
      <div class="clearfix"></div>
    </div>

    <!-- <div class="form-group">
      <label for="exampleInputPassword1">Contact Name</label>
      <input type="text" id="contact_name" name="contact_name" class="form-control">
    </div> -->
    <div class="form-group">
      <div class="n_box1">
        <label for="exampleInputPassword1">Title</label>
        <select class="form-control select_title" id="contact_title" name="contact_title">
          @if(!empty($titles))
            @foreach($titles as $key=>$title_row)
            <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="n_box2">
        <label for="exampleInputPassword1">First Name</label>
        <input type="text" id="contact_fname" name="contact_fname" class="form-control toUpperCase"></div>
      <div class="n_box3">
        <label for="exampleInputPassword1">Middle Name</label>
        <input type="text" id="contact_mname" name="contact_mname" class="form-control"></div>
      <div class="n_box4">
        <label for="exampleInputPassword1">Last Name</label>
        <input type="text" id="contact_lname" name="contact_lname" class="form-control toUpperCase"></div>
      <div class="clearfix"></div>
    </div>

    <div class="twobox">
      <div class="twobox_1">
        <div class="form-group">
          <label for="exampleInputPassword1">Telephone</label>
          <input type="text" id="telephone" name="telephone" class="form-control">
        </div>
      </div>

      <div class="twobox_49">
        <div class="form-group">
          <label for="exampleInputPassword1">Mobile</label>
          <input type="text" id="mobile" name="mobile" class="form-control">
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Email</label>
      <input type="text" id="email" name="email" class="form-control">
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Company Name</label>
      <!-- <input type="text" id="company_name" name="company_name"  class="form-control"> -->
      <select class="form-control" id="Company_id" name="Company_id">
        @if(isset($ContactCompany) && count($ContactCompany)>0)
          @foreach($ContactCompany as $key=>$r)
            <option value="{{$r['client_id'] or ''}}">{{$r['client_name'] or '' }}</option>
          @endforeach
        @endif
      </select>  
    </div>

    <div class="form-group">
      <div style="width: 100%">
        <div class="cntdrop1">Select</div>
        <div style="float: left;">
          <a href="javascript:void(0)" class="newAddress" data-address_type="{{ $type or '' }}" data-page_name="{{ $page_name or '' }}">New</a> | 
          <a href="javascript:void(0)" class="editAddress" data-address_type="{{ $type or '' }}" data-page_name="{{ $page_name or '' }}">Edit</a> | 
          <a href="javascript:void(0)" class="deleteAddress" data-address_type="{{ $type or '' }}">Delete</a> | <a href="javascript:void(0)" class="copyAddress" data-address_type="{{ $type or '' }}">View</a></div>
      </div>
      <!-- <select class="form-control change_address" name="address" id="address">
        <option value="">-- Select --</option>
        @if(!empty($all_address))
          @foreach($all_address as $key=>$r)
            <option value="{{ $r['address_type'] or "" }}_{{$r['address_id']}}">{{$r['fullAddress'] }}</option>
          @endforeach
        @endif
      </select>  -->  
      <select class="form-control get_orgoldcont_address" id="other_address" name="address" data-type="other">
        <option value="">-- Select Address --</option>
        @if(isset($cont_address) && count($cont_address)>0)
          @foreach($cont_address as $key=>$r)
            <option value="{{$r['address_id'] or ''}}">{{$r['fullAddress'] or '' }}</option>
          @endforeach
        @endif
      </select>                
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Position</label>
      <input type="text" id="position" name="position" class="form-control">
    </div>

    <div class="form-group">
      <div class="row">
        <div class="col-md-9" style="padding-top: 7px">Change this Contact status to Client</div>
        <div class="col-md-3">
          <select class="form-control" id="change_contact" name="change_contact">
            <option value="N">No</option>
            <option value="Y">Yes</option>
          </select>   
        </div>
      </div>
    </div>

    
    </div>

      <div class="modal-footer" style="margin-top: 0px;">
        <button class="btn btn-info SaveNewContact" type="button" name="save">Save</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
        <div class="clearfix"></div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>


<!-- New Address modal start -->
<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add/Edit Address</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
      <!-- <div id="locationField">
      <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
    </div> -->
        <div class="show_loader"></div>
        <form method="post" action="/client/save-client-address" name="address_form" id="address_form">
        <input type="hidden" id="address_id" name="address_id">
        <input type="hidden" id="address_page_open" name="address_page_open">
        <input type="hidden" id="address_type" name="address_type">
        <input type="hidden" id="link" name="link" value="/organisation/add-client">
        <input type="hidden" name="client_id" value="{{ $client_details['client_id'] or '0' }}">



        
        <table width="100%" class="AddAddressTbl">
          <tr>
            <td align="left" width="25%"><strong>Address Line 1 : </strong></td> 
            <td align="left" id="locationField" style="height: 45px;">
            <!-- <input type="text" class="form-control address_search" name="address1"> -->
            <input type="text" class="form-control address_search" name="address1" id="address1" placeholder="Enter your address" onFocus="geolocate()"></input>
            </td>
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
              <a href="javascript:void(0)" id="anwar" class="btn btn-info save_new_address" >Save</a>
            </td>
          </tr>
        </table>
      </form>
      </div>
    
    </div>
  </div>
</div>        
<!-- New Address modal End -->

<div class="modal fade in" id="full_address-modal" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">FULL ADDRESS</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" id="show_full_address"><!-- Full Address --></div>
    
    </div>
  </div>
</div>