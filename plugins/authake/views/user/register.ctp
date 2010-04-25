<div id="authake">
<?php echo $this->renderElement('gotohomepage'); ?>
<div class="register form">
<?php echo $form->create(null, array('action'=>'register'));?>
	<fieldset>
 		<legend><?php __('Registration');?></legend>
<?php
        
    echo $form->input('login', array('label'=>__('Login', true), 'size'=>'12'));
    echo $form->input('email', array('label'=>__('Email', true), 'size'=>'40'));
    echo $form->input('password1', array('type'=>'password', 'label'=>__('Password', true), 'value' => '', 'size'=>'12'));
    echo $form->input('password2', array('type'=>'password', 'label'=>__('Please, re-enter password', true), 'value' => '', 'size'=>'12'));
        
    echo $form->end(__('Register', true));
?>
	</fieldset>
</div>
</div>




