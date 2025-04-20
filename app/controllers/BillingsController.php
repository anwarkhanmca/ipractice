<?php
/*use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;*/

class BillingsController extends BaseController {
  private $_api_context;

  public function __construct()
  {
    parent::__construct();
    $session    = Session::get('admin_details');
    $this->user_id    = $session['id'];
    if (empty($this->user_id)) {
      Redirect::to('/login')->send();
    }
    if (isset($session['user_type']) && $session['user_type'] == "C") {
      Redirect::to('/client-portal')->send();
    }

    // setup PayPal api context
    /*$paypal_conf = Config::get('paypal');
    $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
    $this->_api_context->setConfig($paypal_conf['settings']);*/
  }

  public function billings_subscriptions()
  {
    $data['title']          = "Billings and Subscriptions";
    $data['heading']        = "BILLINGS AND SUBSCRIPTIONS";
    $data['previous_page']  = '<a href="/settings-dashboard">Settings</a>';   
        
    return View::make("settings.billings.billings", $data);
  }
    
  public function admin()
  {
    $data['title'] = "";
    $data['heading'] = "";
    //$data['previous_page'] ='<a href="/settings-dashboard">Settings</a>';   
        
    return View::make("settings.admin",$data);
  }
	
  public function payment($msg)
  {
    $data['title']          = "Billings and Subscriptions";
    $data['heading']        = "BILLINGS AND SUBSCRIPTIONS";
    $data['previous_page']  = '<a href="/settings-dashboard">Settings</a>';
    $data['user_id']        = $this->user_id;
    if(base64_decode($msg) == 'success'){
      $data['paypal_success'] = 'Your payment has been successfully completed.';
      $payment_session        = Session::get('payment_details');
      print_r($payment_session);
      if(isset($payment_session['total_amount']) && $payment_session['total_amount'] != ''){
        $arr['user_id']         = $this->user_id;
        $arr['no_of_clients']   = $payment_session['no_of_clients'];
        $arr['no_of_months']    = $payment_session['no_of_months'];
        $arr['perclient_price'] = $payment_session['perclient_price'];
        $arr['total_amount']    = $payment_session['total_amount'];
        $arr['currency_code']   = 'GBP';
        $arr['payment_status']  = 'Y';
        $arr['created']         = date('Y-m-d H:i:s');
        Payment::insert($arr);
        Session::forget('payment_details');
      }
      
    }

    if(base64_decode($msg) == 'error'){
      $data['paypal_error'] = 'There are some error, please try again';
    }


    $details = PaypalSetting::getDetails();

    if(isset($details['server']) && $details['server'] == "S"){
      $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }else{
      $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
    }
    
    $cancel_url = 'http://mpm.digiopia.in/payment/'.base64_encode('error');
    $return_url = 'http://mpm.digiopia.in/payment/'.base64_encode('success');

    $data['paypal_url']   = $paypal_url;  
    $data['paypal_id']    = isset($details['email'])?$details['email']:'';
    $data['cancel_url']   = $cancel_url;  
    $data['return_url']   = $return_url; 
    $data['client_price'] = isset($details['perclient_price'])?$details['perclient_price']:'0';

    return View::make("settings.billings.payment", $data);
  }

  public function store_payment_data()
  {
    $no_of_clients   = Input::get('no_of_clients');
    $no_of_months    = Input::get('no_of_months');
    $perclient_price = Input::get('perclient_price');
    $total_amount    = Input::get('total_amount');

    $arr['no_of_clients']     = $no_of_clients;
    $arr['no_of_months']      = $no_of_months;
    $arr['perclient_price']   = $perclient_price;
    $arr['total_amount']      = $total_amount;
    
    Session::put('payment_details', $arr);
    $payment_session = Session::get('payment_details');
    echo json_encode($payment_session);
    exit;
  }





//////
/*  public function postPayment()
{
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $item_1 = new Item();
    $item_1->setName('Item 1') // item name
        ->setCurrency('USD')
        ->setQuantity(2)
        ->setPrice('15'); // unit price

    // add item to list
    $item_list = new ItemList();
    $item_list->setItems(array($item_1));

    $amount = new Amount();
    $amount->setCurrency('USD')
        ->setTotal(78);

    $transaction = new Transaction();
    $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Your transaction description');

    $redirect_urls = new RedirectUrls();
    $redirect_urls->setReturnUrl(URL::route('payment.status'))
        ->setCancelUrl(URL::route('payment.status'));

    $payment = new Payment();
    $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));

    try {
        $payment->create($this->_api_context);
    } catch (\PayPal\Exception\PPConnectionException $ex) {
        if (\Config::get('app.debug')) {
            echo "Exception: " . $ex->getMessage() . PHP_EOL;
            $err_data = json_decode($ex->getData(), true);
            exit;
        } else {
            die('Some error occur, sorry for inconvenient');
        }
    }

    foreach($payment->getLinks() as $link) {
        if($link->getRel() == 'approval_url') {
            $redirect_url = $link->getHref();
            break;
        }
    }

    // add payment ID to session
    Session::put('paypal_payment_id', $payment->getId());

    if(isset($redirect_url)) {
        // redirect to paypal
        return Redirect::away($redirect_url);
    }

    return Redirect::route('original.route')
        ->with('error', 'Unknown error occurred');
}


public function getPaymentStatus()
{
    // Get the payment ID before session clear
    $payment_id = Session::get('paypal_payment_id');

    // clear the session payment ID
    Session::forget('paypal_payment_id');

    if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
        return Redirect::route('original.route')
            ->with('error', 'Payment failed');
    }

    $payment = Payment::get($payment_id, $this->_api_context);

    // PaymentExecution object includes information necessary 
    // to execute a PayPal account payment. 
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = new PaymentExecution();
    $execution->setPayerId(Input::get('PayerID'));

    //Execute the payment
    $result = $payment->execute($execution, $this->_api_context);

    echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later

    if ($result->getState() == 'approved') { // payment made
        return Redirect::route('original.route')
            ->with('success', 'Payment success');
    }
    return Redirect::route('original.route')
        ->with('error', 'Payment failed');
}*/




}
