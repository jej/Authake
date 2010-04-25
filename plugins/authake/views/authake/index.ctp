<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon door_in"><?php echo $html->link(__('Logout', true), array('controller'=> 'user', 'action'=>'logout')); ?></li>
    </ul>
</div>
<div class="index">
<h2><?php __('Authake administration page');?></h2>

<div class="actions">
    <ul>
        <li class="icon user"><?php echo $html->link(__('Manage users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
        <li class="icon group"><?php echo $html->link(__('Manage groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
        <li class="icon lock"><?php echo $html->link(__('Manage rules', true), array('controller'=> 'rules', 'action'=>'index')); ?> </li>
    </ul>
</div>

<h3><?php __('Users');?></h3>
<?php echo $this->requestAction('authake/users/index/tableonly', array('return')); ?>
<div class="actions">
    <ul>
        <li class="icon add"><?php echo $html->link(__('New user', true), array('controller'=> 'users', 'action'=>'add')); ?></li>
    </ul>
</div>

<h3><?php __('Groups');?></h3>
<?php echo $this->requestAction('authake/groups/index/tableonly', array('return')); ?>
<div class="actions">
    <ul>
        <li class="icon add"><?php echo $html->link(__('New group', true), array('controller'=> 'groups', 'action'=>'add')); ?></li>
    </ul>
</div>

<h3><?php __('Rules');?></h3>
<?php echo $this->requestAction('authake/rules/index/tableonly', array('return')); ?>
<div class="actions">
    <ul>
        <li class="icon add"><?php echo $html->link(__('New rule', true), array('controller'=> 'rules', 'action'=>'add')); ?></li>
    </ul>
</div>

</div>
</div>