<!--//app/View/Users/login.ctp-->

<div class="users form">
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend>
			<?php echo __('Please enter your username and password'); ?>
		</legend>
		<?php echo $this->Form->input('username');
		echo $this->Form->input('password');
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Login')); ?>

	<button>
		<?php
		echo $this->Html->link(
				'Create New User',
				array('controller' => 'users', 'action' => 'add')
		);
		?>
	</button>

	<!--
	<form action="http://google.com">
		<input type="submit" value="Go to Google">
	</form>
	-->

</div>
