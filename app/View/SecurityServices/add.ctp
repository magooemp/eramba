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
							'class' => 'form-control',
							'empty' => __( 'Choose one' )
						) ); ?>
						<span class="help-block"><?php echo __( 'Use a pre-defined classification criteria as a priotization tool  Select the Service Classification Critical.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Service Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'user_id', array(
							'options' => $users,
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'empty' => __( 'Select an owner' )
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the name of the owner of this Service. The owner typically is a person, group, Etc and is fully accountable for the service maintenance, Etc.' ); ?></span>
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

							if ( isset( $this->request->data['SecurityService']['security_policy_id'] ) && is_array( $this->request->data['SecurityService']['security_policy_id'] ) ) {
								foreach ( $this->request->data['SecurityService']['security_policy_id'] as $entry ) {
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
					<label class="col-md-2 control-label"><?php echo __( 'Service Audit Calendar' ); ?>:</label>
					<div class="col-md-5">
						<div id="audit-inputs-wrapper">
							<button class="btn add-dynamic" id="add_service_audit_calendar"><?php echo __( 'Add Date' ); ?></button>
							<?php
								$formKey = 0;
								if ( isset( $data ) ) {
									foreach ( $data['SecurityServiceAuditDate'] as $key => $audit_date ) {
										echo $this->element( 'ajax/audit_calendar_entry', array(
											'model' => 'SecurityService',
											'formKey' => $key,
											'day' => $audit_date['day'],
											'month' => $audit_date['month']
										) );
										$formKey++;
									}
								}
							?>
						</div>
						<span class="help-block"><?php echo __( 'Select the months in the year where this audit must take place. At least once a year this control should receive Audits.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Maintenance Metric Description' ); ?>:</label>
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
					<label class="col-md-2 control-label"><?php echo __( 'Service Maintenance Calendar' ); ?>:</label>
					<div class="col-md-5">
						<div id="maintenance-inputs-wrapper">
							<button class="btn add-dynamic" id="add_service_maintenance_calendar"><?php echo __( 'Add Date' ); ?></button>
							<?php
								$maintenanceFormKey = 0;
								if ( isset( $data ) ) {
									foreach ( $data['SecurityServiceMaintenanceDate'] as $key => $audit_date ) {
										echo $this->element( 'ajax/audit_calendar_entry', array(
											'model' => 'SecurityService',
											'formKey' => $key,
											'field' => 'maintenance_calendar',
											'day' => $audit_date['day'],
											'month' => $audit_date['month']
										) );
										$maintenanceFormKey++;
									}
								}
							?>
						</div>
						<span class="help-block"><?php echo __( 'Select the months in the year where this maintenance must take place.' ); ?></span>
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

							if ( isset( $this->request->data['SecurityService']['service_contract_id'] ) && is_array( $this->request->data['SecurityService']['service_contract_id'] ) ) {
								foreach ( $this->request->data['SecurityService']['service_contract_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'service_contract_id', array(
							'options' => $contracts,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
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

<script type="text/javascript">
jQuery(document).ready(function($) {
	var formKey = <?php echo $formKey; ?>;
	<?php if ( ! $formKey ) : ?>
		load_new_entry();
	<?php endif; ?>
	function load_new_entry() {
		$.ajax({
			type: "POST",
			dataType: "html",
			async: true,
			url: "/securityServices/auditCalendarFormEntry",
			data: { formKey: formKey },
			beforeSend: function () {
			},
			complete: function (XMLHttpRequest, textStatus) {
			},
			success: function (data, textStatus) {
				formKey++;
				$("#audit-inputs-wrapper").append(data);	
			}
		});
	}

	$("#add_service_audit_calendar").on("click", function(e) {
		e.preventDefault();
		load_new_entry();
	});

	var maintenanceFormKey = <?php echo $maintenanceFormKey; ?>;
	<?php if ( ! $maintenanceFormKey ) : ?>
		load_new_maintenance_entry();
	<?php endif; ?>
	function load_new_maintenance_entry() {
		$.ajax({
			type: "POST",
			dataType: "html",
			async: true,
			url: "/securityServices/auditCalendarFormEntry",
			data: { formKey: maintenanceFormKey, field: 'maintenance_calendar' },
			beforeSend: function () {
			},
			complete: function (XMLHttpRequest, textStatus) {
			},
			success: function (data, textStatus) {
				maintenanceFormKey++;
				$("#maintenance-inputs-wrapper").append(data);	
			}
		});
	}

	$("#add_service_maintenance_calendar").on("click", function(e) {
		e.preventDefault();
		load_new_maintenance_entry();
	});
});
</script>