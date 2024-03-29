<?php
use_helper('I18N');
use_helper('Number');
?>
<style>
	p {
		margin: 8px auto;
	}
	
	table.receipt {
		width: 600px;
		//font-family: arial;
		//font-size: .7em;
		
		border: 2px solid #ccc;
	}
	
	table.receipt td, table.receipt th {
		padding:5px;
	}
	
	table.receipt th {
		text-align: left;
	}
	
	table.receipt .payer_details {
		padding: 10px 0;
	}
	
	table.receipt .receipt_header, table.receipt .order_summary_header {
		font-weight: bold;
		text-transform: uppercase;
	}
	
	table.receipt .footer
	{
		font-weight: bold;
	}
        .align{
                padding-right:80px !important;
                text-align:right;
        }
	
	
</style>

<?php
$wrap_content  = isset($wrap)?$wrap:false;

//wrap_content also tells  wheather its a refill or 
//a product order. we wrap the receipt with extra
// text only if its a product order.

 ?>
 
<?php if($wrap_content): ?>
	<p><?php echo __('Hi') ?>&nbsp;<?php echo $customer->getFirstName();?></p>
	
	<p>
	<?php echo __('Thank you for your order of <b>%1%</b>.', array('%1%'=>$order->getProduct()->getName())) ?>
	</p>
	
	<p>
	<?php echo __('Your goods will be shipped today. You should have delivery within two days. Your customer number is '); echo $customer->getUniqueid();?>. <?php echo __(' There, you can use in your dealings with customer service'); ?></p>
	
	<p>
	<?php echo __('Do not hesitate to contact us if you have any questions.') ?>
	</p>
        <p>
            <a href="mailto:support@zapna.no">support@zapna.no</a>
	</p>
        <p>
	<?php echo __('Yours sincerely,') ?>
	</p>
        <p>
	<?php echo __('XXXXXXX') ?>
	</p>
	<br />
<?php endif; ?>
<table width="520px">
	<tr style="border:0px solid #fff">
		<td colspan="4" align="right" style="text-align:right; border:0px solid #fff"><?php echo image_tag('http://customer.zapna.no/images/zapna_logo_small.jpg',array('width' => '170'));?></td>
	</tr>
</table>
<table class="receipt" cellspacing="0" width="600px">
<!--<tr bgcolor="#CCCCCC" class="receipt_header"> 
    <td colspan="4"> LandNCall AB
    </td>
  </tr>
  <tr>
  <td colspan="4" class="payer_summary">
	Telefonv&atilde;gen 30
	<br />
	126 37 H&atilde;gersten
	<br />
	
	<br />
	Tel:      +46 85 17 81 100
	<br />	
	<br />
	Cvr:     32068219
	<br />
  </td>
  </tr>-->
  <tr bgcolor="#CCCCCC" class="receipt_header"> 
    <th colspan="3"><?php echo __('Order Receipt') ?></th>
    <th><?php echo __('Order No.') ?> <?php echo $order->getId() ?></th>
  </tr>
  
  <tr> 
    <td colspan="4" class="payer_summary">
      <?php echo __('Customer Number') ?>   <?php echo $customer->getUniqueId(); ?><br/>
      <?php echo sprintf("%s %s", $customer->getFirstName(), $customer->getLastName())?><br/>
      <?php echo $customer->getAddress() ?><br/>
      <?php echo sprintf('%s, %s', $customer->getCity(), $customer->getPoBoxNumber()) ?><br/>
      <?php 
	  $eC = new Criteria();
	  $eC->add(EnableCountryPeer::ID, $customer->getCountryId());
	  $eC = EnableCountryPeer::doSelectOne($eC);
	  echo $eC->getName();
	  ?>
      
      
      <br /><br />
      <?php echo __('Mobile Number') ?>: <br />
      <?php echo $customer->getMobileNumber() ?><br />

      <?php if($agent_name!=''){ echo __('Agent Name') ?>:  <?php echo $agent_name; } ?>
    </td>
  </tr>
  <tr class="order_summary_header" bgcolor="#CCCCCC"> 
    <td><?php echo __('Date') ?></td>
    <td><?php echo __('Description') ?></td>
    <td><?php echo __('Quantity') ?></td>
    <td class="align"><?php echo __('Amount') ?>(<?php echo sfConfig::get('app_currency_code')?>)</td>
  </tr>
  <tr> 
    <td><?php echo $order->getCreatedAt('m-d-Y') ?></td>
    <td>
    <?php if ($order->getIsFirstOrder())
    {
        echo $order->getProduct()->getName(); 
        if($transaction->getDescription()=="Anmeldung inc. sprechen"){
          echo "<br />["; echo __('Smartsim including pot'); echo "]";
        }else{
            echo  '<br />['. $transaction->getDescription() .']';
        }
    }
    else
    {
	if($transaction->getDescription()=="Refill"){
          echo "Refill ".$transaction->getAmount();
        }else{
          echo $transaction->getDescription();  
        }           	
    }
    ?>
	</td>
    <td><?php echo $order->getQuantity() ?></td>
    <td class="align"><?php echo format_number($subtotal = $transaction->getAmount()-$vat) //($order->getProduct()->getPrice() - $order->getProduct()->getPrice()*.2) * $order->getQuantity()) ?>&nbsp;Nkr</td>
  </tr>
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer"> 
    <td>&nbsp;</td>
    <td><?php echo __('Subtotal') ?></td>
    <td>&nbsp;</td>
    <td class="align"><?php echo format_number($subtotal) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
  <tr class="footer"> 
    <td>&nbsp;</td>
    <td><?php echo __('VAT') ?> (<?php echo $vat==0?'0%':'25%' ?>)</td>
    <td>&nbsp;</td>
    <td class="align"><?php echo format_number($vat) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Total') ?></td>
    <td>&nbsp;</td>
    <td class="align"><?php echo format_number($transaction->getAmount()) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer">
    <td class="payer_summary" colspan="4" style="font-weight:normal; white-space: nowrap;"> 
    <?php echo __('Zapna - Postboks 5093 Majorstua - 0301 Oslo')?> </td>
  </tr>
</table>
        