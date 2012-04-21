<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Log in'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Log in'));?>
</div>
<div id="signup" class="well">
	<p>Don't have an account? <?php echo $this->Html->link('Sign up', array('action' => 'add')); ?></p>
</div>