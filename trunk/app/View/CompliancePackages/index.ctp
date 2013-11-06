<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'compliancePackages',
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
				<?php //if ( empty( $entry['CompliancePackage'] ) ) continue; ?>
				<div class="widget box">
					<div class="widget-header">
						<h4><?php echo __( 'Regulator or Compliance Authority' ); ?>: <?php echo $entry['ThirdParty']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-eye-open"></i> ' . __( 'View Third Party' ), array(
										'controller' => 'thirdParty',
										'action' => 'edit',
										$entry['ThirdParty']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add Compliance Package' ), array(
										'controller' => 'compliancePackages',
										'action' => 'add',
										$entry['ThirdParty']['id']
									), array(
										'escape' => false
									) ); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="widget-content">
						<?php if ( ! empty( $entry['CompliancePackage'] ) ) : ?>
							<?php foreach ( $entry['CompliancePackage'] as $compliancePackage ) : ?>
								<div class="widget box">
									<div class="widget-header">
										<h4><?php echo __( 'Compliance Package' ); ?>: <?php echo $compliancePackage['name']; ?></h4>
										<div class="toolbar no-padding">
											<div class="btn-group">
												<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
												<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
													<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
												</span>
												<ul class="dropdown-menu pull-right">
													<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit' ), array(
														'controller' => 'compliancePackages',
														'action' => 'edit',
														$compliancePackage['id']
													), array(
														'escape' => false
													) ); ?></li>
													<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete' ), array(
														'controller' => 'compliancePackages',
														'action' => 'delete',
														$compliancePackage['id']
													), array(
														'escape' => false
													) ); ?></li>
													<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add Compliance Package Item' ), array(
														'controller' => 'compliancePackageItems',
														'action' => 'add',
														$compliancePackage['id']
													), array(
														'escape' => false
													) ); ?></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="widget-content">
										<?php if ( ! empty( $compliancePackage['CompliancePackageItem'] ) ) : ?>
											<table class="table table-hover table-striped">
												<thead>
													<tr>
														<th><?php echo __( 'Item ID' ); ?></th>
														<th><?php echo __( 'Item Name' ); ?></th>
														<th><?php echo __( 'Item Description' ); ?></th>
														<th class="align-center"><?php echo __( 'Action' ); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ( $compliancePackage['CompliancePackageItem'] as $compliancePackageItem ) : ?>
													<tr>
														<td><?php echo $compliancePackageItem['item_id']; ?></td>
														<td><?php echo $compliancePackageItem['name']; ?></td>
														<td><?php echo $compliancePackageItem['description']; ?></td>
														<td class="align-center">
															<?php echo $this->element( 'action_buttons', array( 
																'id' => $compliancePackageItem['id'],
																'controller' => 'compliancePackageItems'
															) ); ?>
														</td>
													</tr>
													<?php endforeach ; ?>
												</tbody>
											</table>
										<?php else : ?>
											<?php echo $this->element( 'not_found', array(
												'message' => __( 'No Compliance Package Items found.' )
											) ); ?>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Compliance Packages found.' )
							) ); ?>
						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Third Parties found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>