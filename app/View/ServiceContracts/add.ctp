<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'ServiceContract', array(
							'url' => array( 'controller' => 'serviceContracts', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'ServiceContract', array(
							'url' => array( 'controller' => 'serviceContracts', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'third_party_id', array(
							'type' => 'hidden',
							'value' => $tp_id
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
						<span class="help-block"><?php echo __( 'Give a name to the contract you have in between this provider and your organization. Examples: Firewall Hardware Support, Firewall Consulting Time, Etc.' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Service contracts usually have a start and end dates. This will help you to keep track of renovations.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Service Value' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'value', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'min' => 0
						) ); ?>
						<span class="help-block"><?php echo __( 'Provide a description of the service contract scope, Etc.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Start Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'start', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'min' => 0
						) ); ?>
						<span class="help-block"><?php echo __( 'Record the service contract value, how much money you are paying for this?' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'End Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'end', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'min' => 0
						) ); ?>
						<span class="help-block"><?php echo __( 'Service contracts usually have a start and end dates. This will help you to keep track of renovations.' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary',
						'div' => false
					) ); ?>
					&nbsp;
					<?php echo $this->Html->link( __( 'Cancel' ), array(
						'controller' => 'serviceContracts',
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