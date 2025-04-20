<input type="hidden" id="isShowTable" value="G">

<form method="post" id="NewProposalForm" action="">
<div id="tab_1" class="tab-pane {{ (isset($tab_no) && $tab_no == '1')?'active':'hide' }}">
<input type="hidden" name="ExtProspectId" id="ExtProspectId" value="{{ $prospect_id or '0' }}">
<input type="hidden" name="from_page" id="from_page" value="{{ $from_page or '' }}">
    <div class="nav-tabs-custom">
        <table width="100%" class="newProposalTbl">
            <tr>
                <td width="19%"></td>
                <td width="20%"></td>
                <td width="3%"></td>
                <td width="20%"></td>
                <td width="3%"></td>
                <td width="8%"></td>
                <td width="8%"></td>
                <td width="6%"></td>
                <td width="13%"></td>
            </tr>
            <tr>
                <td class="firstTd">
                    <select class="form-control newdropdown" id="NewPropContctType">
                        <option value="">Select Contact Type</option>
                        <option value="p_ind" {{ (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'p_ind')?'selected':''}}>Prospect - Individual</option>
                        <option value="p_org" {{ (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'p_org')?'selected':''}}>Prospect - Organisation</option>
                        <option value="c_ind" {{ (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'c_ind')?'selected':''}}>Client - Individual</option>
                        <option value="c_org" {{ (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'c_org')?'selected':''}}>Client - Organisation</option>
                        <option value="template" {{ ( (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'template') || $from_page == 'template')?'selected':''}}>Template</option>
                    </select>
                </td>

                <td id="clientProspectList" style="display: {{($from_page != 'template')?'table-cell':'none';}}">
                    <select class="form-control newdropdown {{ (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] != '')?'':'hide'}}" id="propContactList">
                    @if(isset($crmLeads['cpName']) && $crmLeads['cpName'] != '')
                        <option value="{{ $crmLeads['cpId'] or ''}}">{{ $crmLeads['cpName'] or '' }}</option>
                    @else
                        <option value="">Select Client or Prospect</option>
                    @endif
                    </select>
                </td>
                <td class="FirstPlusIcon" style="display: {{($from_page != 'template')?'table-cell':'none';}}">
                @if(isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'p_ind')
                    <a href="javascript:void(0)" id="FPlus" data-type="ind" data-leads_id="0" class="open_form-modal"><img src="/img/plus_1.png"></a>
                @elseif(isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'p_org')
                    <a href="javascript:void(0)" id="FPlus" data-type="org" data-leads_id="0" class="open_form-modal"><img src="/img/plus_1.png"></a>
                @elseif(isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'c_ind')
                    <a href="javascript:void(0)" id="FPlus" class="FirstPlusA" data-cont_type="c_ind"><img src="/img/plus_1.png"></a>
                @elseif(isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] == 'c_org')
                    <a href="javascript:void(0)" id="FPlus" class="FirstPlusA" data-cont_type="c_org"><img src="/img/plus_1.png"></a>
                @else
                    <a href="javascript:void(0)" id="FPlus" class="{{ (isset($crmLeads['firstDrop']) && $crmLeads['firstDrop'] != '')?'':'hide'}}"><img src="/img/plus_1.png"></a>
                @endif

                </td>
                <td id="propContactTd" style="display: {{($from_page != 'template')?'table-cell':'none';}}">
                    <select class="form-control newdropdown {{ (isset($crmLeads['contactName']) && trim($crmLeads['contactName']) != '')?'':'hide'}}" id="propContactDrop">
                        @if(isset($crmLeads['contactName']) && trim($crmLeads['contactName']) != '')
                            <option value="{{$crmLeads['contactId']}}">{{ $crmLeads['contactName']}}</option>
                        @else
                            <option value="">Select Contact</option>
                        @endif
                    </select>
                </td>
                <td class="SecondPlusIcon" style="display: {{($from_page != 'template')?'table-cell':'none';}}">
                    <a href="javascript:void(0)" id="SPlus" style="display: none;"><img src="/img/plus_1.png"></a>
                </td>

                <td width="46%" class="TemplateNameTd" colspan="4" style="display: {{($from_page=='template')?'table-cell':'none';}}">
                    <input type="text" name="TemplateName" id="TemplateName" placeholder="Template Name" style="width: 100%; padding-left: 3px;" value="{{ $crmLeads['template_name'] or '' }}">
                </td>

                <td>Proposal ID</td>
                <td><input type="text" class="form-control" id="ProposalID" value="{{ $proposalId or '' }}" disabled></td>
                <td>Validity</td>
                <td><input type="text" class="form-control" id="propValidity" value="30" style="width: 20%; float: left; margin-right: 7px; padding: 6px 5px;"> <div style="float: left; margin-top: 6px;">Days</div></td>
            </tr>
            <tr>
                <td colspan="5"><input type="text" class="form-control" placeholder="Proposal Title" id="PropTitle" value="{{ $crmLeads['proposal_title'] or '' }}"></td>
                <td>Start Date</td>
                <td><input type="text" id="ProsStartDate" value="{{ isset($crmLeads['start_date'])?date('d-m-Y', strtotime($crmLeads['start_date']) ):date('d-m-Y') }}" class="form-control" style="padding: 6px 5px;"></td>
                <td>End Date</td>
                <td><input type="text" id="ProsEndDate" value="{{ isset($crmLeads['end_date'])?date('d-m-Y', strtotime($crmLeads['end_date']) ):date('d-m-Y', strtotime('+ 1 year')) }}" class="form-control" style="width: 55%; padding: 6px 5px;"></td>
            </tr>
        </table>

        <ul class="nav nav-tabs nav-tabsbg secondHeadTab" id="header_ul">
          <li class="active" id="tab_11"><a class="openNpSecTab" data-id="11" href="javascript:void(0)"><b>SERVICES</b></a></li>
          <li id="tab_12"><a class="openNpSecTab" data-id="12" href="javascript:void(0)"><b>COVER LETTER</b></a></li>
          <li id="tab_13"><a class="openNpSecTab" data-id="13" href="javascript:void(0)"><b>ATTACHMENTS</b></a></li>
          <li id="tab_14"><a class="openNpSecTab" data-id="14" href="javascript:void(0)"><b>NOTE</b></a></li>
          <li id="tab_15"><a class="openNpSecTab" data-id="15" href="javascript:void(0)"><b>T & Cs</b></a></li>
          <!-- <li id="tab_14"><a class="openNpSecTab" data-id="14" href="javascript:void(0)"><b>TASKS</b></a></li> -->
          
          <!-- <li class="dropdown" style="float: right;" id="tab_15">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Add Service <b class="caret"></b></a>
            <ul class="dropdown-menu proposal-dropdown-menu proposal_ul">
              <li><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="S">Custom</a></li>
              <li><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="P">Existing Proposal</a></li>
              <li><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="T">Template</a></li>
            </ul>
          </li> --> 

        </ul>

