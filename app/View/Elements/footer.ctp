<?php if ($this->Session->read('Auth.User')) { ?>
	<div class="control-btn">
		<a href="<?= $this->base ?>/users/logout">Logout</a>
	</div>
<?php } else { ?>
	<div class="control-btn">
		<a href="<?= $this->base ?>/users/login">Login</a>
	</div>
<?php } ?>

</div>
<div id="footer">
	<span style="font-size: 10px">WTFIDID V0.1 - 2014 - <?php echo date("Y")?></span>
	<?php
	$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
	echo $this->Html->link(
			$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
			'http://www.cakephp.org/',
			array('target' => '_blank', 'escape' => false)
	);
	?>
</div>
</div>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
