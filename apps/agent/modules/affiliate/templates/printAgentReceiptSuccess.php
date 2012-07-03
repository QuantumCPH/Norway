<?php
use_helper('I18N');
use_helper('Number');
require_once(sfConfig::get('sf_lib_dir') . '/baseUtil.class.php');
?>
<style>
	p {
		margin: 8px auto;
	}

	table.receipt {
		width: 600px;
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

<table class="receipt" cellspacing="0" width="520px">
<tr bgcolor="#CCCCCC" class="receipt_header">
    <td colspan="4"> Zapna ApS
    </td>
  </tr>
  <tr>
  <td colspan="4" class="payer_summary">
	Zapna ApS<br>
        Softgarden, Postboks 5093 Majorstua <br>
        0301 Oslo

	<br>
  </td>
  </tr>
  <tr bgcolor="#CCCCCC" class="receipt_header">
    <th colspan="3"><?php echo __('Order Receipt') ?></th>
    <th><?php echo __('Order No.') ?> <?php echo $agent_order->getId() ?></th>
  </tr>

  <tr>
    <td colspan="4" class="payer_summary">
      <?php echo sprintf("%s ", $agent->getName())?><br/>
      <?php echo $agent->getAddress() ?><br/>
      <?php echo sprintf('%s, %s', $agent->getCity(), $agent->getPostCode()) ?><br/>
      <?php  echo $agent->getCountryName(); ?>


      <br /><br />
      <?php echo __('Phone Number') ?>: <br />
      <?php echo $agent->getHeadPhoneNumber() ?><br />
      
    </td>
  </tr>
  <tr class="order_summary_header" bgcolor="#CCCCCC">
    <td><?php echo __('Date') ?></td>
    <td><?php //echo __('Description') ?></td>
    <td><?php echo __('Quantity') ?></td>
    <td class="align"><?php echo __('Amount') ?>(Nkr)</td>
  </tr>
  <tr>
    <td><?php echo $agent_order->getCreatedAt('m-d-Y') ?></td>
    <td>
        
    </td>
    <td>1<?php //echo $agent_order->getQuantity() ?></td>
    <td class="align"><?php echo BaseUtil::format_number($subtotal = $agent_order->getAmount()) //($order->getProduct()->getPrice() - $order->getProduct()->getPrice()*.2) * $order->getQuantity()) ?>&nbsp;Nkr</td>
  </tr>
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Subtotal') ?></td>
    <td>&nbsp;</td>
    <td class="align"><?php echo BaseUtil::format_number($subtotal) ?>&nbsp;Nkr</td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('VAT') ?> (<?php echo '0%' ?>)</td>
    <td>&nbsp;</td>
    <td class="align"><?php echo BaseUtil::format_number(0.00) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Total') ?></td>
    <td>&nbsp;</td>
    <td class="align"><?php echo BaseUtil::format_number($agent_order->getAmount()) ?>&nbsp;Nkrr</td>
  </tr>
</table>
<?php if($wrap_content): ?>
<br />
<p>
<?php
	$c = new  Criteria();
	$c->add(GlobalSettingPeer::NAME, 'expected_delivery_time_agent_order');

	$global_setting_expected_delivery = GlobalSettingPeer::doSelectOne($c);

	if ($global_setting_expected_delivery)
		$expected_delivery = $global_setting_expected_delivery->getValue();
	else
		$expected_delivery = "3 business days";
?>
<p>
	<?php echo __('You will receive your package within %1%.', array('%1%'=>$expected_delivery)) ?>
</p>
<?php endif; ?>

<p>
	<?php echo __('If you have any questions please feel free to contact our customer support center at '); ?>
	<a href="mailto:support@zapna.no">support@zapna.no</a>
</p>

<p><?php echo __('Cheers') ?></p>

<p>
<?php echo __('Support') ?><br />
Zapna
</p>