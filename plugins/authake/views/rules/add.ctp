<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon lock"><?php echo $html->link(__('Manage rules', true), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="rules form">
<?php echo $form->create('Rule');?>
	<fieldset>
 		<legend><?php __('Add Rule');?></legend>
	<?php
        echo $form->input('name', array('label'=>__('Description', true), 'type'=>'textarea', 'cols'=>'50', 'rows'=>'2'));
        echo $form->input('group_id', array('label'=>__('Groupe', true)));
        echo $form->input('order', array('label'=>__('Order', true)));
        echo $form->input('action', array('label'=>__('Action<br/>(perl regex)', true), 'type'=>'textarea', 'cols'=>'50', 'rows'=>'3'));
        echo $form->input('permission', array('label'=>__('Permission', true), 'style'=>'width: 5em;'));
        echo $form->input('forward', array('label'=>__('Forward action on deny', true)));
        echo $form->input('message', array('label'=>__('Flash message on deny', true), 'type'=>'textarea', 'cols'=>'50', 'rows'=>'2'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
</div>
