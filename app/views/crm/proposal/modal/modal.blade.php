<div id="SendTextAreaHide" style="display: none;">
    <p>Dear [Name],</p>
    <p>Thanks for the opportunity.</p>
    <p style="margin-bottom:10px;">Please click [link]  to view the proposal.</p>
    <p style="margin-bottom:10px;">Please do not hesitate to call if you have any queries regarding the proposal.</p>
    <p style="margin-bottom:10px;">Kind regards</p>
    <p style="margin-bottom:5px;">[Staff User]</p>
    <p>[Practice Name]</p></td>
</div>

<!-- Send email pop up -->
<div class="modal fade" id="openActionSendPopUp-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header commentHeader">
        <table width="100%" class="popHeading">
          <tr>
            <td class="PTitle"></td>
            <td><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></td>
          </tr>
        </table>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="col-md-12">
          <form method="post" action="/proposal/action" id="sendActionEmailForm">
            <input type="hidden" name="action" value="sendEmailFromProposal">
            <input type="hidden" name="sending_page" id="sending_page" value="">
            <input type="hidden" name="client_id" id="client_id" value="">
            <table width="100%">
              <tr>
                <td height="50"><input class="form-control" name="actionEmail" id="actionEmail" placeholder="Enter recipient email address" /></td>
              </tr>
              <tr>
                <td id="SendTextAreaTd">
                  <!-- <p>Dear [firstname],</p>
                  <p>Thanks for the opportunity.</p>
                  <p style="margin-bottom: 10px;">Please click here  to view the proposal.</p>
                  <p style="margin-bottom: 20px;">[link]</p>
                  <p style="margin-bottom: 10px;">Please do not hesitate to call if you have any queries regarding the proposal.</p>
                  <p style="margin-bottom: 10px;">Kind regards</p>
                  <p style="margin-bottom: 5px;">Staff User</p>
                  <p>[Practice Name]</p></td> -->
              </tr>
              <tr>
                <td align="center">
                  <button type="button" class="commentIcon" id="sendActionEmail" style="margin-top:10px">SEND</button>
                </td>
              </tr>
            </table>
          </form>
        </div>

        
      <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<!-- Comment pop up -->
<div class="modal fade" id="openCommentPopUp-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header commentHeader">
        <table width="100%" class="popHeading">
          <tr>
            <td class="PTitle"></td>
            <td><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></td>
          </tr>
        </table>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;"></div>
        <div class="col-md-12">
          <form method="post" action="/proposal-preview/action" id="commentForm">
            <input type="hidden" id="crm_proposal_id" name="crm_proposal_id" value="">
            <input type="hidden" name="action" value="saveCommentInPreview">
            <input type="hidden" name="added_from" value="popup">
            <table width="100%">
              <tr>
                <td id="textAreaTd"><!-- <textarea class="form-control classy-editor" rows="3" name="comment_text" id="comment_text"></textarea> --></td>
              </tr>
              <tr>
                <td><button type="button" class="commentIcon" id="postComment" style="margin: 10px 0 20px;"><i class="fa fa-comment "></i> Post Comment</button></td>
              </tr>
            </table>
          </form>
        </div>

        <div class="col-md-12" id="postCommentArea"><!-- Ajax Call--></div>

      <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>


<!-- ///////////////////////////////////SMALL MODAL FOR MESSAGE///////////////////// -->
<div class="modal fade modal-sm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      
      </div>
      <div class="modal-body">
       <h4 id="message_modal"></h4>
      </div>
    
    </div>
  </div>
</div> 

