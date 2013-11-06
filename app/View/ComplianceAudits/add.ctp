<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'ComplianceAudit', array(
							'url' => array( 'controller' => 'complianceAudits', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'ComplianceAudit', array(
							'url' => array( 'controller' => 'complianceAudits', 'action' => 'add' ),
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
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Compliance Package' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'third_party_id', array(
							'options' => $compliance_packages,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Audit Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'date', array(
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