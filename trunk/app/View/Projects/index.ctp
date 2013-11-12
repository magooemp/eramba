<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'projects',
						'action' => 'add'
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

		<?php if ( ! empty( $data ) ) : ?>
			<?php foreach ( $data as $entry ) : ?>
				<div class="widget box widget-closed">
					<div class="widget-header">
						<h4><?php echo $entry['Project']['title']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit Project' ), array(
										'controller' => 'projects',
										'action' => 'edit',
										$entry['Project']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete Project' ), array(
										'controller' => 'projects',
										'action' => 'delete',
										$entry['Project']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add an update' ), array(
										'controller' => 'projectAchievements',
										'action' => 'add',
										$entry['Project']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-eye-open"></i> ' . __( 'View all updates' ), array(
										'controller' => 'projectAchievements',
										'action' => 'index',
										$entry['Project']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add an expense' ), array(
										'controller' => 'projectExpenses',
										'action' => 'add',
										$entry['Project']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-eye-open"></i> ' . __( 'View all expenses' ), array(
										'controller' => 'projectExpenses',
										'action' => 'index',
										$entry['Project']['id']
									), array(
										'escape' => false
									) ); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="widget-content" style="display:none;">
						
						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo $this->Paginator->sort( 'ProjectStatus.name', __( 'Status' ) ); ?></th>
									<th><?php echo __( 'Start' ); ?></th>
									<th><?php echo __( 'Planned End' ); ?></th>
									<th><?php echo __( 'Owner' ); ?></th>
									<th><?php echo __( 'Completion' ); ?></th>
									<th><?php echo __( 'Planned Budget' ); ?></th>
									<th><?php echo __( 'Current Budget' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['ProjectStatus']['name']; ?></td>
									<td><?php echo $entry['Project']['start']; ?></td>
									<td><?php echo $entry['Project']['deadline']; ?></td>
									<td><?php echo $entry['User']['name'] . ' ' . $entry['User']['surname']; ?></td>
									<?php
									$completion = 0;
									foreach ( $entry['ProjectAchievement'] as $achievement ) {
										$time = CakeTime::fromString( $achievement['date'] );
										if ( ! isset( $time_tmp ) || $time > $time_tmp ) {
											$completion = $achievement['completion'];
											$time_tmp = $time;
										}
									}
									?>
									<td><?php echo CakeNumber::toPercentage( $completion, 0 ); ?></td>
									<td><?php echo CakeNumber::currency( $entry['Project']['plan_budget'] ); ?></td>
									<?php
									$expenses = 0;
									foreach ( $entry['ProjectExpense'] as $expense ) {
										$expenses += $expense['amount'];
									}
									?>
									<td><?php echo CakeNumber::currency( $expenses ); ?></td>
								</tr>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Project Goal' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['Project']['goal']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Root Cause Analysis' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['Project']['rca']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Proactive Plans' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['Project']['proactive']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Reactive Plans' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['Project']['reactive']; ?></td>
								</th>
							</tbody>
						</table>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Processes found.' )
			) ); ?>
		<?php endif; ?>


		<!--<div class="widget">

			<div class="widget-content">
				<?php if ( ! empty( $data ) ) : ?>
					<table class="table table-hover table-striped table-bordered table-highlight-head">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort( 'Project.title', __( 'Title' ) ); ?></th>
								<th><?php echo $this->Paginator->sort( 'ProjectStatus.name', __( 'Status' ) ); ?></th>
								<th class="align-center"><?php echo __( 'Action' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $data as $entry ) : ?>
								<tr>
									<td><?php echo $entry['Project']['title']; ?></td>
									<td><?php echo $entry['ProjectStatus']['name']; ?></td>
									<td class="align-center">
										<?php echo $this->element( 'action_buttons', array( 
											'id' => $entry['Project']['id'],
											'controller' => 'projects'
										) ); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
				<?php else : ?>
					<?php echo $this->element( 'not_found', array(
						'message' => __( 'No Projects found.' )
					) ); ?>
				<?php endif; ?>
				
			</div>

		</div>-->
	</div>

</div>