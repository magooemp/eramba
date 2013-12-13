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
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo __( 'Project Status' ); ?> <span class="caret"></span></button>
					<ul class="dropdown-menu pull-right" style="text-align: left;">
						<?php $all_link = Router::url( array( 'controller' => 'projects', 'action' => 'index' ) ); ?>
						<li><a href="<?php echo $all_link; ?>"><?php echo __( 'All' ); ?></a></li>
						<?php foreach ( $statuses as $id => $status ) : ?>
							<?php $link = Router::url( array(
								'controller' => 'projects',
								'action' => 'index',
								$id
							) ); ?>
							<li><a href="<?php echo $link; ?>"><?php echo $status; ?></a></li>
						<?php endforeach; ?>
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
									<?php
									$today = CakeTime::format( 'Y-m-d', CakeTime::fromString( 'now' ) );
									$notification = '<span class="label label-success">' . __( 'Not Expired' ) . '</span>';
									if ( $entry['Project']['deadline'] > $today ) {
										$notification = '<span class="label label-danger">' . __( 'Expired' ) . '</span>';
									}
									?>
									<td><?php echo $entry['Project']['deadline'] . '&nbsp;' . $notification; ?></td>
									
									<td><?php echo $entry['User']['name'] . ' ' . $entry['User']['surname']; ?></td>
									<?php
									$completion = 0;
									foreach ( $entry['ProjectAchievement'] as $achievement ) {
										$completion += $achievement['completion'];
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
									<?php
									$notification = '<span class="label label-success">' . __( 'Ok' ) . '</span>';
									if ( $expenses > $entry['Project']['plan_budget'] ) {
										$notification = '<span class="label label-danger">' . __( 'Over Budget' ) . '</span>';
									}
									?>
									<td><?php echo CakeNumber::currency( $expenses ) . '&nbsp;' . $notification; ?></td>
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

						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Project Updates' ); ?></h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content" style="display:none;">
								<?php if ( ! empty( $entry['ProjectAchievement'] ) ) : ?>
									<table class="table table-hover table-striped">
										<thead>
											<tr>
												<th><?php echo __( 'Update Owner' ); ?></th>
												<th><?php echo __( 'Description' ); ?></th>
												<th><?php echo __( 'Date' ); ?></th>
												<th><?php echo __( 'Completion' ); ?></th>
												<th class="align-center"><?php echo __( 'Action' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ( $entry['ProjectAchievement'] as $update ) : ?>
											<tr>
												<td><?php echo $update['User']['name'] . ' ' . $update['User']['surname']; ?></td>
												<td><?php echo $update['description']; ?></td>
												<td><?php echo $update['date'] ?></td>
												<td><?php echo CakeNumber::toPercentage( $update['completion'], 0 ); ?></td>
												<td class="align-center">
													<?php echo $this->element( 'action_buttons', array( 
														'id' => $update['id'],
														'controller' => 'projectAchievements'
													) ); ?>
												</td>
											</tr>
											<?php endforeach ; ?>
										</tbody>
									</table>
								<?php else : ?>
									<?php echo $this->element( 'not_found', array(
										'message' => __( 'No Project Updates found.' )
									) ); ?>
								<?php endif; ?>
							</div>
						</div>

						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Project Expenses' ); ?></h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content" style="display:none;">
								<?php if ( ! empty( $entry['ProjectExpense'] ) ) : ?>
									<table class="table table-hover table-striped">
										<thead>
											<tr>
												<th><?php echo __( 'Amount' ); ?></th>
												<th><?php echo __( 'Description' ); ?></th>
												<th><?php echo __( 'Date' ); ?></th>
												<th class="align-center"><?php echo __( 'Action' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ( $entry['ProjectExpense'] as $expense ) : ?>
											<tr>
												<td><?php echo CakeNumber::currency( $expense['amount'] ); ?></td>
												<td><?php echo $expense['description']; ?></td>
												<td><?php echo $expense['date'] ?></td>
												<td class="align-center">
													<?php echo $this->element( 'action_buttons', array( 
														'id' => $expense['id'],
														'controller' => 'projectExpenses'
													) ); ?>
												</td>
											</tr>
											<?php endforeach ; ?>
										</tbody>
									</table>
								<?php else : ?>
									<?php echo $this->element( 'not_found', array(
										'message' => __( 'No Project Updates found.' )
									) ); ?>
								<?php endif; ?>
							</div>
						</div>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Projects found.' )
			) ); ?>
		<?php endif; ?>


	</div>

</div>