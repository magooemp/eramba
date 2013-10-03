<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'thirdParties',
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
		<div class="widget box">

			<div class="widget-content">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th><?php echo __( 'Name' ); ?></th>
							<th><?php echo __( 'Description' ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['ThirdParty']['tp_name']; ?></td>
								<td><?php echo $entry['ThirdParty']['tp_description']; ?></td>
								<td class="align-center">
									<ul class="table-controls">
										<li>
											<?php echo $this->Html->link( '<i class="icon-pencil"></i>', array(
												'controller' => 'thirdParties',
												'action' => 'edit',
												$entry['ThirdParty']['tp_id']
											), array(
												'class' => 'bs-tooltip',
												'escape' => false,
												'title' => __( 'Edit' )
											) ); ?>
										</li>
										<li><a href="javascript:void(0);" class="bs-tooltip" title="Delete"><i class="icon-trash"></i></a> </li>
									</ul>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

		</div>
	</div>

</div>