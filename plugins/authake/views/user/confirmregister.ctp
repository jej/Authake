<div id="authake">
<?php echo $this->renderElement('gotohomepage'); ?>
<div class="confirmregister form">
<?php echo $form->create(null, array('action'=>'confirmregister'));?>
	<fieldset>
 		<legend><?php __('Confirm registration');?></legend>
	<?php
		echo $form->input('email', array('size'=>'40'));
		echo $form->input('code', array('size'=>'40'));
	?>
	</fieldset>
<?php echo $form->end(__('Confirm', true));?>
</div>
</div>