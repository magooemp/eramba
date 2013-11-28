<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'BusinessContinuityPlanAudit', array(
							'url' => array( 'controller' => 'businessContinuityPlanAudits', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'BusinessContinuityPlanAudit', array(
							'url' => array( 'controller' => 'businessContinuityPlanAudits', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Metric' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'audit_metric_description', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'At the time of creating the Security Service, a metric was defined in order to be able to measure the level of efficacy of the control. This should be utilized as the base for this audit review.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Metric Success Criteria' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'audit_success_criteria', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'At the time of creating the Security Service, a success criteria was defined in order to evaluate if the metric results are within acceptable threasholds (audit pass) or not (audit not pass).' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Conclusion' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'result_description', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe what evidence was avilable, the accuracy and integrity of the metrics taken and if the metrics are within the expected threasholds or not.' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Register the person who has worked on this audit (the auditor name)' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Start Date' ); ?>:</label>
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
					<label class="col-md-2 control-label"><?php echo __( 'Audit End Date' ); ?>:</label>
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
					<label class="col-md-2 control-label"><?php echo __( 'Audit Result' ); ?>:</label>
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
						<span class="help-block"><?php echo __( 'After evluating the audit evidence, success criteria, etc you are able to conclude with the audit result. Pass or Fail are the available options.' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary',
						'div' => false
					) ); ?>
					&nbsp;
					<?php echo $this->Html->link( __( 'Cancel' ), array(
						'controller' => 'businessContinuityPlans',
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