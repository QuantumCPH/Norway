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

<table width="600" align="center">
    <tr style="border:0px solid #fff">
 <td colspan="4" align="right" style="text-align:right; border:0px solid #fff"><?php echo image_tag('http://customer.zapna.no/images/zapna_logo_small.jpg',array('width' => '170'));?></td>
    </tr>
</table>
<?php
 if ($order->getIsFirstOrder()){
?>
<table width="600" align="center"  cellspacing="0">
   <tr>
    <td><span class="payer_summary"><?php echo sprintf("%s %s", $customer->getFirstName(), $customer->getLastName())?></span>,<br/>
      <?php echo $customer->getAddress() ?><br/>
      <?php echo sprintf('%s %s', $customer->getPoBoxNumber(), $customer->getCity()) ?><br/>

     </td>
  </tr>
  <tr>
    <td align="right">
        Oslo, <?php echo $customer->getCreatedAt('d-m-Y') ?>
    </td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Takk for din bestilling og velkommen som kunde hos Zapna. <br/>Ditt telefonnummer <?php echo $customer->getMobileNumber(); ?> er satt opp for <?php if ($order->getIsFirstOrder())
    {
		echo $order->getProduct()->getName() ;
		
    }
    else
    {
		echo $transaction->getDescription();
    }
    ?>	 </strong></td>
  </tr>
 <tr>
 <td>


<table width="600" align="center" cellpadding="5" cellspacing="5" id="mailbody" style="font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 13px; line-height: 1.5;">
  <tr valign="top">
    <td width="344" height="588"><table width="344">
      <tr>
          <td colspan="2"><p style="text-align: justify;" >Vi er glade for å ønske deg velkommen til en ny og mer mobiligere verden. Vi håper du blir fornøyd med in <?php if ($order->getIsFirstOrder())
    {
		echo $order->getProduct()->getName() ;
    }
    else
    {
		echo $transaction->getDescription();
    }
    ?> og våre lave priser.
    <?php if($customer->getReferrerId()!=null or $customer->getReferrerId()!="" ): ?>
     <?php  $c = new Criteria();
            $c->add(AgentCompanyPeer::ID, $customer->getReferrerId());
            $agent_name  = AgentCompanyPeer::doSelectOne($c)->getName();
            ?>
          <?php echo $agent_name; ?> har levert startpakke som du skal benytte for å komme i gang.
              <?php endif; ?>
              </p></td>
      </tr>

	    <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><p style="color: #f07c00;	font-weight: bold; 	font-size: 16px;">Kom raskt i gang!</p></td>
      </tr>
	    <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="33" align="center" valign="top"><div align="center" style="font-size: 36px; color: #FFFFFF; background-color: #f07c00;">1</div></td>
        <td width="295" valign="top" style="text-align: justify;">Ta ditt nåværende SIM-kort forsiktig ut av din mobiltelefon.</td>
      </tr>
      <tr>
          <td width="33" align="center" valign="top">&nbsp;</td>
          <td width="295" valign="top" style="text-align: justify;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top"><div align="center" style="font-size: 36px; color: #FFFFFF; background-color: #f07c00;">2</div></td>
        <td valign="top" style="text-align: justify;">Fjern beskyttelsestapen over klistreområdet nederst på Zapna SIM-kortet.<br />
Sett forsiktig Zapna SIM-kortet over ditt nåværende SIM-kort og sett kortene tilbake i din mobiltelefon.
</td>
      </tr>
      <tr>
          <td width="33" align="center" valign="top">&nbsp;</td>
          <td width="295" valign="top" style="text-align: justify;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top"><div align="center" style="font-size: 36px; color: #FFFFFF; background-color: #f07c00;">3</div></td>
        <td valign="top" style="text-align: justify;">Se hvordan du installerer Zapna SIM-kortet  <a href="https://zapna.no/">her</a> </td>
      </tr>
      <tr>
          <td width="33" align="center" valign="top">&nbsp;</td>
          <td width="295" valign="top" style="text-align: justify;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top"><div align="center" style="font-size: 36px; color: #FFFFFF; background-color: #f07c00;">4</div></td>
        <td valign="top" style="text-align: justify;">Kontakt din nåværende norske mobiloperatør og be om at de sperrer ditt abonnement for utenlandssamtaler.</td>
      </tr>
	    <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><p><span style="font-size: 14px; font-weight: bold;">Zapna aktiveres automatisk</span></p></td>
        </tr>
		  <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><p style="text-align: justify;">Etter at du har satt ditt smartSIM i din mobiltelefon, vil alle dine utenlandsamtaler automatisk skje via Zapna.<br>
          Ditt nåværende mobilabonnement fortsetter å fungere som før når du ringer til norske telefonnumre.<br>
          Du har valgt: <br />
         <strong>Brukernamn:</strong> <?php echo $customer->getMobileNumber();?><br />
         <strong>Lösenord:</strong> <?php echo $customer->getPlainText();?><br />
          God fornøyelse med din nye utenlandsforbindelse, som gjør at du ringer mobilligere  til hele verden!</p></td>
      </tr>
    </table>
    <p  >&nbsp;</p></td>
    <td width="240" align="left" bgcolor="#f07c00"><table width="263">
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p   style="color: #FFFFFF; font-weight: bold; font-size: 18px; text-align: justify;"><strong>Benytt&nbsp;online selvbetjening</strong></p></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p   style="color: #FFFFFF; text-align: justify;">På <a href="www.zapna.no">www.zapna.no</a> kan du holde øye med ditt forbruk og fylle på samtaletid.</p></td>
      </tr>
      <tr>
        <td><p   style="color: #FFFFFF; text-align: justify;">Nå kan du også sende webSMS til hele verden for omkring 30 øre fra din kundportal.</p></td>
      </tr>
      <tr>
        <td><p   style="color: #FFFFFF;text-align: justify;">Du kan også sikre deg automatisk påfylling  <a href="http://www.zapna.no/" title="Du kan ogs&aring; tanke her!">her</a>.</p></td>
      </tr>
      <tr>
        <td height="130"><p   style="color: #FFFFFF; text-align: justify;">Når du benytter Zapna vil du høre ”Zerocall is connecting your call”. For å forsikre deg om at du alltid ringer via Zapna er det viktig at du sperrer ditt abonnement for utenlandske samtaler hos din nåværende mobiloperatør.</p></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p style="color: #FFFFFF;text-align: justify;"><strong>Har du bru</strong><strong>k</strong><strong>&nbsp;</strong><strong>for hj</strong><strong>e</strong><strong>lp?</strong></p></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="42"><p   style="color: #FFFFFF;text-align: justify;">Så kan du kontakte oss på følgende måte:</p></td>
      </tr>
      <tr>
        <td>
          <ul style="color: #FFFFFF;text-align: justify;">
            <li>Email: <a href="mailto:support@zapna.no">support@zapna.no</a></li>
            <li>Finn svarene på de vanligste spørsmål (FAQ) på vår hjemmeside <a href="http://www.zapna.no">www.zapna.no</a></li>
            <li>Eller ring til vår kundeservice  2162 7500</li>
          </ul>          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
	  <td>
	    <p style="font-size: 14px; font-weight: bold;">Vennlig hilsen<br/> Zapna </p></td>
  </tr>

</table>
 </td>
 </tr>

</table>
<div style="width:600px;margin: 0 auto;"><br /><hr /><br /></div>
<?php
 }
