<div id="sf_admin_container">
	<div id="sf_admin_content">
	<!-- employee/list?filters[company_id]=1 -->
	<a href="<?php echo url_for('employee/usage').'?employee_id='.$employee->getId(); ?>" class="external_link" target="_self">Usage</a>
      
        </div></div>
<div id="sf_admin_container">
	<div id="sf_admin_content">
		<div id="company-info">
		    <h1>Employee Details</h1>
			<fieldset>
				<div class="form-row">
				  <label class="required">Employee Name:</label>
				  <div class="content">
				  	<?php echo $employee->getFirstName()." ".$employee->getLastName(); ?> &nbsp; <?php echo link_to('edit info', 'employee/edit?id='.$employee->getId()) ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Company:</label>
				  <div class="content">
				  	<?php echo ($employee->getCompany()?$employee->getCompany():'N/A') ?>
				  </div>
				</div>

                            <div class="form-row">
				  <label class="required">Employee Balance:</label>
				  <div class="content">
				  	<?php  echo BaseUtil::format_number($balance);echo "&nbsp;";
                                        echo sfConfig::get('app_currency_code');                 ?>
				  </div>
				</div>
				<div class="form-row">
				  <label class="required">Email:</label>
				  <div class="content">
				  	<?php echo ($employee->getEmail()?$employee->getEmail():'N/A') ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Mobile Number</label>
				  <div class="content">
				  	<?php echo $employee->getMobileNumber() ?>
				  </div>
				</div>
                                <div class="form-row">
				  <label class="required">Unique Id</label>
				  <div class="content">
				  	<?php echo $employee->getUniqueId() ?>
				  </div>
				</div>

				<div class="form-row">
				  <label class="required">Product:</label>
				  <div class="content">
				  	<?php $pidd=$employee->getProductId();

                                         $pid = new Criteria();
        $pid->add(ProductPeer::ID, $pidd);
        $product = ProductPeer::doSelectOne($pid);

                         echo $product->getName();
                                        ?>
				  </div>
				</div>



                            <?php


                           $empid=$employee->getRegistrationType();
                          if(isset($empid) && $empid==1){ ?>

                            <div class="form-row">
				  <label class="required">Resenumber:</label>
				  <div class="content">
				  	<?php    $voip = new Criteria();
        $voip->addAnd(SeVoipNumberPeer::CUSTOMER_ID, $employee->getCountryMobileNumber());
        $voipv = SeVoipNumberPeer::doSelectOne($voip);

                         echo $voipv->getNumber(); ?>
				  </div>
				</div>


                            <?php  } ?>




<!--                            <div class="form-row">
				  <label class="required">Product Price:</label>
				  <div class="content">
				  	<?php //echo $employee->getProductPrice(); ?>
				  </div>
				</div>-->


                            <div class="form-row">
				  <label class="required">Created at:</label>
				  <div class="content">
				  	<?php echo $employee->getCreatedAt() ?>
				  </div>
				</div>
                	<!--<div class="form-row">
				  <label class="required">App Code:</label>
				  <div class="content">
				  	<?php //echo $employee->getAppCode() ?>
				  </div>
				</div>-->
			</fieldset>
		</div>
	</div>
</div>