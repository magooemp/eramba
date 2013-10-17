<!-- Top Left Menu -->
<ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
	<!--<li>
		<a href="#">
			<i class="icon-calendar"></i>&nbsp;<?php echo __( 'Calendar' ); ?>
		</a>
	</li>-->
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Organization' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'Business Units' ), array(
				'controller' => 'businessUnits',
				'action' => 'index'
			) ); ?></li>
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
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Asset Management' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'Asset Classification' ), array(
				'controller' => 'assetClassifications',
				'action' => 'index'
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Asset Identification' ), array(
				'controller' => 'assets',
				'action' => 'index'
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Data Asset Analysis' ), array(
				'controller' => 'dataAssets',
				'action' => 'index'
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Asset Labeling' ), array(
				'controller' => 'assetLabels',
				'action' => 'index'
			) ); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'System Management' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'System Authorization' ), array(
				'controller' => 'users',
				'action' => 'index'
			) ); ?></li>
		</ul>
	</li>
</ul>
<!-- /Top Left Menu -->