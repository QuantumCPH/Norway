<?php

class AgentCompany extends BaseAgentCompany
{
    public function __toString(){
        return $this->getName();
    }

    public function getAccountManager(){
        return UserPeer::retrieveByPk($this->getAccountManagerId());
    }
    
    public function getReferences()
    { //get the all referecnes to this agent company
    	$c = new Criteria();
    	
    	$c->add(CustomerPeer::REFERRER_ID, $this->id);
    	
    	return CustomerPeer::doSelect($c);
    }
    
    public function getTotalRegistrationFeeEarned()
    {
    	//get registrations with
    	 
    	/*
    	 * select * from 
    	 */
    }
    public function getRegistrationRevenueCommissision()
    {
        
       $c = new Criteria();
       $c->add(TransactionPeer::AGENT_COMPANY_ID,$this->getId());
       $c->add(TransactionPeer::DESCRIPTION,'Registration' );
       $transactions=TransactionPeer::doSelect($c);       
       $sum=0.00;
       $per=BaseUtil::format_number(0);
       foreach($transactions as $transaction){
        $sum = $sum+ $transaction->getCommissionAmount();
        $per=BaseUtil::format_number($sum);
       }

       return $per;


       
    }
    public function getRefillRevenueCommissision()
    {

       $c = new Criteria();
       $c->add(TransactionPeer::AGENT_COMPANY_ID,$this->getId());
       $c->add(TransactionPeer::DESCRIPTION,'Refill' );
       $transactions=TransactionPeer::doSelect($c);

       $sum=0.00;
       $per=BaseUtil::format_number(0);
       foreach($transactions as $transaction){
        $sum = $sum+ $transaction->getCommissionAmount();
        $per=BaseUtil::format_number($sum);
       }

       return $per;

    }
    public function getRevenueAtShopCommissision()
    {

       $c = new Criteria();
       $c->add(TransactionPeer::AGENT_COMPANY_ID,$this->getId());
       //$c->add(TransactionPeer::DESCRIPTION,  substr($this->getDescription(), 0, 26));
       $transactions=TransactionPeer::doSelect($c);
       $con=new Criteria();
       //$con->add(TransactionPeer::DESCRIPTION);
       $sum=0.00;
       $per=BaseUtil::format_number(0);
       foreach($transactions as $transaction)
       {
           $description=substr($transaction->getDescription(),0 ,26);
           if($description== 'Refill')
           {
               $name=substr($transaction->getDescription(),27,-1 );
               if($name==$this->getName())
                {                  
                   $sum = $sum+ $transaction->getAmount();
                   $per=BaseUtil::format_number(($sum*10)/100);
                  
                }              
           }
       }

       return $per;

    }
    /*today code */
    public function getRegistrationRevenue()
    {

       $c = new Criteria();
       $c->add(TransactionPeer::AGENT_COMPANY_ID,$this->getId());
       $c->add(TransactionPeer::DESCRIPTION,'Registration' );
       $transactions=TransactionPeer::doSelect($c);
       $sum=BaseUtil::format_number(0);
       foreach($transactions as $transaction){
        $sum = BaseUtil::format_number($sum+ $transaction->getAmount());
       }

       return $sum;



    }
    public function getRefillRevenue()
    {

       $c = new Criteria();
       $c->add(TransactionPeer::AGENT_COMPANY_ID,$this->getId());
       $c->add(TransactionPeer::DESCRIPTION,'Refill' );
       $transactions=TransactionPeer::doSelect($c);

       $sum=BaseUtil::format_number(0);
       foreach($transactions as $transaction){
        $sum = BaseUtil::format_number($sum+ $transaction->getAmount());
       }

       return $sum;

    }
    public function getRevenueAtShop()
    {

       $c = new Criteria();
       $c->add(TransactionPeer::AGENT_COMPANY_ID,$this->getId());       
       $transactions=TransactionPeer::doSelect($c);
       $con=new Criteria();       
       $sum=BaseUtil::format_number(0);
       foreach($transactions as $transaction)
       {
           $description=substr($transaction->getDescription(),0 ,26);
           if($description== 'Refill')
           {
               $name=substr($transaction->getDescription(),27,-1 );
               if($name==$this->getName())
                {
                   $sum = BaseUtil::format_number($sum+ $transaction->getAmount());
                }
           }
       }

       return $sum;

    }
    /*****
     * 
     */


  public function getCountryName()
    {
       $cc = new Criteria;
       $cc->add(EnableCountryPeer::ID,$this->getCountryId());
       $country = EnableCountryPeer::doSelectOne($cc);
       return $country->getName();
    }
   
    
}
