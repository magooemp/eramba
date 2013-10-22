<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'SecurityService', array(
							'url' => array( 'controller' => 'securityServices', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'SecurityService', array(
							'url' => array( 'controller' => 'securityServices', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Name' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'name', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Name this Security Service (Firewalls, CCTV, Etc)' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Give a brief description on what this services does.' ); ?></span>
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
						<span class="help-block"><?php echo __( 'The objective is to understand what is the status of this service: Proposed (Just a good idea that needs to be validated and drafted), Design (there\'s budget and a business case, so it\'s time to design), Transition (the design is moving towards an implementation), Production (the service is working, metrics are being taken, etc), Retired (the service is no longer used)  Select the Service Status Proposed Design Transition Production Retired.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Service Classification' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'service_classification_id', array(
							'options' => $classifications,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Use a pre-defined classification criteria as a priotization tool  Select the Service Classification Critical.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Service Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'owner', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the name of the owner of this Service. The owner typically is a person, group, Etc and is fully accountable for the service maintenance, Etc.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Documentation URL' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'documentation_url', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Document ONE url where the documentation for this Service is located (Wiki Page, Etc)' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Metric Description' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'audit_metric_description', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'At regular intervals, Security controls must be Audited. This is a key component of any Security Framework. Audits don’t need to be complex but yet must be usefull to determine if the control is delivering or not. For example, in the case of a CCTV system: "Recordings must be available for the last 90 Days"' ); ?></span>
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
						<span class="help-block"><?php echo __( 'What answer is expected in order to determine if the Audit is successful or not. Example: CCTV recordings must be available.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Success Criteria' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'maintenance_metric_description', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'At regular intervals, Security controls must receive some sort of maintenance. For example, if you have "User Account" reviews then at regular intervals this reviews must be done. Note: this is different from an Audit, an audit for this type of control would be "Number of creeping accounts found".' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Describe the amount of OPEX this controls costs per annun. Do not include Support Contracts (they are described separetely).' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Describe the amount of CAPEX paid for this control.' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Describe the amount of Days / Year that must be dedicated in order to build, operate, improve, audit this control. For example, 30 days year (Some 10 hours / Week of one resource)' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Service Contracts' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['ServiceContract'] ) ) {
								foreach ( $this->request->data['ServiceContract'] as $sc ) {
									$selected[] = $sc['id'];
								}
							}
						?>
						<?php echo $this->Form->input( 'service_contract_id', array(
							'options' => $contracts,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'hiddenField' => false,
							'selected' => $selected
						) ); ?>
						<span class="help-block"><?php echo __( 'Select all applicable Support Contracts for this Security Service.' ); ?></span>
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