<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'projectAchievements',
						'action' => 'add',
						$project_id
					), array(
						'class' => 'btn',
						'escape' => false
					) ); ?>
					
					<button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo __( 'Actions' ); ?> <span class="caret"></span></button>
					<ul class="dropdown-menu pull-right" style="text-align: left;">
						<li><a href="#"><i class="icon-file"></i> <?php echo __( 'Export' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="widget">
			<?php if ( ! empty( $data ) ) : ?>
				<table class="table table-hover table-striped table-bordered table-highlight-head">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort( 'Project.title', __( 'Project Name' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'User.name', __( 'Update Owner' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ProjectAchievement.description', __( 'Description' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ProjectAchievement.date', __( 'Date' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ProjectAchievement.completion', __( 'Completion' ) ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['Project']['title']; ?></td>
								<td><?php echo $entry['User']['name'] . ' ' . $entry['User']['surname']; ?></td>
								<td><?php echo $entry['ProjectAchievement']['description']; ?></td>
								<td><?php echo $entry['ProjectAchievement']['date']; ?></td>
								<td><?php echo CakeNumber::toPercentage( $entry['ProjectAchievement']['completion'], 0 ); ?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['ProjectAchievement']['id'],
										'controller' => 'projectAchievements'
									) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Project Updates found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>