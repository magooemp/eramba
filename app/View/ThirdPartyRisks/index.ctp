<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'thirdPartyRisks',
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
						<h4><?php echo __( 'Third Party' ); ?>: <?php echo $entry['ThirdParty']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
							</div>
						</div>
					</div>
					<div class="widget-content" style="display:none;">
						<?php if ( ! empty( $entry['ThirdPartyRisk'] ) ) : ?>
							<?php foreach ( $entry['ThirdPartyRisk'] as $risk ) : ?>
								<?php
								$today = CakeTime::format( 'Y-m-d', CakeTime::fromString( 'now' ) );
								$extra_class = '';
								if ( $risk['review'] > $today ) {
									$extra_class = 'widget-header-alert';
								}
								foreach ( $risk['RiskException'] as $risk_exception ) {
									if ( ! $extra_class && ( $risk_exception['expiration'] > $today ) ) {
										$extra_class = 'widget-header-alert';
									}
								}
								foreach ( $risk['SecurityService'] as $security_service ) {
									if ( ! $extra_class ) {
										if ( ! $security_service['status']['all_done'] ) {
											$extra_class = 'widget-header-warning';
										}
										if ( ! $security_service['status']['last_passed'] ) {
											$extra_class = 'widget-header-warning';
										}

										if ( ! $security_service['maintenanceStatus']['all_done'] ) {
											$extra_class = 'widget-header-warning';
											
										}
										if ( ! $security_service['maintenanceStatus']['last_passed'] ) {
											$extra_class = 'widget-header-warning';
										}
									}
								}
								?>
								<div class="widget box widget-closed">
									<div class="widget-header <?php echo $extra_class; ?>">
										<h4><?php echo __( 'Third Party Risk' ); ?>: <?php echo $risk['title']; ?></h4>
										<div class="toolbar no-padding">
											<div class="btn-group">
												<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
												<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
													<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
												</span>
												<ul class="dropdown-menu pull-right">
													<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit' ), array(
														'controller' => 'thirdPartyRisks',
														'action' => 'edit',
														$risk['id']
													), array(
														'escape' => false
													) ); ?></li>
													<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete' ), array(
														'controller' => 'thirdPartyRisks',
														'action' => 'delete',
														$risk['id']
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
													<th><?php echo __( 'Title' ); ?></th>
													<th><?php echo __( 'Risk Mitigation Strategy' ); ?></th>
													<th><?php echo __( 'Risk Score' ); ?></th>
													<th><?php echo __( 'Residual Risk' ); ?></th>
													<th><?php echo __( 'Owner' ); ?></th>
													<th><?php echo __( 'Risk Review Date' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $risk['title']; ?></td>
													<td><?php echo $risk['RiskMitigationStrategy']['name']; ?></td>
													<td><?php echo $risk['risk_score']; ?></td>
													<td><?php echo $risk['residual_score']; ?></td>
													<td><?php echo $risk['User']['name'] . ' ' . $risk['User']['surname']; ?></td>
													<?php
													$today = CakeTime::format( 'Y-m-d', CakeTime::fromString( 'now' ) );
													$notification = '<span class="label label-success">' . __( 'Not Expired' ) . '</span>';
													if ( $risk['review'] > $today ) {
														$notification = '<span class="label label-danger">' . __( 'Expired' ) . '</span>';
													}
													?>
													<td><?php echo $risk['review']; ?>&nbsp;<?php echo $notification; ?></td>
												</tr>
											</tbody>
										</table>

										<?php if ( ! empty( $risk['RiskClassification'] ) ) : ?>
											<table class="table table-hover table-striped table-bordered table-highlight-head">
												<thead>
													<tr>
														<?php foreach ( $risk['RiskClassification'] as $classification ) : ?>
															<th><?php echo $classification['RiskClassificationType']['name']; ?></th>
														<?php endforeach; ?>
													</tr>
												</thead>
												<tbody>
													<tr>
														<?php foreach ( $risk['RiskClassification'] as $classification ) : ?>
															<td><?php echo $classification['name']; ?></td>
														<?php endforeach; ?>
													</tr>
												</tbody>
											</table>
										<?php endif; ?>

										<div class="widget box widget-closed">
											<div class="widget-header">
												<h4><?php echo __( 'Shared Assets' ); ?></h4>
												<div class="toolbar no-padding">
													<div class="btn-group">
														<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
													</div>
												</div>
											</div>
											<div class="widget-content" style="display:none;">
												<?php if ( ! empty( $risk['Asset'] ) ) : ?>
												<table class="table table-hover table-striped table-bordered table-highlight-head">
													<thead>
														<tr>
															<th><?php echo __( 'Name' ); ?></th>
															<th><?php echo __( 'Description' ); ?></th>
															<th><?php echo __( 'Label' ); ?></th>
															<th><?php echo __( 'Legal Constrain' ); ?></th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ( $risk['Asset'] as $asset ) : ?>
														<tr>
															<td><?php echo $asset['name']; ?></td>
															<td><?php echo $asset['description']; ?></td>
															<td><?php
															if ( ! empty( $asset['AssetLabel'] ) ) {
																echo $asset['AssetLabel']['name'];
															}
															?></td>
															<td><?php
															if ( ! empty( $asset['Legal'] ) ) {
																echo $asset['Legal']['name'];
															}
															?></td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
												<?php else : ?>
													<?php echo $this->element( 'not_found', array(
														'message' => __( 'No Assets found.' )
													) ); ?>
												<?php endif; ?>
											</div>
										</div>

										<table class="table table-hover table-striped table-bordered table-highlight-head">
											<thead>
												<tr>
													<th><?php echo __( 'Threat Tags' ); ?></th>
													<th><?php echo __( 'Vulnerability Tags' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<?php foreach ( $risk['Threat'] as $threat ) : ?>
															<span class="label label-info"><?php echo $threat['name']; ?></span>
														<?php endforeach; ?>
													</td>
													<td>
														<?php foreach ( $risk['Vulnerability'] as $vulnerability ) : ?>
															<span class="label label-info"><?php echo $vulnerability['name']; ?></span>
														<?php endforeach; ?>
													</td>
												</tr>
											</tbody>
										</table>

										<table class="table table-hover table-striped table-bordered table-highlight-head">
											<thead>
												<tr>
													<th><?php echo __( 'Threat Description' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $risk['threats']; ?></td>
												</tr>
											</tbody>
										</table>

										<table class="table table-hover table-striped table-bordered table-highlight-head">
											<thead>
												<tr>
													<th><?php echo __( 'Vulnerability Description' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $risk['vulnerabilities']; ?></td>
												</tr>
											</tbody>
										</table>

										<div class="widget box widget-closed">
											<div class="widget-header">
												<h4><?php echo __( 'Risk Exceptions' ); ?></h4>
												<div class="toolbar no-padding">
													<div class="btn-group">
														<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
													</div>
												</div>
											</div>
											<div class="widget-content" style="display:none;">
												<?php if ( ! empty( $risk['RiskException'] ) ) : ?>
												<table class="table table-hover table-striped table-bordered table-highlight-head">
													<thead>
														<tr>
															<th><?php echo __( 'Name' ); ?></th>
															<th><?php echo __( 'Description' ); ?></th>
															<th><?php echo __( 'Author' ); ?></th>
															<th><?php echo __( 'Expiration' ); ?></th>
															<th><?php echo __( 'Status' ); ?></th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ( $risk['RiskException'] as $risk_exception ) : ?>
														<tr>
															<td><?php echo $risk_exception['title']; ?></td>
															<td><?php echo $risk_exception['description']; ?></td>
															<td><?php echo $risk_exception['author']; ?></td>
															<td><?php echo $risk_exception['expiration']; ?></td>
															<?php
															$today = CakeTime::format( 'Y-m-d', CakeTime::fromString( 'now' ) );
															$notification = '<span class="label label-success">' . __( 'Not Expired' ) . '</span>';
															if ( $risk_exception['expiration'] > $today ) {
																$notification = '<span class="label label-danger">' . __( 'Expired' ) . '</span>';
															}
															?>
															<td><?php echo $notification; ?></td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
												<?php else : ?>
													<?php echo $this->element( 'not_found', array(
														'message' => __( 'No Risks Exceptions found.' )
													) ); ?>
												<?php endif; ?>
											</div>
										</div>

										<div class="widget box widget-closed">
											<div class="widget-header">
												<h4><?php echo __( 'Security Controls' ); ?></h4>
												<div class="toolbar no-padding">
													<div class="btn-group">
														<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
													</div>
												</div>
											</div>
											<div class="widget-content" style="display:none;">
												<?php if ( ! empty( $risk['SecurityService'] ) ) : ?>
												<table class="table table-hover table-striped table-bordered table-highlight-head">
													<thead>
														<tr>
															<th><?php echo __( 'Name' ); ?></th>
															<th><?php echo __( 'Objective' ); ?></th>
															<th><?php echo __( 'Owner' ); ?></th>
															<th><?php echo __( 'Status' ); ?></th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ( $risk['SecurityService'] as $security_service ) : ?>
														<tr>
															<td><?php echo $security_service['name']; ?></td>
															<td><?php echo $security_service['objective']; ?></td>
															<?php
															if ( ! empty( $security_service['User'] ) ) {
																$name = $security_service['User']['name'] . ' ' . $security_service['User']['surname'];
															} else {
																$name = '';
															}
															?>
															<td><?php echo $name; ?></td>
									<?php
									$msg = array();
									if ( ! $security_service['status']['all_done'] ) {
										$msg[] = '<span class="label label-warning">' . __( 'Missing audits.' ) . '</span>';
										
									}
									if ( ! $security_service['status']['last_passed'] ) {
										$msg[] = '<span class="label label-danger">' . __( 'Last audit failed.' ) . '</span>';
									}

									if ( $security_service['status']['all_done'] && $security_service['status']['last_passed'] ) {
										$msg[] = '<span class="label label-success">' . __( 'No audit issues.' ) . '</span>';
									}

									if ( ! $security_service['maintenanceStatus']['all_done'] ) {
										$msg[] = '<span class="label label-warning">' . __( 'Missing maintenances.' ) . '</span>';
										
									}
									if ( ! $security_service['maintenanceStatus']['last_passed'] ) {
										$msg[] = '<span class="label label-danger">' . __( 'Last maintenance failed.' ) . '</span>';
									}

									if ( $security_service['maintenanceStatus']['all_done'] && $security_service['maintenanceStatus']['last_passed'] ) {
										$msg[] = '<span class="label label-success">' . __( 'No maintenance issues.' ) . '</span>';
									}
									?>
															<td><?php echo implode( '<br />', $msg ); ?></td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
												<?php else : ?>
													<?php echo $this->element( 'not_found', array(
														'message' => __( 'No Security Controls found.' )
													) ); ?>
												<?php endif; ?>
											</div>
										</div>

									</div>
								</div>
							<?php endforeach; ?>

						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Third Party Risks related to this Third Party found.' )
							) ); ?>
						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

			<?php //echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Third Parties found.' )
			) ); ?>
		<?php endif; ?>
	</div>

</div>