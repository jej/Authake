<div id="authake">
<? if (!$tableonly) { echo $this->renderElement('gotoadminpage'); } ?>
<div class="rules index">
<?php if (!$tableonly) { ?>

<h2><?php __('Rules');?></h2>
<div class="actions">
    <ul>
        <li class="icon add"><?php echo $html->link(__('New Rule', true), array('action'=>'add')); ?></li>
    </ul>
</div>
<?php } ?>
<table class="listing" cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('Description');?></th>
	<th><?php __('Group');?></th>
    <th>&nbsp;</th>
	<th><?php __('Action');?></th>
	<th class="actions"><?php __('Actions');?></th>
    <th><?php __('Order');?></th>
</tr>
<?php
$i = 0;
$up = null;
foreach ($rules as $k => $rule):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $htmlbis->link($rule['Rule']['name'], array('action'=>'view', $rule['Rule']['id'])); ?>
		</td>
		<td>
			<?php
             
             $groupname = $rule['Group']['name'];
             
             if ($rule['Group']['id'])
                echo $html->link($groupname, array('controller'=> 'groups', 'action'=>'view', $rule['Group']['id']));
            else
                echo $groupname;
            
            ?>
		</td>
        <td style="text-align: center;">
            <?php
            echo $htmlbis->iconallowdeny($rule['Rule']['permission']);             
             ?>
        </td>
		<td>
			<?php
             echo str_replace(' or ', '<br/>', $rule['Rule']['action']);
              ?>
		</td>
		<td class="actions">
            <?php if ($rule['Rule']['id'] != 1) { ?>      
            <?php echo $htmlbis->iconlink('information', __('View', true), array('action'=>'view', $rule['Rule']['id'])); ?>
            <?php echo $htmlbis->iconlink('pencil', __('Edit', true), array('action'=>'edit', $rule['Rule']['id'])); ?>
			<?php echo $htmlbis->iconlink('cross', __('Delete', true), array('action'=>'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete the rule "%s"?', true), $rule['Rule']['name'])); ?>
            <?php

            if ($up) {
                echo $htmlbis->iconlink('arrow_up', __('Move up', true), array('action'=>'up', $rule['Rule']['id'].'/'.$up));
            } else {
                echo $htmlbis->iconlink('empty', '', array('action'=>''));
            }
            $up = $rule['Rule']['id'];
              
            $down = $rules[$k+1]['Rule']['id'];
            if ($down>1) {
                echo $htmlbis->iconlink('arrow_down', __('Move down', true), array('action'=>'up', $rule['Rule']['id'].'/'.$down));
            } else {
                echo $htmlbis->iconlink('empty', '', array('action'=>''));
            }
              
        }
 ?>
		</td>
        <td>
            <?php if (($rule['Rule']['id']) != 1) echo $rule['Rule']['order']; ?>
        </td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<?php if (!$tableonly) { ?>
<div class="actions">
	<ul>
        <li class="icon user"><?php echo $html->link(__('Manage Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li class="icon group"><?php echo $html->link(__('Manage Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
	</ul>
</div>
<?php } ?>
</div>