<!-- Add New Service Modal -->
<div class="modal fade" id="Servicepop431-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:570px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD/EDIT NEW SERVICES</h4>
            <div class="clearfix"></div>
        </div>
        
        <div class="modal-body">
        <div class="show_loader"></div>
        <div class="form-group">
            <div class="panel-body">
                {{ Form::open(array('url' => '/', 'class'=>'form-horizontal')) }}
                <input type="hidden" id="prop_serv_id" name="prop_serv_id" value="0">
                <input type="hidden" id="Servtype" name="Servtype" value="P">
                <input type="hidden" id="dfltServiceId" name="dfltServiceId" value="0">
                <input type="hidden" id="ServiceAction" name="ServiceAction" value="0">
                
                <div class="input-group  col-md-12 proposal-input-group">
                    <div class="col-md-4">
                        <label class="proposal-label"><b>Service Name </b></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="Service Name" name="service_name" id="serViceName" />
                        @if ($errors->has('service_name')) <span style="color: red">{{ $errors->first('service_name') }}</span> @endif
                    </div>
                </div>

                <div class="input-group  col-md-12 proposal-input-group">
                    <div class="col-md-4">
                        <label class="proposal-label"><b>Price</b></label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-number" id="servcPrice" placeholder="Price" name="price" value="{{ isset($editProduct) ? $editProduct->price : Input::old('price') }}"/>
                        @if ($errors->has('price')) <span style="color: red">{{ $errors->first('price') }}</span> @endif
                    </div>
                </div>

                <div class="input-group  col-md-12 proposal-input-group">
                    <div class="col-md-4">
                        <label class="proposal-label">Tax Rate <a href="javascript:void(0)" class="tax_rate_open"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></label>
                    </div>
                    <div class="col-md-8">
                        <select name="servcRate" id="servcRate" class="form-control tAxRaTeSelecT">
                            <option value="">Tax Rate</option>
                            @if(isset($TaxRates) && count($TaxRates) >0 )
                                @foreach($TaxRates as $key=>$v)
                                    <option value="{{$v['tax_rate_id'] or '0'}}">{{$v['name'] or ''}}({{$v['rate'] or '0'}}%)</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <input type="hidden" name="service_id" value="{{ isset($editProduct) ? $editProduct->service_id : Input::old('product_id') }}">

                {{ Form::close() }}
            </div>
            <div class="clearfix"></div>  
        </div>

        <div class="auto_modal_footer clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2 saveServiceInPop" name="save">Save</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tax_rate-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Tax Rates - Add to List</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader"></div>
        <table width="100%">
            <tr>
                <td width="60%">* Name</td>
                <td colspan="3">* Rate</td>
            </tr>
            <tr>
                <td width="60%"><input type="text" id="Taxname" class="form-control" style="width: 95%"></td>
                <td width="20%"><input type="text" id="Taxrate" class="form-control" style="width: 93%"></td>
                <td width="5%">%</td>
                <td width="15%"><button type="button" id="saveTaxRates" class="btn btn-info">Add</button></td>
            </tr>
        </table>

        <table width="100%" class="table table-bordered tax-rate-list TaxRateTable" style="margin-top: 10px">
          <thead>
            <tr>
              <th>Name</th>
              <th style="width: 15%;">Rate</th>
              <th style="width: 15%; text-align: center;">Action</th>
              <th style="width: 18%; text-align: center;"><a href="javascript:void(0)" class="tax_rate_open" id="tax_rate_open" data-is_archive="show">Show Archive</a></th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="activities-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="acTiVePopTitlE">EXAMPLE SERVICE NAME</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;margin-bottom: 10px"></div>
        <input type="hidden" id="activityOpenFrom" value="">
        <input type="hidden" id="activityServiceId" value="">
        <table width="100%">
            <tr>
              <td width="65%"><input type="text" class="form-control" id="actIviTyName" style="width: 95%" placeholder="Activity Name"></td>
              <td width="20%"><input type="text" class="form-control priceRound" id="servActBaseFee" placeholder="Annual base fee"></td>
              <td width="10%" align="right"><button type="button" id="saveActivtbTn" class="btn btn-info">Add</button></td>
            </tr>
        </table>

        <table width="100%" class="tax-rate-list table table-bordered table-hover">
          <thead>
            <th>Activity Name</th>
            <th width="20%">Base Fee</th>
            <th style="text-align: center; width: 8%">Action</th>
            <th width="16%"><a href="javascript:void(0)" id="activities_modal" class="activities_modal" data-is_archive="show">Show Archive</a></th>
          </thead>
          <tbody id="popActvtiList">
            <!-- Ajax Call -->
          </tbody>
        </table>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Section -->
