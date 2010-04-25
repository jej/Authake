<div id="authake">
<?php echo $this->renderElement('gotohomepage'); ?>
<div class="mypassword form">
<?php echo $form->create(null, array('action'=>'mypassword'));?>
<fieldset class="mypassword">
    <?php echo $form->input('loginoremail', array('label'=>__('Login or email', true), 'size'=>'40'));?>
</fieldset>
<?php echo $form->end(__('Request for password', true))  ?>
</div>
</div>