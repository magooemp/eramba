<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'Asset', array(
							'url' => array( 'controller' => 'assets', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'Asset', array(
							'url' => array( 'controller' => 'assets', 'action' => 'add' ),
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
						<span class="help-block"><?php echo __( 'Give a name to the asset you have identified.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Related Business Units' ); ?>:</label>
					<div class="col-md-10">
						<?php
							$selected = array();
							if ( isset( $this->request->data['BusinessUnit'] ) ) {
								foreach ( $this->request->data['BusinessUnit'] as $bu ) {
									$selected[] = $bu['id'];
								}
							}

							if ( isset( $this->request->data['Asset']['business_unit_id'] ) && is_array( $this->request->data['Asset']['business_unit_id'] ) ) {
								foreach ( $this->request->data['Asset']['business_unit_id'] as $entry ) {
									$selected[] = $entry;
								}
							}
						?>
						<?php echo $this->Form->input( 'business_unit_id', array(
							'options' => $bu_list,
							'label' => false,
							'div' => false,
							'class' => 'select2 col-md-12 full-width-fix select2-offscreen',
							'multiple' => true,
							'selected' => $selected
						) ); ?>
						<span class="help-block"><?php echo __( 'Which Business Unit is connected to this asset? You can select more than one.' ); ?></span>
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
						<span class="help-block"><?php echo __( 'Give a brief description on what the asset is.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Label' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'asset_label_id', array(
							'options' => $labels,
							'label' => false,
							'div' => false,
							'empty' => __( 'Choose one' ),
							'class' => 'form-control'
							//'class' => 'abc col-md-12 full-width-fix'
						) ); ?>
						<span class="help-block"><?php echo __( 'Choose a label from your asset label classification.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Type' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'asset_media_type_id', array(
							'options' => $media_types,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
							//'class' => 'select2 col-md-12 full-width-fix'
						) ); ?>
						<span class="help-block"><?php echo __( 'This one is important. There\'s an obvious difference in between what data and an asset is. Data is an asset. An asset is not necesarily data. Examples: Credit Card Numbers, Invoices, Personal Information, Project Names, Etc are data (and potentially assets too). Windows servers, chairs, computers, etc are most likely assets for your program.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Liabilities' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'legal_id', array(
							'options' => $legals,
							'label' => false,
							'div' => false,
							'empty' => __( 'Choose one' ),
							'class' => 'form-control'
							//'class' => 'select2 col-md-12 full-width-fix'
						) ); ?>
						<span class="help-block"><?php echo __( 'In the unlikely case of un-authorized disclosure or questionable integrity, confidentialiy or availability it might be that some liabilities might affect the asset. List the most significant (previously defined under Organization).' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'asset_owner_id', array(
							'options' => $bu_list,
							'label' => false,
							'div' => false,
							'empty' => __( 'Select an Owner' ),
							'class' => 'form-control'
							//'class' => 'select2 col-md-12 full-width-fix'
						) ); ?>
						<span class="help-block"><?php echo __( 'Try to define, under which bussiness organizations the Owners, Guardians (On whom\'s responsability is the adequated availability of the asset) of the assets and Users.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Guardian' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'asset_guardian_id', array(
							'options' => $bu_list,
							'label' => false,
							'div' => false,
							'empty' => __( 'Select a Guardian' ),
							'class' => 'form-control'
							//'class' => 'select2 col-md-12 full-width-fix'
						) ); ?>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'User' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'asset_user_id', array(
							'options' => $bu_list,
							'label' => false,
							'div' => false,
							'empty' => __( 'Select a User' ),
							'class' => 'form-control'
							//'class' => 'select2 col-md-12 full-width-fix'
						) ); ?>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Classification' ); ?>:</label>
					<div class="col-md-10">
						<?php

						foreach ( $classifications as $classification_type ) :
							$options = array();
							$options_ids = array();

							if ( empty( $classification_type['AssetClassification'] ) ) {
								continue;
							}

							foreach ( $classification_type['AssetClassification'] as $asset_classification ) {
								$options[ $asset_classification['id'] ] = $asset_classification['name'];
								$options_ids[] = $asset_classification['id'];
							}

							$selected = null;

							if ( isset( $this->request->data['AssetClassification'] ) ) {
								foreach ( $this->request->data['AssetClassification'] as $ac ) {
									if ( in_array( $ac['id'], $options_ids ) ) {
										$selected = $ac['id'];
									}
								}
							}
							
							echo $this->Form->input( 'asset_classification_id][', array(
								'options' => $options,
								'label' => false,
								'div' => false,
								'style' => 'margin-bottom:5px;',
								'empty' => __( 'Classification' ) . ': ' . $classification_type['AssetClassificationType']['name'],
								'class' => 'form-control',
								'selected' => $selected
							) );
						endforeach;
						?>
						<span class="help-block"><?php echo __( 'Use the previously defined asset classification criterias and choose the appropiate classification profile for this asset.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Main Container' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'asset_id', array(
							'options' => $assets,
							'label' => false,
							'div' => false,
							'empty' => __( 'Select a Container' ),
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Most assets are contained at some point in time within another asset. Example: Financial Data might be contained in another asset, called "Financial SpreadSheets".' ); ?></span>
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