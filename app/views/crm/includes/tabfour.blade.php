<?php 
session_start();

?>

<div class="col_m2" style="height: 56px;">
  <div style="z-index: 99;"> 
    <!-- <div class="import_fromch" style="margin-right: 74%">
      <a href="javascript:void(0)" class="import_fromch_link">SEND DIRECT DEBIT REQUEST</a>
    </div> -->
    <div class="import_fromch_main" style="float:left;margin-right: 15%">
      <div class="import_fromch" style="width:136px">
        <a href="/import-from-ch/b3JnX2xpc3Q=" class="import_fromch_link">DIRECT DEBIT</a>
        <a href="javascript:void(0)" class="i_selectbox" id="select_icon"><img src="/img/arrow_icon.png"></a>
        <div class="clearfix"></div>
      </div>
      <div class="i_dropdown open_toggle"><a href="/chdata/bulk-company-upload-page/b3JnX2xpc3Q=">No Data</a></div>
    </div>

    <div style="float:left; width:20%; margin-top: 8px;">
      <div class="inner_hed">Total <strong class="collection_color">Amount Due</strong></div>
      <div class="inner_hed">{{ isset($tab_details['Amount_Due'])?number_format($tab_details['Amount_Due'], 2):'' }}</div>
    </div>

    <div style="float:left; width:20%; margin-top: 8px;">
      <div class="inner_hed">Total To be Collected :</div>
      <div class="inner_hed">{{ isset($tab_details['ToBe_Collected'])?number_format($tab_details['ToBe_Collected'], 2):'' }}</div>
    </div>

    <?php if(!isset($_SESSION['access_token'])){?>
    <div class="import_fromch" style="float:left;">
      <a href="/xero/index.php" target="_blank" class="btn btn-info">SYNC WITH XERO</a>
    </div>
    <?php }else{?>
    <script>
    if (window.opener) {
      window.opener.location.href = window.opener.location.href;
      if (window.opener.progressWindow){
          window.opener.progressWindow.close()
      }
      window.close();    
    } 
    </script>
    <?php }?>
    <script>
    function import_from_xero(){///import_from_xero
        url='/xero/index.php?authenticate=1';
        newwindow=window.open(url,'name','left=300,top=100,height=600,width=750,scrollbars=1');
        if (window.focus) {newwindow.focus();}
        return false;
    }
    </script>
    <?php if (isset($_SESSION['access_token'])){?>
        <div class="import_fromch" style="float:left;margin-right: 10px; margin-left: 10%">
          <a href="/xero/index.php?invoice=1&owner_id={{ base64_encode($owner_id) }}&contacts=1" class="btn btn-info">IMPORT INVOICE</a>
        </div>

        <div class="import_fromch" style="float:left;">
          <a href="/xero/index.php?wipe=1&owner_id={{ base64_encode($owner_id) }}" class="btn btn-info">REFRESH</a>
        </div>
    <?php }?>


  </div>
</div>

