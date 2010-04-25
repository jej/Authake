<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon user"><?php echo $html->link(__('Manage users', true), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="users view">
<h2><?php  echo sprintf(__('User %s', true), "<u>{$user['User']['login']}</u>"); ?></h2>
<?php if (empty($actions)) { ?>
    <dl><?php $i = 0; $class = ' class="altrow"';?>
<?php if ($user['User']['disable']) { ?>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo $html->image("icons/error.png", array('title' => __('Warning', true))); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
                    echo "<strong>".__('Account disabled', true)."</strong>";
            ?>
            &nbsp;
        </dd>
<?php } ?>        
		
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Login'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['login']." <em>(Id {$user['User']['id']})</em>"; ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('In groups'); ?></dt>
        <dd<?php echo $class;?>>
    <?php
        $gr = array();
        foreach ($user['Group'] as $group) {
            $class = '';
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }

            $gr[] = $html->link($group['name'], array('controller'=> 'groups', 'action'=>'view', $group['id']));
        }
        
        if (empty($gr)) {
            $gr[] = __('No group', true);
        }
        
        echo implode( '&nbsp;&ndash;&nbsp;', $gr);
?>
            
        </dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php $email = $user['User']['email']; echo "<a href=\"mailto:{$email}\">{$email}</a>"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email check code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php $j = $user['User']['emailcheckcode'];
                    echo $j ? $j : __('No email change requested', true);
            ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password change code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php $j = $user['User']['passwordchangecode'];
                    echo $j ? $j : __('No password change requested', true);
            ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Account expires on'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
                    $exp = $user['User']['expire_account'];
                    if ($exp != '0000-00-00')
                        echo $exp;
                    else
                        echo __('Never', true);
            ?>
            &nbsp;
        </dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created on'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y H:i', $time->fromString($user['User']['created'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated on'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y H:i', $time->fromString($user['User']['updated'])); ?>
			&nbsp;
		</dd>
    </dl>

<?php } ?>

</div>

<div class="actions">
    <ul>
<?php if (!empty($actions)) { ?>
        <li class="icon user"><?php echo $html->link(__('View user', true), array('action'=>'view', $user['User']['id'])); ?></li>
<?php } ?>
        <li class="icon user_edit"><?php echo $html->link(__('Edit user', true), array('action'=>'edit', $user['User']['id'])); ?></li>
<?php if (empty($actions)) { ?>
        <li class="icon lock"><?php echo $html->link(__('View allowed & denied actions', true), array('action'=>'view', "{$user['User']['id']}/actions")); ?></li>
        <li class="icon cross"><?php echo $html->link(__('Delete user', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete user \'%s\'?', true), $user['User']['login'])); ?></li>
<?php } ?>
    </ul>
</div>

<?php if (!empty($actions)) { ?>

<div class="monitor_rules index">
<h3><?php __('Allowed & denied actions');?></h3>
<?php
    foreach($actions as $controller => $ruleslist) {
        echo "<div style=\"float: left; padding: 0 0.7em; margin: 0.5em; border-left: 1px solid #CCC;\"><h4>{$controller}</h4>";
        echo "<ul>";
        foreach($ruleslist as $k => $rule) {
            if ($rule['permission'] == "Allow")
                echo '<li class="icon accept"><p style="color: green">'.$rule['action'];
            else
                echo '<li class="icon delete"><p style="color: red">'.$rule['action'];
            echo '</p></li>';
        
        }
        echo "</ul></div>";
    }

?>
<p style="clear: both"></p>
</div>
    <div class="actions">
        <ul>
            <li class="icon lock"><?php echo $html->link(__('Manage rules', true), array('controller'=> 'rules', 'action'=>'index')); ?></li>
            <li class="icon accept"><?php echo $html->link(__('Hide this view', true), array('action'=>'view', $user['User']['id'])); ?></li>
        </ul>
    </div>
<?php } ?>

<div class="related">
    <h3><?php echo sprintf(__('Rules applied to user %s', true), "{$user['User']['login']}");?></h3>
    <?php if (!empty($rules)):?>
    <p><em><?php __('Rules herited from guest group are greyed'); ?></em></p>
    <table class="listing" cellpadding = "0" cellspacing = "0">
    <tr>
        <th><?php __('Description'); ?></th>
        <th>&nbsp;</th>
        <th><?php __('Action'); ?></th>
        <th class="actions"><?php __('Actions');?></th>
    </tr>
    <?php
        $i = 0;
        foreach ($rules as $r):
                $rule = $r['Rule'];
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
            ?>
            <tr<?php echo $class;?><?php
            if ($rule['group_id'] != 0)
                echo " style=\"font-weight: bold;\"";
            else
                echo " style=\"color: #999;\"";
            ?>>
                <td><?php echo $rule['name'];?></td>
                <td><?php echo $htmlbis->iconallowdeny($rule['permission']); ?></td>
                <td><?php
                 echo str_replace(' or ', '<br/>', $rule['action']);
                ?></td>
                <td class="actions">
                    <?php echo $htmlbis->iconlink('information', __('View', true), array('controller'=> 'rules', 'action'=>'view', $rule['id'])); ?>
                    <?php echo $htmlbis->iconlink('pencil', __('Edit', true), array('controller'=> 'rules', 'action'=>'edit', $rule['id'])); ?>
                </td>
            </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

    <div class="actions">
        <ul>
            <li class="icon add"><?php echo $html->link(__('New Rule', true), array('controller'=> 'rules', 'action'=>'add')); ?></li>
            <li class="icon lock"><?php echo $html->link(__('Manage rules', true), array('controller'=> 'rules', 'action'=>'index')); ?> </li>
            
        </ul>
    </div>
</div>
</div>