<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 20px;">
    <tr>
        <td width="10%"><strong>Payment Method</strong></td>
        <td width="15%">
            <div class="pay_method">
                <select class="form-control newdropdown change_payment" data-client_id="{{ $client_details['client_id'] or '' }}" data-data_type="payment_method">
                  <option value="0" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '0')?'selected':''}}>None</option>
                  <option value="1" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '1')?'selected':''}}>Direct Debit</option>
                  <option value="2" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '2')?'selected':''}}>Invoice Basis</option>
                  <option value="3" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '3')?'selected':''}}>Standing Order</option>
                  <option value="4" {{(isset($acc_details['payment_method']) && $acc_details['payment_method'] == '4')?'selected':''}}>Other</option>
                </select>
          </div>
        </td>
        <td width="8%"><strong>Billing Cycle</strong></td>
        <td width="15%">
          <div class="pay_method">
            <select class="form-control newdropdown change_payment" data-client_id="{{ $client_details['client_id'] or '' }}" data-data_type="billing_cycle">
              <option value="0" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '0')?'selected':''}}>None</option>
              <option value="1" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '1')?'selected':''}}>Weekly</option>
              <option value="2" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '2')?'selected':''}}>Monthly</option>
              <option value="3" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '3')?'selected':''}}>Yearly</option>
              <option value="4" {{(isset($acc_details['billing_cycle']) && $acc_details['billing_cycle'] == '4')?'selected':''}}>Adhoc</option>
            </select>
          </div>
        </td>
        <td width="56%"><strong>Direct Debit Status</strong></td>
    </tr>
</table>

<div class="basic_info_relationship">
    <ul>
        <li>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><p class="table_h">Recurring Contracts</p></td>
              <td width="78%">&nbsp;</td>
            </tr>
          </table>
          
          <div class="row bottom_space">
            <div class="col-xs-6">
              <div class="dataTables_length" id="example2_length">
                
              </div>
            </div>
            <div class="col-xs-6">
              <div id="example2_filter" class="dataTables_filter">
                <form>
                  <input type="text" name="recurringText" id="recurringText" placeholder="Search" class="tableSearch" />
                  <button type="submit" id="LoadrecurringButton" style="display: none;">Search</button>
                </form>
              </div>
            </div>
          </div>
          <div id="recurringContracts"></div>
        </li>

        <li>
          <p class="table_h">Non Recurring Contracts</p>
          <div class="row bottom_space">
            <div class="col-xs-6">
              <div class="dataTables_length" id="example2_length">
                
              </div>
            </div>
            <div class="col-xs-6">
              <div id="example2_filter" class="dataTables_filter">
                <form>
                  <input type="text" name="nonRecurringText" id="nonRecurringText" placeholder="Search" class="tableSearch" />
                  <button type="submit" id="LoadNonRecurringButton" style="display: none;">Search</button>
                </form>
              </div>
            </div>
          </div>
          <div id="nonRecurringContracts"></div>
        </li>

        <li>
            <p class="table_h">Services</p>
            <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">

            @if(isset($renewalServices) && count($renewalServices) >0)
              @foreach($renewalServices as $key=>$service_row)
              <tr>
                <td align="left">{{ $service_row['service_name'] }}</td>
              </tr>
              @endforeach
            @else
              <tr>
                <td align="left">No records to display</td>
              </tr>
            @endif
            </table>
        </li>

    </ul>
</div>
