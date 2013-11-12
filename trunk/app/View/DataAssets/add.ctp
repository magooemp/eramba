<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'DataAsset', array(
							'url' => array( 'controller' => 'dataAssets', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'DataAsset', array(
							'url' => array( 'controller' => 'dataAssets', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<?php echo $this->Form->input( 'asset_id', array(
					'type' => 'hidden',
					'value' => $asset_id
				) ); ?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Flow Status' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'data_asset_status_id', array(
							'options' => $statuses,
							'label' => false,
							'div' => false,
							'class' => 'form-control',
						) ); ?>
						<span class="help-block"><?php echo __( 'Choose the status being analysed.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Flow Description' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'description', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe a bit more the status you have previously selected.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Which Business Unit is Involved?' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['BusinessUnit'] ) ) {
								foreach ( $this->request->data['BusinessUnit'] as $entry ) {
									$selected[] = $entry['id'];
								}
							}

							if ( isset( $this->request->data['DataAsset']['business_unit_id'] ) ) {
								foreach ( $this->request->data['DataAsset']['business_unit_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'business_unit_id', array(
							'options' => $business_units,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'selected' => $selected
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Which Third Party is Involved?' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['ThirdParty'] ) ) {
								foreach ( $this->request->data['ThirdParty'] as $entry ) {
									$selected[] = $entry['id'];
								}
							}

							if ( isset( $this->request->data['DataAsset']['third_party_id'] ) ) {
								foreach ( $this->request->data['DataAsset']['third_party_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'third_party_id', array(
							'options' => $third_parties,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'selected' => $selected
						) ); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Compensating controls' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['SecurityService'] ) ) {
								foreach ( $this->request->data['SecurityService'] as $entry ) {
									$selected[] = $entry['id'];
								}
							}

							if ( isset( $this->request->data['DataAsset']['security_service_id'] ) ) {
								foreach ( $this->request->data['DataAsset']['security_service_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'security_service_id', array(
							'options' => $services,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'selected' => $selected
						) ); ?>
						<span class="help-block"><?php echo __( 'Choose the most suitable available compensating controls (you can select multiple) or NONE if you have nothing suitable' ); ?></span>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Form->submit( $submit_label, array(
						'class' => 'btn btn-primary',
						'div' => false
					) ); ?>
					&nbsp;
					<?php echo $this->Html->link( __( 'Cancel' ), array(
						'controller' => 'dataAssets',
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