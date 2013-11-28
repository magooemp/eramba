<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'SecurityServiceMaintenance', array(
							'url' => array( 'controller' => 'securityServiceMaintenances', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'SecurityServiceMaintenance', array(
							'url' => array( 'controller' => 'securityServiceMaintenances', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Maintenance Task' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'task', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'What is required to do in order to execute this maintenance task?' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Task Conclusion' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'task_conclusion', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'How did the task go?' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'user_id', array(
							'options' => $users,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Who did the task?' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Maintenance Start Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'start_date', array(
							'label' => false,
							'div' => false,
							'minYear' => date('Y') - 1,
							'maxYear' => date('Y') + 1,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Register the date at which this audit started.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Maintenance End Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'end_date', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Register the date at which this audit ended.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Task Result' ); ?>:</label>
					<div class="col-md-10">
						<?php $options = array(
							0 => __( 'Fail' ),
							1 => __( 'Pass' )
						); ?>
						<?php echo $this->Form->input( 'result', array(
							'options' => $options,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Altough this is not strictly an audit, this maintenance task are a good indication to know if services are working or not.' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary',
						'div' => false
					) ); ?>
					&nbsp;
					<?php echo $this->Html->link( __( 'Cancel' ), array(
						'controller' => 'securityServices',
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