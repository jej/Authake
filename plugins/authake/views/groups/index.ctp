<div id="authake">
<? if (!$tableonly) { echo $this->renderElement('gotoadminpage'); } ?>
<div class="groups index">
<?php if (!$tableonly) { ?>

<h2><?php __('Groups');?></h2>
<div class="actions">
    <ul>
        <li class="icon add"><?php echo $html->link(__('New group', true), array('action'=>'add')); ?></li>
    </ul>
</div>
<?php } ?>
<p class="paging_count">
<?php
echo $paginator->counter(array(
'format' => __('There are %current% groups on this system.', true)
));
?></p>
<table class="listing" cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($groups as $group):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
    <?php if ($group['Group']['id'] != 0) { ?>
		<td>
			<?php echo $html->link($group['Group']['name'], array('action'=>'view', $group['Group']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $htmlbis->iconlink('information', __('View', true), array('action'=>'view', $group['Group']['id'])); ?>
			<?php echo $htmlbis->iconlink('pencil', __('Edit', true), array('action'=>'edit', $group['Group']['id'])); ?>
			<?php echo $htmlbis->iconlink('cross', __('Delete', true), array('action'=>'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete the group \'%s\'?', true), $group['Group']['name'])); ?>
        </td>
    <?php } else { ?>
	</tr>
    <?php } ?>
<?php endforeach; ?>
<?php
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
    echo "<tr{$class}>";
    ?>
        <td>
            <?php echo __('Everybody (all users, logged or not, are in this group)', true); ?>
        </td>
        <td class="actions">&nbsp;
        </td>
    </tr>
</table>
</div>

<?php if (!$tableonly) { ?>
<div class="actions">
	<ul>
        <li class="icon user"><?php echo $html->link(__('Manage users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
        <li class="icon lock"><?php echo $html->link(__('Manage rules', true), array('controller'=> 'rules', 'action'=>'index')); ?> </li>
	</ul>
</div>
<?php } ?>
</div>