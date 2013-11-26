<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'ComplianceFinding', array(
							'url' => array( 'controller' => 'complianceFindings', 'action' => 'edit', $compliance_audit_id ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'ComplianceFinding', array(
							'url' => array( 'controller' => 'complianceFindings', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<?php echo $this->Form->input( 'compliance_audit_id', array(
					'type' => 'hidden',
					'value' => $compliance_audit_id
				) ); ?>

				<?php echo $this->Form->input( 'compliance_package_item_id', array(
					'type' => 'hidden',
					'value' => $compliance_package_item_id
				) ); ?>
				
				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Compliance Package Item' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'null', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'disabled' => true,
							'value' => $compliance_package_item_name
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Title' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'title', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
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
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Status' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'compliance_finding_status_id', array(
							'options' => $statuses,
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'selected' => 1
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Deadline' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'deadline', array(
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
						'controller' => 'complianceAudits',
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