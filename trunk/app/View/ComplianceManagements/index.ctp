<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'legals',
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
							<th><?php echo $this->Paginator->sort( 'ThirdParty.name', __( 'Name' ) ); ?></th>
							<th><?php echo __( '% Strategy Mitigate' ); ?></th>
							<th><?php echo __( '% Strategy NA' ); ?></th>
							<th><?php echo __( '% Missing Controls' ); ?></th>
							<th><?php echo __( '% Failed Controls' ); ?></th>
							<th><?php echo __( '% Comp. On-Going' ); ?></th>
							<th><?php echo __( '% Compliant' ); ?></th>
							<th><?php echo __( '% Non-Compliant' ); ?></th>
							<th><?php echo __( '% Comp. N/A' ); ?></th>
							<th><?php echo __( '# Incident' ); ?></th>
							<th><?php echo __( '# Open Audit Items' ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['ThirdParty']['name']; ?></td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx %</td>
								<td>xx</td>
								<td>xx</td>
								<td class="align-center">
									<ul class="table-controls">
										<li>
											<?php echo $this->Html->link( '<i class="icon-search"></i>', array(
												'controller' => 'complianceManagements',
												'action' => 'analyze',
												$entry['ThirdParty']['id']
											), array(
												'class' => 'bs-tooltip',
												'escape' => false,
												'title' => __( 'Analyze' )
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
					'message' => __( 'No Legal Constrains found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>