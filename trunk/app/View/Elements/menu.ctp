<!-- Top Left Menu -->
<ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
	<li>
		<a href="#">
			<i class="icon-calendar"></i>&nbsp;<?php echo __( 'Calendar' ); ?>
		</a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Organization' ); ?>
			<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><a href="#"><?php echo __( 'Business Units' ); ?></a></li>
			<li><?php echo $this->Html->link( __( 'Legal Constrains' ), array(
				'controller' => 'legals',
				'action' => 'index'
			) ); ?></li>
			<!--<li class="divider"></li>-->
			<li><?php echo $this->Html->link( __( 'Third Parties' ), array(
				'controller' => 'thirdParties',
				'action' => 'index'
			) ); ?></li>
		</ul>
	</li>
</ul>
<!-- /Top Left Menu -->