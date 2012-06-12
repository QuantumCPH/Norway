<div id="sf_admin_container"><h1><?php echo __('Low Credit Alert Report') ?></h1><br>
<?php if ($sf_user->hasFlash('notice')): ?>
	<div class='notice'>
	  <?php echo $sf_user->getFlash('notice') ?>
	</div>
<?php endif; ?>
    
<?php echo form_tag('invoice/usageAlertReport') ?>



<label> Start date/time</label>
<?php echo input_date_tag('startdate', date('Y-m-d'), 'rich=true') ?>
<br /><br />
<label>  End date/time</label>
 <?php echo input_date_tag('enddate', date('Y-m-d'), 'rich=true') ?>
<br/>
<input type="submit" value="Generate Report" />
</div>