<div class="modal fade" id="newPricingTemplate-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="col-md-12">
          <div class="col-md-11"><h4 class="modal-title TitLe">Create New Pricing Template</h4></div>
          <div class="col-md-1"><button type="submit" name="save" id="save" class="btn btn-info">SAVE</button></div>
        </div>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;"></div>
        <div class="col-md-12 popupDrop" id="divDropPT">
          <input type="text" class="form-control" placeholder="Template Name">
        </div>
        <div class="col-md-12 popupDrop" id="divDropT">
          <select class="form-control">
            <option value="">-- Select Pricing Template --</option>
          </select>
        </div>
        <div class="col-md-12 popupDrop" id="divDropP">
          <select class="form-control">
            <option value="">-- Select Pricing based on an existing client --</option>
          </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-12">
        <table width="100%" class="table table-bordered" id="SeRvPopList">
          <thead>
            <tr>
              <th width="25%">Service Options</th>
              <th width="40%">Services</th>
              <th width="20%">Price</th>
              <th width="15%">Ordering</th>
            </tr>
          </thead>
          <tbody>
            <!-- <tr>Complementary
              <td><input type="checkbox"></td>
              <td><input type="checkbox"></td>
              <td><input type="checkbox"></td>
              <td>Service Name</td>
              <td><input type="text" class="priceRound"></td>
            </tr> -->
          </tbody>
        </table>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<!-- New Service  Pop Up -->
<div class="modal fade" id="newServiceInNewProposal-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="col-md-12">
          <div class="col-md-11"><h4 class="modal-title TitLe">Create New Pricing Template</h4></div>
          <div class="col-md-1"><button type="submit" name="save" id="save" class="btn btn-info">SAVE</button></div>
        </div>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;"></div>
        <div class="col-md-12 popupDrop" id="divDropPT">
          <input type="text" class="form-control" placeholder="Template Name">
        </div>
        <div class="col-md-12 popupDrop" id="divDropT">
          <select class="form-control">
            <option value="">-- Select Pricing Template --</option>
          </select>
        </div>
        <div class="col-md-12 popupDrop" id="divDropP">
          <select class="form-control">
            <option value="">-- Select Pricing based on an existing client --</option>
          </select>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-12">
        <table width="100%" class="table table-bordered" id="SeRvPopList">
          <thead>
            <tr>
              <th width="25%">Service Options</th>
              <th width="40%">Services</th>
              <th width="20%">Price</th>
              <th width="15%" style="text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- <tr>Complementary
              <td><input type="checkbox"></td>
              <td><input type="checkbox"></td>
              <td><input type="checkbox"></td>
              <td>Service Name</td>
              <td><input type="text" class="priceRound"></td>
            </tr> -->
          </tbody>
        </table>

        <table class="table table-bordered table-striped table-hover" style="width: 65%; float: left;">
            <thead>
                <tr>
                    <th width="25%">
                        <button class="btn btn-success">Add</button>
                        <button class="btn btn-danger">Cancel</button>
                    </th>
                    <th width="40%">
                      <select class="form-control newdropdown">
                        @if(isset($allServices) && count($allServices) >0)
                          @foreach($allServices as $k=>$v)
                              <option value="{{ $v['service_id'] or '' }}">{{ $v['service_name'] or '' }}</option>
                          @endforeach
                        @endif
                      </select>
                    </th>
                </tr>
            </thead>
        </table>

        <div style="float: left; width: 100%">
          <button type="button" class="addnew_line" style="width: 102px;"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new</p></button>
        </div>

        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="newProposalTablePop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:850px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW SERVICE PACKAGE</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'addTableProposalForm')) }}
      <div class="modal-body">
      <div class="show_loader"></div>
        <input type="hidden" name="action" value="addNewTable">
        <input type="hidden" name="old_heading_id" id="old_heading_id" value="">
        <!-- <div class="col-md-12 mbottom20">
          <div class="col-md-2" style="margin-top: 8px;"><label>Package Name</label></div>
          <div class="col-md-9">
            <input type="text" class="form-control toUpperCase" placeholder="eg Compliance Services, Starter Package, Optional Services, One-off Services" id="heading_name" name="heading_name">
          </div>
          <div class="col-md-1">
            <a href="javascript:void(0)" class="btn btn-info addNewTableBtn">Add</a>
          </div>
          <div class="clearfix"></div>
        </div> -->
        <div class="row">
          <div class="col-md-12 mbottom20">
            <div class="col-md-2" style="margin-top: 8px; padding-left: 0px;"><label>Package Name</label></div>
            <div class="col-md-6">
              <input type="text" class="form-control toUpperCase" placeholder="eg Compliance Services, Starter Package, Optional Services, One-off Services" id="heading_name" name="heading_name">
            </div>
            <div class="col-md-3">
              <select class="form-control packageTypes" name="heading_type" id="heading_type">
                <option value="">Package Type</option>
                <option value="R">Recurring</option>
                <option value="F">One - off</option>
                <option value="O">Optional</option>
                <option value="C">Complementary</option>
              </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0)" class="btn btn-info addNewTableBtn">Add</a>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      <table class="table table-bordered table-hover dataTable add_heading_table" width="100%">
        <!-- crm/proposal/proposals/ajax_service_package_popup-->
      </table>

        
      </div>
    {{ Form::close() }}
  </div>
  </div>
