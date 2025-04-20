

            <!-- <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
              <li class="{{ ($proposal_page == 'final')?'active':'' }}"><a href="{{ url('crm/viewAllProposal') }}"> &nbsp;FINAL</a></li>
              <li class="{{ ($proposal_page == 'draft')?'active':'' }}"><a href="{{ url('crm/view-draft') }}"> &nbsp;DRAFT</a></li>
              <li class="dropdown {{($proposal_page == 'letter' || $proposal_page == 'pricing')?'active':'' }}">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle"> &nbsp;TEMPLATES<b class="caret"></b></a>
                <ul class="dropdown-menu proposal-dropdown-menu proposal_ul">
                  <li class="{{ ($proposal_page == 'letter')?'active':'' }}"><a href="{{ url('crm/letter-template') }}"><i class="fa fa-file-text tiny-icon"></i> Letter Templates</a></li>
                  <li class="{{ ($proposal_page == 'pricing')?'active':'' }}"><a href="{{ url('crm/pricing-template') }}"><i class="fa fa-gbp" ></i> Pricing Templates</a></li>
                </ul>
              </li>
              
              @if($proposal_page == 'letter')
                <li style="float: right;"><a href="javascript:void(0)" class="newLetterTemplate">+New Letter Template</a></li>
              @endif
              @if($proposal_page == 'pricing')
                <li style="float: right;"><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="PT">+New Pricing Template</a></li>
              @endif
            </ul> -->

            
              @include('crm/proposal/proposals/final')
                <!-- @if($proposal_page == 'final')
                    @include('crm/proposal/proposals/final')
                @elseif($proposal_page == 'draft')
                    @include('crm/proposal/proposals/final')
                @elseif($proposal_page == 'letter')
                    @include('crm/proposal/proposals/letter_template')
                @elseif($proposal_page == 'pricing')
                    @include('crm/proposal/proposals/pricing_template')
                @endif -->
       




<div class="modal fade" id="newLetterTemplate-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="col-md-12">
          <div class="col-md-11"><h4 class="modal-title">Add New Template</h4></div>
          <div class="col-md-1"><button type="submit" name="save" id="save" class="btn btn-info">SAVE</button></div>
        </div>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;"></div>

        <div class="col-md-12" style="padding-left: 0px;">
          <div class="col-md-8">
            <input type="hidden" name="template_id" id="template_id" value="">

            <div class="form-group">
              <input name="template_subject" id="template_subject" type="text" class="form-control" placeholder="Subject Line">
              <div class="clearfix"></div>     
            </div>

            <div class="form-group">
              <textarea name="template_message" id="template_message_body" class="form-control" placeholder="Message" style="height: 250px; visibility: hidden; display: none;"></textarea>
            </div>
          </div>
        
          <div class="col-md-4" style="margin-top: -23px;">
          <div class="input_dropdownbn">
            <label style="margin-top: 0"><!-- Insert Placeholder -->&nbsp;</label>
            <select class="form-control newdropdown" id="changePlaceHolder">
              <option value="">Select Placeholder Type</option>
              <option value="general">General</option>
              <option value="org">Organisation Details</option>
              <option value="ind">Individual Details</option>
              <option value="staff">Staff Details</option>
              <option value="practice">Practice Details</option>
              <option value="address">Organisation Address Details</option>
              <option value="other">Other Contacts</option>
            </select>
            
            <ul class="placeholderList"><!-- Ajax Call --></ul>
          </div>
        </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>


