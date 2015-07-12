<?php

class Fsb_Dbblmaster_Model_Checkout extends Mage_Payment_Model_Method_Abstract {

    protected $_code          = 'dbblmaster';
    protected $_formBlockType = 'dbblmaster/form';
    protected $_infoBlockType = 'dbblmaster/info';


    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

    public function getOrderPlaceRedirectUrl() {
        return Mage::getUrl('dbblmaster/redirect', array('_secure' => true));
    }

    public function getWebmoneyUrl() {
		$url = 'http://bangladeshbrand.com/dbblpay/payment.php';
        return $url;
    }

    public function getQuote() {

        $orderIncrementId = $this->getCheckout()->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);		        
        return $order;
    }

    public function getWebmoneyCheckoutFormFields() {



        $order_id = $this->getCheckout()->getLastRealOrderId();
        $order    = Mage::getModel('sales/order')->loadByIncrementId($order_id);
        $amount   = trim(round($order->getGrandTotal(), 2));
		
		$name = Mage::getSingleton('customer/session')->getCustomer()->getName();
		$customer_id = Mage::getSingleton('customer/session')->getCustomer()->getCustomerId();
		$email =  Mage::getSingleton('customer/session')->getCustomer()->getEmail();
		
		
		
		/*
		*   set order id in session
		*/
		
		
		$_SESSION['specialy_order_id_odd'] = $order_id;
		
		/*
		*	Put the values for desier domain and redirect url
		*	domain name is the domain name from which is going to check out	
		*	redirect url is the url to redirect	
		*/
		
		$payment_method = 'dutch';

		$domain_url = Mage::getBaseUrl (Mage_Core_Model_Store::URL_TYPE_WEB);	
		
		$domain_name = $domain_url;
		$redirect_url = $domain_url.'index.php/dbblmaster/redirect/success';


		/**
		*		1 = Nexus; 5 = MasterCard; 4 = VISA; 3 = VisaDebit; 2 = MasterDebit 
		*
		**/
		
        $params = array(
	
		'paymnet_method' => $payment_method,
		'name' 			 => $name,
		'email' 		 => $email,
		'customer_id'  	 => $customer_id,
		'domain' 		 => $domain_name,
		'red_url' 		 => $redirect_url,
		'card_type'		 =>'5',
		'transaction_id' => $order_id,
		'amount' 		 => $amount 
		
			
        );
        return $params;


    }
}