</div>


<!-- proposal settings dropdown standard packages -->
<div class="modal fade" id="openPackagePop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:850px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW SERVICE PACKAGE</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'openPackagePopForm')) }}
      <div class="modal-body">
        <div class="show_loader"></div>
        <input type="hidden" name="action" value="savePackagePop">
        <div class="row">
          <div class="col-md-12 mbottom20">
            <div class="col-md-2" style="margin-top: 8px; padding-left: 0px;"><label>Package Name</label></div>
            <div class="col-md-6">
              <input type="text" class="form-control toUpperCase" placeholder="eg Compliance Services, Starter Package, Optional Services, One-off Services" id="package_name" name="package_name">
            </div>
            <div class="col-md-3">
              <select class="form-control packageTypes" name="package_type" id="package_type">
                <option value="">Package Type</option>
                <option value="R">Recurring</option>
                <option value="F">One - off</option>
                <option value="O">Optional</option>
                <option value="C">Complementary</option>
              </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0)" class="btn btn-info addNewPackageBtn">Add</a>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>

      <table class="table table-bordered table-hover dataTable add_package_table" width="100%">
        
          <!-- crm/proposal/proposals/ajax_standard_package_popup-->
        
    
    </table>

        
      </div>
    {{ Form::close() }}
  </div>
  </div>
</div>
<!-- proposal settings dropdown standard packages -->

<!-- Services in new proposal page -->
<div class="modal fade" id="viewProposalServicePop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
        <div class="left">VIEW SERVICES - <a href="javascript:void(0)" class="tableName"></a></div>
        <div style="float: left;margin-left: 200px;">Add Services <a href="javascript:void(0)" class="round_plus newProposalServicePop" data-crm_proptbl_id=""> <img src="/img/plus_1.png"></a></div>
        </h4>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body">
      <div class="show_loader"></div>
        <input type="hidden" id="package_type" value="">
        <table class="table table-bordered table-striped table-hover" width="100%" id="viewServiceTable">
          <thead>
              <tr>
                  <th colspan="2">Service Name</th>
                  <th width="10%">Billing frequency</th>
                  <th width="10%">Tax Rate</th>
                  <th width="10%">Add Table</th>
                  <th width="10%">Flex Fees (%)</th>
                  <th width="16%" colspan="2">Annual Fees (Excluding Tax)</th>
                  <th width="4%">Notes</th>
                  <th width="4%">Action</th>
              </tr>
          </thead>
          <tbody class="sortingServices">
            <!-- crm/proposal/proposals/ajax_table_services_popup -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="newProposalServicePop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW SERVICES</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'addServiceProposalForm')) }}
      <div class="modal-body">
      <div class="show_loader"></div>
        <input type="hidden" name="action" value="addNewService">
        <input type="hidden" name="old_crm_proptbl_id" id="old_crm_proptbl_id" value="">
        <input type="hidden" name="old_service_id" id="old_service_id" value="">
        <input type="hidden" name="old_heading_id" id="old_heading_id" value="">
        <input type="hidden" name="old_page_name" id="old_page_name" value="add">
        <div class="col-md-12 mbottom20">
          <div class="col-md-7">
            <input type="text" class="form-control" placeholder="Service Name" id="service_name" name="service_name">
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control priceRound" placeholder="Annual base fee" id="srvBaseFee" name="srvBaseFee">
          </div>
          <div class="col-md-2">
            <a href="javascript:void(0)" class="btn btn-info addNewServiceBtn">Add</a>
          </div>
          <div class="clearfix"></div>
        </div>
      <table class="table table-bordered table-hover dataTable add_service_table" width="100%">
        <thead>
          <tr>
            <th align="center" width="13%">Show/Hide</th>
            <th width="10%">Tables</th>
            <th>Service Name</th>
            <th width="14%" align="center">Base Fee</th>
            <th align="center" width="10%">Action</th>
          </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
          <!-- Ajax Call -->
        </tbody>
      </table>
    </div>
    {{ Form::close() }}
  </div>
  </div>
