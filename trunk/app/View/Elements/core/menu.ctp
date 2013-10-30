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
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Legal Constrains' ), array(
				'controller' => 'legals',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<!--<li class="divider"></li>-->
			<li><?php echo $this->Html->link( __( 'Third Parties' ), array(
				'controller' => 'thirdParties',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
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
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Asset Identification' ), array(
				'controller' => 'assets',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Data Asset Analysis' ), array(
				'controller' => 'dataAssets',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Asset Labeling' ), array(
				'controller' => 'assetLabels',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Controls Catalogue' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'Security Services' ), array(
				'controller' => 'securityServices',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Services Contracts' ), array(
				'controller' => 'serviceContracts',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Services Classification' ), array(
				'controller' => 'serviceClassifications',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Business Continuity Plans' ), array(
				'controller' => 'businessContinuityPlans',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Risk Management' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'Risk Classifications' ), array(
				'controller' => 'riskClassifications',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Asset Risk Management' ), array(
				'controller' => 'risks',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Risk Exceptions' ), array(
				'controller' => 'riskExceptions',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Third Party Risk Management' ), array(
				'controller' => 'thirdPartyRisks',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Business Continuity' ), array(
				'controller' => 'businessContinuities',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Compliance Analysis' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'Compliance Exception' ), array(
				'controller' => 'complianceExceptions',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'Security Operations' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'Project Improvements' ), array(
				'controller' => 'projects',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Security Incidents' ), array(
				'controller' => 'securityIncidents',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Security Incident Classification' ), array(
				'controller' => 'securityIncidentClassifications',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Policy Exceptions' ), array(
				'controller' => 'policyExceptions',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php echo __( 'System Management' ); ?>
			&nbsp;<i class="icon-caret-down small"></i>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link( __( 'User Accounts' ), array(
				'controller' => 'users',
				'action' => 'index',
				'admin' => false,
				'plugin' => null
			) ); ?></li>
			<li><?php echo $this->Html->link( __( 'Role Management' ), array(
				'controller' => 'aros',
				'action' => 'ajax_role_permissions',
				'admin' => true,
				'plugin' => 'acl'
			) ); ?></li>
		</ul>
	</li>
</ul>
<!-- /Top Left Menu -->