<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-content">

				<?php
					if (isset($edit)) {
						echo $this->Form->create( 'Project', array(
							'url' => array( 'controller' => 'projects', 'action' => 'edit' ),
							'class' => 'form-horizontal row-border'
						) );

						echo $this->Form->input( 'id', array( 'type' => 'hidden' ) );
						$submit_label = __( 'Edit' );
					}
					else {
						echo $this->Form->create( 'Project', array(
							'url' => array( 'controller' => 'projects', 'action' => 'add' ),
							'class' => 'form-horizontal row-border'
						) );
						
						$submit_label = __( 'Add' );
					}
				?>

				<div class="form-group form-group-first">
					<label class="col-md-2 control-label"><?php echo __( 'Title' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'title', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Give the project a title, name or code so it\'s easily identified on the project list menu' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Goal' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'goal', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the project Goal, it\'s roadmap and deliverables.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'RCA' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'rca', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Describe the root cause analysis of why this is required.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Proactive Plan' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'proactive', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'If this project aims to mitigate an incident or improve something on your system, describe the proactive plans (stop the bleeding).' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Reactive Plan' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'reactive', array(
							'type' => 'textarea',
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'If this project aims to mitigate an incident or improve something on your system, describe the long term plans.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Project Start Date' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'start', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Document the project kick-off date. The date format for this field is YYYY-MM-DD, the default is todays date.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Project Deadline' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'deadline', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Document the project deadline. The date format for this field is YYYY-MM-DD, the default is todays date.' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Owner' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'user_id', array(
							'options' => $users,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Document the project owner, someone who is responsible for make this project deliver what has been documented on the times specified above' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Planned Budget' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'plan_budget', array(
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Document the planned and approved budget for this project' ); ?></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __( 'Status' ); ?>:</label>
					<div class="col-md-10">
						<?php echo $this->Form->input( 'project_status_id', array(
							'options' => $statuses,
							'label' => false,
							'div' => false,
							'class' => 'form-control'
						) ); ?>
						<span class="help-block"><?php echo __( 'Select an applicable type for this Third Party.' ); ?></span>
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