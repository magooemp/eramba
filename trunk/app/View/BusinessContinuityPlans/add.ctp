<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'BusinessContinuityPlan', array(
							'url' => array( 'controller' => 'businessContinuityPlans', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'BusinessContinuityPlan', array(
							'url' => array( 'controller' => 'businessContinuityPlans', 'action' => 'add' ),
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
						<span class="help-block"><?php echo __( 'Give the plan a title, name or code so it\'s easily identified on the plan list menu' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Objective' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'objective', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the plan objective, it should be something short and straightforward to understand' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Metric' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'audit_metric', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Continuity plans without regular testing and audits are doomed to fail. Set your audit metric criteria (Response time?, etc)' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Success Criteria' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'audit_success_criteria', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Define a success criteria for the metric you have just defined (Under 2 hs, etc)' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Sponsor' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'sponsor', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Who is responsible for keeping this plan realitistic, communicateed and applicable?' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Launch Criteria' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'launch_criteria', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the criteria the plan responsible should use to know if it\'s appropiate to kick the plan or not in the case of an emergency.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Launch Responsible' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'launch_responsible', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'There should be someone who is authorized to lunch this plan (sometimes the Plan Sponsor)' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Status' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'security_service_type_id', array(
							'options' => $types,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the status of the plan. Only productive plans are considered "live" plans!  Select the Plan Status Proposed Design Transition Production Retired' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Cost (OPEX)' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'opex', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the OPEX cost of this Control' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Cost (CAPEX)' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'capex', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the CAPEX cost of this Control' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Resource Utilization' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'resource_utilization', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the resources implementing, operating and auditing this control requires in Days/Year.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Regular Reviews' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'regular_review', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the resources implementing, operating and auditing this control requires in Days/Year.' ); ?></span>
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