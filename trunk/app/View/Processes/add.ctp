<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'Process', array(
							'url' => array( 'controller' => 'processes', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'Process', array(
							'url' => array( 'controller' => 'processes', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'business_unit_id', array(
							'type' => 'hidden',
							'value' => $bu_id
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group" style="border-top:none;">
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
					<label class="col-md-2 control-label"><?php echo __( 'RTO' ); ?>:</label>
					<div class="col-md-5">
						<?php echo $this->Form->input( 'rto', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'default' => 0
						) ); ?>
						<span class="help-block"><?php echo __( 'The period of time within which systems, applications, or functions must be recovered after a disruption has occurred. For example, critical business functions must be restored within 4 hours upon occurrence of a disaster.' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary',
						'div' => false
					) ); ?>
					&nbsp;
					<?php echo $this->Html->link( __( 'Cancel' ), array(
						'controller' => 'businessUnits',
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