</div>

<!-- Activities in new proposal page -->
<div class="modal fade" id="viewProposalActivityPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
          <div class="left">VIEW ACTIVITIES - <a href="javascript:void(0)" class="ActivityName"></a></div>
          <div style="float: left;margin-left: 200px;">Add Activities <a href="javascript:void(0)" class="round_plus newProposalActivityPop" data-p_service_id="" data-service_id="" data-service_name=""><img src="/img/plus_1.png"></a></div>
          <div class="left" style="margin-left: 150px;">
            <input type="checkbox" class="doNotUseFeesService" data-popup="activity" data-p_service_id="" data-service_id=""> 
            <span style="font-size: 14px;">Do not use activity fees to price this service</span>
          </div>
        </h4>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body">
      <div class="show_loader"></div>
        <table class="table table-bordered table-striped table-hover" width="100%" id="viewActivityTable">
          <thead>
            <tr>
                <th>Activity Name</th>
                <th width="14%">Activity Options</th>
                <th width="10%">Flex Fees (%)</th>
                  <th width="16%" colspan="2">Annual Fees (Excluding Tax)</th>
                <th width="4%">Notes</th>
                <th width="5%">Action</th>
            </tr>
          </thead>
          <tbody class="sortingActivities">
          <!-- Ajax Call -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="newProposalActivityPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW ACTIVITIES - <span class="addNewActServName"></span></h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'addActivityProposalForm')) }}
      <div class="modal-body">
        <div class="show_loader"></div>
        <input type="hidden" name="action" value="addNewActivity">
        <input type="hidden" name="old_service_id" id="old_service_id" value="">
        <input type="hidden" name="old_prop_service_id" id="old_prop_service_id" value="">
        <div class="col-md-12 mbottom20">
          <div class="col-md-7">
            <input type="text" class="form-control" placeholder="Activity Name" id="activity_name" name="activity_name">
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control priceRound" placeholder="Annual base fee" id="actBaseFee" name="actBaseFee">
          </div>
          <div class="col-md-2">
            <a href="javascript:void(0)" class="btn btn-info addNewActivityBtn">Add</a>
          </div>
          <div class="clearfix"></div>
        </div>
        <table class="table table-bordered table-hover dataTable add_activity_table" width="100%">
          <thead>
            <tr>
              <th align="center" width="11%">Show/Hide</th>
              <th>Activity Name</th>
              <th width="14%">Base Fee</th>
              <th align="center" width="8%">Action</th>
            </tr>
          </thead>

          <tbody role="alert" aria-live="polite" aria-relevant="all">
            <!-- Ajax Call -->
          </tbody>
        </table>
      </div>
    {{ Form::close() }}
    </div>
  </div>
</div>


<div class="modal fade" id="newProposalNotesPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NOTES - <span class="addNewName"></span></h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'addNotesProposalForm')) }}
      <div class="modal-body">
        <div class="show_loader"></div>
        <input type="hidden" name="action" value="addNewNotes">
        <input type="hidden" name="notesTableId" id="notesTableId" value="">
        <input type="hidden" name="notesType" id="notesType" value="">
        <input type="hidden" name="notesTableName" id="notesTableName" value="">
        <input type="hidden" name="notesTableIdName" id="notesTableIdName" value="">

        <div class="form-group">
          <textarea class="form-control" name="proposalNote" id="proposalNote" rows="4"></textarea>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" style="float: right;">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info pull-left save_t2 saveProposalNotesPop" name="save">Save</button>
        </div>
        <div class="clearfix"></div>
      </div>
    {{ Form::close() }}
    </div>
  </div>
