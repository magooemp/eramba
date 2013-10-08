<div class="row-fluid login-wrapper">
	<div class="span4 box">
		<div class="content-wrap">
			<h6><?php echo __('Change your password'); ?></h6>
			<div class="reset-pass">
				<p><?php echo __('You can change your password in the form bellow.'); ?></p>
				
				<?php 
				echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'useticket')));
				
				echo $this->Form->input('pass', array(
					'label' => false, 
					'div' => false,
					'type' => 'password',
					'placeholder' => __('New password'),
					'error' => array(
						'between' => __('Passwords must be between 8 and 30 characters long.'),
						'compare' => __('Password and verify password must be same.')
					)
				));
					
				echo $this->Form->input('pass2', array(
					'label' => false, 
					'div' => false,
					'type' => 'password',
					'placeholder' => __('Verify password'),
				));
					
				echo $this->Form->input('hash', array('type' => 'hidden'));
				
				echo $this->Form->submit(__('Change password'), array('class' => 'btn-flat success login')); 
				
				echo $this->Form->end(); 
				?>
			</div>
		</div>
	</div>
</div>