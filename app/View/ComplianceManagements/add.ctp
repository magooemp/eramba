<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'ComplianceManagement', array(
							'url' => array( 'controller' => 'complianceManagements', 'action' => 'edit', $compliance_package_item_id ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'ComplianceManagement', array(
							'url' => array( 'controller' => 'complianceManagements', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<?php echo $this->Form->input( 'compliance_package_item_id', array(
					'type' => 'hidden',
					'value' => $compliance_package_item_id
				) ); ?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Treatment Strategy' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'compliance_treatment_strategy_id', array(
							'options' => $strategies,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Mitigation Control' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['SecurityService'] ) ) {
								foreach ( $this->request->data['SecurityService'] as $entry ) {
									$selected[] = $entry['id'];
								}
							}

							if ( isset( $this->request->data['ComplianceManagement']['security_service_id'] ) ) {
								foreach ( $this->request->data['ComplianceManagement']['security_service_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'security_service_id', array(
							'options' => $security_services,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'selected' => $selected
						) ); ?>
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

							if ( isset( $this->request->data['ComplianceManagement']['security_policy_id'] ) ) {
								foreach ( $this->request->data['ComplianceManagement']['security_policy_id'] as $entry ) {
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
					<label class="col-md-2 control-label"><?php echo __( 'Compliance Exception' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'compliance_exception_id', array(
							'options' => $exceptions,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Compliance Efficacy' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$percentages = array();
							for ( $i = 0; $i <= 10; $i++ ) {
								$percentages[ $i*10 ] = $i*10;
							}
						?>
						<?php echo $this->Form->input( 'efficacy', array(
							'options' => $percentages,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Status' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'compliance_status_id', array(
							'options' => $statuses,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
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