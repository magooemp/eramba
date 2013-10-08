<div class="row-fluid login-wrapper">
	<div class="span4 box">
		<div class="content-wrap">
			<h6><?php echo __('Did you forgot your password?'); ?></h6>
			<div class="reset-pass">
				<p><?php echo __('Enter your email. We will send you email with link and simple tutorial how to change your password.'); ?></p>
				
				<?php 
				echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'resetpassword')));
				
				echo $this->Form->input('email', array(
					'label' => false, 
					'div' => false,
					'placeholder' => __('Your email'),
					'class' => 'span12'
				));
				
				echo $this->Form->submit(__('Get new password'), array('class' => 'btn-flat success login')); 
				
				echo $this->Form->end(); 
				
				echo $this->Html->link(
					__('Back to login'),
					array('controller' => 'users', 'action' => 'login')
				);
				?>
			</div>
		</div>
	</div>
</div>