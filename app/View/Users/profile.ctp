<?php 
$statuses = array(
	USER_ACTIVE 	=> __('Active'),
	USER_NOTACTIVE 	=> __('Inactive')
);
?>
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
				echo $this->Form->create( 'User', array(
					'url' => array( 'controller' => 'users', 'action' => 'profile' ),
					'class' => 'form-horizontal row-border'
				) );

				$submit_label = __( 'Edit' );
				?>

				<div class="form-group" style="border-top:none; padding-top:5px;">
					<label class="col-md-2 control-label"><?php echo __( 'Name' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'name', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'error' => array(
								'notEmpty' 	=> __('Name is required.'),
							)
						) ); ?>
						<span class="help-block"><?php echo __( 'First Name' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Surname' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'surname', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Surname' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Email' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'email', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'error' => array(
								'email' 	=> __('Email address is in wrong format.'),
								'notEmpty' 	=> __('Email address is required.'),
							)
						) ); ?>
						<span class="help-block"><?php echo __( 'If you forget your password, we will use this email to Contact you.' ); ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Current password' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'old_pass', array(
							'type' => 'password',
							'label' => false,
							'div' => false,
							'class' => 'form-control',
						) ); ?>
						<span class="help-block"><?php echo __( 'Eneter your current password.' ); ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Password' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'pass', array(
							'type' => 'password',
							'label' => false,
							'div' => false,
							'required' => false,
							'class' => 'form-control',
							'error' => array(
								'between' => __('Passwords must be between 8 and 30 characters long.'),
								'compare' => __('Password and verify password must be same.')
							)
						) ); ?>
						<span class="help-block"><?php echo __( 'Set your access password.' ); ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Verify Password' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'pass2', array(
							'type' => 'password',
							'label' => false,
							'div' => false,
							'class' => 'form-control',
						) ); ?>
						<span class="help-block"><?php echo __( 'Type your password again.' ); ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Role' ); ?>:</label>
					<div class="col-md-3">
						<?php echo $this->Form->input( 'group_id', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'error' => array(
								'notEmpty' 	=> __('Role is required.'),
							)
						) ); ?>
						<span class="help-block"><?php echo __( 'Select your Role. Each role has different access permissions to eramba.' ); ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Status' ); ?>:</label>
					<div class="col-md-3">
						<?php echo $this->Form->input( 'status', array(
							'options' => $statuses,
							'label' => false,
							'div' => false,
							'default' => USER_ACTIVE,
							'class' => 'form-control',
							'error' => array(
								'notEmpty' 	=> __('Status is required.'),
							)
						) ); ?>
						<span class="help-block"><?php echo __( 'Select user status.' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary'
					) ); ?>
				</div>

				<?php echo $this->Form->end(); ?>

			</div>
		</div>
	</div>
</div>