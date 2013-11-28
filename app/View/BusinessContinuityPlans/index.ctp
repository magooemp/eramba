<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'businessContinuityPlans',
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
						<h4><?php echo $entry['BusinessContinuityPlan']['title']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit Continuity Plan' ), array(
										'controller' => 'businessContinuityPlans',
										'action' => 'edit',
										$entry['BusinessContinuityPlan']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add New Task on Plan' ), array(
										'controller' => 'businessContinuityTasks',
										'action' => 'add',
										$entry['BusinessContinuityPlan']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-search"></i> ' . __( 'Audits' ), array(
										'controller' => 'businessContinuityPlanAudits',
										'action' => 'index',
										$entry['BusinessContinuityPlan']['id']
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
									<th><?php echo __( 'Plan Title' ); ?></th>
									<th><?php echo __( 'Sponsor' ); ?></th>
									<th><?php echo __( 'Status' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['BusinessContinuityPlan']['title']; ?></td>
									<td><?php echo $entry['BusinessContinuityPlan']['sponsor']; ?></td>
									<td><?php echo $entry['SecurityServiceType']['name']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Opex' ); ?></th>
									<th><?php echo __( 'Capex' ); ?></th>
									<th><?php echo __( 'Resource Utilization' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo CakeNumber::currency( $entry['BusinessContinuityPlan']['opex'] ); ?></td>
									<td><?php echo CakeNumber::currency( $entry['BusinessContinuityPlan']['capex'] ); ?></td>
									<td><?php echo $entry['BusinessContinuityPlan']['resource_utilization']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Objective' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['BusinessContinuityPlan']['objective']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Launch Responsible' ); ?></th>
									<th><?php echo __( 'Launch Criteria' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['BusinessContinuityPlan']['launch_responsible']; ?></td>
									<td><?php echo $entry['BusinessContinuityPlan']['launch_criteria']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Audit Metric' ); ?></th>
									<th><?php echo __( 'Audit Success Criteria' ); ?></th>
									<th><?php echo __( 'Audit Status' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['BusinessContinuityPlan']['audit_metric']; ?></td>
									<td><?php echo $entry['BusinessContinuityPlan']['audit_success_criteria']; ?></td>
									<?php
									$is_audit_ok = true;
									foreach ( $entry['BusinessContinuityPlanAudit'] as $audit ) {
										if ( ! $audit['result'] ) {
											$is_audit_ok = false;
										}
									}
									?>
									<td><?php echo $is_audit_ok ? __( 'Ok' ) : __( 'Not Ok' ); ?></td>
								</th>
							</tbody>
						</table>


						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Plan Task Details' ); ?></h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content" style="display:none;">
								<?php if ( ! empty( $entry['BusinessContinuityTask'] ) ) : ?>
									<table class="table table-hover table-striped">
										<thead>
											<tr>
												<th><?php echo __( 'Step' ); ?></th>
												<th><?php echo __( 'When' ); ?></th>
												<th><?php echo __( 'Who' ); ?></th>
												<th><?php echo __( 'Does Something' ); ?></th>
												<th><?php echo __( 'Where' ); ?></th>
												<th><?php echo __( 'How' ); ?></th>
												<th class="align-center"><?php echo __( 'Action' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ( $entry['BusinessContinuityTask'] as $task ) : ?>
											<tr>
												<td><?php echo $task['step']; ?></td>
												<td><?php echo $task['when']; ?></td>
												<td><?php echo $task['who']; ?></td>
												<td><?php echo $task['does']; ?></td>
												<td><?php echo $task['where']; ?></td>
												<td><?php echo $task['how']; ?></td>
												<td class="align-center">
													<?php echo $this->element( 'action_buttons', array( 
														'id' => $task['id'],
														'controller' => 'businessContinuityTasks'
													) ); ?>
												</td>
											</tr>
											<?php endforeach ; ?>
										</tbody>
									</table>
								<?php else : ?>
									<?php echo $this->element( 'not_found', array(
										'message' => __( 'No Business Continuity Plan Tasks found.' )
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
				'message' => __( 'No Business Continuity Plans found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>