</div>

<div class="modal fade" id="grandTotalHeading-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">GRAND TOTAL - SUM</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'addTableProposalForm')) }}
      <div class="modal-body">
      <div class="show_loader"></div>
      <table class="table table-bordered table-hover dataTable" width="100%">
        <thead>
          <tr>
            <th align="center" width="20%">Include</th>
            <th >Table Name</th>
          </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($tableHeadings) && count($tableHeadings) >0)
            @foreach($tableHeadings as $key=>$value)
              <!-- <tr id="tablePop_tr_{{ $value['heading_id'] or "" }}">
                <td align="center">
                  <span class="custom_chk"><input type="checkbox" id="table{{ $value['heading_id']}}" class="grand_total_check" {{ (isset($value['grand_show']) && $value['grand_show'] > 0)?"checked":"" }}  {{ (isset($value['table_show']) && $value['table_show'] > 0)?"":"disabled" }} value="{{ $value['heading_id'] or "" }}" data-heading_id="{{ $value['heading_id'] or "" }}" /><label style="width:0px!important" for="table{{ $value['heading_id'] or "" }}">&nbsp;</label></span>
                </td>
                <td>{{$value['heading_name'] or ""}}</td>
              </tr> -->
            @endforeach
          @endif

        </tbody>
    
    </table>

        
      </div>
    {{ Form::close() }}
  </div>
  </div>
</div>


<div class="modal fade" id="pNewLetterTemplate-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD LETTER TEMPLATE</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/settings/action', 'id'=>'pNewLetterTemplateForm')) }}
      <div class="modal-body">
        <div class="show_loader"></div>
        <input type="hidden" name="action" value="savepNewLetterTemplate">
        <input type="hidden" name="pNewLetterId" id="pNewLetterId" value="0">
        <div class="col-md-12 pleft0">
          <div class="col-md-9 pleft0">
            <div class="form-group">
              <input type="text" name="pnTempTitle" id="pnTempTitle" class="form-control" placeholder="Title">
              <div class="clearfix"></div>
            </div>

            <div class="form-group">
              <textarea class="form-control" name="pnTempDesc" id="pnTempDesc" cols="10"></textarea>
              <div class="clearfix"></div>
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-info pull-right savepnTempPop">Save</button>
              <button type="button" class="btn btn-info pull-right editpnTempPop">Edit</button>
            </div>
          </div>
          <div class="col-md-3 pleft0">
            <div class="form-group">
                <select class="form-control newdropdown" id="changePlaceHolder" data-page_name="letter">
                    <option value="">Select Placeholder Type</option>
                    <option value="proposal_general">General</option>
                </select>
            </div>

            <div class="form-group">
                <ul class="placeholderList"><!-- Ajax Call --></ul>
            </div>
            <div class="clearfix"></div>
            <!-- <div class="col-md-11">
              <select class="form-control newdropdown" id="pnTempPlaceDrop">
                <option value="">Select Placeholder Type</option>
              </select>
            </div> -->
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    {{ Form::close() }}
    </div>
  </div>
</div>

@include('crm.modal.add_service_table_modal')


<!-- Services in new proposal page -->
<div class="modal fade" id="openAddOpperFee-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
        <div class="left">VIEW SERVICES - <a href="javascript:void(0)" class="tableName"></a></div>
        <div style="float: left;margin-left: 200px;">Add Table Rows <a href="javascript:void(0)" class="round_plus addNewRowInTablePop"> <img src="/img/plus_1.png"></a></div>
        </h4>
        <div class="clearfix"></div>
      </div>
      <form id="openAddOpperFee-form" method="post" action="/proposal/action">
      <input type="hidden" name="action" value="saveServiceFeeTypePop">
      <input type="hidden" name="p_service_id" id="PCervId" value="">
      <input type="hidden" name="proposalServiceId" id="proposalServiceId" value="">
      <input type="hidden" name="id" id="ServTblId" value="">
      <input type="hidden" name="action_type" id="action_type" value="">
      <div class="show_loader"></div>
      <div class="modal-body" id="viewServFeesTypeTable">
        @include('crm/proposal/proposals/ajax_service_fees_table')
      </div>

      <div class="modal-footer mtop0">
        <button type="button" class="btn btn-danger " data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info saveServiceFeeType" name="save">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="openWipNotesPopup-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES <span class="addNewName"></span></h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/proposal/action', 'id'=>'addNotesProposalForm')) }}
      <div class="modal-body">
        <div class="show_loader"></div>
        <input type="hidden" name="action" value="addNewNotes">
        <input type="hidden" name="wipTableId" id="wipTableId" value="">

        <div class="form-group" id="wipNotesTextareaTd">
          <!-- <textarea class="form-control" name="wipNotesTextarea" id="wipNotesTextarea" rows="4"></textarea> -->
          <div class="clearfix"></div>
        </div>

        <!-- <div class="form-group" style="float: right;">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info pull-left save_t2 saveWipListNotesPop" name="save">Save</button>
        </div> -->
        <div class="clearfix"></div>
      </div>
    {{ Form::close() }}
    </div>
  </div>