<div id="step11" class="commonClass tab-pane {{(isset($page_open) && $page_open=='1')?'active':'hide'}}">
    <div class="col-md-12" style="margin-top: 10px;">
        <div class="panel panel-primary">
            <!-- <div class="panel-heading" style="color:#fff;background-color:#0866C6;border-color:#0866C6; padding: 10px 15px;">
                <div style="float: left; margin-right: 4%;"> <i class="fa fa-list tiny-icon"></i> Tables</div>
                
                <div class="left"><a href="javascript:void(0)" class="newProposalTablePop" data-prop_serv_id="0" data-action="add" style="color: #fff;" >+ New Table</a></div>
                <div class="clearfix"></div>
            </div> -->
        <ul class="nav nav-tabs nav-tabsbg" id="header_ul">
          <li><a href="javascript:void(0)"><i class="fa fa-list tiny-icon"></i> Service Packages</a></li>
          <li><a href="javascript:void(0)" class="newProposalTablePop" data-prop_serv_id="0" data-action="add" data-page_name="add">+ Select Service Package</a></li>
          <!-- <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">+ New Table <b class="caret"></b></a>
            <ul class="dropdown-menu proposal-dropdown-menu proposal_ul">
              <li><a href="javascript:void(0)" class="newProposalTablePop" data-prop_serv_id="0" data-action="add" style="color: #fff;" >Custom</a></li>
              <li><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="P">Existing Proposal</a></li>
              <li><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="T">Template</a></li>
            </ul>
          </li> -->

        </ul>
            <div class="panel-body">
                <div class="table-responsive" id="newAddedTableToProposal">
                    @include('crm/proposal/proposals/ajax_table_content')
                    <!-- <div class="row">
                        <div class="col-md-12 bottom_5">
                        <table style="width:100%">
                            <tr style="background-color: #eaeae1;">
                                <td style="width:48%">
                                    <div class="tableTabheader" data-no="{{$v['heading_id'] or ''}}" data-type="up"><span class="headingArrow" id="headingArrow_{{$v['heading_id'] or ''}}"><img src="/img/arrows-down.png"></span> {{ $v['heading_name'] or ''}}</div>
                                </td>
                                <td style="width:10%">
                                    Add Services &nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="round_plus newProposalServicePop" data-crm_proptbl_id="{{ $v['id'] or ''}}"><img src="/img/plus_1.png"></a>
                                </td>
                                <td style="width:7%">
                                    Sub Total &nbsp;&nbsp;&nbsp;£
                                </td>
                                <td style="width:7%">
                                    <input type="text" class="priceRound">
                                </td>
                                <td style="width:5%; border-right: 1px solid #fff; text-align: center;">
                                    <input type="checkbox" > <img src="/img/question_frame.png" title="Do not display fee seperately in proposal">
                                </td>
                                <td style="width:4%; text-align: center;">
                                    <a href="javascript:void(0)"><img src="/img/dotted_icon.png" height="12"></a>
                                </td>
                            </tr>
                        </table>
                        </div>

                        <div class="col-md-12 inactive" id="subTableIn_{{$v['heading_id'] or ''}}">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th width="10%">Tax Rate</th>
                                        <th width="5%">Hrs</th>
                                        <th width="9%">Fees</th>
                                        <th width="4%">Notes</th>
                                        <th width="4%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="float: left; width: 95%">Vat returns</div>
                                            <div class="left"><a href="javascript:void(0)" class="innerSubTable" data-sub_no="{{$v['heading_id'] or ''}}_1" data-type="up"><img src="/img/arrows-up.png"></a></div>
                                        </td>
                                        <td>
                                            <select class="form-control newdropdown">
                                                <option value="0">-- --</option>
                                            </select>                                            
                                        </td>
                                        <td><input type="text" class="priceRound"></td>
                                        <td><input type="text" class="priceRound"></td>
                                        <td align="center"><a href="javascript:void(0)" class="notes_btn"><span style="">notes</span></a></td>
                                        <td align="center">
                                            <a href="javascript:void(0)" class="innerSubTable" data-sub_no="{{$v['heading_id'] or ''}}_1" data-type="up"><img src="/img/dotted_icon.png" height="12"></a>
                                        </td>
                                    </tr>

                                    <tr class="inactive subSubTableRow" id="1subSubTableRow_{{$v['heading_id'] or ''}}_1" data-no="{{$v['heading_id'] or ''}}_1">
                                        <td colspan="7">This service includes : - </td>
                                    </tr>

                                    <tr class="inactive subSubTableRow" id="2subSubTableRow_{{$v['heading_id'] or ''}}_1" data-no="{{$v['heading_id'] or ''}}_1">
                                        <td colspan="2" style="padding-left: 50px">Check your internet banking</td>
                                        <td>
                                            <select class="form-control newdropdown">
                                                <option value="0">-- Not Applicable --</option>
                                                <option value="1">Chargeable</option>
                                                <option value="2">Disbursement and Recharges</option>
                                                <option value="3">Optional</option>
                                            </select> 
                                        </td>
                                        <td><input type="text" class="priceRound"></td>
                                        <td><input type="text" class="priceRound"></td>
                                        <td><a href="javascript:void(0)" class="notes_btn"><span style="">notes</span></a></td>
                                        <td align="center"><a href="javascript:void(0)"><img src="/img/cross.png" height="12"></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
            </div>
        </div>
        </div>

        <!-- <div class="panel panel-primary">
            <div class="panel-heading" style="color:#fff;background-color:#0866C6;border-color:#0866C6;">
                <div style="width: 92%; float: left;"><i class="fa fa-list tiny-icon"></i> Services</div>
                <div style="float: left;"><a href="javascript:void(0)" class="" data-prop_serv_id="0" data-action="add" style="color: #fff;">+ New Service</a></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive" >
                    <table class="table table-bordered table-striped table-hover" id="serviceTable">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th width="20%">Table <a href="javascript:void(0)" class=""><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                <th>Price</th>
                                <th width="10%">Tax Rate <a href="javascript:void(0)" class="tax_rate_open"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                <th width="35%">This services includes : -</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($ServicesTask) && count($ServicesTask) >0 )
                            @foreach($ServicesTask as $key=>$v)
                            <tr class="TaskServTablTr_{{ $v['service_id']}}">
                                <td>*{{ ucwords(strtolower($v['service_name'])) }}</td>
                                <td>
                                    <select class="form-control newdropdown">
                                        <option value="0">-- Not Applicable --</option>
                                        @if(isset($tableHeadings) && count($tableHeadings) > 0)
                                            @foreach($tableHeadings as $k=>$vt)
                                                <option value="{{$vt['heading_id'] or ''}}">{{$vt['heading_name'] or ''}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td>{{ !empty($v['price'])?number_format($v['price'], 2):'' }}</td>
                                <td>{{ !empty($v['tax_percent'])?$v['tax_percent'].'%':'' }}</td>
                                <td>
                                    <div style="float: left;width: 10%; margin-right: 3px;"><a href="javascript:void(0)" class="activities_modal" data-type="T" data-prop_serv_id="0" data-service_id="{{ $v['service_id']}}"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
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
                            </tr>
                            @endforeach
                        @endif

                        @if(isset($ServicesProp) && count($ServicesProp) >0 )
                            @foreach($ServicesProp as $key=>$v)
                            @if(isset($v['service_id']) && $v['service_id'] =='0' )
                            <tr class="ServTablTr_{{ $v['prop_serv_id']}}">
                                <td>{{ $v['service_name'] or '' }}</td>
                                <td>
                                    <select class="form-control newdropdown">
                                        <option value="0">-- Not Applicable --</option>
                                        @if(isset($tableHeadings) && count($tableHeadings) > 0)
                                            @foreach($tableHeadings as $k=>$vt)
                                                <option value="{{$vt['heading_id'] or ''}}">{{$vt['heading_name'] or ''}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td>{{ number_format($v['price'], 2) }}</td>
                                <td>{{ $v['tax_percent'] or '0' }}%</td>
                                <td>
                                    <div style="float: left;width: 10%; margin-right: 3px;"><a href="javascript:void(0)" class="activities_modal" data-type="P" data-prop_serv_id="{{ $v['prop_serv_id']}}" data-service_id="{{ $v['service_id']}}"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
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
                            </tr>
                            @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
    </div>
    <!--col-md-12-->
    <div class="clearfix"></div>
</div>
<!-- SERVICES END-->

<div id="step12" class="commonClass tab-pane {{(isset($page_open) && $page_open ==12)?'active':'hide'}}">
    <div class="nav-tabs-custom">
        <div class="show_loader"></div>
        <div class="col-md-12">
            <div class="col-md-9 pleft0">
                <div class="col-md-4 pleft0">
                    <div class="form-group">
                        <select class="form-control newdropdown newPageSettingsTmpl" id="extTmplateId" data-type="template">
                            <option value="">Copy From Template-Settings</option>
                            @if(isset($templates) && count($templates) >0)
                                @foreach($templates as $k=>$v)
                                  <option value="{{ $v['template_id'] or ''}}">{{ $v['title'] or ''}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <select class="form-control newdropdown newPageSettingsTmpl" id="extLetterId" data-type="letter">
                            <option value="">Copy From Existing Letter</option>
                            @if(isset($letters) && count($letters) >0)
                                @foreach($letters as $k=>$v)
                                  <option value="{{ $v['cover_letter_id'] or ''}}">{{ $v['prospect_name'] or ''}} - {{ $v['proposal_title'] or ''}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="crmPCoverLerretId" value="{{$coverLetters['cover_letter_id'] or '0'}}">
                        <table width="100%" class="newProposalTbl">
                            <!-- <tr>
                                <td><input type="text" class="form-control" id="npfTempTitle" name="npfTempTitle" value="{{ $coverLetters['title'] or '' }}"></td>
                            </tr> -->
                            <tr>
                                <td><textarea id="coverLtrText" name="coverLtrText">{{ $coverLetters['desc'] or '' }}</textarea></td>
                            </tr>
                            <!-- <tr>
                                <td align="right">
                                    <button type="button" class="btn btn-info saveCPCoverLetter">Save</button>
                                </td>
                            </tr> -->
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control newdropdown" id="changePlaceHolder" data-page_name="proposal">
                        <option value="">Select Placeholder Type</option>
                        <option value="proposal_general">General</option>
                    </select>
                </div>

                <div class="form-group">
                    <ul class="placeholderList"><!-- Ajax Call --></ul>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>

        
    </div>
    <div class="clearfix"></div>
</div><!-- Cover Letter End -->

<div id="step13" class="commonClass tab-pane {{(isset($page_open) && $page_open== 13)?'active':'hide'}}">
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <table class="table table-bordered table-striped table-hover" width="100%" id="attchCreateTbl">
              <thead>
                <tr>
                    <th width="5%"><input type="checkbox"></th>
                    <th><b>Title</b></th>
                    <th><b>PDF File</b></th>
                    <th><b>Notes</b></th>
                    <th width="10%" style="text-align: center;">Preview</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($attachments) && count($attachments) >0)
                  @foreach($attachments as $key=>$v)
                    @if($v['is_archive'] == 'N')
                        <tr class="attachmnt_{{ $v['id'] }}">
                            <td><span class="custom_chk chk_fixed"><input type="checkbox" class="checkedAttachment" value="{{ $v['id'] }}" id="attach_{{ $v['id'] }}" {{ (!empty($attach_ids) && in_array($v['id'], $attach_ids))?'checked':'' }} /><label style="width:0px!important" for="attach_{{ $v['id'] }}">&nbsp;</label></span></td>
                          <td>{{ $v['title'] or '' }}</td>
                          <td>{{ $v['file'] or '' }}</td>
                          <td><a href="javascript:void(0)" class="notes_btn proposalNotes {{(in_array($v['id'], $attach_ids))?'':'disable_click' }}" data-table_id="{{ $v['id'] }}" data-type="crm_attachment" data-name="{{$v['title'] or ''}}">Notes</a></td>
                          <td align="center"><a href="/uploads/pdf forms/{{ $v['file'] or '' }}" class="btn btn-xs btn-primary" style=" background-color: #0866C6; border-color: #0866C6" target="_blank"><i class="fa fa-eye tiny-icon"></i> Preview</a></td>
                        </tr>
                    @endif
                    @endforeach
                @endif  
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
</div><!-- Attachments End -->

<div id="step15" class="commonClass tab-pane {{(isset($page_open) && $page_open ==15)?'active':'hide' }}">
    <div class="nav-tabs-custom">
        <div class="col-md-12">
            <input type="hidden" id="crmPTermsId" value="{{ $terms['id'] or '0' }}">
            <table width="100%" class="newProposalTermsTbl">
                <tr>
                    <td><textarea id="termsText" name="termsText">{{$terms['terms'] or ''}}</textarea></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
</div><!-- Terms and Conditions End -->

</form>
</div>
</div>



