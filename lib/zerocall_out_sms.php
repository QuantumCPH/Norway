<?php
require_once(sfConfig::get('sf_lib_dir') . '/smsCharacterReplacement.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ZeroCallOutSMS {
/*
 * @@prductName: This will be sent in the sms.
 * @@telephoneNumber: this will be sent in the SMS.
 * @@password: password of the account to be sent in sms.
 * @@recepientMobileNumber: This needs to be a complete number where user will be receiving the sms.
 *
 */
    public function toCustomerAfterReg($productId, Customer $customer) {
        
        $product                = ProductPeer::retrieveByPK($productId);
        $productName            = $product->getName();
        $telephoneNumber        = $customer->getMobileNumber();
        $callingCode            = '47';
        $recipientMobileNumber  = $callingCode.$telephoneNumber;
        $password               = $customer->getPlainText();
        $agentid                = $customer->getReferrerId();
         if (isset($agentid) && $agentid != "") {
             $agent = AgentCompanyPeer::retrieveByPK($agentid);
             $agentMobileNumber = $agent->getMobileNumber();
             
             $this->toAgentAfterReg($telephoneNumber, $agentMobileNumber);
        }


        $sms_dk_object = SmsTextPeer::retrieveByPK(4);
        $sms_uk_object = SmsTextPeer::retrieveByPK(5);
        $sms_dk_object2 = SmsTextPeer::retrieveByPK(6);


        $sms_text_dk = $sms_dk_object->getMessageText();
        $sms_text_dk = str_replace("(productname-zerocall-out)", $productName, $sms_text_dk);
        $sms_text_dk = str_replace("(telephonenumber)", $telephoneNumber, $sms_text_dk);
        $sms_text_dk = str_replace("(chosen-password)", $password, $sms_text_dk);
        $this->carbordfishSMS($recipientMobileNumber, $sms_text_dk);

        $sms_text_uk = $sms_uk_object->getMessageText();
        $sms_text_uk = str_replace("(productname-zerocall-out)", $productName, $sms_text_uk);
        $sms_text_uk = str_replace("(telephonenumber)", $telephoneNumber, $sms_text_uk);
        $sms_text_uk = str_replace("(chosen-password)", $password, $sms_text_uk);
        $this->carbordfishSMS($recipientMobileNumber, $sms_text_uk);

        $sms_text_dk2 = $sms_dk_object2->getMessageText();
        $this->carbordfishSMS($recipientMobileNumber, $sms_text_dk2);
        
    }

/*
 * @@customerMobileNumber: to be sent in sms.
 * @@agentMobileNumber: This needs to be a complete number where user will be receiving the sms.
 *
 */

    public function toAgentAfterReg($customerMobileNumber,$agentMobileNumber) {
        //$sms_dk_object = SmsTextPeer::retrieveByPK(13);
        $sms_dk_object = SmsTextPeer::retrieveByPK(7);
        $sms_text_dk = $sms_dk_object->getMessageText();
        $sms_text_dk = str_replace("(customer-telephone-number)", $customerMobileNumber, $sms_text_dk);
        $sms_text_dk = str_replace("(datetime)", date('H:i d-m-Y'), $sms_text_dk);
       
        $this->carbordfishSMS($agentMobileNumber, $sms_text_dk);
    }
    
    public function toCustomerForgotPassword(Customer $customer){
        
        $customerCell           = $customer->getMobileNumber();
        $customerPassword       = $customer->getPlainText();
        $callingCode            = '47';
        $MobileNumber           = $callingCode.$customerCell;
        
        $sms_dk_object    = SmsTextPeer::retrieveByPK(3);
        $sms_text         = $sms_dk_object->getMessageText();
        $sms_text         = str_replace("(mobilenumber)", $customerCell, $sms_text);
        $sms_text         = str_replace("(password)", $customerPassword, $sms_text);
        
        $this->carbordfishSMS($MobileNumber, $sms_text);
    }
    
   private  function carbordfishSMS($mobile_number,$sms_text){
        $data1 = array(
            'S' => 'H',
            'UN' => 'zapna1',
            'P' => 'Zapna2010',
            'DA' => $mobile_number,
            'SA' => 'Zapna',
            'M' => $sms_text,
            'ST' => '5'
        );

        $queryString = http_build_query($data1, '', '&');
        $queryString = smsCharacter::smsCharacterReplacement($queryString);
        $res = file_get_contents('http://sms1.cardboardfish.com:9001/HTTPSMS?' . $queryString);
        sleep(0.25);
        $smsLog = new SmsLog();
        $smsLog->setMessage($sms_text);
        $smsLog->setStatus($res);
        $smsLog->setSmsType(1);
        $smsLog->setSenderName("Zapna");
        $smsLog->setMobileNumber($mobile_number);
        $smsLog->save();
        if (substr($res, 0, 2) == 'OK')
            return true;
        else
            return false;
    }
    
    public function toCustomerAfterRefill(Customer $customer,$amount){
        
        $customerCell           = $customer->getMobileNumber();
        $callingCode            = '47';
        $MobileNumber           = $callingCode.$customerCell;
        $agentid                = $customer->getReferrerId();
         if (isset($agentid) && $agentid != "") {
             $agent = AgentCompanyPeer::retrieveByPK($agentid);
             $agentMobileNumber = $agent->getMobileNumber();             
             
             $this->toAgentAfterCustomerRefill($telephoneNumber, $agentMobileNumber, $amount);
         }
        $sms_dk_object    = SmsTextPeer::retrieveByPK(8);
        $sms_text         = $sms_dk_object->getMessageText();        
        $sms_text         = str_replace("(amount)", $amount, $sms_text);
       
        $this->carbordfishSMS($MobileNumber, $sms_text);
    }
   
    public function toAgentAfterCustomerRefill($customerMobileNumber,$agentMobileNumber, $refillAmount){
        
        $sms_dk_object = SmsTextPeer::retrieveByPK(9);
        $sms_text_dk = $sms_dk_object->getMessageText();
        $sms_text_dk = str_replace("(mobileNumber)", $customerMobileNumber, $sms_text_dk);
        $sms_text_dk = str_replace("(amount)", $refillAmount, $sms_text_dk);
        $sms_text_dk = str_replace("(datetime)", date('H:i d-m-Y'), $sms_text_dk);
       
        $this->carbordfishSMS($agentMobileNumber, $sms_text_dk);
    }
    
    public function toCustomerChangePassword(Customer $customer){
        
        $customerCell           = $customer->getMobileNumber();
        $customerPassword       = $customer->getPlainText();
        $callingCode            = '47';
        $MobileNumber           = $callingCode.$customerCell;
        
        
        $sms_dk_object    = SmsTextPeer::retrieveByPK(10);
        $sms_text         = $sms_dk_object->getMessageText();
        $sms_text         = str_replace("(mobilenumber)", $customerCell, $sms_text);
        $sms_text         = str_replace("(password)", $customerPassword, $sms_text);

        $this->carbordfishSMS($MobileNumber, $sms_text);
    }
    
    public function toAgentAfterRefill(AgentCompany $agent,$amount){
        
        $agent_company_id = $agent->getId();
        
        $c = new Criteria();
        $c->add(AgentCompanyPeer::ID, $agent_company_id);
        $agent_mobileNumber  = AgentCompanyPeer::doSelectOne($c)->getMobileNumber();
        $callingCode            = '47';
        $MobileNumber           = $callingCode.$agent_mobileNumber;
        
        $sms_dk_object    = SmsTextPeer::retrieveByPK(11);
        $sms_text         = $sms_dk_object->getMessageText();        
        $sms_text         = str_replace("(amount)", $amount, $sms_text);
        
        
        $this->carbordfishSMS($MobileNumber, $sms_text);
    }
    
    public function toCustomerChangeNumber(Customer $customer,$old_mobile_number){
        
        $customerCell           = $customer->getMobileNumber();
        $customerPassword       = $customer->getPlainText();
        $callingCode            = '47';
        $MobileNumber           = $callingCode.$customerCell;
        
        
        $sms = SmsTextPeer::retrieveByPK(1);
        $sms_text = $sms->getMessageText();
        $sms_text = str_replace(array("(oldnumber)", "(newnumber)"),array($old_mobile_number, $customerCell),$sms_text);
                                   

        $this->carbordfishSMS($MobileNumber, $sms_text);
    }
}

?>
