<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon group"><?php echo $html->link(__('Manage groups', true), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
        <legend><?php __('Create a new group');?></legend>   
	<?php
		echo $form->input('name', array('label'=>__('Name', true)));
        echo $form->input('User', array('label'=>__('Users in this group<br/>Press \'Control\' for multi-selection', true), 'style'=>'width: 15em;'));
	?>
	</fieldset>
<?php echo $form->end(__('Create', true));?>
</div>
</div>