<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'AssetClassification', array(
							'url' => array( 'controller' => 'assetClassifications', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'AssetClassification', array(
							'url' => array( 'controller' => 'assetClassifications', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group" style="border-top:none;">
					<label class="col-md-2 control-label"><?php echo __( 'Classification Type' ); ?>:</label>
					<div class="col-md-4">
						<?php echo $this->Form->input( 'asset_classification_type_id', array(
							'options' => $ac_types,
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'empty' => __( 'Choose one or create new below' )
						) ); ?>
						<span class="help-block"><?php echo __( 'This is the begining of the classification of assets. Let\'s say you are clasifying cars, a classification example could be "Size". Later, you will name several options (names) for that Type of classification, such as "Big". "Small", Etc. Most regulations and standards require classifications such as "Confidentiality, Sensibility or Integrity" level, Etc.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'New Classification Type' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'AssetClassificationType.name', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'If you havent created a Classification type before, you will need to create one.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Name' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'name', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'You will need to create a name for your classification. Examples could be "High", "Low", etc.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Criteria' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'criteria', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Very important. It\'s crucial when classifying to be consistent with the criteria you use. Ideally your criteria should be simple and practical. Dont get too creative here. Examples: "The asset worth is higher than a 40k EUR", "The disclosure of this asset could mean legal actions against the company", Etc.' ); ?></span>
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
		var $type_ele = $("#AssetClassificationAssetClassificationTypeId");
		var $new_class_ele = $("#AssetClassificationTypeName");

		$type_ele.on("change", function() {
			if ( $(this).val() == '' ) {
				$new_class_ele.prop( 'disabled', false );
			} else {
				$new_class_ele.prop( 'disabled', true );
			}
		}).trigger("change");
	});
</script>