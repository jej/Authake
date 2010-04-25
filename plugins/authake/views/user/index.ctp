<div id="authake">
<?php echo $this->renderElement('gotohomepage'); ?>
<div class="users view"><? //pr($user);?>
<h2><?php  __('Profile of '); echo $user['User']['login'];?></h2>
    <dl><?php $i = 0; $class = ' class="altrow"';?>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Login'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $user['User']['login']." <em>(Id {$user['User']['id']})</em>"; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Groups'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
             
            $gr = array();
            foreach($user['Group'] as $group) $gr[] = $group['name'];
            if (empty($gr))
                __('Guest');
            else
                echo implode(", ", $gr); ?>
            
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $user['User']['created']; ?>
            &nbsp;
        </dd>
    </dl>

<?php echo $form->create('User', array('url'=>'index'));?>
    <fieldset>
        <legend><?php __('Modify');?></legend>
    <?php
        echo $form->input('email', array('value'=>$user['User']['email'], 'size'=>'40')); echo '(If modified, you will have to confirm it before the next login)';
        echo $form->input('password1', array('type'=>'password', 'value' => '', 'size'=>'12'));
        echo $form->input('password2', array('type'=>'password', 'value' => '', 'size'=>'12'));
    ?>
    </fieldset>
<?php echo $form->end(__('Save', true));?>

</div>
</div>