</div>



@include('crm.modal.newtask_modal')
<!-- Add new todo pop up -->
<!-- <div class="modal fade" id="edittaskcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="clearfix"></div>
      </div>
      {{ Form::open(array('url' => '/savetask', 'files' => true, 'id'=>'basicform')) }}
      <input type="hidden" name="page_open" value="{{ $page_open or '' }}">
      <input type="hidden" name="editrowid" id="editrowid" value="">
      <input type="hidden" name="redirect_url" id="redirect_url" value="/crm/OQ==/YWxs/wip">
      <input type="hidden" name="added_from" id="added_from" value="wip">
      <input type="hidden" name="editattacment" id="editattachmentfile" value="">
      <input type="hidden" name="is_billable" id="is_billable" value="Y">

      <div class="modal-body" >
        <div class="loader_show"></div>
        <div class="error" id="editerrormsg" style="color: red;"></div>
        <div class="success" id="editsuccessmsg" style="color: #0866c6; font-size: 18px;"></div>

        <div class="row" style="padding: 0px 40px 20px 40px;" class="content_part">
          <div class="form-group">
            <div class="col-md-3"><strong>Add New Task</strong></div>
            <div class="col-md-9">
              <span class="urgnt_con">Urgent?</span>
              <span class="rad_butt editurgent">
                <input type="radio" name="editurgent" value="Yes" id="yess" /> Yes</span>
              <span class="rad_butt editurgent">
                <input type="radio" name="editurgent" value="No" id="noo" checked /> No</span>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Task Name </strong></div>
            <div class="col-md-9">
              <input type="text" placeholder="" id="edittaskname" name="edittaskname" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Task Date </strong></div>
            <div class="col-md-9">
              <input type="text" value="<?= date('d-m-Y');?>" id="edittaskdate" name="edittaskdate" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Task Time </strong></div>
            <div class="col-md-9">
              <input type="text" value="<?= date('H:i');?>" id="edittask_time" name="edittask_time" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Client Name</strong></div>
            <div class="col-md-9">
              <select class="form-control" name="rel_client_id_edit" id="rel_client_id_edit">
                <option value="">None</option>
                @if(isset($allClients) && count($allClients)>0)
                  @foreach($allClients as $key=>$client_row)
                    @if($client_row['client_name'] != "")
                      <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Allocate to</strong></div>
            <div class="col-md-9">
              <select class="form-control" name="staff_id_edit" id="staff_id_edit">
                <option value="">Leave blank if own task</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                    <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                    @endforeach
                  @endif
                </select>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Note</strong></div>
            <div class="col-md-9">
              <textarea rows="4" name="editnotes" id="notesid" class="form-control"></textarea>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Amount</strong></div>
            <div class="col-md-9">
              <input type="text" id="amount" name="amount" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Attachment</strong></div>
            <div class="col-md-9">
              <input type="file" name="add_file_edit" id="add_file_edit" /></span>
              <p class="help-block" id="attachfilename"></p>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-9">
              <div class="email_btns2" style="width:130px;">
                <button data-dismiss="modal" class="btn btn-danger pull-left save_t"  type="button">Cancel</button>
                <button  class="btn btn-info" id="editsavetaskbtn" name="save" type="submit">Save</button>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    {{ Form :: close() }}
    </div>
  </div>
</div> -->