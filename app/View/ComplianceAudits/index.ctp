<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'complianceAudits',
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
		<div class="widget">
			<?php if ( ! empty( $data ) ) : ?>
				<table class="table table-hover table-striped table-bordered table-highlight-head">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort( 'ComplianceAudit.name', __( 'Name' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ComplianceAudit.date', __( 'Date' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'ThirdParty.name', __( 'Compliance Package' ) ); ?></th>
							<th><?php echo __( 'Audit Findings' ); ?></th>
							<th class="align-center"><?php echo __( 'Item Action' ); ?></th>
							<th class="align-center"><?php echo __( 'Findings Action' ); ?></th>
							<th class="align-center"><?php echo __( 'Attachments Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['ComplianceAudit']['name']; ?></td>
								<td><?php echo $entry['ComplianceAudit']['date']; ?></td>
								<td><?php echo $entry['ThirdParty']['name']; ?></td>
								<td><?php 
									$count = count( $entry['ComplianceFinding'] );
									echo __n( '%d Item', '%d Items', $count, $count );
								?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['ComplianceAudit']['id'],
										'controller' => 'complianceAudits'
									) ); ?>
								</td>
								<td class="align-center">
									<ul class="table-controls">
										<li>
											<?php echo $this->Html->link( '<i class="icon-search"></i>', array(
												'controller' => 'complianceFindings',
												'action' => 'index',
												$entry['ComplianceAudit']['id']
											), array(
												'class' => 'bs-tooltip',
												'escape' => false,
												'title' => __( 'View all findings' )
											) ); ?>
										</li>
										<li>
											<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>', array(
												'controller' => 'complianceFindings',
												'action' => 'add',
												$entry['ComplianceAudit']['id']
											), array(
												'class' => 'bs-tooltip',
												'escape' => false,
												'title' => __( 'Add finding' )
											) ); ?>
										</li>
									</ul>
								</td>
								<td class="align-center">
									<ul class="table-controls">
										<li>
											<?php echo $this->Html->link( '<i class="icon-search"></i>', array(
												'controller' => 'attachments',
												'action' => 'index',
												//$entry['ComplianceAudit']['id']
											), array(
												'class' => 'bs-tooltip',
												'escape' => false,
												'title' => __( 'View all attachments' )
											) ); ?>
										</li>
										<li>
											<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>', array(
												'controller' => 'attachments',
												'action' => 'add',
												//$entry['ComplianceAudit']['id']
											), array(
												'class' => 'bs-tooltip',
												'escape' => false,
												'title' => __( 'Add attachments' )
											) ); ?>
										</li>
									</ul>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Compliance Audits found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>