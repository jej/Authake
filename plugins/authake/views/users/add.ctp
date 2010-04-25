<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon user"><?php echo $html->link(__('Manage users', true), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Create a new user');?></legend>
	<?php
		echo $form->input('login', array('label'=>__('Login', true)));
		echo $form->input('password', array('label'=>__('Password', true), 'size'=>'12'));
		echo $form->input('email', array('label'=>__('Email', true), 'size'=>'40'));
		echo $form->input('Group', array('label'=>__('In groups<br/>Press \'Control\' for multi-selection', true), 'style'=>'width: 15em;'));
        echo $form->label(__('Disable account', true));
        echo $form->checkbox('disable');
        
	?>
	</fieldset>
<?php echo $form->end(__('Create', true));?>
</div>
</div>