<div class="tabarea">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg">
      <li class="{{ ($page_open == 4)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('4') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">OUTSTANDING INVOICES</a></li>
      <li class="{{ ($page_open == 42)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('42') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">TO BE COLLECTED</a></li>
      <li class="{{ ($page_open == 43)?'active':'' }}" style="float:right;"><a href="{{ $goto_url }}/{{ base64_encode('43') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">SETTINGS</a></li>
    </ul>
    <div class="tab-content">
      <div id="tab_4" class="tab-pane {{ ($page_open == 4)?'active':'' }}">
      <!-- <div style="height:14px; background:#0866c6; width:100% "></div> -->
        <table class="table table-bordered table-hover dataTable crm" id="exampletab4" aria-describedby="exampletab4_info">
          <thead>
            <tr>
              <td align="center" width="3%"><input type="checkbox" /></td>
              <td align="left" width="30%"><strong>Client Name</strong></td>
              <td align="left" width="15%"><strong>Contact Name</strong></td>
              <td align="left"><strong>Email</strong></td>
              <td align="left" width="11%"><strong>Telephone Number</strong></td>
              <td align="right" width="8%"><strong class="collection_color">Amount Due</strong></td>
              <td align="center" width="10%"><strong>DD Status</strong></td>
              <!-- <td align="right" width="11%"><strong>To be Collected (&#163;)</strong></td>
              <td width="8%"><strong>Auto Collect</strong></td>
              <td align="center" width="8%"><strong>Merge Client</strong></td> -->
            </tr>
          </thead>
          <tbody>
          @if(isset($org_clients) && count($org_clients) >0)
            @foreach($org_clients as $key=>$value)
            <tr class="inv_tr_{{ $value['client_id'] or "" }}">
              <td align="center"><input type="checkbox" /></td>
              <td>{{ $value['business_name'] or "" }}</td>
              <td align="left">
                <select class="form-control newdropdown select_acc_details" style="width:100%;height:30px;" data-client_id="{{ $value['client_id'] or "" }}" data-client_type="org">
                  <option value="">-- None --</option>
                  @if(isset($value['contact_persons']) && count($value['contact_persons'])>0)
                    @foreach($value['contact_persons'] as $key=>$contact_row)
                    <option value="{{ $contact_row['client_id'] or "" }}_{{ $contact_row['address_type'] or "" }}" {{ (isset($value['contacts']['check']) && $value['contacts']['check'] == $contact_row['client_id']."_".$contact_row['address_type'])?"selected":"" }}>{{ $contact_row['contact_name'] or "" }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
              <td align="left">{{ $value['contacts']['email'] or "" }}</td>
              <td align="left">{{ $value['contacts']['telephone'] or "" }}</td>
              <td align="right">
                <a href="javascript:void(0)" class="amount_mdd" data-contact_id="{{ $value['ContactID'] or "" }}" data-type="org">{{ isset($value['AmountDue'])?number_format($value['AmountDue'], 2):"0.00" }}</a>
              </td>
              <!-- <td align="right">{{ (isset($value['ToBeCollected']) && ($value['ToBeCollected'] != '0' || $value['ToBeCollected'] != '0.00'))?number_format($value['ToBeCollected'], 2):'0.00' }}</td> -->
              <td align="center">
                <div class="pending">PENDING</div>
                <!-- <select class="form-control newdropdown">
                  <option value="Authorised">Authorised</option>
                  <option value="Awaiting Authorisation">Awaiting Authorisation</option>
                  <option value="Cancelled">Cancelled</option>
                  <option value="No DD Requested">No DD Requested</option>
                </select> -->
              </td>
              <!-- <td align="center">
                <a href="javascript:void(0)" class="notes_btn autocollect_pop" data-client_type="org" data-client_id="{{ $value['client_id'] or "" }}">Action</a>
                @if(isset($value['auto_collect']) && $value['auto_collect'] == 'Y')
                  <a href="javascript:void(0)" class="notes_btn autocollect_pop" data-client_type="org" data-client_id="{{ $value['client_id'] or "" }}">Action</a>
                @else
                  <span class="disable_btn">Action</span>
                @endif
              </td>
              <td align="center"><a href="javascript:void(0)" class="open_edit_pop" data-client_type="org" data-client_id="{{ $value['client_id'] or "" }}">View</a></td> -->
            </tr>
            @endforeach
          @endif


          @if(isset($tab_details['invoice_details']) && count($tab_details['invoice_details']) >0)
            @foreach($tab_details['invoice_details'] as $key=>$value)
              @if($value['merged_client_id'] == '0')
              <tr class="inv_tr_{{ $value['crm_invoice_id'] or "" }}">
                <td align="center"><input type="checkbox" /></td>
                <td>{{ $value['Name'] or "" }}</td>
                <td align="center">&nbsp;</td>
                <td align="left">{{ $value['EmailAddress'] or "" }}</td>
                <td align="left"></td>
                <td align="right"><a href="javascript:void(0)" class="amount_mdd" data-id="{{ $value['crm_invoice_id'] or "" }}" data-contact_id="{{ $value['ContactID'] or "" }}"  data-type="xero">{{ isset($value['TotalAmountDue'])?number_format($value['TotalAmountDue'], 2):'0.00' }}</a></td>
                <!-- <td align="right">{{ (isset($value['TotalCollected']) && $value['TotalCollected'] != 0)?number_format($value['TotalCollected'], 2):'0.00' }}</td> -->
                <td align="center"><div class="received">RECEIVED</div></td>
                
                <!-- <td align="center">
                  <a href="javascript:void(0)" class="notes_btn autocollect_pop" data-client_type="xero" data-contact_id="{{ $value['ContactID'] or "" }}" data-invoice_id="{{ $value['crm_invoice_id'] or "" }}" data-client_id="0">Action</a>
                  @if(isset($value['auto_collect']) && $value['auto_collect'] == 'Y')
                    <a href="javascript:void(0)" class="notes_btn autocollect_pop" data-client_type="xero" data-contact_id="{{ $value['ContactID'] or "" }}" data-invoice_id="{{ $value['crm_invoice_id'] or "" }}" data-client_id="0">Action</a>
                  @else
                    <span class="disable_btn">Action</span>
                  @endif
                </td>
                <td align="center"><a href="javascript:void(0)" class="open_edit_pop" data-client_type="xero" data-contact_id="{{ $value['ContactID'] or "" }}" data-id="{{ $value['crm_invoice_id'] or "" }}">Merge</a></td> -->
              </tr>
              @endif
            @endforeach
          @endif
          </tbody>
        </table>
      </div>

      <div id="tab_42" class="tab-pane {{ ($page_open == 42)?'active':'' }}">
        <table class="table table-bordered table-hover dataTable crm" id="exampletab42">
          <thead>
            <tr>
              <td width="5%">Delete</td>
              <td align="left" width="30%"><strong>Client Name</strong></td>
              <td align="left" width="15%"><strong>Payment ID</strong></td>
              <td align="center"><strong>Details</strong></td>
              <td align="center" width="11%"><strong>Created</strong></td>
              <td align="right" width="10%"><strong class="collection_color">Amount</strong></td>
              <td align="center" width="10%"><strong>Fee</strong></td>
              <td align="center" width="12%"><strong>Payment Status</strong></td>
            </tr>
          </thead>
          <tbody>
         @if(isset($tab_details['invoice_details']) && count($tab_details['invoice_details']) >0)
            @foreach($tab_details['invoice_details'] as $key=>$value)
            <tr class="inv_tr_{{ $value['crm_invoice_id'] or "" }}">
              <td align="center"><a href="javascript:void(0)" class="delete_invoice" data-invoice_id="{{ $value['crm_invoice_id'] or '' }}" data-invoice_no="{{ $value['InvoiceNumber'] or "" }}" data-client_type="xero"><img src="/img/cross.png"></a></td>
              <td>{{ $value['Name'] or "" }}</td>
              <td align="center">&nbsp;</td>
              <td align="center">{{ $value['InvoiceNumber'] or "" }}</td>
              <td align="center">{{ $value['collection_date'] or "" }}</td>
              <td align="right">{{ $value['new_amount'] or "" }}</td>
              <td align="right"></td>
              <td align="center"><div class="received">RECEIVED</div></td>
            </tr>
            @endforeach
          @endif 
          </tbody>
        </table>
      </div>

      <div id="tab_43" class="tab-pane {{ ($page_open == 43)?'active':'' }}">
        <div class="debit_set">
          <table width="100%">
            <tr>
              <td colspan="4"><strong>Connected Services</strong></td>
            </tr>
            <tr>
              <td width="10%">Gocardless </td>
              <td width="10%"><a href="javascript:void(0)">Connect</a></td>
              <td width="10%">Xero</td>
              <td width="10%"><a href="javascript:void(0)">Connect</a></td>
            </tr>
            <tr>
              <td>Smart Debit</td>
              <td><a href="javascript:void(0)">Connect</a></td>
              <td>Quick Books</td>
              <td><a href="javascript:void(0)">Connect</a></td>
            </tr>
          </table>
        </div>
      </div>





    </div>
  </div>
</div>
