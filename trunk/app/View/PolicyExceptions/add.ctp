<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'PolicyException', array(
							'url' => array( 'controller' => 'policyExceptions', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'PolicyException', array(
							'url' => array( 'controller' => 'policyExceptions', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Title' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'title', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Give a descriptive title to this Exception' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Description' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'description', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the Policy Exception in detail (when, what, where, why, whom, how).' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Status' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'policy_exception_status_id', array(
							'options' => $statuses,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the Exception status' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'user_id', array(
							'options' => $users,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe for whom this Exception is' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Security Policy Items' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['SecurityPolicy'] ) ) {
								foreach ( $this->request->data['SecurityPolicy'] as $entry ) {
									$selected[] = $entry['id'];
								}
							}

							if ( isset( $this->request->data['PolicyException']['security_policy_id'] ) && isset( $this->request->data['PolicyException']['security_policy_id'] ) ) {
								foreach ( $this->request->data['PolicyException']['security_policy_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'security_policy_id', array(
							'options' => $security_policies,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'selected' => $selected
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Expiration' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'expiration', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Exceptions are not eternal, they must expire at some time' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary',
						'div' => false
					) ); ?>
					&nbsp;
					<?php echo $this->Html->link( __( 'Cancel' ), array(
						'action' => 'index'
					), array(
						'class' => 'btn btn-inverse'
					) ); ?>
				</div>

				<?php echo $this->Form->end(); ?>

			</div>
		</div>
	</div>
</div>