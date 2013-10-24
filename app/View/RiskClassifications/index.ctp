<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'riskClassifications',
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
							<th><?php echo $this->Paginator->sort( 'RiskClassification.name', __( 'Name' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'RiskClassification.criteria', __( 'Criteria' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'RiskClassification.value', __( 'Value' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'RiskClassificationType.name', __( 'Type' ) ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['RiskClassification']['name']; ?></td>
								<td><?php echo $entry['RiskClassification']['criteria']; ?></td>
								<td><?php echo $entry['RiskClassification']['value']; ?></td>
								<td><?php echo $entry['RiskClassificationType']['name']; ?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['RiskClassification']['id'],
										'controller' => 'riskClassifications'
									) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Risk Classifications found.' )
				) ); ?>
			<?php endif; ?>

		</div>
	</div>

</div>