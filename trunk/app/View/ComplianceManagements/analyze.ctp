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

		<?php if ( ! empty( $data['CompliancePackage'] ) ) : ?>
			<?php foreach ( $data['CompliancePackage'] as $entry ) : ?>
				<div class="widget box">
					<div class="widget-header">
						<h4><?php echo $entry['package_id'] . ' - ' . $entry['name'] . ' (' . $entry['description'] . ')'; ?></h4>

						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
							</div>
						</div>
					</div>
					<div class="widget-content">
						<?php if ( ! empty( $entry['CompliancePackageItem'] ) ) : ?>
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo __( 'Item Name' ); ?></th>
										<th><?php echo __( 'Item Description' ); ?></th>
										<th class="align-center"><?php echo __( 'Action' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $entry['CompliancePackageItem'] as $item ) : ?>
									<tr>
										<td><?php echo $item['name']; ?></td>
										<td><?php echo $item['description']; ?></td>
										<td class="align-center">
											<ul class="table-controls">
												<?php if ( empty( $item['ComplianceManagement'] ) ) : ?>
													<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i>', array(
															'controller' => 'complianceManagements',
															'action' => 'add',
															$item['id']
														), array(
															'class' => 'bs-tooltip',
															'escape' => false,
															'title' => __( 'Add analysis' )
														) ); ?></li>
												<?php else : ?>
													<li><?php echo $this->Html->link( '<i class="icon-pencil"></i>', array(
															'controller' => 'complianceManagements',
															'action' => 'edit',
															$item['ComplianceManagement']['id']
														), array(
															'class' => 'bs-tooltip',
															'escape' => false,
															'title' => __( 'Edit analysis' )
														) ); ?></li>
												<?php endif; ?>
											</ul>
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

			<?php //echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Compliance Packages found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>