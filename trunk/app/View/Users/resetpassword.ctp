<div class="box">
	<div class="content">

		<?php echo $this->Form->create( 'User', array(
			'action' => 'resetpassword',
			'class' => 'form-vertical login-form'
		) ); ?>

			<h3 class="form-title"><?php echo __( 'Did you forgot your password?' ); ?></h3>
			<p><?php echo __('Enter your email. We will send you email with link and simple tutorial how to change your password.'); ?></p>
			<br />

			<!-- Input Fields -->
			<div class="form-group">
				<!--<label for="username">Username:</label>-->
				<div class="input-icon">
					<i class="icon-envelope"></i>
					<?php echo $this->Form->input( 'email', array(
						'label' => false, 
						'div' => false,
						'placeholder' => __( 'Enter email address' ),
						'class' => 'form-control',
						'data-rule-required' => 'true',
						'data-rule-email' => 'true',
						'data-msg-required' => __( 'Please enter your email.' )
					) ); ?>
				</div>
			</div>

			<div class="form-actions">
				<?php echo $this->Html->link( __( 'Back' ),
					array( 'action' => 'login' ),
					array( 'class' => 'btn btn-default pull-left' )
				); ?>

				<?php echo $this->Form->submit( __( 'Reset Your Password' ),array(
					'class' => 'submit btn btn-primary pull-right',
					'div' => false
				) ); ?>
			</div>

		<?php echo $this->Form->end(); ?>

	</div>
</div>