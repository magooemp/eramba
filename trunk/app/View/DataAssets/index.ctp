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
				<div class="widget box widget-closed">
					<div class="widget-header">
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
							<table class="table table-hover table-striped">
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
							</table>
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