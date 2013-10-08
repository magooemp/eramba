<div class="row-fluid login-wrapper">

	<div class="span4 box">
		<header class="login-header clearfix">
			<?php 
			echo $this->Html->link(
				__('Did you forget your password?'),
				array('controller' => 'users', 'action' => 'resetpassword'),
				array('class' => 'forgot')
			);
			?>
		</header>
		<div class="content-wrap">
			<?php 
			echo $this->Form->create('User', array('action' => 'login', 'class' => 'login'));
			echo $this->Form->input('login', array(
				'label' => false, 
				'div' => false,
				'placeholder' => __('Login'),
				'class' => 'span12'
			));
			
			echo $this->Form->input('password', array(
				'label' => false,
				'div' => false,
				'placeholder' => __('Password'),
				'class' => 'span12'
			));
			
			echo $this->Form->input('permanent', array(
				'type' => 'checkbox',
				'label' => __('Remember me'),
				'div' => 'remember'
			));
			
			echo $this->Form->submit(__('Login'), array('class' => 'btn-flat success login')); 
			
			echo $this->Form->end(); 
			?>
		</div>
	</div>
</div>