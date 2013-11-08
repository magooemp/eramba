<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'ProjectAchievement', array(
							'url' => array( 'controller' => 'projectAchievements', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'ProjectAchievement', array(
							'url' => array( 'controller' => 'projectAchievements', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<?php echo $this->Form->input( 'project_id', array(
					'type' => 'hidden',
					'value' => $project_id
				) ); ?>

				<?php echo $this->Form->input( 'user_id', array(
					'type' => 'hidden',
					'value' => $user_id
				) ); ?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Update Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'user_name', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control',
							'value' => $user_name,
							'disabled' => true
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
					<label class="col-md-2 control-label"><?php echo __( 'Update Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'date', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
					</div>
				</div>

				<?php
				$percentages = array();
				for ( $i = 1; $i <= 10; $i++ ) {
					$percentages[ $i*10 ] = $i*10;
				}
				?>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Update Contribution Towards Completion' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'completion', array(
							'options' => $percentages,
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
						'controller' => 'projects',
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