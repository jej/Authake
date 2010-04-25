<div id="authake">
<?php echo $this->renderElement('gotohomepage'); ?>
<div class="changemypassword form">
<?php echo $form->create(null, array('action'=>'changemypassword'));?>
<fieldset class="mypassword">
    <?php echo $form->input('email', array('label'=>'Email', 'size'=>'40'));?>
    <?php echo $form->input('code', array('label'=>'Code', 'size'=>'40'));?>
    <?php echo $form->input('password1', array('label'=>'New password', 'type'=>'password', 'value' => '', 'size'=>'12'));?>
    <?php echo $form->input('password2', array('label'=>'Please re-enter password', 'type'=>'password', 'value' => '', 'size'=>'12'));?>
</fieldset>
<?php echo $form->end(__('Change my password now', true))  ?>
</div>
</div>
        
        
