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

		<?php if ( ! empty( $data ) ) : ?>
			<?php foreach ( $data as $entry ) : ?>
				<div class="widget box">
					<div class="widget-header">
						<h4><?php echo __( 'Audit' ); ?>: <?php echo $entry['ComplianceAudit']['name']; ?></h4>

						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
							</div>
						</div>
					</div>
					<div class="widget-content">

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Audit Date' ); ?></th>
									<th><?php echo __( 'Compliance Package' ); ?></th>
									<th><?php echo __( 'Number of findings' ); ?></th>
									<th><?php echo __( 'Open' ); ?></th>
									<th><?php echo __( 'Closed' ); ?></th>
									<th><?php echo __( 'Expired' ); ?></th>
									<th class="align-center"><?php echo __( 'Action' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['ComplianceAudit']['date']; ?></td>
									<td><?php echo $entry['ThirdParty']['name']; ?></td>
									<td><?php 
										$count = count( $entry['ComplianceFinding'] );
										echo __n( '%d Item', '%d Items', $count, $count );
									?></td>
									<td>?</td>
									<td>?</td>
									<td>?</td>
									<td class="align-center">
										<ul class="table-controls">
											<li>
												<?php echo $this->Html->link( '<i class="icon-search"></i>', array(
													'controller' => 'complianceAudits',
													'action' => 'analyze',
													$entry['ThirdParty']['id'], $entry['ComplianceAudit']['id']
												), array(
													'class' => 'bs-tooltip',
													'escape' => false,
													'title' => __( 'Analyze' )
												) ); ?>
											</li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>

						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Findings Details' ); ?></h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content" style="display:none;">
								
								<table class="table table-hover table-striped table-bordered table-highlight-head">
									<thead>
										<tr>
											<th><?php echo __( 'Title' ) ?></th>
											<th><?php echo __( 'Status' ); ?></th>
											<th><?php echo __( 'Description' ); ?></th>
											<th><?php echo __( 'Attachments' ); ?></th>
											<th class="align-center"><?php echo __( 'Action' ); ?></th>
										</tr>
									</thead>
									<tbody>

										<?php foreach ( $entry['ComplianceFinding'] as $finding ) : ?>
											<tr>
												<td><?php echo $finding['title']; ?></td>
												<td><?php echo $finding['ComplianceFindingStatus']['name']; ?></td>
												<td><?php echo $finding['description']; ?></td>
												<td>?</td>
												<td class="align-center">
													<?php echo $this->element( 'action_buttons', array( 
														'id' => $finding['id'],
														'controller' => 'complianceFindings'
													) ); ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>

							</div>
						</div>

						<?php /*if ( ! empty( $entry['ComplianceAudit'] ) ) : ?>

							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo __( 'Name' ); ?></th>
										<th><?php echo __( 'Date' ); ?></th>
										<th><?php echo __( 'Audit Findings' ); ?></th>
										<th class="align-center"><?php echo __( 'Item Action' ); ?></th>
										<th class="align-center"><?php echo __( 'Findings Action' ); ?></th>
										<th class="align-center"><?php echo __( 'Attachments Action' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $entry['ComplianceAudit'] as $item ) : ?>
									<tr>
										<td><?php echo $item['name']; ?></td>
										<td><?php echo $item['date']; ?></td>
										<td><?php 
											$count = count( $item['ComplianceFinding'] );
											echo __n( '%d Item', '%d Items', $count, $count );
										?></td>
										<td class="align-center">
											<?php echo $this->element( 'action_buttons', array( 
												'id' => $item['id'],
												'controller' => 'complianceAudits'
											) ); ?>
										</td>
										<td class="align-center">
											<ul class="table-controls">
												<li>
													<?php echo $this->Html->link( '<i class="icon-search"></i>', array(
														'controller' => 'complianceFindings',
														'action' => 'index',
														$item['id']
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
														$item['id']
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
									<?php endforeach ; ?>
								</tbody>
							</table>
						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Compliance Audits found.' )
							) ); ?>
						<?php endif;*/ ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Third Parties found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>