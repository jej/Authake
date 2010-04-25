<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon lock"><?php echo $html->link(__('Manage rules', true), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="rules view">
<h2><?php  __('Rule');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rule['Rule']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
             
            if (!$rule['Group']['id'])
                echo "<strong>".__("Everybody, including not logged users", true)."</strong>";
            else
                echo $html->link($rule['Group']['name'], array('controller'=> 'groups', 'action'=>'view', $rule['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rule['Rule']['order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Action'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
             echo str_replace(' or ', '<br/>', $rule['Rule']['action']);
             ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Permission'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
            echo $htmlbis->iconallowdeny($rule['Rule']['permission']);
             ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Forward action on deny'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
            $fw = $rule['Rule']['forward'];
            if ($fw)
                echo $fw;
            else
                __('Forward to the login page, or default deny action if logged');
?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Flash message on deny'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
            $msg = $rule['Rule']['message'];
            if ($msg)
                echo $msg;
            else
                __('No output');
?>
            &nbsp;
        </dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li class="icon lock_edit"><?php echo $html->link(__('Edit Rule', true), array('action'=>'edit', $rule['Rule']['id'])); ?> </li>
		<li class="icon cross"><?php echo $html->link(__('Delete Rule', true), array('action'=>'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rule['Rule']['id'])); ?> </li>
	</ul>
</div>
</div>