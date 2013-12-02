<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">		
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
				foreach ( $entry['DataAsset'] as $data_asset ) {
					foreach ( $data_asset['SecurityService'] as $security_service ) {
						if ( $extra_class != 'widget-header-alert' ) {
							if ( $extra_class != 'widget-header-warning' ) {
								if ( $security_service['status']['status'] == 1 || ! $security_service['status']['all_done'] ) {
									$extra_class = 'widget-header-warning';
								}
							}
							
							if ( $security_service['status']['status'] == 2 || ! $security_service['status']['last_passed'] ) {
								$extra_class = 'widget-header-alert';
							}
						}
					}
				}
				
				?>
				<div class="widget box widget-closed">
					<div class="widget-header <?php echo $extra_class; ?>">
						<h4><?php echo __( 'Asset' ); ?>: <?php echo $entry['Asset']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-eye-open"></i> ' . __( 'View this asset' ), array(
										'controller' => 'assets',
										'action' => 'edit',
										$entry['Asset']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add new analysis' ), array(
										'controller' => 'dataAssets',
										'action' => 'add',
										$entry['Asset']['id']
									), array(
										'escape' => false
									) ); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="widget-content" style="display:none;">
						<?php if ( ! empty( $entry['DataAsset'] ) ) : ?>
							<?php foreach ( $entry['DataAsset'] as $data_asset ) : ?>
							
								<div class="widget box widget-closed">
									<div class="widget-header">
										<h4><?php echo $data_asset['DataAssetStatus']['name']; ?> <?php if ( $data_asset['description'] ) echo '(' . $data_asset['description'] . ')'; ?></h4>
										<div class="toolbar no-padding">
											<div class="btn-group">
												<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
												<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
													<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
												</span>
												<ul class="dropdown-menu pull-right">
													<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit' ), array(
														'controller' => 'dataAssets',
														'action' => 'edit',
														$data_asset['id']
													), array(
														'escape' => false
													) ); ?></li>
													<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete' ), array(
														'controller' => 'dataAssets',
														'action' => 'delete',
														$data_asset['id']
													), array(
														'escape' => false
													) ); ?></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="widget-content" style="display:none;">
										<?php if ( ! empty( $data_asset['SecurityService'] ) ) : ?>
											<table class="table table-hover table-striped table-bordered table-highlight-head">
												<thead>
													<tr>
														<th><?php echo __( 'Security Control' ); ?></th>
														<th><?php echo __( 'Status' ); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ( $data_asset['SecurityService'] as $security_service ) : ?>
														<?php
															$extra_class = '';
															if ( $security_service['status']['status'] == 1 || ! $security_service['status']['all_done'] ) {
																$extra_class = 'row-warning';
															}
															if ( $security_service['status']['status'] == 2 || ! $security_service['status']['last_passed'] ) {
																$extra_class = 'row-alert';
															}
														?>
														<tr class="<?php //echo $extra_class; ?>">
															<td><?php echo $this->Html->link( $security_service['name'], array(
																'controller' => 'securityServices',
																'action' => 'edit',
																$security_service['id']
															) ); ?></td>
															<td><?php
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

																echo implode( '<br />', $msg );
															?></td>
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
							<?php endforeach; ?>

							<!--<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo __( 'Data State' ); ?></th>
										<th><?php echo __( 'Description' ); ?></th>
										<th><?php echo __( 'Applicable Security Controls' ); ?></th>
										<th class="align-center"><?php echo __( 'Action' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $entry['DataAsset'] as $data_asset ) : ?>
									<tr>
										<td><?php echo $data_asset['DataAssetStatus']['name']; ?></td>
										<td><?php echo $data_asset['description']; ?></td>
										<td>
											<?php foreach ( $data_asset['SecurityService'] as $security_service ) : ?>
												<?php echo $this->Html->link( $security_service['name'], array(
													'controller' => 'securityServices',
													'action' => 'edit',
													$security_service['id']
												) ); ?>
												<br />
											<?php endforeach; ?>
										</td>
										<td class="align-center">
											<?php echo $this->element( 'action_buttons', array( 
												'id' => $data_asset['id'],
												'controller' => 'dataAssets'
											) ); ?>
										</td>
									</tr>
									<?php endforeach ; ?>
								</tbody>
							</table>-->
						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Data Assets found.' )
							) ); ?>
						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Assets found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>