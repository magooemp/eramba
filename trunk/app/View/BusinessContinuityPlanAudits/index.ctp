<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo __( 'Actions' ); ?> <span class="caret"></span></button>
					<ul class="dropdown-menu pull-right" style="text-align: left;">
						<li><a href="#"><i class="icon-file"></i> <?php echo __( 'Export' ); ?></a></li>
					</ul>
			</div>
		</div>
		<div class="widget">
			<?php if ( ! empty( $data ) ) : ?>
				<table class="table table-hover table-striped table-bordered table-highlight-head">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort( 'BusinessContinuityPlan.title', __( 'Control Name' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'BusinessContinuityPlanAudit.planned_date', __( 'Planned Start' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'BusinessContinuityPlanAudit.start_date', __( 'Actual Start' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'BusinessContinuityPlanAudit.end_date', __( 'Actual End' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'BusinessContinuityPlanAudit.result', __( 'Result' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'BusinessContinuityPlanAudit.result_description', __( 'Conclusion' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'User.name', __( 'Owner' ) ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['BusinessContinuityPlan']['title']; ?></td>
								<td><?php echo $entry['BusinessContinuityPlanAudit']['planned_date']; ?></td>
								<td><?php echo $entry['BusinessContinuityPlanAudit']['start_date']; ?></td>
								<td><?php echo $entry['BusinessContinuityPlanAudit']['end_date']; ?></td>
								<td>
									<?php
									$options = array(
										0 => __( 'Fail' ),
										1 => __( 'Pass' )
									);
									if ( isset( $options[ $entry['BusinessContinuityPlanAudit']['result'] ] ) ) {
										echo $options[ $entry['BusinessContinuityPlanAudit']['result'] ];
									}
									?>
								</td>
								<td><?php echo $entry['BusinessContinuityPlanAudit']['result_description']; ?></td>
								<td><?php echo $entry['User']['name']; ?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['BusinessContinuityPlanAudit']['id'],
										'controller' => 'businessContinuityPlanAudits'
									) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Audits found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>