?>
<table width="520px" align="center">
	<tr style="border:0px solid #fff">
		<td align="right" style="text-align:right; border:0px solid #fff"><?php echo image_tag('http://customer.zapna.no/images/zapna_logo_small.jpg',array('width' => '170'));?></td>
	</tr>
    <tr><td>
       <table class="receipt" cellspacing="0" width="520px">
  <tr bgcolor="#CCCCCC" class="receipt_header">
    <th colspan="3"><?php echo __('Order Receipt')." (".$order->getProduct()->getName().")" ?></th>
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
    <td style="padding-right:80px; text-align:right"><?php echo __('Amount') ?>(<?php echo sfConfig::get('app_currency_code')?>)</td>
  </tr>
  <tr>
    <td><?php echo $order->getCreatedAt('m-d-Y') ?></td>
    <td>
    <?php
         echo __("Registration Fee");

    ?>
	</td>
    <td><?php echo $order->getQuantity() ?></td>
    <td style="padding-right:80px; text-align:right"><?php echo BaseUtil::format_number($order->getProduct()->getRegistrationFee()); ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
<!--  <tr>
    <td></td>
    <td>
    <?php
         echo __("Product Price");

    ?>
	</td>
    <td><?php echo $order->getQuantity() ?></td>
    <td style="padding-right:80px; text-align:right"><?php echo BaseUtil::format_number($order->getProduct()->getPrice()); ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>-->
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Subtotal') ?></td>
    <td>&nbsp;</td>
    <td style="padding-right:80px; text-align:right"><?php echo BaseUtil::format_number($subTotal = $order->getProduct()->getPrice()+$order->getProduct()->getRegistrationFee()) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>

  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('VAT') ?> (<?php echo $vat==0?'0%':'25%' ?>)</td>
    <td>&nbsp;</td>
    <td style="padding-right:80px; text-align:right"><?php echo BaseUtil::format_number($vat) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
  <tr class="footer">
    <td>&nbsp;</td>
    <td><?php echo __('Total') ?></td>
    <td>&nbsp;</td>
    <td style="padding-right:80px; text-align:right"><?php echo BaseUtil::format_number($subTotal+$vat) ?>&nbsp;<?php echo sfConfig::get('app_currency_code')?></td>
  </tr>
  <tr>
  	<td colspan="4" style="border-bottom: 2px solid #c0c0c0;">&nbsp;</td>
  </tr>
  <tr class="footer">
    <td class="payer_summary" colspan="4" style="font-weight:normal; white-space: nowrap;">
    <?php echo __('Zapna Aps – Softgarden, Postboks 5093 Majorstua - 0301 Oslo');?> </td>
  </tr>
</table>
    </td></tr>
</table>

        