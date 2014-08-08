<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		/*Default Non-Authenticated users to a normal user and not allow them to make themself an Admin 		 */
		if($authUser){ 
		 echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'noteuser' => 'Notes User')
        ));
        
        
        } else
        {
	       echo $this->Form->hidden('role', array('value' => 'noteuser'));
        }
        	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Notes'), array('controller' => 'notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Note'), array('controller' => 'notes', 'action' => 'add')); ?> </li>
	</ul>
</div>
