<div class="tab-content">
  <!-- Tab 1 Start-->
  @if($page_open == 11)
  <div id="tab_11">
 <!-- <div id="tab_11" class="tab-pane {{ ($page_open == 11)?'active':'' }}"> -->
  
  <span style="float: left; padding-right: 10px; padding-top: 7px;">Dashboard</span>
  <span style="float:left;">
    <select id="crmdashboard" name="" class="form-control" style="width: 250px;">
      <option value="existingclient">Existing Client</option>
      <option value="salesperformancedashboard">Sales Performance Dashboard</option>
    </select>
  </span>
  <div class="clearfix"></div>
                               
  <div id="salesimg" style="padding-top:10px;"><img src="/img/img_2.png" /></div>
  </div>
  @endif
<!-- Tab 1 End-->

<!-- Tab 2 Start-->
@if($tab_no == 2)
@include('crm/includepdf/tabtwo')
@endif
<!--  <div id="tab_2" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
    
  </div> -->
<!-- Tab 2 End-->

<!-- Tab 3 Start-->
@if($page_open == 3)
<div id="tab_3">
  <!--<div id="tab_3" class="tab-pane {{ ($page_open == 3)?'active':'' }}"> -->
 <!-- Tab 3 -->
 
                            <!--sub tab -->
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
                                <li class="active"><a data-toggle="tab" href="#tab_6">All [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">Not Started [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">In Progress [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">Renewals sent [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">Client Review [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">Renegotiated [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">Accpted [8]</a></li>
                                <li class=""><a data-toggle="tab" href="#">Client Invoiced [8]</a></li>
                              </ul>
                              <div class="tab-content">
                                <div id="tab_6" class="tab-pane active">
                                  <!--table area-->
                                  <div class="box-body table-responsive">
                                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                                      <div class="row">
                                        <div class="col-xs-6"></div>
                                        <div class="col-xs-6"></div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12">
                                          <div class="col_m2">
                                           
                                            
                                            <table width="100%" border="0" class="staff_holidays">
                                              <tbody>
                                               
                                                <tr>
                                                  
                                                  
                                                <table  border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                                                  
                                                      <thead>
                                                        <tr>
                                                        <td><strong>Delete</strong></td>
                                                          <td><strong>DOJ</strong></td>
                                                          <td align="center"><strong>Business Name</strong></td>
                                                          <td align="center"><strong>Annual Fee</strong></td>
                                                          <td align="center"><strong>Contract End Date</strong></td>
                                                          <td align="center"><strong>Days</strong></td>
                                                         
                                                          <td align="center"><strong>Job Start Date</strong>
                                                          <i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>
                                                          </td>
                                                          <td align="center"><strong>Notes</strong></td>
                                                          <td align="center"><strong>Quotes</strong>
                                                          <i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>
                                                          </td>
                                                          <td align="center"><strong>Status</strong>
                                                          <i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>
                                                          </td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr><td> 
                                                        <a href="javascript:void(0)" class="delete_single_task DeleteBoxRow" data-client_id="" data-tab=""><img src="/img/cross.png"></a>
                                                        </td>
                                                          <td>28-08-2015</td>
                                                          <td>Business Name  Co Limited</td>
                                                          <td align="center">&nbsp; </td>
                                                          <td align="center">08-08-2015</td>
                                                          <td align="center">39</td>
                                                          
                                                          
                                                          
                                                          
                                                          
                                                          <td align="center">18-08-2015
                                               <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="4" data-tab="21"></span>
                                                          
                                                          </td>
                                                           
                                                          <td align="center">
                <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-leads_id="33" data-tab="11"><span style="">notes</span></a>
                                                          
                                                          
                                                          </td>
                                                         
                                                          <td align="center">
                             <div class="email_client_selectbox" style="height:24px; width:93px!important">
                                  <span>SEND</span>
                                  <div class="small_icon" data-id="27" data-tab="11"></div><div class="clr"></div>
                                  
                                </div>  <img src="/img/corner_arrow.png" style="height:12px;">                      
                                                          
                                                          </td>
                                                          
                                  <td align="center">
                                    <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_27" data-leads_id="27">
                                                                                      
                                                          <option value="4">QUALIFIED</option>
                                                          <option value="6">DISCUSSIONS</option>
                                                          <option value="7">PROPOSAL</option>
                                                          <option value="8" selected="">NEGITIATIONS</option>
                                                          <option value="10">CLOSING</option>
                                                                                      </select></td>
                                                        </tr>
                                                       
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end table-->
                                </div>
                                <!-- /.tab-pane -->
                                
                                <!-- /.tab-pane -->
                              </div>
                            </div>
                            <!--end sub tab-->
                         
  </div>
  @endif
<!-- Tab 3 End-->

<!-- Tab 4 Start-->
@if($page_open == 4)
<div id="tab_4">
<!--
  <div id="tab_4" class="tab-pane {{ ($page_open == 4)?'active':'' }}"> -->
  
  
   <div class="col_m2">
     
   <div  class="import_fromch_main" style="width:670px; padding-top: 10px; z-index: 99; margin: 0 0 0 16%;"> 
       
            <div class="import_fromch" style=" margin-right: 42px;">
              <a href="javascript:void(0)" class="import_fromch_link">SEND DIRECT DEBIT REQUEST</a>
              
             
            </div>
            
            
            <div class="import_fromch" style="float:right;">
              <a href="javascript:void(0)" class="import_fromch_link">SYNC WITH XERO</a>
              
              
            </div>
             
        </div>
   
    
                                            <table width="100%" border="0" class="staff_holidays">
                                              <tbody>
                                               
                                                <tr>
                                                  
                                                  
                                                <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                                                  
                                                      <thead>
                                                        <tr>
                                                        <td><input type="checkbox" name="" class="CheckallCheckbox" /></td>
                                                          <td><strong>Account Ref</strong></td>
                                                          <td align="center"><strong>Client Name</strong></td>
                                                          <td align="center"><strong>Contact Name</strong></td>
                                                          <td align="center"><strong>Email</strong></td>
                                                          <td align="center"><strong class="collection_color">Ammount Due (&#163;)</strong></td>
                                                          <td align="center"><strong>To be Collected (&#163;)</strong></td>
                                                            <td align="center"><strong>Status</strong></td>
                                                          <td align="center"><strong class="collection_color">Collection Date</strong></td>
                                                          <td align="center"><strong>Notes</strong></td>
                                                          
                                                          
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                        
                                                        <td> 
                                                        <input type="checkbox" name="" class="CheckallCheckbox" /></td>
                                                          <td>28-08-2015</td>
                                                          <td>Business Name  Co Limited</td>
                                                          <td align="center">&nbsp; </td>
                                                          <td align="center">08-08-2015</td>
                                         <td align="center"><a href="#" class="" data-toggle="modal" id=""  data-target="#amount_mdd">299.00</a></td>
                                                          
                                                          <td align="center"><a href="#">299.00</a></td>
                                                          <td align="center" class="autho_color">Authorised</td>
                                                         
                                                          
                                                          
                                                          <td align="center">18-08-2015
                                               <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="4" data-tab="21"></span>
                                                          
                                                          </td>
                                                           
                                                          <td align="center">
                <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-leads_id="33" data-tab="11"><span style="">notes</span></a>
                                                          
                                                          
                                                          </td>
                                                         
                                                         
                                                          
                                  
                                                        </tr>
                                                       
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
  
  <!-- Tab 4 -->
  </div>
  @endif
<!-- Tab 4 End-->

<!-- Tab 5 Start-->
@if($page_open == 51 || $page_open == 511 || $page_open == 512 || $page_open == 513)
 @include('crm/includepdf/leads_tab')
@endif
<!--
  <div id="tab_51" class="tab-pane {{ ($page_open == 51 || $page_open == 511 || $page_open == 512 || $page_open == 513)?'active':'' }}">
     
  </div> -->
<!-- Tab 5 End-->

<!-- Tab 6 Start-->
@if($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617 || $page_open == 62 || $page_open == 63 || $page_open == 64 || $page_open == 65)
@include('crm/includepdf/opportunities_tab')
@endif
 <!-- <div id="tab_61" class="tab-pane {{ ($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617 || $page_open == 62 || $page_open == 63 || $page_open == 64 || $page_open == 65)?'active':'' }}">
    
  </div> -->
<!-- Tab 6 End-->

<!-- Tab 7 Start-->
@if($page_open == '7')
<div id="tab_7">
  <!-- <div id="tab_7" class="tab-pane {{ ($page_open == '7')?'active':'' }}"> -->
   
   <div class="tab_topcon">
                      <div style="float:left; margin-top:30px; width:25%;" class="top_bts">
                        <ul style="padding:0;">
                          <li>
                            <div style="width:170px;" class="import_fromch_main">
  
                              <div class="import_fromch">
                              
<a class="import_fromch_link" href="#" data-toggle="modal"  data-target="#forecast-modal" > +NEW FORECAST VALUES</a>
                              <!--  <a id="select_icon" class="i_selectbox" href="javascript:void(0)"><img src="/img/arrow_icon.png"></a> -->
                                <div class="clearfix"></div>
                              </div>
                              
                          </div>
                          </li>
                          <li>
                            <div style="width:108px;" class="import_fromch_main">
                              <div class="import_fromch">
                                <a class="import_fromch_link" href="javascript:void(0)">Show Totals</a>
                              <!--  <a id="select_icon" class="i_selectbox" href="javascript:void(0)"><img src="/img/arrow_icon.png"></a> -->
                                <div class="clearfix"></div>
                              </div>
                              
                          </div>
                          </li>
                          
                         
                          
                            
                          
                          
                          <!-- <li>
                            <a class="btn btn-info" href="/crm/graph-page" target="_blank">GRAPHS</a>
                          </li>
                          <li>
                            <a class="btn btn-info" href="/crm/report" target="_blank">REPORT</a>
                          </li> -->
                        <div class="clearfix"></div>
                        </ul>
                      </div>
                     
                           <form style="float:left; width:75%">
                           
                             <div style="margin-top:0px; float: left; width:14%; margin-right: 1%;">
                              <p style="font-weight: bold;">Select Months</p>
                               <select id="marital_status" name="marital_status" class="form-control" style="width: 100%;">
                 
                                 
                                            <option value='1'>Janaury</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                               </select>
                             </div>
                             
                            <div style="margin-top:0px; float: left; width:12%; margin-right: 1%;">
                              <p style="font-weight: bold;">Select Year</p>
                               <select id="marital_status" name="marital_status" class="form-control" style="width: 100%;">
                 
                                  <option selected="" value="1">2015</option>
                               </select>
                             </div>
                             
                             <div style="margin-top:0px; float: left; width:14%; margin-right: 1%;">
                              <p style="font-weight: bold;">Include Previous</p>
                               <select id="marital_status" name="marital_status" class="form-control" style="width: 100%;">
                 
                                  <option selected="selected" value="1">1 Month</option>
                                  <option selected="" value="1">2 Month</option>
                                  <option selected="" value="1">3 Month</option>
                                  <option selected="" value="1">4 Month</option>
                                  <option selected="" value="1">5 Month</option>
                                  <option selected="" value="1">6 Month</option>
                                  <option selected="" value="1">7 Month</option>
                                  <option selected="" value="1">8 Month</option>
                                  <option selected="" value="1">9 Month</option>
                                  <option selected="" value="1">10 Month</option>
                                  <option selected="" value="1">11 Month</option>
                                  <option selected="" value="1">12 Month</option>
                                  <option selected="" value="1">13 Month</option>
                                  <option selected="" value="1">14 Month</option>
                                  <option selected="" value="1">15 Month</option>
                                  <option selected="" value="1">16 Month</option>
                                  <option selected="" value="1">17 Month</option>
                                  <option selected="" value="1">18 Month</option>
                                  <option selected="" value="1">19 Month</option>
                                  <option selected="" value="1">20 Month</option>
                                  <option selected="" value="1">21 Month</option>
                                  <option selected="" value="1">22 Month</option>
                                  <option selected="" value="1">23 Month</option>
                                  <option selected="" value="1">24 Month</option>
                                  
                               </select>
                             </div>
                             
                             <div style="margin-top:0px; float: left; width:11%; margin-right: 1%;">
                              <p style="font-weight: bold;">Forecasts</p>
                               <input type="text" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555; padding: 7px 0px;   height: 34px; background: #fff; width: 100px;"/>
                             </div>
                             
                              <div style="margin-top:0px; float: left; width:11%;   height: 34px; margin-right: 1%;">
                              <p style="font-weight: bold;">Closed Deals</p>
                               <input type="text" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555; padding: 7px 0px; background: #fff; width: 100px;"/>
                             </div>
                             
                              <div style="margin-top:0px; float: left; width:11%;   height: 34px; margin-right: 1%;">
                              <p style="font-weight: bold;">Pipeline Deals</p>
                               <input type="text" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555; padding: 7px 0px; background: #fff; "/>
                             </div>
                             <div class="clearfix"></div>
                           </form> 
                           
                            
                            
                      
                      <div class="clearfix"></div>
                    </div>
                    
                    <!--
                    <div style="margin-bottom:20px;"><strong class="search_t">Search</strong> &nbsp;	<input style=" padding: 3px; border: #ccc solid 1px;   width: 16em;" type="text" name="search" value="" id="id_search" placeholder="" autofocus=""></div> -->
                    
                    
                    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                      <thead>
                        <tr role="row">
                        
                          <td align="center" width="4%" style="color: black; background: #deedf5;" >EDIT</td>
                          <td align="center" width="12%" style="background:#0066ff; color: white" >MONTHS</td>
                          <td align="center" width="12%" style="background:#00ccff; color: white">FORECAST</td>
                          <td align="center" width="12%"  style="background:#ffcd0a;; color: white">CLOSED DEALS</td>
                          <td align="center" width="12%" style="background:#ff3199; color: white">OTHER CLOSED</td>
                          <td align="center" width="12%" style="background:#f56954; color: white">VARIANCE</td>
                          <td align="center" width="12%" style="background:#4da2a2; color: white">PIPELINE DEALS</td>
                          <td align="center" width="12%" style="background:#ff3399; color: white">OTHER PIPELINE</td>
                          <td  align="center"width="12%" style="background:#f56954; color: white">VARIANCE</td>
                          
                          <!-- <th width="6%">Client Onboarding</th> -->
                        </tr>
                      </thead>

                      <tbody role="alert" aria-live="polite" aria-relevant="all">
                        
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS1</td>
                              <td align="center">FORECAST1</td>
                              <td align="center">CLOSED DEALS1</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE1</td>
                              <td align="center">PIPELINE DEALS1</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE1
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                            <tr>
                              
                              <td align="center"><img src="/img/edit_icon.png"> </td>
                              <td align="center"> MONTHS</td>
                              <td align="center">FORECAST</td>
                              <td align="center">CLOSED DEALS</td>
                              <td align="center"><input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 24px; "></td>
                              <td align="center">VARIANCE</td>
                              <td align="center">PIPELINE DEALS</td>
                              <td align="center">
                               <input type="text" class="forecasttext" value="" name="" id="" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142PX; border-radius: 5px; height: 24px; "></td>
                              <td align="center">
                                 VARIANCE
                              </td>
                             
                            </tr>
                           
                           
                            
                      
                      </tbody>
                    </table>
                    
                  
   
   <!-- Tab 7 -->
  </div>
  @endif
<!-- Tab 7 End-->

<!-- Tab 8 Start-->
@if($page_open == 8)
<div id="tab_8">
  <!-- <div id="tab_8" class="tab-pane {{ ($page_open == 8)?'active':'' }}"> -->
    <div class="import_fromch_main" style="width:600px; padding-left: 20px;   padding-bottom: 46px; padding-top: 10px;">
           
            <div class="import_fromch"  style=" margin-right: 42px;">
              <a href="javascript:void(0)" class="import_fromch_link">+ ADD NEW</a>
              
             
            </div>
            
            
            <div class="import_fromch" >
              <a href="javascript:void(0)" class="import_fromch_link">IMPORT - CSV</a>
              
              
            </div>
             
        </div>
        
        
  <div class="col_m2">
  
                  
                            <!--sub tab -->
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
                                <li class="active"><a data-toggle="tab" href="#tab_6">LIST</a></li>
                                <li class=""><a data-toggle="tab" href="#tab_7">EXAMPLE DESCRIPTION</a></li>
                              </ul>
                              <div class="tab-content">
                                <div id="tab_6" class="tab-pane active">
                                  <!--table area-->
                                  <div class="box-body table-responsive">
                                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                                      <div class="row">
                                        <div class="col-xs-6"></div>
                                        <div class="col-xs-6"></div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12">
                                          <div class="col_m2">
                                            <div class="notes_top_btns"> </div>
                                            <div class="total_annual_fee">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                
                                                <!--  <td>Total Annual Fees</td>
                                                  <td><input type="text" id="" class="form-control"></td>
                                                  <td width="10%">&nbsp;</td>
                                                  <td>Average Fees</td>
                                                  <td><input type="text" id="" class="form-control"></td> -->
                                                </tr>
                                              </tbody></table>
                                            </div>
                                            
                                            
                                            <table width="100%" border="0" class="staff_holidays">
                                              <tbody>
                                                <tr>
                                                  <td valign="top"><table width="100%" border="0">
                                                      <tbody>
                                                        <tr>
                                                         
                                                          
                                                          
                                                          
                                                          
                                                        </tr>
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                                <tr>
                                                  <td valign="top">
                                                   
                                                  
      <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">                                            
                                                  
                                                      <thead>
                                                        <tr>
                                                         
                                                          <td align="center" style="width:10%"><strong>Date</strong></td>
                                                          <td align="center" style="width:60%"><strong>List Name</strong></td>
                                                          <td align="center" style="width:20%"><strong>Action</strong></td>
                                                          <td align="center" style="width:10%"><strong>Notes</strong></td>
                                                          
                                                         
                                                        </tr>
                                                        </thead>
                                                      <tbody>
                                                        <tr>
                                                          
                                                          <td align="center">09-09-2015</td>
                                                          <td align="center">EXAMPLE DESCRIPTION</td>
                                                          <td align="center">
                                                          <span style="padding-right: 20px;"><button  style="border-radius: 4px; width: 100px; border-color: rgb(8, 102, 198);" >Download</button></span>
                                                          
                                                          
                                                          <span style="padding-left:10px ;">
                                                         
                                                          <img src="/img/edit_icon.png"></span>
                                                          <span style="padding-left:10px ;">
                                                          <img src="/img/cross.png">
                                                         </span>
                                                          </td>
                                                         <td align="center">
                                                  <a href="javascript:void(0)" class="notes_btn " id="mailingnotes"  data-leads_id="21" data-tab="11"><span style="">notes</span></a>
                                                          </td>
                            
                                                          
                                                       
                                                        </tr>
                                                     
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end table-->
                                </div>
                                <!-- /.tab-pane -->
                                <div id="tab_7" class="tab-pane">
                                  <!--table area-->
                                  <div class="box-body table-responsive">
                                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                                      <div class="row">
                                        <div class="col-xs-6"></div>
                                        <div class="col-xs-6"></div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-12">
                                          <div class="col_m2">
                                            <div class="notes_top_btns"> </div>
                                            <div class="total_annual_fee">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                <!--  <td>Total Annual Fees</td>
                                                  <td><input type="text" id="" class="form-control"></td>
                                                  <td width="10%">&nbsp;</td>
                                                  <td>Average Fees</td>
                                                  <td><input type="text" id="" class="form-control"></td> -->
                                                </tr>
                                              </tbody></table>
                                            </div>
                                            <table width="100%" border="0" class="staff_holidays">
                                              <tbody>
                                                <tr>
                                                  <td valign="top"><table width="100%" border="0">
                                                      <tbody>
                                                        <tr>
                                                          <td width="5%"><strong>Show</strong></td>
                                                          <td width="7%"><select class="form-control">
                                                              <option>50</option>
                                                              <option>20</option>
                                                              <option>10</option>
                                                              <option>15</option>
                                                            </select></td>
                                                          <td width="35%"><strong>entries</strong></td>
                                                          <td width="24%">&nbsp;</td>
                                                          <td width="5%"><strong>Search</strong></td>
                                                          <td width="21%"><input type="text" id="" class="form-control"></td>
                                                        </tr>
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                                <tr>
                                                  <td valign="top"><table width="100%" class="table table-bordered">
                                                      <tbody>
                                                        <tr>
                                                          <td><div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div></td>
                                                          <td><strong>Joining Date</strong></td>
                                                          <td align="center"><strong>Client Name</strong></td>
                                                          <td align="center"><strong>Payment Method</strong></td>
                                                          <td align="center"><strong>Engagement letters</strong></td>
                                                          <td align="center"><strong>Annual Fee</strong></td>
                                                          <td align="center"><strong>Monthly Fees</strong></td>
                                                          <td align="center"><strong>Contract End Date</strong></td>
                                                          <td align="center"><strong>Count Down</strong></td>
                                                          <td align="center"><strong>Renewals</strong></td>
                                                          <td align="center"><strong>Quotes</strong></td>
                                                        </tr>
                                                        <tr>
                                                          <td><div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div></td>
                                                          <td>09-09-2015</td>
                                                          <td align="center">Cockerton &amp; Co Limited</td>
                                                          <td align="center">ewfe</td>
                                                          <td align="center"><select class="form-control">
                                                              <option>50</option>
                                                              <option>20</option>
                                                              <option>10</option>
                                                              <option>15</option>
                                                            </select></td>
                                                          <td align="center">&nbsp;</td>
                                                          <td align="center">ergre</td>
                                                          <td align="center">ewfew</td>
                                                          <td align="center">ewf</td>
                                                          <td align="center"><button class="btn btn-default">SENT</button></td>
                                                          <td align="center"><button class="btn btn-default">View</button></td>
                                                        </tr>
                                                        <tr>
                                                          <td><div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div></td>
                                                          <td>09-09-2015</td>
                                                          <td align="center">Cockerton &amp; Co Limited</td>
                                                          <td align="center">ewfe</td>
                                                          <td align="center"><select class="form-control">
                                                              <option>50</option>
                                                              <option>20</option>
                                                              <option>10</option>
                                                              <option>15</option>
                                                            </select></td>
                                                          <td align="center">&nbsp;</td>
                                                          <td align="center">ergre</td>
                                                          <td align="center">ewfew</td>
                                                          <td align="center">ewf</td>
                                                          <td align="center"><button class="btn btn-default">SENT</button></td>
                                                          <td align="center"><button class="btn btn-default">View</button></td>
                                                        </tr>
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!--end table-->
                                </div>
                                <!-- /.tab-pane -->
                              </div>
                            </div>
                            <!--end sub tab-->
                          </div>
  
  
  
  
  
 <!-- Tab 8 -->
  </div>
  @endif
<!-- Tab 8 End-->
      

</div>