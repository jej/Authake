<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon group"><?php echo $html->link(__('Manage groups', true), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
 		<legend><?php __('Modify group'); echo " ".$this->data['Group']['name']; ?></legend>
	<?php
        echo $form->input('id');   
		echo $form->input('name', array('label'=>__('Name', true)));
		echo $form->input('User', array('label'=>__('Users in this group<br/>Press \'Control\' for multi-selection', true), 'style'=>'width: 15em;'));
	?>
	</fieldset>
<?php echo $form->end(__('Modify', true));?>
</div>
<div class="actions">
	<ul>
        <li class="icon info"><?php echo $html->link(__('View group', true), array('action'=>'view', $form->value('Group.id')));?></li>
		<li class="icon cross"><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Group.id'))); ?></li>
	</ul>
</div>
</div>
