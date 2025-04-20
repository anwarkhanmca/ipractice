<?php
if (isset($_REQUEST)){
	if (!isset($_REQUEST['where'])) $_REQUEST['where'] = "";
}
//echo "<pre>";print_r($_REQUEST);die;	

  if ( isset($_REQUEST['wipe'])) {
    $owner_id = $_REQUEST['owner_id'];
    session_destroy();
    header("Location: ".$base_url."crm/".base64_encode('4')."/".$owner_id);

  }else if ( isset($_REQUEST['sesson_destroy'])) {
    session_destroy();
    echo "<script>top.window.location = '/crm/apps'</script>";

  } elseif(isset($_REQUEST['refresh'])) {
      $response = $XeroOAuth->refreshToken($oauthSession['oauth_token'], $oauthSession['oauth_session_handle']);
      if ($XeroOAuth->response['code'] == 200) {
          $session = persistSession($response);
          $oauthSession = retrieveSession();
      } else {
          outputError($XeroOAuth);//die;
          if ($XeroOAuth->response['helper'] == "TokenExpired") $XeroOAuth->refreshToken($oauthSession['oauth_token'], $oauthSession['session_handle']);
      }
      echo "<script>top.window.location = '/crm/apps'</script>";

  } elseif ( isset($oauthSession['oauth_token']) && isset($_REQUEST) ) {

    $XeroOAuth->config['access_token']  = $oauthSession['oauth_token'];
    $XeroOAuth->config['access_token_secret'] = $oauthSession['oauth_token_secret'];
    $XeroOAuth->config['session_handle'] = $oauthSession['oauth_session_handle'];

    if( isset($_REQUEST['contacts'])) {
      if (!isset($_REQUEST['method'])) {
        $response = $XeroOAuth->request('GET', $XeroOAuth->url('Contacts', 'core'), array('where'=>'EmailAddress!=""'));
        if ($XeroOAuth->response['code'] == 200) {
          $contacts = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
          echo "There are " . count($contacts->Contacts[0]). " contacts in this Xero organisation, the first one is: </br>";
          //echo "<pre>";print_r($contacts->Contacts[0]->Contact);//die;
          $contact_array = (array) $contacts->Contacts[0];
          $contacts = XeroApi::getContactArray($contact_array);
          //echo "<pre>";print_r($contact_array);
          //echo "<pre>";print_r($contacts);
          
        } else {
             outputError($XeroOAuth);
        }
      } elseif(isset($_REQUEST['method']) && $_REQUEST['method'] == "post" ){
        $xml = "<Contacts>
                 <Contact>
                   <Name>Matthew and son</Name>
                   <EmailAddress>emailaddress@yourdomain.com</EmailAddress>
                   <SkypeUserName>matthewson_test99</SkypeUserName>
                   <FirstName>Matthew</FirstName>
                   <LastName>Masters</LastName>
                 </Contact>
               </Contacts>
               ";
        $response = $XeroOAuth->request('POST', $XeroOAuth->url('Contacts', 'core'), array(), $xml);
        if ($XeroOAuth->response['code'] == 200) {
          $contact = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
           echo "" . count($contact->Contacts[0]). " contact created/updated in this Xero organisation.";
           if (count($contact->Contacts[0])>0) {
               echo "The first one is: </br>";
               pr($contact->Contacts[0]->Contact);
          }
        } else {
               outputError($XeroOAuth);
        }
      }elseif(isset($_REQUEST['method']) && $_REQUEST['method'] == "put" ){
        $xml = "<Contacts>
            <Contact>
              <Name>Orlena Greenville</Name>
            </Contact>
          </Contacts>";
        $response = $XeroOAuth->request('PUT', $XeroOAuth->url('Contacts', 'core'), array(), $xml);
        if ($XeroOAuth->response['code'] == 200) {
          $contacts = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
          echo "There are " . count($contacts->Contacts[0]). " successful contact(s) created in this Xero organisation.";
          if(count($contacts->Contacts[0])>0){
            echo "The first one is: </br>";
            pr($contacts->Contacts[0]->Contact);
          }
        } else {
          outputError($XeroOAuth); 
        }
      }
    }//not check

    //echo "<pre>";print_r($_REQUEST);die;  
    if (isset($_REQUEST['invoice'])) {
      $owner_id = $_REQUEST['owner_id'];
      if (!isset($_REQUEST['method'])) {
        $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoices', 'core'), array('where'=>'status="AUTHORISED" and Type="ACCREC"', 'order'=>'Total DESC'));
        if ($XeroOAuth->response['code'] == 200) {//echo "<pre>";print_r($response);
            $invoices = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
            //echo "There are ".count($invoices->Invoices[0])." invoices in this Xero organisation, the first one is: </br>";
            echo "<pre>";print_r($invoices->Invoices[0]->Invoice);
            $invoice_array = (array) $invoices->Invoices[0];
            echo "<pre>";print_r($invoice_array['Invoice']);echo "Anwar";die;

            /* =============== User defined function =============== */
            $return = XeroApi::save_invoices($invoices->Invoices[0], $contacts);
            if($return >= 1){
              session_destroy();
            }
            header("Location: ".$base_url."crm/".base64_encode('4')."/".$owner_id);
            /* =============== User defined function =============== */

            if ($_REQUEST['invoice']=="pdf") {
                $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoice/'.$invoices->Invoices[0]->Invoice->InvoiceID, 'core'), array(), "", 'pdf');
                if ($XeroOAuth->response['code'] == 200) {
                    $myFile = $invoices->Invoices[0]->Invoice->InvoiceID.".pdf";
                    $fh = fopen($myFile, 'w') or die("can't open file");
                    fwrite($fh, $XeroOAuth->response['response']);
                    fclose($fh);
                    echo "PDF copy downloaded, check your the directory of this script.</br>";
                } else {die('first die');
                    outputError($XeroOAuth);
                }
            }
        } else {die('last die');
            outputError($XeroOAuth);
        }
      }elseif(isset($_REQUEST['method']) && $_REQUEST['method'] == "put" && $_REQUEST['invoice']==1){
        $ids = isset($_REQUEST['ids'])?explode(',', $_REQUEST['ids']):array();
        $ids = $_REQUEST['ids'];

        $xml = "<Invoices>";
        if(isset($_REQUEST['page_name']) && $_REQUEST['page_name'] == 'wip'){

          $dtls = XeroApi::getWipInvoiceDetailsByIds( $ids );
          if(isset($dtls) && count($dtls) >0){
            foreach ($dtls as $k => $d) {
              $client_name = !empty($d['client_name'])?$d['client_name']:'';

              $xml .= "<Invoice>
                <Type>ACCREC</Type>
                <Contact>
                  <Name>".htmlentities($client_name)."</Name>
                </Contact>
                <Date>".date('Y-m-d')."T00:00:00</Date>
                <DueDate>".date('Y-m-d')."T00:00:00</DueDate>
                <LineAmountTypes>Exclusive</LineAmountTypes>";
                $xml .= "<LineItems>";
                if(isset($d['LineItem']) && count($d['LineItem']) >0){
                  
                  foreach ($d['LineItem'] as $sk => $sd) {
                    $activity_name = ';';
                    if(isset($sd['activity_name']) && !empty($sd['activity_name'])){
                      $activity       = implode(';',$sd['activity_name']);
                      $activity_name  .= htmlentities($activity);
                    }

                    $taskname = str_replace("'", "`", htmlentities($sd['taskname']));
                    $xml .= "<LineItem>
                      <Description>".$taskname.$activity_name."</Description>
                      <Quantity>1</Quantity>
                      <UnitAmount>".$sd['amount']."</UnitAmount>
                      <AccountCode>200</AccountCode>
                    </LineItem>";
                  }
                  
                }
              $xml .= "</LineItems>";
              $xml .= "</Invoice>";
            }
          }


          /*if(isset($ids) && count($ids) >0){
            foreach ($ids as $k => $v) {
              $d = XeroApi::getWipDetailsById($v);
              $activity_name = '';
              if(!empty($d['activity_name'])){
                $activity_name = implode(';',$d['activity_name']);
              }
              
              $xml .= "<Invoice>
                  <Type>ACCREC</Type>
                  <Contact>
                    <Name>".$d['client_name']."</Name>
                  </Contact>
                  <Date>".date('Y-m-d')."T00:00:00</Date>
                  <DueDate>".date('Y-m-d')."T00:00:00</DueDate>
                  <LineAmountTypes>Exclusive</LineAmountTypes>
                  <LineItems>
                    <LineItem>
                      <Description>".$d['taskname'].";".$activity_name."</Description>
                      <Quantity>1</Quantity>
                      <UnitAmount>".$d['amount']."</UnitAmount>
                      <AccountCode>200</AccountCode>
                    </LineItem>
                  </LineItems>
                </Invoice>";
            }
          }*/
        }
          
        $xml .= "</Invoices>";

        $response = $XeroOAuth->request('PUT', $XeroOAuth->url('invoices', 'core'), array(), $xml);
        //echo "<pre>";print_r($response);die;
        if ($XeroOAuth->response['code'] == 200) {
          if(isset($_REQUEST['page_name']) && $_REQUEST['page_name'] == 'wip'){
            XeroApi::updateWipInvoiceByIds( $ids );

            echo "<script>top.window.location = '/crm/OQ==/YWxs/wip'</script>";
          }
          /*$invoice = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
          echo "" . count($invoice->Invoices[0]). " invoice created in this Xero organisation.";
          if (count($invoice->Invoices[0])>0) {
            echo "The first one is: </br>";
            pr($invoice->Invoices[0]->Invoice);
          }*/
        } else {
            outputError($XeroOAuth);
        }
      } elseif (isset($_REQUEST['method']) && $_REQUEST['method'] == "4dp" && $_REQUEST['invoice']== 1 ) {
        $xml = "<Invoices>
          <Invoice>
            <Type>ACCREC</Type>
            <Contact>
              <Name>Steve Buscemi</Name>
            </Contact>
            <Date>2014-05-13T00:00:00</Date>
            <DueDate>2014-05-20T00:00:00</DueDate>
            <LineAmountTypes>Exclusive</LineAmountTypes>
            <LineItems>
              <LineItem>
                <Description>Monthly rental for property at 56b Wilkins Avenue</Description>
                <Quantity>4.3400</Quantity>
                <UnitAmount>395.6789</UnitAmount>
                <AccountCode>200</AccountCode>
              </LineItem>
            </LineItems>
          </Invoice>
        </Invoices>";
        $response = $XeroOAuth->request('PUT', $XeroOAuth->url('Invoices', 'core'), array('unitdp' => '4'), $xml);
        if ($XeroOAuth->response['code'] == 200) {
          $invoice = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
          echo "" . count($invoice->Invoices[0]). " invoice created in this Xero organisation.";
          if (count($invoice->Invoices[0])>0) {
              echo "The first one is: </br>";
              pr($invoice->Invoices[0]->Invoice);
          }
        } else {
            outputError($XeroOAuth);
        }
      } elseif (isset($_REQUEST['method']) && $_REQUEST['method'] == "post" ) {
          $xml = "<Invoices>
                    <Invoice>
                      <Type>ACCREC</Type>
                      <Contact>
                        <Name>Martin Hudson</Name>
                      </Contact>
                      <Date>2013-05-13T00:00:00</Date>
                      <DueDate>2013-05-20T00:00:00</DueDate>
                      <LineAmountTypes>Exclusive</LineAmountTypes>
                      <LineItems>
                        <LineItem>
                          <Description>Monthly rental for property at 56a Wilkins Avenue</Description>
                          <Quantity>4.3400</Quantity>
                          <UnitAmount>395.00</UnitAmount>
                          <AccountCode>200</AccountCode>
                        </LineItem>
                     </LineItems>
                   </Invoice>
                 </Invoices>";
          $response = $XeroOAuth->request('POST', $XeroOAuth->url('Invoices', 'core'), array(), $xml);
          if ($XeroOAuth->response['code'] == 200) {
              $invoice = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
              echo "" . count($invoice->Invoices[0]). " invoice created in this Xero organisation.";
              if (count($invoice->Invoices[0])>0) {
                  echo "The first one is: </br>";
                  pr($invoice->Invoices[0]->Invoice);
              }
          } else {
              outputError($XeroOAuth);
          }
      }elseif(isset($_REQUEST['method']) && $_REQUEST['method'] == "put" && $_REQUEST['invoice']=="attachment" ){
        $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoices', 'core'), array('Where' => 'Status=="DRAFT"'));
            if ($XeroOAuth->response['code'] == 200) {
                $invoices = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                echo "There are " . count($invoices->Invoices[0]). " draft invoices in this Xero organisation, the first one is: </br>";
                pr($invoices->Invoices[0]->Invoice);
                if ($_REQUEST['invoice']=="attachment") {
                  $attachmentFile = file_get_contents('http://i.imgur.com/mkDFLf2.png');

                    $response = $XeroOAuth->request('PUT', $XeroOAuth->url('Invoice/'.$invoices->Invoices[0]->Invoice->InvoiceID.'/Attachments/image.png', 'core'), array(), $attachmentFile, 'file');
                    if ($XeroOAuth->response['code'] == 200) {
                        echo "Attachment successfully created against this invoice.";
                  } else {
                      outputError($XeroOAuth);
                  }
                }
            } else {
                outputError($XeroOAuth);
            }
         
      }

    }else{
      //echo "<script>top.window.location = '/crm/OQ==/YWxs/wip'</script>";
    }
}

