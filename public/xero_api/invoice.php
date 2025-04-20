<?php
if (isset($_REQUEST['method']) && $_REQUEST['method'] == "put" && $_REQUEST['invoice']== 1 ){
    $ids = $_REQUEST['ids'];

    $xml = "<Invoices>";
    if(isset($_REQUEST['page_name']) && $_REQUEST['page_name'] == 'wip'){

      $dtls = XeroApi::getWipInvoiceDetailsByIds( $ids );
      if(isset($dtls) && count($dtls) >0){
        foreach ($dtls as $k => $d) {
          $xml .= "<Invoice>
            <Type>ACCREC</Type>
            <Contact>
              <Name>".$d['client_name']."</Name>
            </Contact>
            <Date>".date('Y-m-d')."T00:00:00</Date>
            <DueDate>".date('Y-m-d')."T00:00:00</DueDate>
            <LineAmountTypes>Exclusive</LineAmountTypes>
            <LineItems>";
            if(isset($d['LineItem']) && count($d['LineItem']) >0){
              foreach ($d['LineItem'] as $sk => $sd) {
                $activity_name = '';
                if(!empty($sd['activity_name'])){
                  $activity_name = implode(';',$sd['activity_name']);
                }
                $xml .= "<LineItem>
                  <Description>".$sd['taskname'].";".$activity_name."</Description>
                  <Quantity>1</Quantity>
                  <UnitAmount>".$sd['amount']."</UnitAmount>
                  <AccountCode>200</AccountCode>
                </LineItem>";
              }
            }
          $xml .= "</LineItems></Invoice>";
        }
      }
    }
      
    $xml .= "</Invoices>";

    $response = $XeroOAuth->request('PUT', $XeroOAuth->url('invoices', 'core'), array(), $xml);
    //echo "<pre>";print_r($response);die;
    if ($XeroOAuth->response['code'] == 200) {
      if(isset($_REQUEST['page_name']) && $_REQUEST['page_name'] == 'wip'){
        //XeroApi::updateWipInvoiceByIds( $ids );
        echo "<script>top.window.location = '/crm/OQ==/YWxs/wip'</script>";
      }
    } else {
        outputError($XeroOAuth);
    }
    include 'invoice.php';
  }
?>