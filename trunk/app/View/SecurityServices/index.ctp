<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'securityServices',
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
				<?php
				$extra_class = '';
				if ( $extra_class != 'widget-header-alert' ) {
					if ( $extra_class != 'widget-header-warning' ) {
						if ( ! $entry['SecurityService']['status']['all_done'] || ! $entry['SecurityService']['maintenanceStatus']['all_done'] ) {
							$extra_class = 'widget-header-warning';
						}
					}
					
					if ( ! $entry['SecurityService']['status']['last_passed'] || ! $entry['SecurityService']['maintenanceStatus']['last_passed'] ) {
						$extra_class = 'widget-header-alert';
					}
				}
				?>
				<div class="widget box widget-closed">
					<div class="widget-header <?php echo $extra_class; ?>">
						<h4><?php echo $entry['SecurityService']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit' ), array(
										'controller' => 'securityServices',
										'action' => 'edit',
										$entry['SecurityService']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete' ), array(
										'controller' => 'securityServices',
										'action' => 'delete',
										$entry['SecurityService']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-search"></i> ' . __( 'Audits' ), array(
										'controller' => 'securityServiceAudits',
										'action' => 'index',
										$entry['SecurityService']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-search"></i> ' . __( 'Maintenances' ), array(
										'controller' => 'securityServiceMaintenances',
										'action' => 'index',
										$entry['SecurityService']['id']
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
									<th><?php echo __( 'Classification' ); ?></th>
									<th><?php echo __( 'Status' ); ?></th>
									<th><?php echo __( 'Owner' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['ServiceClassification']['name']; ?></td>
									<td><?php echo $entry['SecurityServiceType']['name']; ?></td>
									<td><?php echo $entry['User']['name'] . ' ' . $entry['User']['surname']; ?></td>
								</tr>
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
									<td><?php echo CakeNumber::currency( $entry['SecurityService']['opex'] ); ?></td>
									<td><?php echo CakeNumber::currency( $entry['SecurityService']['capex'] ); ?></td>
									<td><?php echo $entry['SecurityService']['resource_utilization']; ?></td>
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
									<td><?php echo $entry['SecurityService']['objective']; ?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'URL' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['SecurityService']['documentation_url']; ?></td>
								</th>
							</tbody>
						</table>

						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Security Policies Items' ); ?></h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content" style="display:none;">
								<?php if ( ! empty( $entry['SecurityPolicy'] ) ) : ?>
									<table class="table table-hover table-striped">
										<thead>
											<tr>
												<th><?php echo __( 'Name' ); ?></th>
												<th><?php echo __( 'Description' ); ?></th>
												<th><?php echo __( 'Status' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ( $entry['SecurityPolicy'] as $securityPolicy ) : ?>
											<tr>
												<td><?php echo $securityPolicy['index']; ?></td>
												<td><?php echo $securityPolicy['description']; ?></td>
												<?php
												$statuses = array(
													0 => __( 'Draft' ),
													1 => __( 'Released' )
												);
												?>
												<td><?php echo $statuses[ $securityPolicy['status'] ]; ?></td>
											</tr>
											<?php endforeach ; ?>
										</tbody>
									</table>
								<?php else : ?>
									<?php echo $this->element( 'not_found', array(
										'message' => __( 'No Security Policies found.' )
									) ); ?>
								<?php endif; ?>
							</div>
						</div>

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
									<td><?php echo $entry['SecurityService']['audit_metric_description']; ?></td>
									<td><?php echo $entry['SecurityService']['audit_success_criteria']; ?></td>
									<?php
									$extra_class = '';
									if ( ! $entry['SecurityService']['status']['all_done'] ) {
										$extra_class = 'cell-warning';
									}
									if ( ! $entry['SecurityService']['status']['last_passed'] ) {
										$extra_class = 'cell-alert';
									}
									?>
									<td class="<?php //echo $extra_class; ?>"><?php
										$msg = array();
										if ( ! $entry['SecurityService']['status']['all_done'] ) {
											$msg[] = '<span class="label label-warning">' . __( 'Missing audits.' ) . '</span>';
											
										}
										if ( ! $entry['SecurityService']['status']['last_passed'] ) {
											$msg[] = '<span class="label label-danger">' . __( 'Last audit failed.' ) . '</span>';
										}

										if ( $entry['SecurityService']['status']['all_done'] && $entry['SecurityService']['status']['last_passed'] ) {
											$msg[] = '<span class="label label-success">' . __( 'No audit issues.' ) . '</span>';
										}

										echo implode( '<br />', $msg );
									?></td>
								</th>
							</tbody>
						</table>

						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( 'Maintenance Metric' ); ?></th>
									<th><?php echo __( 'Maintenance Status' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $entry['SecurityService']['maintenance_metric_description']; ?></td>
									<?php
									$extra_class = '';
									if ( ! $entry['SecurityService']['maintenanceStatus']['all_done'] ) {
										$extra_class = 'cell-warning';
									}
									if ( ! $entry['SecurityService']['maintenanceStatus']['last_passed'] ) {
										$extra_class = 'cell-alert';
									}
									?>
									<td class="<?php //echo $extra_class; ?>"><?php
										$msg = array();
										if ( ! $entry['SecurityService']['maintenanceStatus']['all_done'] ) {
											$msg[] = '<span class="label label-warning">' . __( 'Missing maintenances.' ) . '</span>';
											
										}
										if ( ! $entry['SecurityService']['maintenanceStatus']['last_passed'] ) {
											$msg[] = '<span class="label label-danger">' . __( 'Last maintenance failed.' ) . '</span>';
										}

										if ( $entry['SecurityService']['maintenanceStatus']['all_done'] && $entry['SecurityService']['maintenanceStatus']['last_passed'] ) {
											$msg[] = '<span class="label label-success">' . __( 'No maintenance issues.' ) . '</span>';
										}

										echo implode( '<br />', $msg );
									?></td>
								</th>
							</tbody>
						</table>

						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Mitigation' ); ?></h4>
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
											<th><?php echo __( 'Mitigation Type' ); ?></th>
											<th><?php echo __( 'Description' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ( $entry['Risk'] as $risk ) : ?>
										<tr>
											<td><?php echo __( 'Asset based Risk' ) ?></td>
											<td><?php echo $this->Html->link( $risk['title'], array(
												'controller' => 'risks',
												'action' => 'edit',
												$risk['id']
											) ); ?></td>
										</tr>
										<?php endforeach ; ?>

										<?php foreach ( $entry['ThirdPartyRisk'] as $risk ) : ?>
										<tr>
											<td><?php echo __( 'Third Party Risk' ) ?></td>
											<td><?php echo $this->Html->link( $risk['title'], array(
												'controller' => 'thirdPartyRisks',
												'action' => 'edit',
												$risk['id']
											) ); ?></td>
										</tr>
										<?php endforeach ; ?>

										<?php foreach ( $entry['SecurityIncident'] as $security_incident ) : ?>
										<tr>
											<td><?php echo __( 'Security Incident' ) ?></td>
											<td><?php echo $this->Html->link( $security_incident['title'], array(
												'controller' => 'securityIncidents',
												'action' => 'edit',
												$security_incident['id']
											) ); ?></td>
										</tr>
										<?php endforeach ; ?>

										<?php foreach ( $entry['DataAsset'] as $data_asset ) : ?>
										<tr>
											<td><?php echo __( 'Data Asset' ) ?></td>
											<td><?php echo $this->Html->link( $data_asset['description'], array(
												'controller' => 'dataAssets',
												'action' => 'edit',
												$data_asset['id']
											) ); ?></td>
										</tr>
										<?php endforeach ; ?>

										<?php foreach ( $entry['ComplianceManagement'] as $compliance ) : ?>
										<tr>
											<td><?php echo __( 'Compliance' ) ?></td>
											<td><?php echo $this->Html->link( $compliance['CompliancePackageItem']['name'], array(
												'controller' => 'compliancePackageItems',
												'action' => 'edit',
												$compliance['CompliancePackageItem']['id']
											) ); ?></td>
										</tr>
										<?php endforeach ; ?>
									</tbody>
								</table>
							</div>
						</div>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Security Services found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>